<?php

namespace App\Services\Tuning\Rules;

use App\Services\Context\BuildContext;
use App\Services\Envelopes\ResultEnvelope;
use App\Services\Envelopes\EnvelopeFactory;

class RuleEngine
{
    private array $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function run(BuildContext $context): ResultEnvelope
    {
        $envelope = EnvelopeFactory::base($context);

        foreach ($this->rules as $rule) {
            if ($rule->applies($context)) {
                $rule->apply($context, $envelope);
            }
        }

        return $envelope;
    }
}

