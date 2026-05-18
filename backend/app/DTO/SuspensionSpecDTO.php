<?php

namespace App\DTO;

class SuspensionSpecDTO
{
    public ?int $id = null;
    public ?int $suspensionId = null;
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
            'suspensionId' => $this->suspensionId,
            'springConstantNm' => $this->springConstantNm,
            'dampingRatio' => $this->dampingRatio,
            'rideHeightMm' => $this->rideHeightMm,
            'groundClearanceMm' => $this->groundClearanceMm,
            'camberAngleDeg' => $this->camberAngleDeg,
            'weightKg' => $this->weightKg,
        ];
    }
}
