<?php

declare(strict_types=1);

use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Auth\Sessions\RevokeCurrent\RevokeCurrentResponseFixture;
use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Error\ErrorResponseFixture;

use function N1ebieski\KSEFClient\Tests\getClientStub;

/**
 * @return array<string, array{RevokeCurrentResponseFixture}>
 */
dataset('validResponseProvider', function (): array {
    $responses = [
        new RevokeCurrentResponseFixture(),
    ];

    $combinations = [];

    foreach ($responses as $response) {
        $combinations[$response->name] = [$response];
    }

    /** @var array<string, array{RevokeCurrentResponseFixture}> */
    return $combinations;
});

test('valid response', function (RevokeCurrentResponseFixture $responseFixture): void {
    $clientStub = getClientStub($responseFixture);

    $response = $clientStub->auth()->sessions()->revokeCurrent()->status();

    expect($response)->toEqual($responseFixture->statusCode);
})->with('validResponseProvider');

test('invalid response', function (): void {
    $responseFixture = new ErrorResponseFixture();

    expect(function () use ($responseFixture): void {
        $clientStub = getClientStub($responseFixture);

        $clientStub->auth()->sessions()->revokeCurrent();
    })->toBeExceptionFixture($responseFixture->data);
});
