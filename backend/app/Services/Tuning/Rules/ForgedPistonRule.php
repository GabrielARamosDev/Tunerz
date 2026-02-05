<?php

namespace App\Services\Tuning\Rules;

use App\Services\Tuning\Rules\RuleInterface;
use App\Services\Context\BuildContext;
use App\Services\Tuning\StageEvaluationResult;

class ForgedPistonsRule implements RuleInterface
{
    public function applies(BuildContext $context): bool
    {
        return in_array('forged_pistons', $context->components ?? []);
    }

    public function apply(BuildContext $context, StageEvaluationResult $result): void
    {
        $result->setStatus('PERFORMANCE');
        $result->addRequirement('Componentes forjados instalados - pressão aumentada permitida');
    }
}

