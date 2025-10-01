<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\ConvertDerToPem;

use N1ebieski\KSEFClient\Actions\AbstractAction;
use N1ebieski\KSEFClient\ValueObjects\Certificate;
use SensitiveParameter;

final readonly class ConvertDerToPemAction extends AbstractAction
{
    public function __construct(
        #[SensitiveParameter]
        public string $der,
        public string $name
    ) {
    }
}
