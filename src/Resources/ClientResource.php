<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Resources;

use DateTimeImmutable;
use DateTimeInterface;
use N1ebieski\KSEFClient\Contracts\HttpClient\HttpClientInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Auth\AuthResourceInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Certificates\CertificatesResourceInterface;
use N1ebieski\KSEFClient\Contracts\Resources\ClientResourceInterface;
use N1ebieski\KSEFClient\DTOs\Config;
use N1ebieski\KSEFClient\Resources\AbstractResource;
use N1ebieski\KSEFClient\Resources\Auth\AuthResource;
use N1ebieski\KSEFClient\Resources\Certificates\CertificatesResource;
use N1ebieski\KSEFClient\ValueObjects\AccessToken;
use N1ebieski\KSEFClient\ValueObjects\RefreshToken;
use Psr\Log\LoggerInterface;

final class ClientResource extends AbstractResource implements ClientResourceInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private Config $config,
        readonly private ?LoggerInterface $logger = null
    ) {
    }

    public function getAccessToken(): ?AccessToken
    {
        return $this->config->accessToken;
    }

    public function getRefreshToken(): ?RefreshToken
    {
        return $this->config->refreshToken;
    }

    public function withAccessToken(AccessToken $accessToken, ?DateTimeInterface $validUntil = null): self
    {
        $this->client = $this->client->withAccessToken($accessToken);
        $this->config = $this->config->withAccessToken($accessToken);

        return $this;
    }

    public function withRefreshToken(RefreshToken $refreshToken, ?DateTimeInterface $validUntil = null): self
    {
        $this->config = $this->config->withRefreshToken($refreshToken);

        return $this;
    }

    private function refreshTokenIfExpired(): void
    {
        if ($this->config->accessToken->isExpired() && $this->config->refreshToken?->isExpired() === false) {
            $this->withAccessToken(AccessToken::from($this->config->refreshToken->token));

            /** @var object{accessToken: object{token: string, validUntil: string<date-time>}} $authorisationTokenResponse */
            $authorisationTokenResponse = $this->auth()->token()->refresh()->object();

            $this->withAccessToken(AccessToken::from(
                token: $authorisationTokenResponse->accessToken->token,
                validUntil: new DateTimeImmutable($authorisationTokenResponse->accessToken->validUntil)
            ));
        }
    }

    public function auth(): AuthResourceInterface
    {
        return new AuthResource($this->client);
    }

    public function certificates(): CertificatesResourceInterface
    {
        $this->refreshTokenIfExpired();

        return new CertificatesResource($this->client);
    }
}
