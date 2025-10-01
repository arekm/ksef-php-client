<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Auth\Status;

use N1ebieski\KSEFClient\Requests\AbstractRequest;
use N1ebieski\KSEFClient\Requests\ValueObjects\ReferenceNumber;
use SensitiveParameter;

final readonly class StatusRequest extends AbstractRequest
{
    public function __construct(
        #[SensitiveParameter]
        public ReferenceNumber $referenceNumber,
    ) {
    }
}
