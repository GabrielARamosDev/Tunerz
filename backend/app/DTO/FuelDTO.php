<?php

namespace App\DTO;

class FuelDTO
{
    public ?int $id = null;
    public ?string $type = null;
    public ?int $octaneRating = null;
    public ?float $density = null;
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
            'octaneRating' => $this->octaneRating,
            'density' => $this->density,
            'specifications' => $this->specifications,
        ];
    }
}
