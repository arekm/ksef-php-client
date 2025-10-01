<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Certificates\Retrieve;

use N1ebieski\KSEFClient\Contracts\BodyInterface;
use N1ebieski\KSEFClient\Requests\AbstractRequest;
use N1ebieski\KSEFClient\Requests\Certificates\ValueObjects\CertificateSerialNumber;
use N1ebieski\KSEFClient\Support\ValueObjects\KeyType;

final readonly class RetrieveRequest extends AbstractRequest implements BodyInterface
{
    /**
     * @param array<int, CertificateSerialNumber> $certificateSerialNumbers
     */
    public function __construct(
        public array $certificateSerialNumbers,
    ) {
    }

    public function toBody(KeyType $keyType = KeyType::Camel): array
    {
        return $this->toArray($keyType);
    }
}
