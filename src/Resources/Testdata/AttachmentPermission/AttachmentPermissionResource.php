<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\Resources\Testdata\AttachmentPermission;

use N1ebieski\KSEFClient\Contracts\Exception\ExceptionHandlerInterface;
use N1ebieski\KSEFClient\Contracts\HttpClient\HttpClientInterface;
use N1ebieski\KSEFClient\Contracts\HttpClient\ResponseInterface;
use N1ebieski\KSEFClient\Contracts\Resources\Testdata\AttachmentPermission\AttachmentPermissionResourceInterface;
use N1ebieski\KSEFClient\Requests\Testdata\AttachmentPermission\Approve\ApproveHandler;
use N1ebieski\KSEFClient\Requests\Testdata\AttachmentPermission\Approve\ApproveRequest;
use N1ebieski\KSEFClient\Requests\Testdata\AttachmentPermission\Revoke\RevokeHandler;
use N1ebieski\KSEFClient\Requests\Testdata\AttachmentPermission\Revoke\RevokeRequest;
use N1ebieski\KSEFClient\Resources\AbstractResource;
use Throwable;

final class AttachmentPermissionResource extends AbstractResource implements AttachmentPermissionResourceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly ExceptionHandlerInterface $exceptionHandler
    ) {
    }

    public function approve(ApproveRequest|array $request): ResponseInterface
    {
        try {
            if ($request instanceof ApproveRequest === false) {
                $request = ApproveRequest::from($request);
            }

            return (new ApproveHandler($this->client))->handle($request);
        } catch (Throwable $throwable) {
            throw $this->exceptionHandler->handle($throwable);
        }
    }

    public function revoke(RevokeRequest|array $request): ResponseInterface
    {
        try {
            if ($request instanceof RevokeRequest === false) {
                $request = RevokeRequest::from($request);
            }

            return (new RevokeHandler($this->client))->handle($request);
        } catch (Throwable $throwable) {
            throw $this->exceptionHandler->handle($throwable);
        }
    }
}
