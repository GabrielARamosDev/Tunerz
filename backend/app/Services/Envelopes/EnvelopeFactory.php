<?php

namespace App\Services\Envelopes;

use App\Services\Context\BuildContext;
use App\Services\Envelopes\ResultEnvelope;
use App\Services\Ranges\Range;

class EnvelopeFactory
{
    public static function base(BuildContext $context): ResultEnvelope
    {
        $env = new ResultEnvelope();

        $env->boostPsi = new Range(0, 14, 18, 8);
        $env->powerHp = new Range(150, 280, 320, 230);
        $env->afr = new Range(11.5, 12.2, 12.8, 11.8);

        return $env;
    }
}

