<?php

declare(strict_types=1);

use function N1ebieski\KSEFClient\Tests\getClientStub;
use N1ebieski\KSEFClient\Requests\Invoices\Query\Metadata\MetadataRequest;
use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Error\ErrorResponseFixture;
use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Invoices\Query\Metadata\MetadataRequestFixture;

use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Invoices\Query\Metadata\MetadataResponseFixture;

/**
 * @return array<string, array{MetadataRequestFixture, MetadataResponseFixture}>
 */
dataset('validResponseProvider', function () {
    $requests = [
        new MetadataRequestFixture(),
    ];

    $responses = [
        new MetadataResponseFixture(),
    ];

    $combinations = [];

    foreach ($requests as $request) {
        foreach ($responses as $response) {
            $combinations["{$request->name}, {$response->name}"] = [$request, $response];
        }
    }

    /** @var array<string, array{MetadataRequestFixture, MetadataResponseFixture}> */
    return $combinations;
});

test('valid response', function (MetadataRequestFixture $requestFixture, MetadataResponseFixture $responseFixture) {
    $clientStub = getClientStub($responseFixture);

    $request = MetadataRequest::from($requestFixture->data);

    expect($request)->toBeFixture($requestFixture->data);

    $test = $request->toBody();

    $response = $clientStub->invoices()->query()->metadata($requestFixture->data)->object();

    expect($response)->toBeFixture($responseFixture->data);
})->with('validResponseProvider')->only();

test('invalid response', function () {
    $responseFixture = new ErrorResponseFixture();

    expect(function () use ($responseFixture) {
        $requestFixture = new MetadataRequestFixture();

        $clientStub = getClientStub($responseFixture);

        $clientStub->invoices()->query()->metadata($requestFixture->data);
    })->toBeExceptionFixture($responseFixture->data);
});
