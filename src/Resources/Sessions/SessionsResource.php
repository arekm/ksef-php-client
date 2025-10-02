<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Resources\Sessions;

use N1ebieski\KSEFClient\Contracts\HttpClient\HttpClientInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Sessions\Online\OnlineResourceInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Sessions\SessionsResourceInterface;
use N1ebieski\KSEFClient\Resources\AbstractResource;
use N1ebieski\KSEFClient\Resources\Sessions\Online\OnlineResource;

final class SessionsResource extends AbstractResource implements SessionsResourceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client
    ) {
    }

    public function online(): OnlineResourceInterface
    {
        return new OnlineResource($this->client);
    }
}
