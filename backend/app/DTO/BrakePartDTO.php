<?php

namespace App\DTO;

class BrakePartDTO
{
    public ?int $id = null;
    public ?int $brakeId = null;
    public ?string $rotorType = null;
    public ?string $rotorMaterial = null;
    public ?string $caliperType = null;
    public ?string $caliperMaterial = null;
    public ?string $padType = null;
    public ?string $padMaterial = null;
    public ?bool $dustShield = null;

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
            'brakeId' => $this->brakeId,
            'rotorType' => $this->rotorType,
            'rotorMaterial' => $this->rotorMaterial,
            'caliperType' => $this->caliperType,
            'padType' => $this->padType,
            'dustShield' => $this->dustShield,
        ];
    }
}
