<?php

declare(strict_types=1);

namespace AbyssForgeSdk\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

final class OAuth2ClientCredentials
{
    private string $tokenUrl;
    private string $clientId;
    private string $clientSecret;

    /** @var list<string> */
    private array $scopes;

    private string $audience;
    private int $earlyExpirySeconds;

    private ?string $cachedToken = null;
    private int $expiresAt = 0;

    /** @param list<string> $scopes */
    public function __construct(
        string $tokenUrl,
        string $clientId,
        string $clientSecret,
        array $scopes = [],
        string $audience = '',
        int $earlyExpirySeconds = 30
    ) {
        if (trim($tokenUrl) === '') {
            throw new \InvalidArgumentException('auth: token URL is required');
        }
        if (trim($clientId) === '') {
            throw new \InvalidArgumentException('auth: client ID is required');
        }
        if ($clientSecret === '') {
            throw new \InvalidArgumentException('auth: client secret is required');
        }

        $this->tokenUrl = $tokenUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->scopes = $scopes;
        $this->audience = $audience;
        $this->earlyExpirySeconds = max(0, $earlyExpirySeconds);
    }

    public function token(ClientInterface $httpClient): string
    {
        $now = time();
        if ($this->cachedToken !== null && ($now + $this->earlyExpirySeconds) < $this->expiresAt) {
            return $this->cachedToken;
        }

        $form = ['grant_type' => 'client_credentials'];
        if ($this->scopes !== []) {
            $form['scope'] = implode(' ', $this->scopes);
        }
        if ($this->audience !== '') {
            $form['audience'] = $this->audience;
        }

        $response = $httpClient->request('POST', $this->tokenUrl, [
            'auth' => [$this->clientId, $this->clientSecret],
            'form_params' => $form,
            'http_errors' => false,
        ]);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new \RuntimeException(sprintf('auth: token endpoint status %d', $response->getStatusCode()));
        }

        $raw = (string) $response->getBody();
        $payload = json_decode($raw, true);
        if (!is_array($payload)) {
            throw new \RuntimeException('auth: decode token response failed');
        }

        $accessToken = isset($payload['access_token']) ? trim((string) $payload['access_token']) : '';
        if ($accessToken === '') {
            throw new \RuntimeException('auth: token response missing access_token');
        }

        $tokenType = isset($payload['token_type']) ? strtolower((string) $payload['token_type']) : '';
        if ($tokenType !== '' && $tokenType !== 'bearer') {
            throw new \RuntimeException(sprintf('auth: unsupported token_type %s', (string) $payload['token_type']));
        }

        $expiresIn = isset($payload['expires_in']) ? (int) $payload['expires_in'] : 300;
        if ($expiresIn <= 0) {
            $expiresIn = 300;
        }

        $this->cachedToken = $accessToken;
        $this->expiresAt = $now + $expiresIn;
        return $this->cachedToken;
    }

    public function createAuthenticatedHttpClient(?ClientInterface $tokenHttpClient = null): ClientInterface
    {
        $tokenClient = $tokenHttpClient ?? new Client();

        $stack = HandlerStack::create();
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($tokenClient): RequestInterface {
            $token = $this->token($tokenClient);
            return $request->withHeader('Authorization', 'Bearer ' . $token);
        }));

        return new Client(['handler' => $stack]);
    }
}
