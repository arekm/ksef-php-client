<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Contracts\Resources\Sessions;

use N1ebieski\KSEFClient\Contracts\Resources\Sessions\Online\OnlineResourceInterface;

interface SessionsResourceInterface
{
    public function online(): OnlineResourceInterface;
}
