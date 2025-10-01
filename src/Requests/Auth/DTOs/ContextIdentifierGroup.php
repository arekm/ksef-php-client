<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Auth\DTOs;

use DOMDocument;
use DOMElement;
use N1ebieski\KSEFClient\Contracts\DomSerializableInterface;
use N1ebieski\KSEFClient\Support\AbstractDTO;
use N1ebieski\KSEFClient\ValueObjects\InternalId;
use N1ebieski\KSEFClient\ValueObjects\Nip;
use N1ebieski\KSEFClient\ValueObjects\NipVatUe;

final readonly class ContextIdentifierGroup extends AbstractDTO implements DomSerializableInterface
{
    public function __construct(
        public ContextIdentifierNipGroup | ContextIdentifierNipVatUeGroup | ContextIdentifierInternalIdGroup $contextIdentifierTypeGroup
    ) {
    }

    public static function fromIdentifier(Nip | NipVatUe | InternalId $identifier): self
    {
        return match (true) {
            $identifier instanceof Nip => new self(new ContextIdentifierNipGroup($identifier)),
            $identifier instanceof NipVatUe => new self(new ContextIdentifierNipVatUeGroup($identifier)),
            $identifier instanceof InternalId => new self(new ContextIdentifierInternalIdGroup($identifier)),
        };
    }

    public function toDom(): DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $contextIdentifierGroup = $dom->createElement('ContextIdentifierGroup');
        $dom->appendChild($contextIdentifierGroup);

        /** @var DOMElement $contextIdentifierTypeGroup */
        $contextIdentifierTypeGroup = $dom->importNode($this->contextIdentifierTypeGroup->toDom()->documentElement, true);

        foreach ($contextIdentifierTypeGroup->childNodes as $child) {
            $contextIdentifierGroup->appendChild($dom->importNode($child, true));
        }

        return $dom;
    }
}
