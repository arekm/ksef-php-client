<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Resources\Auth\Sessions;

use N1ebieski\KSEFClient\Contracts\HttpClient\HttpClientInterface;
use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Auth\Sessions\SessionsResourceInterface;
use N1ebieski\KSEFClient\Requests\Auth\Sessions\List\ListHandler;
use N1ebieski\KSEFClient\Requests\Auth\Sessions\List\ListRequest;
use N1ebieski\KSEFClient\Requests\Auth\Sessions\Revoke\RevokeHandler;
use N1ebieski\KSEFClient\Requests\Auth\Sessions\Revoke\RevokeRequest;
use N1ebieski\KSEFClient\Requests\Auth\Sessions\RevokeCurrent\RevokeCurrentHandler;
use N1ebieski\KSEFClient\Resources\AbstractResource;

final class SessionsResource extends AbstractResource implements SessionsResourceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client
    ) {
    }

    public function list(ListRequest | array $request = []): ResponseInterface
    {
        if ($request instanceof ListRequest === false) {
            $request = ListRequest::from($request);
        }

        return (new ListHandler($this->client))->handle($request);
    }

    public function revokeCurrent(): ResponseInterface
    {
        return (new RevokeCurrentHandler($this->client))->handle();
    }

    public function revoke(RevokeRequest | array $request): ResponseInterface
    {
        if ($request instanceof RevokeRequest === false) {
            $request = RevokeRequest::from($request);
        }

        return (new RevokeHandler($this->client))->handle($request);
    }
}
