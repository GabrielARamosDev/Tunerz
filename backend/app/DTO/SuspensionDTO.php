<?php

namespace App\DTO;

class SuspensionDTO
{
    public ?int $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $manufacturer = null;
    public ?string $type = null;
    public ?string $configuration = null;
    
    // Spec properties
    public ?float $springConstantNm = null;
    public ?float $dampingRatio = null;
    public ?float $rideHeightMm = null;
    public ?float $groundClearanceMm = null;
    public ?float $camberAngleDeg = null;
    public ?float $casterAngleDeg = null;
    public ?float $toeInMm = null;
    public ?float $stabilizerDiameterMm = null;
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
            'configuration' => $this->configuration,
            'springConstantNm' => $this->springConstantNm,
            'dampingRatio' => $this->dampingRatio,
            'rideHeightMm' => $this->rideHeightMm,
            'groundClearanceMm' => $this->groundClearanceMm,
            'camberAngleDeg' => $this->camberAngleDeg,
            'weightKg' => $this->weightKg,
        ];
    }
}
