<?php

namespace App\DTO;

class TransmissionSpecDTO
{
    public ?int $id = null;
    public ?int $transmissionId = null;
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
            'transmissionId' => $this->transmissionId,
            'gearsCount' => $this->gearsCount,
            'finalDriveRatio' => $this->finalDriveRatio,
            'maxTorqueNm' => $this->maxTorqueNm,
            'weightKg' => $this->weightKg,
            'oilCapacityL' => $this->oilCapacityL,
        ];
    }
}
