<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Certificates\Query;

use N1ebieski\KSEFClient\Contracts\HttpClient\HttpClientInterface;
use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;
use N1ebieski\KSEFClient\HttpClient\DTOs\Request;
use N1ebieski\KSEFClient\HttpClient\ValueObjects\Method;
use N1ebieski\KSEFClient\HttpClient\ValueObjects\Uri;
use N1ebieski\KSEFClient\Requests\AbstractHandler;

final readonly class QueryHandler extends AbstractHandler
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function handle(QueryRequest $request): ResponseInterface
    {
        return $this->client->sendRequest(new Request(
            method: Method::Post,
            uri: Uri::from('certificates/query'),
            body: $request->toBody(),
            parameters: $request->toParameters()
        ));
    }
}
