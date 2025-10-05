<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\DTOs;

use N1ebieski\KSEFClient\Support\AbstractDTO;

final readonly class QRCodes extends AbstractDTO
{
    public function __construct(
        public string $code1,
        public ?string $code2 = null,
    ) {
    }
}
