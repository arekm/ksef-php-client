<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Auth\DTOs;

use DOMDocument;
use N1ebieski\KSEFClient\Contracts\DomSerializableInterface;
use N1ebieski\KSEFClient\ValueObjects\NipVatUe;
use N1ebieski\KSEFClient\Support\AbstractDTO;

final readonly class ContextIdentifierNipVatUeGroup extends AbstractDTO implements DomSerializableInterface
{
    public function __construct(
        public NipVatUe $nipVatUe,
    ) {
    }

    public function toDom(): DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $contextIdentifierNipVatUeGroup = $dom->createElement('ContextIdentifierNipVatUeGroup');
        $dom->appendChild($contextIdentifierNipVatUeGroup);

        $nip = $dom->createElement('NipVatUe');
        $nip->appendChild($dom->createTextNode((string) $this->nipVatUe->value));

        $contextIdentifierNipVatUeGroup->appendChild($nip);

        return $dom;
    }
}
