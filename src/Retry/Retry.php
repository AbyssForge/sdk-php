<?php

declare(strict_types=1);

namespace AbyssForgeSdk\Retry;

use AbyssForge\ApiException;
use Throwable;

final class Retry
{
    private function __construct()
    {
    }

    /**
     * @template T
     * @param callable():T $fn
     * @return T
     */
    public static function run(callable $fn, ?RetryPolicy $policy = null): mixed
    {
        $effective = $policy ?? new RetryPolicy();
        $attempt = 0;
        $waitMs = $effective->initialWaitMs;
        $lastError = null;

        while ($attempt < $effective->maxAttempts) {
            try {
                return $fn();
            } catch (Throwable $error) {
                $lastError = $error;
                $attempt++;

                if ($attempt >= $effective->maxAttempts || !self::isTransientThrowable($error)) {
                    throw $error;
                }

                $jitter = random_int(0, max(1, (int) floor($waitMs * 0.1)));
                usleep(($waitMs + $jitter) * 1000);
                $waitMs = min((int) ceil($waitMs * $effective->multiplier), $effective->maxWaitMs);
            }
        }

        if ($lastError instanceof Throwable) {
            throw $lastError;
        }

        throw new \RuntimeException('retry failed without captured error');
    }

    public static function isTransientStatus(int $statusCode): bool
    {
        return $statusCode === 0 || $statusCode === 429 || $statusCode >= 500;
    }

    public static function isTransientThrowable(Throwable $error): bool
    {
        if ($error instanceof ApiException) {
            return self::isTransientStatus((int) $error->getCode());
        }

        return true;
    }
}
