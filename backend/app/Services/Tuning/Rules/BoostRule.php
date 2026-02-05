<?php

namespace App\Services\Tuning\Rules;

use App\Services\Tuning\Rules\RuleInterface;
use App\Services\Context\BuildContext;
use App\Services\Tuning\StageEvaluationResult;

class BoostRule implements RuleInterface
{
    public function applies(BuildContext $context): bool
    {
        return isset($context->vehicle) && isset($context->engine);
    }

    public function apply(BuildContext $context, StageEvaluationResult $result): void
    {
        $boost = $context->engine->limiteTurboStock ?? 0;
        $safe = $context->engine->stockTurboLimit ?? 0;

        if ($boost > $safe) {
            $result->setStatus('ATTENTION');
            $result->addRequirement('Bielas forjadas recomendadas');
        }

        if ($boost > 1.0) {
            $result->setStatus('RISK');
            $result->addWarning('Pressão elevada para este motor');
        }
    }
}

