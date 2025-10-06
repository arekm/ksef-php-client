<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Resources\Invoices\Query;

use N1ebieski\KSEFClient\Contracts\HttpClient\HttpClientInterface;
use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Invoices\Query\QueryResourceInterface;
use N1ebieski\KSEFClient\DTOs\Config;
use N1ebieski\KSEFClient\Requests\Invoices\Query\Metadata\MetadataHandler;
use N1ebieski\KSEFClient\Requests\Invoices\Query\Metadata\MetadataRequest;
use N1ebieski\KSEFClient\Resources\AbstractResource;
use Psr\Log\LoggerInterface;

final class QueryResource extends AbstractResource implements QueryResourceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly Config $config,
        private readonly ?LoggerInterface $logger = null
    ) {
    }

    public function metadata(MetadataRequest | array $request): ResponseInterface
    {
        if ($request instanceof MetadataRequest === false) {
            $request = MetadataRequest::from($request);
        }

        return new MetadataHandler($this->client)->handle($request);
    }
}
