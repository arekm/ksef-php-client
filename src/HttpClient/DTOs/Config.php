<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\HttpClient\DTOs;

use N1ebieski\KSEFClient\HttpClient\ValueObjects\BaseUri;
use N1ebieski\KSEFClient\Support\AbstractDTO;
use N1ebieski\KSEFClient\ValueObjects\AccessToken;
use SensitiveParameter;

final readonly class Config extends AbstractDTO
{
    public function __construct(
        public BaseUri $baseUri,
        #[SensitiveParameter]
        public ?AccessToken $accessToken = null,
    ) {
    }

    public function withAccessToken(AccessToken $accessToken): self
    {
        return new self($this->baseUri, $accessToken);
    }
}
