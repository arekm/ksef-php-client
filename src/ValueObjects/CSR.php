<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\ValueObjects;

use N1ebieski\KSEFClient\Support\AbstractValueObject;
use OpenSSLAsymmetricKey;
use SensitiveParameter;

final readonly class CSR extends AbstractValueObject
{
    public function __construct(
        #[SensitiveParameter]
        public string $raw,
        #[SensitiveParameter]
        public OpenSSLAsymmetricKey $privateKey
    ) {
    }
}
