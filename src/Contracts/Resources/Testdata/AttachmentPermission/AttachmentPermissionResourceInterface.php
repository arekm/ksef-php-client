<?php

namespace N1ebieski\KSEFClient\Contracts\Resources\Testdata\AttachmentPermission;

use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;
use N1ebieski\KSEFClient\Requests\Testdata\AttachmentPermission\Approve\ApproveRequest;
use N1ebieski\KSEFClient\Requests\Testdata\AttachmentPermission\Revoke\RevokeRequest;

interface AttachmentPermissionResourceInterface
{
    /**
     * @param ApproveRequest|array<string, mixed> $request
     */
    public function approve(ApproveRequest | array $request): ResponseInterface;

    /**
     * @param RevokeRequest|array<string, mixed> $request
     */
    public function revoke(RevokeRequest | array $request): ResponseInterface;
}
