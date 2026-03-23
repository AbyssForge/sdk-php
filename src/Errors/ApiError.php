<?php

declare(strict_types=1);

namespace AbyssForgeSdk\Errors;

use AbyssForge\ApiException;
use Throwable;

final class ApiError extends \RuntimeException
{
    /** @var list<array{code?: string, field?: string, message?: string}> */
    private array $rejectionReasons;

    /** @param list<array{code?: string, field?: string, message?: string}> $rejectionReasons */
    public function __construct(int $statusCode, string $reason, array $rejectionReasons = [])
    {
        parent::__construct($reason, $statusCode);
        $this->rejectionReasons = $rejectionReasons;
    }

    public function statusCode(): int
    {
        return $this->getCode();
    }

    public function reason(): string
    {
        return $this->getMessage();
    }

    /** @return list<array{code?: string, field?: string, message?: string}> */
    public function rejectionReasons(): array
    {
        return $this->rejectionReasons;
    }

    public static function fromThrowable(Throwable $error): ?self
    {
        if (!$error instanceof ApiException) {
            return null;
        }

        $statusCode = (int) $error->getCode();
        $reason = trim($error->getMessage());
        $rejections = [];

        $body = self::normalizeBody($error->getResponseBody());
        if (isset($body['reason']) && is_string($body['reason']) && trim($body['reason']) !== '') {
            $reason = $body['reason'];
        }

        if (isset($body['rejection_reasons']) && is_array($body['rejection_reasons'])) {
            foreach ($body['rejection_reasons'] as $item) {
                if (is_array($item)) {
                    $rejections[] = self::normalizeRejectionReason($item);
                    continue;
                }
                if (is_object($item)) {
                    $rejections[] = self::normalizeRejectionReason((array) $item);
                }
            }
        }

        if ($reason === '') {
            $reason = 'unknown';
        }

        return new self($statusCode, $reason, $rejections);
    }

    public static function isAuthentication(Throwable $error): bool
    {
        return self::statusCodeFromThrowable($error) === 401;
    }

    public static function isAuthorization(Throwable $error): bool
    {
        return self::statusCodeFromThrowable($error) === 403;
    }

    public static function isRejected(Throwable $error): bool
    {
        return self::statusCodeFromThrowable($error) === 400;
    }

    public static function isNotFound(Throwable $error): bool
    {
        return self::statusCodeFromThrowable($error) === 404;
    }

    private static function statusCodeFromThrowable(Throwable $error): int
    {
        if ($error instanceof self) {
            return $error->statusCode();
        }

        if ($error instanceof ApiException) {
            return (int) $error->getCode();
        }

        return 0;
    }

    /**
     * @param mixed $body
     * @return array<string, mixed>
     */
    private static function normalizeBody(mixed $body): array
    {
        if ($body instanceof \stdClass) {
            return (array) $body;
        }

        if (is_array($body)) {
            return $body;
        }

        if (is_string($body)) {
            $decoded = json_decode($body, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }

    /**
     * @param array<string, mixed> $value
     * @return array{code?: string, field?: string, message?: string}
     */
    private static function normalizeRejectionReason(array $value): array
    {
        $normalized = [];

        if (isset($value['code']) && is_string($value['code'])) {
            $normalized['code'] = $value['code'];
        }
        if (isset($value['field']) && is_string($value['field'])) {
            $normalized['field'] = $value['field'];
        }
        if (isset($value['message']) && is_string($value['message'])) {
            $normalized['message'] = $value['message'];
        }

        return $normalized;
    }
}
