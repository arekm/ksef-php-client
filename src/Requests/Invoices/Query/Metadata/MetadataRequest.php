<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Invoices\Query\Metadata;

use N1ebieski\KSEFClient\Contracts\BodyInterface;
use N1ebieski\KSEFClient\Contracts\ParametersInterface;
use N1ebieski\KSEFClient\DTOs\Requests\Invoices\Amount;
use N1ebieski\KSEFClient\DTOs\Requests\Invoices\BuyerIdentifier;
use N1ebieski\KSEFClient\DTOs\Requests\Invoices\DateRange;
use N1ebieski\KSEFClient\Requests\AbstractRequest;
use N1ebieski\KSEFClient\Support\Optional;
use N1ebieski\KSEFClient\ValueObjects\NIP;
use N1ebieski\KSEFClient\ValueObjects\Requests\InvoiceNumber;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\CurrencyCode;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\FormType;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\InvoiceType;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\InvoicingMode;
use N1ebieski\KSEFClient\ValueObjects\Requests\Invoices\SubjectType;
use N1ebieski\KSEFClient\ValueObjects\Requests\KsefNumber;
use N1ebieski\KSEFClient\ValueObjects\Requests\PageOffset;
use N1ebieski\KSEFClient\ValueObjects\Requests\PageSize;

final readonly class MetadataRequest extends AbstractRequest implements ParametersInterface, BodyInterface
{
    /**
     * @param Optional|array<int, CurrencyCode> $currencyCodes
     * @param Optional|array<int, InvoiceType> $invoiceTypes
     */
    public function __construct(
        public SubjectType $subjectType,
        public DateRange $dateRange,
        public Optional | KsefNumber $ksefNumber = new Optional(),
        public Optional | InvoiceNumber $invoiceNumber = new Optional(),
        public Optional | Amount $amount = new Optional(),
        public Optional | NIP $sellerNip = new Optional(),
        public Optional | BuyerIdentifier $buyerIdentifier = new Optional(),
        public Optional | array $currencyCodes = new Optional(),
        public Optional | InvoicingMode $invoicingMode = new Optional(),
        public Optional | bool $isSelfInvoicing = new Optional(),
        public Optional | FormType $formType = new Optional(),
        public Optional | array $invoiceTypes = new Optional(),
        public Optional | bool $hasAttachment = new Optional(),
        public Optional | PageSize $pageSize = new Optional(),
        public Optional | PageOffset $pageOffset = new Optional(),
    ) {
    }

    public function toParameters(): array
    {
        return $this->toArray(only: ['pageSize', 'pageOffset']);
    }

    public function toBody(): array
    {
        return $this->toArray(only: [
            'subjectType',
            'dateRange',
            'ksefNumber',
            'invoiceNumber',
            'amount',
            'sellerNip',
            'buyerIdentifier',
            'currencyCodes',
            'invoicingMode',
            'isSelfInvoicing',
            'formType',
            'invoiceTypes',
            'hasAttachment'
        ]);
    }
}
