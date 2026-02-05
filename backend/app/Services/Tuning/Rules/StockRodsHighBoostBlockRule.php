<?php

namespace App\Services\Tuning\Rules;

use App\Services\Tuning\Rules\RuleInterface;
use App\Services\Context\BuildContext;
use App\Services\Tuning\StageEvaluationResult;

class StockRodsHighBoostBlockRule implements RuleInterface
{
    public function applies(BuildContext $context): bool
    {
        return !in_array('forged_rods', $context->components ?? []);
    }

    public function apply(BuildContext $context, StageEvaluationResult $result): void
    {
        if ($context->engine->limiteTurboStock > 12) {
            $result->setStatus('BLOCKED');
            $result->addWarning('Pressão acima de 12 psi exige bielas forjadas');
        }
    }
}

