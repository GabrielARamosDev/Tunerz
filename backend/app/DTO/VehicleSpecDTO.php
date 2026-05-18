<?php

namespace App\DTO;

class VehicleSpecDTO
{
    public ?int $id = null;
    public ?int $vehicleId = null;
    public ?string $bodyType = null;
    public ?string $drivetrain = null;
    public ?string $steeringType = null;
    public ?float $lengthMm = null;
    public ?float $widthMm = null;
    public ?float $heightMm = null;
    public ?float $wheelBaseMm = null;
    public ?float $frontTrackMm = null;
    public ?float $rearTrackMm = null;
    public ?float $weightKg = null;
    public ?float $fuelTankL = null;
    public ?float $dragCoefficient = null;

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
            'vehicleId' => $this->vehicleId,
            'bodyType' => $this->bodyType,
            'drivetrain' => $this->drivetrain,
            'steeringType' => $this->steeringType,
            'lengthMm' => $this->lengthMm,
            'widthMm' => $this->widthMm,
            'heightMm' => $this->heightMm,
            'wheelBaseMm' => $this->wheelBaseMm,
            'weightKg' => $this->weightKg,
            'fuelTankL' => $this->fuelTankL,
            'dragCoefficient' => $this->dragCoefficient,
        ];
    }
}
