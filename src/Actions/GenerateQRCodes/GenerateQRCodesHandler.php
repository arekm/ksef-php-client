<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\GenerateQRCodes;

use Endroid\QrCode\Builder\BuilderInterface as QrCodeBuilderInterface;
use Endroid\QrCode\RoundBlockSizeMode;
use N1ebieski\KSEFClient\Actions\AbstractHandler;
use N1ebieski\KSEFClient\Actions\ConvertEcdsaDerToRaw\ConvertEcdsaDerToRawAction;
use N1ebieski\KSEFClient\Actions\ConvertEcdsaDerToRaw\ConvertEcdsaDerToRawHandler;
use N1ebieski\KSEFClient\DTOs\QRCodes;
use N1ebieski\KSEFClient\DTOs\Requests\Auth\ContextIdentifierGroup;
use N1ebieski\KSEFClient\Support\Str;
use N1ebieski\KSEFClient\ValueObjects\Certificate;
use N1ebieski\KSEFClient\ValueObjects\CertificateSerialNumber;
use N1ebieski\KSEFClient\ValueObjects\PrivateKeyType;
use RuntimeException;

final readonly class GenerateQRCodesHandler extends AbstractHandler
{
    public function __construct(
        private QrCodeBuilderInterface $qrCodeBuilder,
        private ConvertEcdsaDerToRawHandler $convertEcdsaDerToRawHandler
    ) {
    }

    public function handle(GenerateQRCodesAction $action): QRCodes
    {
        $invoiceBase64 = Str::base64URLEncode(hash('sha256', $action->document, true));

        $code1Parts = [
            (string) $action->mode->getClientAppInvoiceUrl(),
            (string) $action->nip,
            $action->invoiceCreatedAt->format('d-m-Y'),
            $invoiceBase64
        ];

        $invoiceLink = implode('/', $code1Parts);

        $code1 = $this->qrCodeBuilder->build(
            data: $invoiceLink,
            labelText: $action->ksefNumber?->value ?? 'OFFLINE'
        )->getString();

        $code2 = null;

        if (
            $action->certificate instanceof Certificate
            && $action->certificateSerialNumber instanceof CertificateSerialNumber
            && $action->contextIdentifierGroup instanceof ContextIdentifierGroup
        ) {
            $code2Parts = [
                (string) $action->mode->getClientAppCertificateUrl(),
                $action->contextIdentifierGroup->identifierGroup->getIdentifier()->getType(),
                (string) $action->contextIdentifierGroup->identifierGroup->getIdentifier(),
                (string) $action->nip,
                (string) $action->certificateSerialNumber,
                $invoiceBase64
            ];

            $certificateLink = implode('/', $code2Parts);

            $signature = '';

            $sign = openssl_sign(
                $certificateLink,
                $signature,
                $action->certificate->privateKey,
                $action->certificate->getAlgorithm()
            );

            if ($sign === false) {
                throw new RuntimeException('Unable to sign link');
            }

            // If private key type is EC, convert DER to raw. Don't ask me why, but it works
            if ($action->certificate->getPrivateKeyType()->isEquals(PrivateKeyType::EC)) {
                $signature = $this->convertEcdsaDerToRawHandler->handle(
                    new ConvertEcdsaDerToRawAction($signature, 32)
                );
            }

            $signature = Str::base64URLEncode($signature);

            $certificateLink .= "/{$signature}";

            $code2 = $this->qrCodeBuilder->build(
                data: $certificateLink,
                labelText: 'CERTYFIKAT'
            )->getString();
        }

        return new QRCodes($code1, $code2);
    }
}
