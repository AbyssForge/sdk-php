<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AbyssForge\Model\RawSignalEventPayload;
use AbyssForgeSdk\Client\AbyssForgeClient;
use AbyssForgeSdk\Errors\ApiError;
use AbyssForgeSdk\Retry\Retry;

$baseUrl = getenv('ABYSSFORGE_BASE_URL') ?: 'http://localhost:8080';
$token = getenv('ABYSSFORGE_TOKEN') ?: '';

if ($token === '') {
    fwrite(STDERR, "ABYSSFORGE_TOKEN must be set\n");
    exit(1);
}

$client = AbyssForgeClient::fromBearerToken($baseUrl, $token);

$payload = new RawSignalEventPayload([
    'subject_id' => 'user_42',
    'producer' => 'login-detector',
    'producer_event_id' => 'evt-001',
    'signal_type' => 'failed_login',
    'occurred_at' => new DateTimeImmutable('now', new DateTimeZone('UTC')),
    'severity' => 'high',
    'confidence' => 0.95,
]);

try {
    $result = Retry::run(static fn() => $client->ingestSignal($payload));

    echo sprintf(
        "status=%s reason=%s\n",
        method_exists($result, 'getStatus') ? (string) $result->getStatus() : 'unknown',
        method_exists($result, 'getReason') ? (string) $result->getReason() : 'unknown'
    );
} catch (Throwable $error) {
    $apiError = ApiError::fromThrowable($error);
    if ($apiError !== null) {
        if (ApiError::isAuthentication($apiError)) {
            fwrite(STDERR, "authentication failed: check ABYSSFORGE_TOKEN\n");
            exit(2);
        }

        if (ApiError::isAuthorization($apiError)) {
            fwrite(STDERR, "authorization failed: token lacks required scope\n");
            exit(3);
        }

        fwrite(
            STDERR,
            sprintf("AbyssForge API error: status=%d reason=%s\n", $apiError->statusCode(), $apiError->reason())
        );
        foreach ($apiError->rejectionReasons() as $reason) {
            $code = $reason['code'] ?? 'unknown';
            $field = $reason['field'] ?? '';
            $message = $reason['message'] ?? '';
            fwrite(STDERR, sprintf(" - %s %s %s\n", $code, $field, $message));
        }
        exit(4);
    }

    fwrite(STDERR, sprintf("Unhandled error: %s\n", $error->getMessage()));
    exit(5);
}
