# AbyssForge PHP SDK

PHP client SDK for AbyssForge.

## Install

```bash
composer require abyssforge/sdk
```

## Quick Start (Static Bearer Token)

```php
<?php

declare(strict_types=1);

use AbyssForge\Model\RawSignalEventPayload;
use AbyssForgeSdk\Client\AbyssForgeClient;

$baseUrl = getenv('ABYSSFORGE_BASE_URL') ?: 'http://localhost:8080';
$token = getenv('ABYSSFORGE_TOKEN') ?: '';

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

$result = $client->ingestSignal($payload);
```

## Quick Start (OAuth2 Client Credentials)

```php
<?php

declare(strict_types=1);

use AbyssForgeSdk\Client\AbyssForgeClient;

$client = AbyssForgeClient::fromClientCredentials(
    getenv('ABYSSFORGE_BASE_URL') ?: 'http://localhost:8080',
    getenv('ABYSSFORGE_OAUTH2_TOKEN_URL') ?: 'https://auth.example.com/oauth2/token',
    getenv('ABYSSFORGE_CLIENT_ID') ?: '',
    getenv('ABYSSFORGE_CLIENT_SECRET') ?: '',
    ['signals:write', 'evaluation:read'],
    'abyssforge-api'
);

$health = $client->healthz();
```

## Notes

- `AbyssForgeSdk\\Auth\\OAuth2ClientCredentials` caches access tokens in memory.
- `AbyssForgeClient::fromClientCredentials(...)` builds a client that injects Bearer tokens automatically.
