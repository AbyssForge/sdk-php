<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AbyssForgeSdk\Client\AbyssForgeClient;
use AbyssForgeSdk\Errors\ApiError;
use AbyssForgeSdk\Retry\Retry;

$baseUrl = getenv('ABYSSFORGE_BASE_URL') ?: 'http://localhost:8080';
$token = getenv('ABYSSFORGE_TOKEN') ?: '';
$subjectId = getenv('ABYSSFORGE_SUBJECT_ID') ?: 'subject_123';

if ($token === '') {
    fwrite(STDERR, "ABYSSFORGE_TOKEN must be set\n");
    exit(1);
}

$client = AbyssForgeClient::fromBearerToken($baseUrl, $token);

try {
    $bundle = Retry::run(static fn() => $client->getLatestEvaluation($subjectId));
    echo json_encode($bundle, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
} catch (Throwable $error) {
    $apiError = ApiError::fromThrowable($error);
    if ($apiError !== null) {
        fwrite(
            STDERR,
            sprintf(
                "AbyssForge API error: status=%d reason=%s\n",
                $apiError->statusCode(),
                $apiError->reason()
            )
        );

        foreach ($apiError->rejectionReasons() as $reason) {
            $code = $reason['code'] ?? 'unknown';
            $field = $reason['field'] ?? '';
            $message = $reason['message'] ?? '';
            fwrite(STDERR, sprintf(" - %s %s %s\n", $code, $field, $message));
        }

        exit(2);
    }

    fwrite(STDERR, sprintf("Unhandled error: %s\n", $error->getMessage()));
    exit(3);
}
