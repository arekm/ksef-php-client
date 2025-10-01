<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\ConvertPemToDer;

use N1ebieski\KSEFClient\Actions\AbstractAction;
use SensitiveParameter;

final readonly class ConvertPemToDerAction extends AbstractAction
{
    public function __construct(
        #[SensitiveParameter]
        public string $pem
    ) {
    }
}
