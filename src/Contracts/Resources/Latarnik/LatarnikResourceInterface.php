<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Contracts\Resources\Latarnik;

use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;

interface LatarnikResourceInterface
{
    public function status(): ResponseInterface;

    public function messages(): ResponseInterface;
}
