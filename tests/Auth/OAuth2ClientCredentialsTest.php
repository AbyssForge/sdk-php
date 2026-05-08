<?php

declare(strict_types=1);

namespace AbyssForgeSdk\Tests\Auth;

use AbyssForgeSdk\Auth\OAuth2ClientCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class OAuth2ClientCredentialsTest extends TestCase
{
    public function testConstructorValidatesRequiredFields(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new OAuth2ClientCredentials('', 'client-id', 'client-secret');
    }

    public function testTokenFetchesAndCachesValue(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'access_token' => 'token-abc',
                'token_type' => 'Bearer',
                'expires_in' => 3600,
            ], JSON_THROW_ON_ERROR)),
        ]);

        $history = [];
        $historyMiddleware = Middleware::history($history);
        $stack = HandlerStack::create($mock);
        $stack->push($historyMiddleware);

        $httpClient = new Client(['handler' => $stack]);
        $source = new OAuth2ClientCredentials(
            'https://auth.example.com/oauth2/token',
            'sdk-client',
            'sdk-secret',
            ['signals:write', 'evaluation:read'],
            'abyssforge-api'
        );

        $first = $source->token($httpClient);
        $second = $source->token($httpClient);

        self::assertSame('token-abc', $first);
        self::assertSame('token-abc', $second);
        self::assertCount(1, $history);

        $request = $history[0]['request'];
        self::assertSame('POST', $request->getMethod());
        self::assertStringContainsString('Basic ', $request->getHeaderLine('Authorization'));
        self::assertSame('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));

        $body = (string) $request->getBody();
        self::assertStringContainsString('grant_type=client_credentials', $body);
        self::assertStringContainsString('scope=signals%3Awrite+evaluation%3Aread', $body);
        self::assertStringContainsString('audience=abyssforge-api', $body);
    }

    public function testTokenThrowsOnNonSuccessStatus(): void
    {
        $mock = new MockHandler([
            new Response(401, [], '{"error":"invalid_client"}'),
        ]);

        $httpClient = new Client(['handler' => HandlerStack::create($mock)]);
        $source = new OAuth2ClientCredentials('https://auth.example.com/oauth2/token', 'id', 'secret');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('token endpoint status 401');

        $source->token($httpClient);
    }
}
