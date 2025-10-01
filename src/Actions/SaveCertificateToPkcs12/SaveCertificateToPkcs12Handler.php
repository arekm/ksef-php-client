<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Actions\SaveCertificateToPkcs12;

use N1ebieski\KSEFClient\Actions\AbstractHandler;
use N1ebieski\KSEFClient\ValueObjects\CertificatePath;
use RuntimeException;

final readonly class SaveCertificateToPkcs12Handler extends AbstractHandler
{
    public function handle(SaveCertificateToPkcs12Action $action): CertificatePath
    {
        $result = openssl_pkcs12_export_to_file(
            certificate: $action->certificate->raw,
            output_filename: $action->path,
            private_key: $action->certificate->privateKey,
            passphrase: $action->passphrase
        );

        if ($result === false) {
            throw new RuntimeException('Unable to save the p12 file');
        }

        return CertificatePath::from($action->path, $action->passphrase);
    }
}
