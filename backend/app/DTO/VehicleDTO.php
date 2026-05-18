<?php

namespace App\DTO;

class VehicleDTO
{
    public ?int $id = null;
    public ?string $manufacturer = null;
    public ?string $model = null;
    public ?string $trim = null;
    public ?int $year = null;
    public ?int $generation = null;
    public ?int $engineId = null;
    public ?int $transmissionId = null;
    public ?int $frontSuspensionId = null;
    public ?int $rearSuspensionId = null;
    public ?int $frontBrakeId = null;
    public ?int $rearBrakeId = null;
    public ?int $frontWheelId = null;
    public ?int $rearWheelId = null;
    public ?int $forcedInductionId = null;
    public ?string $imageUrl = null;
    
    // Spec properties
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
            'manufacturer' => $this->manufacturer,
            'model' => $this->model,
            'trim' => $this->trim,
            'year' => $this->year,
            'generation' => $this->generation,
            'engineId' => $this->engineId,
            'transmissionId' => $this->transmissionId,
            'frontSuspensionId' => $this->frontSuspensionId,
            'rearSuspensionId' => $this->rearSuspensionId,
            'frontBrakeId' => $this->frontBrakeId,
            'rearBrakeId' => $this->rearBrakeId,
            'frontWheelId' => $this->frontWheelId,
            'rearWheelId' => $this->rearWheelId,
            'forcedInductionId' => $this->forcedInductionId,
            'bodyType' => $this->bodyType,
            'drivetrain' => $this->drivetrain,
            'weightKg' => $this->weightKg,
            'fuelTankL' => $this->fuelTankL,
        ];
    }
}
