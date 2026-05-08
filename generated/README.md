# AbyssForge

Importable OpenAPI document for the current AbyssForge HTTP boundary.

All HTTP responses include an `X-Correlation-ID` header. JSON error responses also
include the same value in a `correlation_id` field so clients can join retries,
support tickets, and server logs to the same failing request.

Protected endpoints validate bearer token timestamps with a bounded clock-skew
allowance. Operators can tune that allowance with `ABYSSFORGE_AUTH_CLOCK_SKEW_LEEWAY`
when deployment clocks are not perfectly aligned.

Current implemented routes:
- GET /healthz
- GET /livez
- GET /readyz
- POST /v1/signal-events
- GET /v1/outcome-analysis
- GET /v1/subjects/{subject_id}/latest-evaluation
- GET /v1/subjects/{subject_id}/signal-events
- GET /v1/subjects/{subject_id}/evaluations
- GET /v1/subjects/{subject_id}/investigation
- POST /v1/subjects/{subject_id}/review-outcomes
- POST /v1/subjects/{subject_id}/recompute
- POST /v1/subjects/{subject_id}/ruleset-comparisons



## Installation & Usage

### Requirements

PHP 8.1 and later.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/AbyssForge/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure Bearer (JWT) authorization: BearerToken
$config = AbyssForge\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new AbyssForge\Api\SignalEventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$subject_id = 'subject_id_example'; // string | Canonical account identifier for the scored subject

