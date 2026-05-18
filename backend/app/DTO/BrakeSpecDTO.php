<?php

namespace App\DTO;

class BrakeSpecDTO
{
    public ?int $id = null;
    public ?int $brakeId = null;
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
            'brakeId' => $this->brakeId,
            'rotorDiameterMm' => $this->rotorDiameterMm,
            'rotorThicknessMm' => $this->rotorThicknessMm,
            'padThicknessMm' => $this->padThicknessMm,
            'maxForceKn' => $this->maxForceKn,
            'frictionCoefficient' => $this->frictionCoefficient,
            'weightKg' => $this->weightKg,
        ];
    }
}
