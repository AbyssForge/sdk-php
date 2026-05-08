# # IngestResult

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**status** | **string** |  |
**reason** | **string** |  | [optional]
**canonical_event_ref** | [**\AbyssForge\Model\ArtifactRef**](ArtifactRef.md) |  | [optional]
**event** | [**\AbyssForge\Model\SignalEvent**](SignalEvent.md) |  | [optional]
**evaluation** | [**\AbyssForge\Model\EvaluationResult**](EvaluationResult.md) |  | [optional]
**rejection_reasons** | [**\AbyssForge\Model\RejectionReason[]**](RejectionReason.md) |  | [optional]
**correlation_id** | **string** | Request correlation identifier echoed in the &#x60;X-Correlation-ID&#x60; header and JSON error payloads. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
