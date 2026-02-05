<?php

namespace App\Services\Envelopes;

use App\Services\Ranges\Range;

class ResultEnvelope
{
    public Range $boostPsi;
    public Range $powerHp;
    public Range $torqueNm;
    public Range $afr;
    public array $warnings = [];
    public array $blocks = [];
    public array $requirements = [];
}
