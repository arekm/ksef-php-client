<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Testing\Fixtures\Requests\Testdata\AttachmentPermission\Approve;

use N1ebieski\KSEFClient\Testing\Fixtures\Requests\AbstractResponseFixture;

final class ApproveResponseFixture extends AbstractResponseFixture
{
    public int $statusCode = 200;

    public string $data = '';
}
