<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\DTOs\Requests\Invoices;

use N1ebieski\KSEFClient\Support\AbstractDTO;
use N1ebieski\KSEFClient\Support\Optional;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\AmountFrom;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\AmountTo;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\AmountType;

final readonly class Amount extends AbstractDTO
{
    public function __construct(
        public AmountType $type,
        public Optional | AmountFrom $from = new Optional(),
        public Optional | AmountTo $to = new Optional(),
    ) {
    }
}
