<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\DTOs\Requests\Invoices;

use N1ebieski\KSEFClient\Support\AbstractDTO;
use N1ebieski\KSEFClient\Support\Optional;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\BuyerIdentifierType;

final readonly class BuyerIdentifier extends AbstractDTO
{
    public function __construct(
        public BuyerIdentifierType $type,
        public Optional | string $value = new Optional(),
    ) {
    }
}
