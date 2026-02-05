<?php

namespace App\Services\Tuning;

use App\Models\Stage;
use App\Services\Tuning\Rules\BoostRule;
use App\Services\Tuning\Rules\CompressionRule;
use App\Services\Tuning\StageEvaluationResult;

class StageEvaluationService
{
    protected array $rules;

    public function __construct()
    {
        $this->rules = [
            new BoostRule(),
            new CompressionRule(),
        ];
    }

    public function evaluate(Stage $stage): StageEvaluationResult
    {
        $engine = $stage->vehicle->engine;

        $context = [
            'engine' => [
                'compression_ratio' => $engine->compression_ratio,
                'safe_boost_stock' => $engine->safe_boost_stock,
            ],
            'stage' => [
                'boost_pressure' => $stage->boost_pressure,
            ]
        ];

        $result = new StageEvaluationResult();

        foreach ($this->rules as $rule) {
            $rule->apply($context, $result);
        }

        return $result;
    }
}

