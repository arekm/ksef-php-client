<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Tests\Resources;

use DateTimeImmutable;
use N1ebieski\KSEFClient\Testing\AbstractTestCase;
use N1ebieski\KSEFClient\Testing\Fixtures\Requests\Auth\Token\Refresh\RefreshResponseFixture;
use N1ebieski\KSEFClient\ValueObjects\AccessToken;
use N1ebieski\KSEFClient\ValueObjects\RefreshToken;

final class ClientResourceTest extends AbstractTestCase
{
    public function testAutoAccessTokenRefresh(): void
    {
        $responseFixture = new RefreshResponseFixture()->withValidUntil(new DateTimeImmutable('+15 minutes'));

        $accessToken = new AccessToken('access-token', new DateTimeImmutable('-15 minutes'));
        $refreshToken = new RefreshToken('refresh-token', new DateTimeImmutable('+7 days'));

        $clientStub = $this->getClientStub($responseFixture)
            ->withAccessToken($accessToken)
            ->withRefreshToken($refreshToken);

        $clientStub->sessions();

        $newAccessToken = $clientStub->getAccessToken();

        $this->assertFalse($newAccessToken->isEquals($accessToken));

        $this->assertTrue($newAccessToken->isEquals($responseFixture->getAccessToken()));
    }

    public function testThrowExceptionIfAccessTokenIsExpired(): void
    {
        $accessToken = new AccessToken('access-token', new DateTimeImmutable('-15 minutes'));

        $clientStub = $this->getClientStub(new RefreshResponseFixture())
            ->withAccessToken($accessToken);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Access token and refresh token are expired.');

        $clientStub->sessions();
    }
}
