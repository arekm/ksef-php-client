<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\ValueObjects;

use N1ebieski\KSEFClient\Contracts\EnumInterface;
use N1ebieski\KSEFClient\Support\Concerns\HasEquals;

enum PrivateKeyType: string implements EnumInterface
{
    use HasEquals;

    case RSA = 'RSA';

    case EC = 'EC';

    public function getOptions(): array
    {
        return match ($this) {
            self::RSA => [
                'private_key_bits' => 2048,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
            ],
            self::EC => [
                'private_key_type' => OPENSSL_KEYTYPE_EC,
                'curve_name' => 'prime256v1'
            ]
        };
    }
}
