<?php

declare(strict_types=1);

namespace AbyssForgeSdk\Client;

use AbyssForge\Api\SignalEventsApi;
use AbyssForge\Api\SubjectEvaluationsApi;
use AbyssForge\Api\SystemApi;
use AbyssForge\Configuration;
use AbyssForge\Model\RawSignalEventPayload;
use AbyssForge\Model\ReviewOutcomeWriteRequest;
use AbyssForge\Model\RulesetComparisonRequest;
use AbyssForge\Model\SubjectRecomputeRequest;
use AbyssForgeSdk\Auth\BearerToken;

final class AbyssForgeClient
{
    private SignalEventsApi $signals;
    private SubjectEvaluationsApi $evaluations;
    private SystemApi $system;

    public function __construct(
        ?Configuration $configuration = null,
        $httpClient = null
    ) {
        $cfg = $configuration ?? Configuration::getDefaultConfiguration();

        $this->signals = new SignalEventsApi($httpClient, $cfg);
        $this->evaluations = new SubjectEvaluationsApi($httpClient, $cfg);
        $this->system = new SystemApi($httpClient, $cfg);
    }

    public static function fromBearerToken(string $baseUrl, string $token, $httpClient = null): self
    {
        $cfg = BearerToken::configuration($token);
        $cfg->setHost($baseUrl);

        return new self($cfg, $httpClient);
    }

    public function ingestSignal(RawSignalEventPayload $payload): mixed
    {
        return $this->signals->postSignalEvent($payload);
    }

    public function getLatestEvaluation(string $subjectId): mixed
    {
        return $this->evaluations->getLatestSubjectEvaluation($subjectId);
    }

    public function listSignalEvents(string $subjectId): mixed
    {
        return $this->signals->listSubjectSignalEvents($subjectId);
    }

    public function listEvaluations(string $subjectId): mixed
    {
        return $this->evaluations->listSubjectEvaluations($subjectId);
    }

    public function getInvestigation(string $subjectId): mixed
    {
        return $this->evaluations->getSubjectInvestigation($subjectId);
    }

    public function recordReviewOutcome(string $subjectId, ReviewOutcomeWriteRequest $request): mixed
    {
        return $this->evaluations->postSubjectReviewOutcome($subjectId, $request);
    }

    public function recompute(string $subjectId, ?SubjectRecomputeRequest $request = null): mixed
    {
        return $this->evaluations->recomputeSubject($subjectId, $request);
    }

    public function compareRuleset(string $subjectId, RulesetComparisonRequest $request): mixed
    {
        return $this->evaluations->compareSubjectRuleset($subjectId, $request);
    }

    /**
     * @param array{subjectId?: string, recommendationType?: string, reviewLabel?: string}|null $filter
     */
    public function getOutcomeAnalysis(?array $filter = null): mixed
    {
        $subjectId = $filter['subjectId'] ?? null;
        $recommendationType = $filter['recommendationType'] ?? null;
        $reviewLabel = $filter['reviewLabel'] ?? null;

        return $this->evaluations->getOutcomeAnalysis($subjectId, $recommendationType, $reviewLabel);
    }

    public function healthz(): mixed
    {
        return $this->system->getHealthz();
    }

    public function readyz(): mixed
    {
        return $this->system->getReadyz();
    }
}
