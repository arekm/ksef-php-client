<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Testdata\AttachmentPermission\Revoke;

use DateTime;
use N1ebieski\KSEFClient\Contracts\BodyInterface;
use N1ebieski\KSEFClient\Requests\AbstractRequest;
use N1ebieski\KSEFClient\Support\Optional;
use N1ebieski\KSEFClient\ValueObjects\NIP;

final class RevokeRequest extends AbstractRequest implements BodyInterface
{
    public function __construct(
        public readonly NIP $nip,
        public readonly Optional | DateTime | null $expectedEndDate = new Optional(),
    ) {
    }

    public function toBody(): array
    {
        /** @var array<string, mixed> */
        return $this->toArray();
    }
}
