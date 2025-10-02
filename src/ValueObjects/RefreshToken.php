<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\ValueObjects;

use DateTimeInterface;
use N1ebieski\KSEFClient\Support\AbstractValueObject;
use N1ebieski\KSEFClient\ValueObjects\Concerns\HasExpired;
use SensitiveParameter;
use Stringable;

final readonly class RefreshToken extends AbstractValueObject implements Stringable
{
    use HasExpired;

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
}
