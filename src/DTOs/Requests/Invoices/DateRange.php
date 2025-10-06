<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\DTOs\Requests\Invoices;

use N1ebieski\KSEFClient\Support\AbstractDTO;
use N1ebieski\KSEFClient\Support\Optional;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\DateRangeFrom;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\DateRangeTo;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\DateType;

final readonly class DateRange extends AbstractDTO
{
    public function __construct(
        public DateType $dateType,
        public DateRangeFrom $from,
        public Optional | DateRangeTo $to = new Optional(),
    ) {
    }
}
