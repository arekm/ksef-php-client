<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Auth\Token\Refresh;

use N1ebieski\KSEFClient\Contracts\HttpClient\HttpClientInterface;
use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;
use N1ebieski\KSEFClient\HttpClient\DTOs\Request;
use N1ebieski\KSEFClient\HttpClient\ValueObjects\Method;
use N1ebieski\KSEFClient\HttpClient\ValueObjects\Uri;
use N1ebieski\KSEFClient\Requests\AbstractHandler;

final readonly class RefreshHandler extends AbstractHandler
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function handle(): ResponseInterface
    {
        return $this->client->sendRequest(new Request(
            method: Method::Post,
            uri: Uri::from('auth/token/refresh')
        ));
    }
}
