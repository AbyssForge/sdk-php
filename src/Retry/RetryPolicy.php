<?php

declare(strict_types=1);

namespace AbyssForgeSdk\Retry;

// BEGIN generated:retry-policy-class
final class RetryPolicy
{
    public function __construct(
        public readonly int $maxAttempts = 3,
        public readonly int $initialWaitMs = 100,
        public readonly int $maxWaitMs = 5000,
        public readonly float $multiplier = 2.0
    ) {
    }
}
// END generated:retry-policy-class