try {
    $result = $apiInstance->listSubjectSignalEvents($subject_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SignalEventsApi->listSubjectSignalEvents: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *http://localhost:8080*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*SignalEventsApi* | [**listSubjectSignalEvents**](docs/Api/SignalEventsApi.md#listsubjectsignalevents) | **GET** /v1/subjects/{subject_id}/signal-events | List canonical signal events for a subject
*SignalEventsApi* | [**postSignalEvent**](docs/Api/SignalEventsApi.md#postsignalevent) | **POST** /v1/signal-events | Ingest a raw detector event
*SubjectEvaluationsApi* | [**compareSubjectRuleset**](docs/Api/SubjectEvaluationsApi.md#comparesubjectruleset) | **POST** /v1/subjects/{subject_id}/ruleset-comparisons | Compare the latest evaluation with a candidate ruleset replay
*SubjectEvaluationsApi* | [**getLatestSubjectEvaluation**](docs/Api/SubjectEvaluationsApi.md#getlatestsubjectevaluation) | **GET** /v1/subjects/{subject_id}/latest-evaluation | Get the latest persisted evaluation for a subject
*SubjectEvaluationsApi* | [**getOutcomeAnalysis**](docs/Api/SubjectEvaluationsApi.md#getoutcomeanalysis) | **GET** /v1/outcome-analysis | Get deterministic recommendation outcome analysis
*SubjectEvaluationsApi* | [**getSubjectInvestigation**](docs/Api/SubjectEvaluationsApi.md#getsubjectinvestigation) | **GET** /v1/subjects/{subject_id}/investigation | Get the investigation read model for a subject
*SubjectEvaluationsApi* | [**listSubjectEvaluations**](docs/Api/SubjectEvaluationsApi.md#listsubjectevaluations) | **GET** /v1/subjects/{subject_id}/evaluations | List persisted evaluations for a subject
*SubjectEvaluationsApi* | [**postSubjectReviewOutcome**](docs/Api/SubjectEvaluationsApi.md#postsubjectreviewoutcome) | **POST** /v1/subjects/{subject_id}/review-outcomes | Record a review outcome for a subject artifact
*SubjectEvaluationsApi* | [**recomputeSubject**](docs/Api/SubjectEvaluationsApi.md#recomputesubject) | **POST** /v1/subjects/{subject_id}/recompute | Recompute and persist a subject evaluation
*SystemApi* | [**getHealthz**](docs/Api/SystemApi.md#gethealthz) | **GET** /healthz | Health check
*SystemApi* | [**getLivez**](docs/Api/SystemApi.md#getlivez) | **GET** /livez | Liveness check
*SystemApi* | [**getReadyz**](docs/Api/SystemApi.md#getreadyz) | **GET** /readyz | Readiness check

## Models

- [ArtifactRef](docs/Model/ArtifactRef.md)
- [AuthenticationError](docs/Model/AuthenticationError.md)
- [AuthorizationError](docs/Model/AuthorizationError.md)
- [EvaluationResult](docs/Model/EvaluationResult.md)
- [EvaluationRun](docs/Model/EvaluationRun.md)
- [EvidenceRef](docs/Model/EvidenceRef.md)
- [ExplanationFeature](docs/Model/ExplanationFeature.md)
- [ExplanationRule](docs/Model/ExplanationRule.md)
- [FeatureSnapshot](docs/Model/FeatureSnapshot.md)
- [FeatureValue](docs/Model/FeatureValue.md)
- [FeatureWindow](docs/Model/FeatureWindow.md)
- [Guardrail](docs/Model/Guardrail.md)
- [HealthStatus](docs/Model/HealthStatus.md)
- [IngestResult](docs/Model/IngestResult.md)
- [MetadataField](docs/Model/MetadataField.md)
- [OutcomeAnalysis](docs/Model/OutcomeAnalysis.md)
- [OutcomeAnalysisFilter](docs/Model/OutcomeAnalysisFilter.md)
- [OutcomeAnalysisRow](docs/Model/OutcomeAnalysisRow.md)
- [OutcomeAnalysisSummary](docs/Model/OutcomeAnalysisSummary.md)
- [OutcomeClassification](docs/Model/OutcomeClassification.md)
- [OutcomeComparison](docs/Model/OutcomeComparison.md)
- [OutcomeCountByClassification](docs/Model/OutcomeCountByClassification.md)
- [OutcomeCountByRecommendationType](docs/Model/OutcomeCountByRecommendationType.md)
- [OutcomeCountByReviewLabel](docs/Model/OutcomeCountByReviewLabel.md)
- [OutcomeReasonCodeStat](docs/Model/OutcomeReasonCodeStat.md)
- [RawSignalEventPayload](docs/Model/RawSignalEventPayload.md)
- [Recommendation](docs/Model/Recommendation.md)
- [RecommendationExplanation](docs/Model/RecommendationExplanation.md)
- [RecommendationReasonCode](docs/Model/RecommendationReasonCode.md)
- [RejectionReason](docs/Model/RejectionReason.md)
- [ReviewOutcome](docs/Model/ReviewOutcome.md)
- [ReviewOutcomeWriteRequest](docs/Model/ReviewOutcomeWriteRequest.md)
- [ReviewTargetRef](docs/Model/ReviewTargetRef.md)
- [RulesetComparison](docs/Model/RulesetComparison.md)
- [RulesetComparisonRequest](docs/Model/RulesetComparisonRequest.md)
- [ScoreContribution](docs/Model/ScoreContribution.md)
- [ScoreExplanation](docs/Model/ScoreExplanation.md)
- [ScoreResult](docs/Model/ScoreResult.md)
- [SignalEvent](docs/Model/SignalEvent.md)
- [SubjectEvaluationBundle](docs/Model/SubjectEvaluationBundle.md)
- [SubjectEvaluationHistory](docs/Model/SubjectEvaluationHistory.md)
- [SubjectInvestigation](docs/Model/SubjectInvestigation.md)
- [SubjectRecomputeRequest](docs/Model/SubjectRecomputeRequest.md)
- [SubjectSignalEventList](docs/Model/SubjectSignalEventList.md)

## Authorization

Authentication schemes defined for the API:
### BearerToken

- **Type**: Bearer authentication (JWT)

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `0.1.0`
    - Generator version: `7.20.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
