<?php

namespace App\DTO;

class VehicleDTO
{
    public ?int $id = null;
    public ?string $make = null;
    public ?string $model = null;
    public ?int $year = null;
    public ?string $vin = null;
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
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->year,
            'vin' => $this->vin,
            'specifications' => $this->specifications,
        ];
    }
}
