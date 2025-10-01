<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\ValueObjects;

use DateTimeInterface;
use N1ebieski\KSEFClient\Support\AbstractValueObject;
use SensitiveParameter;
use Stringable;

final readonly class RefreshToken extends AbstractValueObject implements Stringable
{
    public function __construct(
        #[SensitiveParameter]
        public string $token,
        #[SensitiveParameter]
        public ?DateTimeInterface $validUntil = null
    ) {
    }

    public function __toString(): string
    {
        return $this->token;
    }

    public static function from(string $token, ?DateTimeInterface $validUntil = null): self
    {
        return new self($token, $validUntil);
    }

    public function isExpired(): bool
    {
        return $this->validUntil instanceof DateTimeInterface
            && $this->validUntil < new \DateTimeImmutable(timezone: new \DateTimeZone('UTC'));
    }
}
