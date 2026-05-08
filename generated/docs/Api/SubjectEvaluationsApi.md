# AbyssForge\SubjectEvaluationsApi



All URIs are relative to http://localhost:8080, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**compareSubjectRuleset()**](SubjectEvaluationsApi.md#compareSubjectRuleset) | **POST** /v1/subjects/{subject_id}/ruleset-comparisons | Compare the latest evaluation with a candidate ruleset replay |
| [**getLatestSubjectEvaluation()**](SubjectEvaluationsApi.md#getLatestSubjectEvaluation) | **GET** /v1/subjects/{subject_id}/latest-evaluation | Get the latest persisted evaluation for a subject |
| [**getOutcomeAnalysis()**](SubjectEvaluationsApi.md#getOutcomeAnalysis) | **GET** /v1/outcome-analysis | Get deterministic recommendation outcome analysis |
| [**getSubjectInvestigation()**](SubjectEvaluationsApi.md#getSubjectInvestigation) | **GET** /v1/subjects/{subject_id}/investigation | Get the investigation read model for a subject |
| [**listSubjectEvaluations()**](SubjectEvaluationsApi.md#listSubjectEvaluations) | **GET** /v1/subjects/{subject_id}/evaluations | List persisted evaluations for a subject |
| [**postSubjectReviewOutcome()**](SubjectEvaluationsApi.md#postSubjectReviewOutcome) | **POST** /v1/subjects/{subject_id}/review-outcomes | Record a review outcome for a subject artifact |
| [**recomputeSubject()**](SubjectEvaluationsApi.md#recomputeSubject) | **POST** /v1/subjects/{subject_id}/recompute | Recompute and persist a subject evaluation |


## `compareSubjectRuleset()`

```php
compareSubjectRuleset($subject_id, $ruleset_comparison_request): \AbyssForge\Model\RulesetComparison
```

Compare the latest evaluation with a candidate ruleset replay

Replays the subject under a candidate score ruleset version, persists the candidate artifacts, and returns the baseline-versus-candidate comparison.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: BearerToken
$config = AbyssForge\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new AbyssForge\Api\SubjectEvaluationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$subject_id = 'subject_id_example'; // string | Canonical account identifier for the scored subject
$ruleset_comparison_request = new \AbyssForge\Model\RulesetComparisonRequest(); // \AbyssForge\Model\RulesetComparisonRequest

try {
    $result = $apiInstance->compareSubjectRuleset($subject_id, $ruleset_comparison_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SubjectEvaluationsApi->compareSubjectRuleset: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **subject_id** | **string**| Canonical account identifier for the scored subject | |
| **ruleset_comparison_request** | [**\AbyssForge\Model\RulesetComparisonRequest**](../Model/RulesetComparisonRequest.md)|  | |

### Return type

[**\AbyssForge\Model\RulesetComparison**](../Model/RulesetComparison.md)

### Authorization

[BearerToken](../../README.md#BearerToken)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getLatestSubjectEvaluation()`

```php
getLatestSubjectEvaluation($subject_id): \AbyssForge\Model\SubjectEvaluationBundle
```

Get the latest persisted evaluation for a subject

Returns the latest persisted feature snapshot, score result, recommendation, and canonical signal events used by the latest subject evaluation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: BearerToken
$config = AbyssForge\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new AbyssForge\Api\SubjectEvaluationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$subject_id = 'subject_id_example'; // string | Canonical account identifier for the scored subject

try {
    $result = $apiInstance->getLatestSubjectEvaluation($subject_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SubjectEvaluationsApi->getLatestSubjectEvaluation: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **subject_id** | **string**| Canonical account identifier for the scored subject | |

### Return type

[**\AbyssForge\Model\SubjectEvaluationBundle**](../Model/SubjectEvaluationBundle.md)

### Authorization

[BearerToken](../../README.md#BearerToken)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getOutcomeAnalysis()`

```php
getOutcomeAnalysis($subject_id, $recommendation_type, $review_label): \AbyssForge\Model\OutcomeAnalysis
```

Get deterministic recommendation outcome analysis

Returns a structured read model that compares persisted recommendations with later review outcomes. Optional filters allow narrowing the result by subject, recommendation type, or review label.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: BearerToken
$config = AbyssForge\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new AbyssForge\Api\SubjectEvaluationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$subject_id = 'subject_id_example'; // string
$recommendation_type = 'recommendation_type_example'; // string
$review_label = 'review_label_example'; // string

try {
    $result = $apiInstance->getOutcomeAnalysis($subject_id, $recommendation_type, $review_label);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SubjectEvaluationsApi->getOutcomeAnalysis: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **subject_id** | **string**|  | [optional] |
| **recommendation_type** | **string**|  | [optional] |
| **review_label** | **string**|  | [optional] |

### Return type

[**\AbyssForge\Model\OutcomeAnalysis**](../Model/OutcomeAnalysis.md)

### Authorization

[BearerToken](../../README.md#BearerToken)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSubjectInvestigation()`

```php
getSubjectInvestigation($subject_id): \AbyssForge\Model\SubjectInvestigation
```

Get the investigation read model for a subject

Returns the current inspectable investigation artifacts for a subject, including signal events, derived artifacts, the latest evaluation, and any persisted review outcomes.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: BearerToken
$config = AbyssForge\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new AbyssForge\Api\SubjectEvaluationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$subject_id = 'subject_id_example'; // string | Canonical account identifier for the scored subject

try {
    $result = $apiInstance->getSubjectInvestigation($subject_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SubjectEvaluationsApi->getSubjectInvestigation: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **subject_id** | **string**| Canonical account identifier for the scored subject | |

### Return type

[**\AbyssForge\Model\SubjectInvestigation**](../Model/SubjectInvestigation.md)

### Authorization

[BearerToken](../../README.md#BearerToken)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listSubjectEvaluations()`

```php
listSubjectEvaluations($subject_id): \AbyssForge\Model\SubjectEvaluationHistory
```

List persisted evaluations for a subject

Returns the subject's persisted evaluation history, including replayed results across versioned scoring policies.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: BearerToken
$config = AbyssForge\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new AbyssForge\Api\SubjectEvaluationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$subject_id = 'subject_id_example'; // string | Canonical account identifier for the scored subject

try {
    $result = $apiInstance->listSubjectEvaluations($subject_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SubjectEvaluationsApi->listSubjectEvaluations: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **subject_id** | **string**| Canonical account identifier for the scored subject | |

### Return type

[**\AbyssForge\Model\SubjectEvaluationHistory**](../Model/SubjectEvaluationHistory.md)

### Authorization

[BearerToken](../../README.md#BearerToken)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postSubjectReviewOutcome()`

```php
postSubjectReviewOutcome($subject_id, $review_outcome_write_request): \AbyssForge\Model\ReviewOutcome
```

Record a review outcome for a subject artifact

Records one append-only `ReviewOutcome` against a persisted subject `Recommendation` or `ScoreResult`. The service validates that the target artifact exists and belongs to the requested subject before persisting the review outcome.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: BearerToken
$config = AbyssForge\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new AbyssForge\Api\SubjectEvaluationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$subject_id = 'subject_id_example'; // string | Canonical account identifier for the scored subject
$review_outcome_write_request = {"reviewed_object":{"kind":"recommendation","id":"rec_acct_12345_score_acct_12345_score_v1_20260307120100_20260307120100"},"reviewer":"operator@example","label":"false_positive","notes":"manual review confirmed detector noise","disposition":"no_external_action"}; // \AbyssForge\Model\ReviewOutcomeWriteRequest

try {
    $result = $apiInstance->postSubjectReviewOutcome($subject_id, $review_outcome_write_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SubjectEvaluationsApi->postSubjectReviewOutcome: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **subject_id** | **string**| Canonical account identifier for the scored subject | |
| **review_outcome_write_request** | [**\AbyssForge\Model\ReviewOutcomeWriteRequest**](../Model/ReviewOutcomeWriteRequest.md)|  | |

### Return type

[**\AbyssForge\Model\ReviewOutcome**](../Model/ReviewOutcome.md)

### Authorization

[BearerToken](../../README.md#BearerToken)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `recomputeSubject()`

```php
recomputeSubject($subject_id, $subject_recompute_request): \AbyssForge\Model\SubjectEvaluationBundle
```

Recompute and persist a subject evaluation

Rebuilds the subject's feature snapshot, score result, and recommendation from stored signal events. When a `score_ruleset_version` is supplied, the replay uses that version and persists the resulting artifacts.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: BearerToken
$config = AbyssForge\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new AbyssForge\Api\SubjectEvaluationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$subject_id = 'subject_id_example'; // string | Canonical account identifier for the scored subject
$subject_recompute_request = new \AbyssForge\Model\SubjectRecomputeRequest(); // \AbyssForge\Model\SubjectRecomputeRequest

try {
    $result = $apiInstance->recomputeSubject($subject_id, $subject_recompute_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SubjectEvaluationsApi->recomputeSubject: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **subject_id** | **string**| Canonical account identifier for the scored subject | |
| **subject_recompute_request** | [**\AbyssForge\Model\SubjectRecomputeRequest**](../Model/SubjectRecomputeRequest.md)|  | [optional] |

### Return type

[**\AbyssForge\Model\SubjectEvaluationBundle**](../Model/SubjectEvaluationBundle.md)

### Authorization

[BearerToken](../../README.md#BearerToken)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
