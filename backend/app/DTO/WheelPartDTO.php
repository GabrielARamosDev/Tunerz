<?php

namespace App\DTO;

class WheelPartDTO
{
    public ?int $id = null;
    public ?int $wheelId = null;
    public ?string $tireMaterial = null;
    public ?string $wheelMaterial = null;

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
            'wheelId' => $this->wheelId,
            'tireMaterial' => $this->tireMaterial,
            'wheelMaterial' => $this->wheelMaterial,
        ];
    }
}
