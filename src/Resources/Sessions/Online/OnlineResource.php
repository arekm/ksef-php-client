<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Resources\Sessions\Online;

use N1ebieski\KSEFClient\Contracts\HttpClient\HttpClientInterface;
use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Sessions\Online\OnlineResourceInterface;
use N1ebieski\KSEFClient\Requests\Sessions\Online\Open\OpenHandler;
use N1ebieski\KSEFClient\Requests\Sessions\Online\Open\OpenRequest;
use N1ebieski\KSEFClient\Resources\AbstractResource;

final class OnlineResource extends AbstractResource implements OnlineResourceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client
    ) {
    }

    public function open(OpenRequest | array $request): ResponseInterface
    {
        if ($request instanceof OpenRequest === false) {
            $request = OpenRequest::from($request);
        }

        return new OpenHandler($this->client)->handle($request);
    }
}
