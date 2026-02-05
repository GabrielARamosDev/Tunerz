<?php

namespace App\Services\Tuning\Rules;

use App\Services\Tuning\StageEvaluationResult;
use App\Services\Context\BuildContext;

interface RuleInterface
{
    public function applies(BuildContext $context): bool;

    public function apply(BuildContext $context, StageEvaluationResult $result): void;
}
