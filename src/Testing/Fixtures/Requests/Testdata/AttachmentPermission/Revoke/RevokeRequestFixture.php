<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Testing\Fixtures\Requests\Testdata\AttachmentPermission\Revoke;

use N1ebieski\KSEFClient\Testing\Fixtures\Requests\AbstractRequestFixture;

final class RevokeRequestFixture extends AbstractRequestFixture
{
    /**
     * @var array<string, mixed>
     */
    public array $data = [
        'nip' => '1234567890',
    ];
}
