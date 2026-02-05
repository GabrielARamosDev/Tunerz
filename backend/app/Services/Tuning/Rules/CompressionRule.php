<?php

namespace App\Services\Tuning\Rules;

use App\Services\Tuning\Rules\RuleInterface;
use App\Services\Context\BuildContext;
use App\Services\Tuning\StageEvaluationResult;

class CompressionRule implements RuleInterface
{
    public function applies(BuildContext $context): bool
    {
        return isset($context->engine) && isset($context->vehicle);
    }

    public function apply(BuildContext $context, StageEvaluationResult $result): void
    {
        if ($context->engine->compressionRate > 10 && 
            $context->engine->limiteTurboStock > 0.7) {
            
            $result->setStatus('RISK');
            $result->addWarning(
              'Alta taxa de compressão para uso com turbo'
            );
        }
    }
}

