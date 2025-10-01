<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\ConvertPemToDer;

use N1ebieski\KSEFClient\Actions\AbstractHandler;

final readonly class ConvertPemToDerHandler extends AbstractHandler
{
    public function handle(ConvertPemToDerAction $action): string
    {
        return base64_decode(preg_replace(
            '/-+BEGIN [^-]+-+|-+END [^-]+-+|\s+/',
            '',
            $action->pem
        ));
    }
}
