<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\ValueObjects;

use BCMathExtended\BC;
use N1ebieski\KSEFClient\Support\AbstractValueObject;
use OpenSSLAsymmetricKey;
use RuntimeException;
use SensitiveParameter;

final readonly class Certificate extends AbstractValueObject
{
    /**
     * @param array{issuer: array<string, string>, serialNumberHex: string} $info
     */
    public function __construct(
        #[SensitiveParameter]
        public string $raw,
        #[SensitiveParameter]
        public array $info,
        #[SensitiveParameter]
        public OpenSSLAsymmetricKey $privateKey,
    ) {
    }

    /**
     * @return array{bits: int, key: string, rsa: array, dsa: array, dh: array, ec: array, type: int}
     */
    public function getPrivateKeyDetails(): array
    {
        $details = openssl_pkey_get_details($this->privateKey);

        if ($details === false) {
            throw new RuntimeException('Unable to get key details');
        }

        return $details;
    }

    public function getFingerPrint(): string
    {
        return base64_encode(hash('sha256', base64_decode($this->raw), true));
    }

    public function getSerialNumber(): string
    {
        return BC::hexdec($this->info['serialNumberHex']);
    }

    public function getIssuer(): string
    {
        $issuer = [];

        foreach ($this->info['issuer'] as $key => $value) {
            $issuer[] = $key . '=' . $value;
        }

        return implode(', ', array_reverse($issuer));
    }
}
