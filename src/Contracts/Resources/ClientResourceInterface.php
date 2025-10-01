<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Contracts\Resources;

use DateTimeInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Auth\AuthResourceInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Certificates\CertificatesResourceInterface;
use N1ebieski\KSEFClient\ValueObjects\AccessToken;
use N1ebieski\KSEFClient\ValueObjects\RefreshToken;

interface ClientResourceInterface
{
    public function getAccessToken(): ?AccessToken;

    public function getRefreshToken(): ?RefreshToken;

    public function withAccessToken(AccessToken $accessToken, ?DateTimeInterface $validUntil = null): self;

    public function withRefreshToken(RefreshToken $refreshToken, ?DateTimeInterface $validUntil = null): self;

    public function auth(): AuthResourceInterface;

    public function certificates(): CertificatesResourceInterface;
}
