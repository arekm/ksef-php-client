<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Factories;

use N1ebieski\KSEFClient\Requests\Sessions\ValueObjects\EncryptedKey;
use N1ebieski\KSEFClient\ValueObjects\EncryptionKey;
use N1ebieski\KSEFClient\ValueObjects\KsefPublicKey;
use RuntimeException;

final readonly class EncryptedKeyFactory extends AbstractFactory
{
    public static function make(EncryptionKey $encryptionKey, KsefPublicKey $ksefPublicKey): EncryptedKey
    {
        $encryptKey = openssl_public_encrypt($encryptionKey->key, $encryptedKey, $ksefPublicKey->value, OPENSSL_PKCS1_PADDING);

        if ($encryptKey === false) {
            throw new RuntimeException('Unable to encrypt key');
        }

        /** @var string $encryptedKey */
        $encryptedKey = base64_encode((string) $encryptedKey); //@phpstan-ignore-line

        /** @var string $encryptedIv */
        $encryptedIv = base64_encode($encryptionKey->iv);

        return new EncryptedKey($encryptedKey, $encryptedIv);
    }
}
