<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\GenerateQRCodes;

use DateTimeInterface;
use N1ebieski\KSEFClient\Actions\AbstractAction;
use N1ebieski\KSEFClient\DTOs\Requests\Auth\ContextIdentifierGroup;
use N1ebieski\KSEFClient\ValueObjects\Certificate;
use N1ebieski\KSEFClient\ValueObjects\CertificateSerialNumber;
use N1ebieski\KSEFClient\ValueObjects\Mode;
use N1ebieski\KSEFClient\ValueObjects\NIP;
use N1ebieski\KSEFClient\ValueObjects\Requests\KsefNumber;
use SensitiveParameter;

final readonly class GenerateQRCodesAction extends AbstractAction
{
    public function __construct(
        public NIP $nip,
        public DateTimeInterface $invoiceCreatedAt,
        #[SensitiveParameter]
        public string $document,
        public Mode $mode = Mode::Production,
        #[SensitiveParameter]
        public ?KsefNumber $ksefNumber = null,
        #[SensitiveParameter]
        public ?Certificate $certificate = null,
        #[SensitiveParameter]
        public ?CertificateSerialNumber $certificateSerialNumber = null,
        #[SensitiveParameter]
        public ?ContextIdentifierGroup $contextIdentifierGroup = null
    ) {
    }
}
