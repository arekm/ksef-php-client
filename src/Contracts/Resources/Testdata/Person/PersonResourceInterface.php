<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Contracts\Resources\Testdata\Person;

use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;
use N1ebieski\KSEFClient\Requests\Testdata\Person\Create\CreateRequest;
use N1ebieski\KSEFClient\Requests\Testdata\Person\Remove\RemoveRequest;

interface PersonResourceInterface
{
    public function create(CreateRequest | array $request): ResponseInterface;

    public function remove(RemoveRequest | array $request): ResponseInterface;
}
