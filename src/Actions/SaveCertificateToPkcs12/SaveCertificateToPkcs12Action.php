<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\SaveCertificateToPkcs12;

use N1ebieski\KSEFClient\Actions\AbstractAction;
use N1ebieski\KSEFClient\ValueObjects\Certificate;
use N1ebieski\KSEFClient\ValueObjects\CertificatePath;
use SensitiveParameter;

final readonly class SaveCertificateToPkcs12Action extends AbstractAction
{
    public function __construct(
        #[SensitiveParameter]
        public Certificate $certificate,
        #[SensitiveParameter]
        public string $path,
        #[SensitiveParameter]
        public ?string $passphrase = null
    ) {
    }
}
