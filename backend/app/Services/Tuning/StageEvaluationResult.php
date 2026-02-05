<?php

namespace App\Services\Tuning;

class StageEvaluationResult
{
    public string $status = 'OK';
    public array $warnings = [];
    public array $requirements = [];

    public function addWarning(string $message): void
    {
        $this->warnings[] = $message;
    }

    public function addRequirement(string $message): void
    {
        $this->requirements[] = $message;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
