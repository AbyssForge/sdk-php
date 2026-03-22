# # Recommendation

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** |  |
**subject_id** | **string** |  |
**recommended_at** | **\DateTime** |  |
**policy_version** | **string** |  |
**type** | **string** |  |
**confidence** | **float** |  |
**rationale** | **string** |  |
**primary_reason** | [**\AbyssForge\Model\RecommendationReasonCode**](RecommendationReasonCode.md) |  |
**additional_reasons** | [**\AbyssForge\Model\RecommendationReasonCode[]**](RecommendationReasonCode.md) |  | [optional]
**explanation** | [**\AbyssForge\Model\RecommendationExplanation**](RecommendationExplanation.md) |  | [optional]
**score_result** | [**\AbyssForge\Model\ArtifactRef**](ArtifactRef.md) |  |
**guardrails** | [**\AbyssForge\Model\Guardrail[]**](Guardrail.md) |  | [optional]
**expires_at** | **\DateTime** |  | [optional]
**review_by** | **\DateTime** |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
