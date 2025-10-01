<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\ConvertEcdsaDerToRaw;

use N1ebieski\KSEFClient\Actions\AbstractAction;
use SensitiveParameter;

final readonly class ConvertEcdsaDerToRawAction extends AbstractAction
{
    public function __construct(
        #[SensitiveParameter]
        public string $der,
        public int $keySize = 32,
    ) {
    }
}
