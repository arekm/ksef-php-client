<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\HttpClient\Factories;

use N1ebieski\KSEFClient\Factories\AbstractFactory;
use N1ebieski\KSEFClient\HttpClient\Exceptions\BadRequestException;
use N1ebieski\KSEFClient\HttpClient\Exceptions\ClientException;
use N1ebieski\KSEFClient\HttpClient\Exceptions\Exception;
use N1ebieski\KSEFClient\HttpClient\Exceptions\InternalServerException;
use N1ebieski\KSEFClient\HttpClient\Exceptions\ServerException;
use N1ebieski\KSEFClient\HttpClient\Exceptions\UnknownSystemException;

final readonly class ExceptionFactory extends AbstractFactory
{
    /**
     * @param object{exception: object{exceptionDetailList: array<int, object{exceptionCode: int, exceptionDescription: string}>}} $exceptionResponse
     */
    public static function make(
        int $statusCode,
        ?object $exceptionResponse
    ): Exception {
        $message = '';

        if ($exceptionResponse !== null) {
            $exceptions = $exceptionResponse->exception->exceptionDetailList;

            $firstException = $exceptions[0] ?? null;

            if ($firstException !== null) {
                $message = "{$firstException->exceptionCode} {$firstException->exceptionDescription}";
            }
        }

        /** @var class-string<Exception> $exceptionNamespace */
        $exceptionNamespace = match (true) {
            $statusCode === 400 => BadRequestException::class,
            $statusCode === 500 => InternalServerException::class,
            $statusCode === 501 => UnknownSystemException::class,
            $statusCode === 401 => value(function () use (&$message) {
                $message = 'Unauthorized';

                return ClientException::class;
            }),
            $statusCode > 400 && $statusCode < 500 => ClientException::class,
            $statusCode > 500 => ServerException::class,
            default => Exception::class
        };

        throw new $exceptionNamespace(
            message: $message,
            code: $statusCode,
            context: $exceptionResponse
        );
    }
}
