<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\SignDocument;

use N1ebieski\KSEFClient\Actions\AbstractAction;
use N1ebieski\KSEFClient\ValueObjects\Certificate;
use N1ebieski\KSEFClient\ValueObjects\PrivateKeyType;
use SensitiveParameter;

final readonly class SignDocumentAction extends AbstractAction
{
    public function __construct(
        #[SensitiveParameter]
        public Certificate $certificate,
        #[SensitiveParameter]
        public string $document,
    ) {
    }

    public function getSignatureMethodNamespace(): string
    {
        return match ($this->certificate->getPrivateKeyType()) {
            PrivateKeyType::RSA => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
            PrivateKeyType::EC => 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256',
            default => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
        };
    }
}
