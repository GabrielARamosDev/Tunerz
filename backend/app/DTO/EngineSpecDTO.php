<?php

namespace App\DTO;

class EngineSpecDTO
{
    public ?int $id = null;
    public ?int $engineId = null;
    public ?int $stockPowerHp = null;
    public ?int $stockPowerRpm = null;
    public ?int $stockTorqueNm = null;
    public ?int $stockTorqueRpm = null;
    public ?float $stockPowerToWeightRatio = null;
    public ?float $stockTorqueToWeightRatio = null;
    public ?int $stockIdleRpm = null;
    public ?int $stockRedlineRpm = null;
    public ?int $cylindersCount = null;
    public ?float $pistonBoreMm = null;
    public ?float $pistonStrokeMm = null;
    public ?int $displacementCc = null;
    public ?float $compressionRatio = null;
    public ?int $valveCount = null;
    public ?float $intakeValveDiameterMm = null;
    public ?int $intakeValveSeatAngle = null;
    public ?float $exhaustValveDiameterMm = null;
    public ?int $exhaustValveSeatAngle = null;
    public ?int $carburatorBarrelCount = null;
    public ?float $maxSafeBoostBar = null;
    public ?float $fuelInjectionTimeMs = null;
    public ?int $fuelFlowrateCcMin = null;
    public ?float $fuelPressureBar = null;
    public ?float $airFuelRatio = null;
    public ?float $intakeLengthCm = null;
    public ?float $intakeDiameterIn = null;
    public ?float $airFlowCfm = null;
    public ?float $thermalEfficiency = null;
    public ?float $coolantCapacityL = null;
    public ?float $oilCapacityL = null;
    public ?float $lengthMm = null;
    public ?float $widthMm = null;
    public ?float $heightMm = null;
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
            'engineId' => $this->engineId,
            'stockPowerHp' => $this->stockPowerHp,
            'stockTorqueNm' => $this->stockTorqueNm,
            'cylindersCount' => $this->cylindersCount,
            'displacementCc' => $this->displacementCc,
            'compressionRatio' => $this->compressionRatio,
            'valveCount' => $this->valveCount,
            'stockIdleRpm' => $this->stockIdleRpm,
            'stockRedlineRpm' => $this->stockRedlineRpm,
            'weightKg' => $this->weightKg,
        ];
    }
}
