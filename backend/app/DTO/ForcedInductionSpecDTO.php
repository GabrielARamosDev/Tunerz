<?php

namespace App\DTO;

class ForcedInductionSpecDTO
{
    public ?int $id = null;
    public ?int $forcedInductionId = null;
    public ?int $stockPowerHp = null;
    public ?int $stockPowerRpm = null;
    public ?int $stockTorqueNm = null;
    public ?int $stockTorqueRpm = null;
    public ?float $stockPowerToWeightRatio = null;
    public ?float $stockTorqueToWeightRatio = null;
    public ?int $modifiedPowerHp = null;
    public ?int $modifiedPowerRpm = null;
    public ?int $modifiedTorqueNm = null;
    public ?int $modifiedTorqueRpm = null;
    public ?float $modifiedPowerToWeightRatio = null;
    public ?float $modifiedTorqueToWeightRatio = null;
    public ?float $maxBoostBar = null;
    public ?float $minBoostBar = null;
    public ?float $peakBoostRpm = null;
    public ?float $boostResponseMs = null;
    public ?float $boostRampTimeS = null;
    public ?int $maxInletTempCelsius = null;
    public ?int $maxOutletTempCelsius = null;
    public ?float $intercoolerTempDropCelsius = null;
    public ?int $coolantTempCelsius = null;
    public ?float $thermalEfficiency = null;
    public ?float $airFlowCfm = null;
    public ?float $boostPressureBar = null;
    public ?int $surgeMarginPercent = null;
    public ?float $compressorEfficiencyPercent = null;
    public ?float $turbineEfficiencyPercent = null;
    public ?float $powerGainHp = null;
    public ?float $torqueGainNm = null;
    public ?float $powerGainPercent = null;
    public ?float $torqueGainPercent = null;
    public ?float $spoolTimeMs = null;
    public ?float $lagMs = null;
    public ?int $maxRpm = null;
    public ?int $safeRpm = null;
    public ?float $weightKg = null;
    public ?int $expectedLifeHours = null;
    public ?bool $requiresHighOctane = null;

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
            'forcedInductionId' => $this->forcedInductionId,
            'stockPowerHp' => $this->stockPowerHp,
            'stockTorqueNm' => $this->stockTorqueNm,
            'modifiedPowerHp' => $this->modifiedPowerHp,
            'modifiedTorqueNm' => $this->modifiedTorqueNm,
            'maxBoostBar' => $this->maxBoostBar,
            'peakBoostRpm' => $this->peakBoostRpm,
            'powerGainHp' => $this->powerGainHp,
            'torqueGainNm' => $this->torqueGainNm,
            'powerGainPercent' => $this->powerGainPercent,
            'torqueGainPercent' => $this->torqueGainPercent,
            'spoolTimeMs' => $this->spoolTimeMs,
            'lagMs' => $this->lagMs,
            'maxRpm' => $this->maxRpm,
            'weightKg' => $this->weightKg,
            'requiresHighOctane' => $this->requiresHighOctane,
        ];
    }
}
