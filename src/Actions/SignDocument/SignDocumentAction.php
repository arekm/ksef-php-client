<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\SignDocument;

use N1ebieski\KSEFClient\Actions\AbstractAction;
use N1ebieski\KSEFClient\ValueObjects\Certificate;
use SensitiveParameter;

final readonly class SignDocumentAction extends AbstractAction
{
    public function __construct(
        #[SensitiveParameter]
        public Certificate $certificate,
        #[SensitiveParameter]
        public string $document,
        #[SensitiveParameter]
        public string | int $algorithm = OPENSSL_ALGO_SHA1
    ) {
    }

    public function getPrivateKeyType(): int
    {
        return $this->certificate->getPrivateKeyDetails()['type'];
    }

    public function getSignatureMethodNamespace(): string
    {
        return match ($this->getPrivateKeyType()) {
            OPENSSL_KEYTYPE_RSA => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
            OPENSSL_KEYTYPE_EC => 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256',
            default => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
        };
    }

    public function getAlgorithm(): int | string
    {
        return match ($this->getPrivateKeyType()) {
            OPENSSL_KEYTYPE_RSA => 'sha256WithRSAEncryption',
            OPENSSL_KEYTYPE_EC => OPENSSL_ALGO_SHA256,
            default => OPENSSL_ALGO_SHA256,
        };
    }
}
