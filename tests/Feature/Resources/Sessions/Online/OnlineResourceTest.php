<?php

use Endroid\QrCode\Builder\Builder as QrCodeBuilder;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use N1ebieski\KSEFClient\Actions\ConvertEcdsaDerToRaw\ConvertEcdsaDerToRawHandler;
use N1ebieski\KSEFClient\Actions\GenerateQRCodes\GenerateQRCodesAction;
use N1ebieski\KSEFClient\Actions\GenerateQRCodes\GenerateQRCodesHandler;
use N1ebieski\KSEFClient\DTOs\QRCodes;
use N1ebieski\KSEFClient\DTOs\Requests\Sessions\Faktura;
use N1ebieski\KSEFClient\Factories\EncryptionKeyFactory;
use N1ebieski\KSEFClient\Support\Utility;
use N1ebieski\KSEFClient\Testing\Fixtures\DTOs\Requests\Sessions\FakturaSprzedazyTowaruFixture;
use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Sessions\Online\Send\SendRequestFixture;
use N1ebieski\KSEFClient\Tests\Feature\AbstractTestCase;
use N1ebieski\KSEFClient\ValueObjects\Mode;
use N1ebieski\KSEFClient\ValueObjects\QRCode;
use N1ebieski\KSEFClient\ValueObjects\Requests\KsefNumber;

/** @var AbstractTestCase $this */

test('send an invoice, check for UPO and generate QR code', function (): void {
    /** @var AbstractTestCase $this */
    /** @var array<string, string> $_ENV */

    $encryptionKey = EncryptionKeyFactory::makeRandom();

    $client = $this->createClient($encryptionKey);

    $openResponse = $client->sessions()->online()->open([
        'formCode' => 'FA (3)',
    ])->object();

    $fakturaFixture = (new FakturaSprzedazyTowaruFixture())
        ->withNip($_ENV['NIP'])
        ->withTodayDate()
        ->withRandomInvoiceNumber();

    $fixture = (new SendRequestFixture())->withFakturaFixture($fakturaFixture);

    $sendResponse = $client->sessions()->online()->send([
        ...$fixture->data,
        'referenceNumber' => $openResponse->referenceNumber,
    ])->object();

    $client->sessions()->online()->close([
        'referenceNumber' => $openResponse->referenceNumber
    ]);

    $statusResponse = Utility::retry(function () use ($client, $openResponse, $sendResponse) {
        $statusResponse = $client->sessions()->invoices()->status([
            'referenceNumber' => $openResponse->referenceNumber,
            'invoiceReferenceNumber' => $sendResponse->referenceNumber
        ])->object();

        if ($statusResponse->status->code === 200) {
            return $statusResponse;
        }

        if ($statusResponse->status->code >= 400) {
            throw new RuntimeException(
                $statusResponse->status->description,
                $statusResponse->status->code
            );
        }
    });

    expect($statusResponse)->toHaveProperty('upoDownloadUrl');
    expect($statusResponse->upoDownloadUrl)->toBeString();

    $faktura = Faktura::from($fakturaFixture->data);

    $generateQRCodesHandler = new GenerateQRCodesHandler(
        qrCodeBuilder: (new QrCodeBuilder())
            ->roundBlockSizeMode(RoundBlockSizeMode::Enlarge)
            ->labelFont(new OpenSans(size: 12)),
        convertEcdsaDerToRawHandler: new ConvertEcdsaDerToRawHandler()
    );

    $ksefNumber = KsefNumber::from($statusResponse->ksefNumber);

    /** @var QRCodes $qrCodes */
    $qrCodes = $generateQRCodesHandler->handle(new GenerateQRCodesAction(
        mode: Mode::Test,
        nip: $faktura->podmiot1->daneIdentyfikacyjne->nip,
        invoiceCreatedAt: $faktura->fa->p_1->value,
        document: $faktura->toXml(),
        ksefNumber: $ksefNumber
    ));

    expect($qrCodes)->toBeInstanceOf(QRCodes::class);
    expect($qrCodes)->toHaveProperty('code1');
    expect($qrCodes->code1)->toBeInstanceOf(QRCode::class);
    expect($qrCodes->code1)->toHaveProperty('raw');
    expect($qrCodes->code1->raw)->toBeString();

    $this->revokeCurrentSession($client);
});
