# AbyssForge\SignalEventsApi



All URIs are relative to http://localhost:8080, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**listSubjectSignalEvents()**](SignalEventsApi.md#listSubjectSignalEvents) | **GET** /v1/subjects/{subject_id}/signal-events | List canonical signal events for a subject |
| [**postSignalEvent()**](SignalEventsApi.md#postSignalEvent) | **POST** /v1/signal-events | Ingest a raw detector event |


## `listSubjectSignalEvents()`

```php
listSubjectSignalEvents($subject_id): \AbyssForge\Model\SubjectSignalEventList
```

List canonical signal events for a subject

Returns the canonical signal events that were accepted for the subject. This makes normalized values and deduplicated event identity inspectable.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new AbyssForge\Api\SignalEventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$subject_id = 'subject_id_example'; // string | Canonical account identifier for the scored subject

try {
    $result = $apiInstance->listSubjectSignalEvents($subject_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SignalEventsApi->listSubjectSignalEvents: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **subject_id** | **string**| Canonical account identifier for the scored subject | |

### Return type

[**\AbyssForge\Model\SubjectSignalEventList**](../Model/SubjectSignalEventList.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postSignalEvent()`

```php
postSignalEvent($raw_signal_event_payload): \AbyssForge\Model\IngestResult
```

Ingest a raw detector event

Accepts one raw detector payload, validates and normalizes it into a canonical `SignalEvent`, deduplicates it, persists it, evaluates the subject when the event is newly accepted, persists the derived feature snapshot, score result, and recommendation, and returns the explicit ingestion outcome.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new AbyssForge\Api\SignalEventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$raw_signal_event_payload = {"subject_id":"acct_12345","producer":"interval-detector","producer_event_id":"det-884221","signal_type":"consistent-action-interval","occurred_at":"2026-03-07T11:45:00Z","severity":"high","confidence":0.92,"value":0.98,"unit":"regularity_score","correlation_ids":["sess_789","match_456"],"attributes":{"platform":"pc","environment":"prod"}}; // \AbyssForge\Model\RawSignalEventPayload

try {
    $result = $apiInstance->postSignalEvent($raw_signal_event_payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SignalEventsApi->postSignalEvent: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **raw_signal_event_payload** | [**\AbyssForge\Model\RawSignalEventPayload**](../Model/RawSignalEventPayload.md)|  | |

### Return type

[**\AbyssForge\Model\IngestResult**](../Model/IngestResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
