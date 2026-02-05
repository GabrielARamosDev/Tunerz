<?php

namespace App\DTO;

class InductionDTO
{
    public ?int $id = null;
    public ?string $type = null;
    public ?string $model = null;
    public ?float $compressorSize = null;
    public ?float $turbineSize = null;
    public ?array $specifications = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'model' => $this->model,
            'compressorSize' => $this->compressorSize,
            'turbineSize' => $this->turbineSize,
            'specifications' => $this->specifications,
        ];
    }
}
