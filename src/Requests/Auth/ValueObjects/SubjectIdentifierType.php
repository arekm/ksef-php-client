<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Requests\Auth\ValueObjects;

enum SubjectIdentifierType: string
{
    case CertificateSubject = 'certificateSubject';

    case CertificateFingerprint = 'certificateFingerprint';
}
