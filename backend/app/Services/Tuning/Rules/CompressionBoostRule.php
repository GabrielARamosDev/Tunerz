<?php

namespace App\Services\Tuning\Rules;

use App\Services\Tuning\Rules\RuleInterface;
use App\Services\Context\BuildContext;
use App\Services\Tuning\StageEvaluationResult;

class CompressionBoostRule implements RuleInterface
{
    public function applies(BuildContext $context): bool
    {
        return $context->induction && $context->induction->type === 'turbo';
    }

    public function apply(BuildContext $context, StageEvaluationResult $result): void
    {
        if ($context->engine->compressionRate >= 10.0) {
            $result->setStatus('ATTENTION');
            $result->addWarning('Alta taxa de compressão limita pressão sem reforço interno');
        }
    }
}

