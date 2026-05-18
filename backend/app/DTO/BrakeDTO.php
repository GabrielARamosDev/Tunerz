<?php

namespace App\DTO;

class BrakeDTO
{
    public ?int $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $manufacturer = null;
    public ?string $type = null;
    
    // Spec properties
    public ?float $rotorDiameterMm = null;
    public ?float $rotorThicknessMm = null;
    public ?float $padThicknessMm = null;
    public ?float $maxForceKn = null;
    public ?float $frictionCoefficient = null;
    public ?float $weightKg = null;

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
            'code' => $this->code,
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
            'type' => $this->type,
            'rotorDiameterMm' => $this->rotorDiameterMm,
            'rotorThicknessMm' => $this->rotorThicknessMm,
            'padThicknessMm' => $this->padThicknessMm,
            'maxForceKn' => $this->maxForceKn,
            'frictionCoefficient' => $this->frictionCoefficient,
            'weightKg' => $this->weightKg,
        ];
    }
}
