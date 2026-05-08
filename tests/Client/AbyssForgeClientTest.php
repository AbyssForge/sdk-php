<?php

declare(strict_types=1);

namespace AbyssForgeSdk\Tests\Client;

use AbyssForgeSdk\Client\AbyssForgeClient;
use PHPUnit\Framework\TestCase;

final class AbyssForgeClientTest extends TestCase
{
    public function testPublicMethodSurfaceIsStable(): void
    {
        $reflection = new \ReflectionClass(AbyssForgeClient::class);

        foreach ([
            'compareRuleset',
            'fromBearerToken',
            'fromClientCredentials',
            'fromEnv',
            'getInvestigation',
            'getLatestEvaluation',
            'getOutcomeAnalysis',
            'healthz',
            'ingestSignal',
            'listEvaluations',
            'listSignalEvents',
            'livez',
            'readyz',
            'recordReviewOutcome',
            'recompute',
        ] as $methodName) {
            self::assertTrue(
                $reflection->hasMethod($methodName),
                sprintf('AbyssForgeClient method %s is missing; public SDK surface changed', $methodName)
            );
        }
    }
}
