<?php

declare(strict_types=1);

use N1ebieski\KSEFClient\DTOs\Requests\Sessions\Faktura;
use N1ebieski\KSEFClient\Support\Arr;
use N1ebieski\KSEFClient\Support\Optional;
use N1ebieski\KSEFClient\Testing\Fixtures\DTOs\Requests\Sessions\FakturaSprzedazyTowaruFixture;

test('filter recursive', function (): void {
    $array = [
        'a' => 'b',
        'c' => [
            'd' => new Optional(),
            'f' => [
                'g' => 'h',
                'i' => [
                    'j' => new Optional(),
                ],
            ],
        ],
    ];

    $expectedArray = [
        'a' => 'b',
        'c' => [
            'f' => [
                'g' => 'h'
            ],
        ],
    ];

    $result = Arr::filterRecursive($array, fn (mixed $value): bool => ! $value instanceof Optional);

    expect($result)->toBe($expectedArray);
})->only();

// test('array with key type except', function (): void {
//     $fakturaFixture = (new FakturaSprzedazyTowaruFixture())
//         ->withTodayDate()
//         ->withNip($_ENV['NIP_1'])
//         ->withRandomInvoiceNumber();

//     $faktura = Faktura::from($fakturaFixture->data);

//     $found = [];

//     $scan = function ($data) use (&$scan, &$found) {
//         var_dump($data);
//         foreach ($data as $key => $value) {
//             if (str_starts_with($key, 'p_') || str_starts_with($key, 'uu_id')) {
//                 $found[] = $key;
//             }

//             if (is_array($value)) {
//                 $scan($value);
//             }
//         }
//     };

//     $scan($faktura->toArray());

//     expect($found)->not->toBeEmpty();
// })->only();
