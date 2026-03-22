# AbyssForge\SystemApi

Liveness and service metadata

All URIs are relative to http://localhost:8080, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getHealthz()**](SystemApi.md#getHealthz) | **GET** /healthz | Health check |
| [**getLivez()**](SystemApi.md#getLivez) | **GET** /livez | Liveness check |
| [**getReadyz()**](SystemApi.md#getReadyz) | **GET** /readyz | Readiness check |


## `getHealthz()`

```php
getHealthz(): \AbyssForge\Model\HealthStatus
```

Health check

Returns the compatibility liveness response for the running service.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new AbyssForge\Api\SystemApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getHealthz();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SystemApi->getHealthz: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\AbyssForge\Model\HealthStatus**](../Model/HealthStatus.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getLivez()`

```php
getLivez(): \AbyssForge\Model\HealthStatus
```

Liveness check

Returns whether the HTTP process is live enough to serve requests.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new AbyssForge\Api\SystemApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getLivez();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SystemApi->getLivez: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\AbyssForge\Model\HealthStatus**](../Model/HealthStatus.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getReadyz()`

```php
getReadyz(): \AbyssForge\Model\HealthStatus
```

Readiness check

Returns whether the running service has an initialized store and is ready to serve traffic.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new AbyssForge\Api\SystemApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getReadyz();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SystemApi->getReadyz: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\AbyssForge\Model\HealthStatus**](../Model/HealthStatus.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
