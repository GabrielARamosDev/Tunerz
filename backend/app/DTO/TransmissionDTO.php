<?php

namespace App\DTO;

class TransmissionDTO
{
    public ?int $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $manufacturer = null;
    public ?string $type = null;
    
    // Spec properties
    public ?int $gearsCount = null;
    public ?float $gearRatio1 = null;
    public ?float $gearRatio2 = null;
    public ?float $gearRatio3 = null;
    public ?float $gearRatio4 = null;
    public ?float $gearRatio5 = null;
    public ?float $gearRatio6 = null;
    public ?float $gearRatio7 = null;
    public ?float $finalDriveRatio = null;
    public ?float $clutchDiameterMm = null;
    public ?int $maxTorqueNm = null;
    public ?float $weightKg = null;
    public ?float $oilCapacityL = null;

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
            'gearsCount' => $this->gearsCount,
            'finalDriveRatio' => $this->finalDriveRatio,
            'maxTorqueNm' => $this->maxTorqueNm,
            'weightKg' => $this->weightKg,
            'oilCapacityL' => $this->oilCapacityL,
        ];
    }
}
