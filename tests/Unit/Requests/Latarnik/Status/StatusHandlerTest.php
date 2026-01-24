<?php

declare(strict_types=1);

use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Latarnik\Status\StatusResponseFixture;
use N1ebieski\KSEFClient\Tests\Unit\AbstractTestCase;

/** @var AbstractTestCase $this */

/**
 * @return array<string, array{StatusResponseFixture}>
 */
dataset('validResponseProvider', function (): array {
    $responses = [
        new StatusResponseFixture(),
    ];

    $combinations = [];

    foreach ($responses as $response) {
        $combinations[$response->name] = [$response];
    }

    /** @var array<string, array{StatusResponseFixture}> */
    return $combinations;
});

test('valid response', function (StatusResponseFixture $responseFixture): void {
    /** @var AbstractTestCase $this */
    $clientStub = $this->createClientStub($responseFixture);

    $response = $clientStub->latarnik()->status()->object();

    expect($response)->toBeFixture($responseFixture->data);
})->with('validResponseProvider');
