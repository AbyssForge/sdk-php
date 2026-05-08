<?php

declare(strict_types=1);

if (!is_file(__DIR__ . '/../vendor/autoload.php')) {
    fwrite(STDERR, "Run composer install in sdks/php before running this example\n");
    exit(1);
}

require_once __DIR__ . '/../vendor/autoload.php';

use AbyssForgeSdk\Client\AbyssForgeClient;

function pickPort(): int
{
    $socket = stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
    if ($socket === false) {
        throw new RuntimeException(sprintf('failed to allocate port: %s', $errstr));
    }

    $name = stream_socket_get_name($socket, false);
    fclose($socket);
    if ($name === false) {
        throw new RuntimeException('failed to read allocated port');
    }

    return (int) substr(strrchr($name, ':'), 1);
}

function waitForServer(string $baseUrl): void
{
    $deadline = microtime(true) + 3.0;
    while (microtime(true) < $deadline) {
        $handle = @fopen($baseUrl . '/not-found', 'rb');
        if ($handle !== false) {
            fclose($handle);
            return;
        }
        usleep(50000);
    }

    throw new RuntimeException('mock server did not start');
}

$port = pickPort();
$baseUrl = sprintf('http://127.0.0.1:%d', $port);
$routerPath = tempnam(sys_get_temp_dir(), 'abyssforge-oauth2-router-');

file_put_contents($routerPath, <<<'PHP'
<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($path === '/oauth2/token') {
    $authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    parse_str((string) file_get_contents('php://input'), $body);

    if ($authorization !== 'Basic ' . base64_encode('sdk-client:sdk-secret')) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'invalid_client']);
        return;
    }

    if (($body['grant_type'] ?? '') !== 'client_credentials') {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'unsupported_grant_type']);
        return;
    }

    header('Content-Type: application/json');
    echo json_encode([
        'access_token' => 'mock-access-token',
        'token_type' => 'Bearer',
        'expires_in' => 300,
    ]);
    return;
}

if ($path === '/readyz') {
    if (($_SERVER['HTTP_AUTHORIZATION'] ?? '') !== 'Bearer mock-access-token') {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'missing bearer token']);
        return;
    }

    header('Content-Type: application/json');
    echo json_encode(['status' => 'ready', 'store' => 'ok']);
    return;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'not_found']);
PHP);

$command = sprintf('php -S 127.0.0.1:%d %s', $port, escapeshellarg($routerPath));
$descriptorSpec = [
    0 => ['pipe', 'r'],
    1 => ['file', '/dev/null', 'w'],
    2 => ['file', '/dev/null', 'w'],
];

$process = proc_open($command, $descriptorSpec, $pipes, __DIR__);
if (!is_resource($process)) {
    @unlink($routerPath);
    throw new RuntimeException('failed to start PHP mock server');
}

try {
    waitForServer($baseUrl);

    $client = AbyssForgeClient::fromClientCredentials(
        $baseUrl,
        $baseUrl . '/oauth2/token',
        'sdk-client',
        'sdk-secret',
        ['evaluation:read'],
        'abyssforge-api'
    );

    $ready = $client->readyz();
    $status = method_exists($ready, 'getStatus') ? (string) $ready->getStatus() : 'unknown';
    echo sprintf("readyz status=%s\n", $status);
} finally {
    proc_terminate($process);
    proc_close($process);
    @unlink($routerPath);
}