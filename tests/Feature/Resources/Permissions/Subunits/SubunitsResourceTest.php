<?php

use N1ebieski\KSEFClient\ClientBuilder;
use N1ebieski\KSEFClient\Exceptions\HttpClient\BadRequestException;
use N1ebieski\KSEFClient\Factories\EncryptionKeyFactory;
use N1ebieski\KSEFClient\Factories\InternalIdFactory;
use N1ebieski\KSEFClient\Support\InternalId;
use N1ebieski\KSEFClient\Support\Utility;
use N1ebieski\KSEFClient\Testing\Fixtures\DTOs\Requests\Sessions\FakturaSprzedazyTowaruFixture;
use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Sessions\Online\Send\SendRequestFixture;
use N1ebieski\KSEFClient\Tests\Feature\AbstractTestCase;
use N1ebieski\KSEFClient\ValueObjects\Mode;
use N1ebieski\KSEFClient\ValueObjects\NIP;
use N1ebieski\KSEFClient\ValueObjects\Requests\Testdata\Subject\SubjectType;

/** @var AbstractTestCase $this */

beforeAll(function (): void {
    $client = (new ClientBuilder())
        ->withMode(Mode::Test)
        ->build();

    try {
        $client->testdata()->person()->create([
            'nip' => $_ENV['NIP_2'],
            'pesel' => $_ENV['PESEL_2'],
            'description' => 'Subject who get InternalId permission',
        ])->status();
    } catch (BadRequestException $exception) {
        if (str_starts_with($exception->getMessage(), '30001')) {
            // ignore
        }
    }
});

afterAll(function (): void {
    $client = (new ClientBuilder())
        ->withMode(Mode::Test)
        ->build();

    $client->testdata()->person()->remove([
        'nip' => $_ENV['NIP_2'],
    ]);
});

test('create InternalId for person', function (): void {
    /** @var AbstractTestCase $this */
    /** @var array<string, string> $_ENV */

    $clientNip1 = $this->createClient();

    /** @var object{referenceNumber: string} $grantsResponse */
    $grantsResponse = $clientNip1->permissions()->subunits()->grants([
        'subjectIdentifierGroup' => [
            'pesel' => $_ENV['PESEL_2']
        ],
        'contextIdentifierGroup' => [
            'internalId' => InternalIdFactory::make(NIP::from($_ENV['NIP_1']), '1234')
        ],
        'description' => 'Create InternalId for PESEL_2',
        'subunitName' => 'Subunit for PESEL_2',
        'subjectDetails' => [
            'personById' => [
                'firstName' => $_ENV['FIRST_NAME_2'],
                'lastName' => $_ENV['LAST_NAME_2'],
            ]
        ]
    ])->object();

    Utility::retry(function (int $attempts) use ($clientNip1, $grantsResponse) {
        /** @var object{status: object{code: int}, referenceNumber: string} $statusResponse */
        $statusResponse = $clientNip1->permissions()->operations()->status([
            'referenceNumber' => $grantsResponse->referenceNumber,
        ])->object();

        try {
            expect($statusResponse->status->code)->toBe(200);

            return $statusResponse;
        } catch (Throwable $exception) {
            if ($attempts > 2) {
                throw $exception;
            }
        }
    });

    $clientNip2 = $this->createClient(
        identifier: $_ENV['NIP_2'],
        certificatePath: $_ENV['CERTIFICATE_PATH_2'],
        certificatePassphrase: $_ENV['CERTIFICATE_PASSPHRASE_2']
    );

    /** @var object{permissions: array<int, object{id: string}>} $queryResponse */
    $queryResponse = $clientNip2->permissions()->query()->personal()->grants([
        'contextIdentifierGroup' => [
            'nip' => $_ENV['NIP_1']
        ],
    ])->object();

    expect($queryResponse)->toHaveProperty('permissions');

    expect($queryResponse->permissions)->toBeArray()->not->toBeEmpty();

    expect($queryResponse->permissions[0])->toHaveProperty('id');

    expect($queryResponse->permissions[0]->id)->toBeString();

    /** @var object{referenceNumber: string} $revokePermissionResponse */
    $revokePermissionResponse = $clientNip2->permissions()->common()->revoke([
        'permissionId' => $queryResponse->permissions[0]->id
    ])->object();

    Utility::retry(function (int $attempts) use ($clientNip2, $revokePermissionResponse) {
        /** @var object{status: object{code: int}, referenceNumber: string} $statusResponse */
        $statusResponse = $clientNip2->permissions()->operations()->status([
            'referenceNumber' => $revokePermissionResponse->referenceNumber,
        ])->object();

        try {
            expect($statusResponse->status->code)->toBe(200);

            return $statusResponse;
        } catch (Throwable $exception) {
            if ($attempts > 2) {
                throw $exception;
            }
        }
    });

    $this->revokeCurrentSession($clientNip1);
    $this->revokeCurrentSession($clientNip2);
})->only();
