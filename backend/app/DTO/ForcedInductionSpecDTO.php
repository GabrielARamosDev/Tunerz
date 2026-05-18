<?php

namespace App\DTO;

class ForcedInductionSpecDTO
{
    public ?int $id = null;
    public ?int $forcedInductionId = null;
    public ?float $turbineDiameterMm = null;
    public ?float $compressorDiameterMm = null;
    public ?int $turbochargerWeightKg = null;
    public ?float $maxRotationalSpeedRpm = null;
    public ?float $superchargerDisplacementCc = null;
    public ?float $pulleyDiameterMm = null;
    public ?float $pulleyRatio = null;
    public ?int $superchargerWeightKg = null;
    public ?float $intercoolerVolumeL = null;
    public ?float $intercoolerCoreLengthMm = null;
    public ?float $intercoolerCoreWidthMm = null;
    public ?float $intercoolerCoreHeightMm = null;
    public ?float $intercoolerInletDiameterMm = null;
    public ?float $intercoolerOutletDiameterMm = null;
    public ?float $intercoolerPressureDropBar = null;
    public ?int $intercoolerWeightKg = null;
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
            'turbineDiameterMm' => $this->turbineDiameterMm,
            'compressorDiameterMm' => $this->compressorDiameterMm,
            'turbochargerWeightKg' => $this->turbochargerWeightKg,
            'superchargerDisplacementCc' => $this->superchargerDisplacementCc,
            'pulleyDiameterMm' => $this->pulleyDiameterMm,
            'pulleyRatio' => $this->pulleyRatio,
            'intercoolerVolumeL' => $this->intercoolerVolumeL,
            'intercoolerCoreLengthMm' => $this->intercoolerCoreLengthMm,
            'intercoolerInletDiameterMm' => $this->intercoolerInletDiameterMm,
            'intercoolerOutletDiameterMm' => $this->intercoolerOutletDiameterMm,
            'intercoolerPressureDropBar' => $this->intercoolerPressureDropBar,
            'maxBoostBar' => $this->maxBoostBar,
            'minBoostBar' => $this->minBoostBar,
            'peakBoostRpm' => $this->peakBoostRpm,
            'boostResponseMs' => $this->boostResponseMs,
            'boostRampTimeS' => $this->boostRampTimeS,
            'maxInletTempCelsius' => $this->maxInletTempCelsius,
            'maxOutletTempCelsius' => $this->maxOutletTempCelsius,
            'intercoolerTempDropCelsius' => $this->intercoolerTempDropCelsius,
            'coolantTempCelsius' => $this->coolantTempCelsius,
            'thermalEfficiency' => $this->thermalEfficiency,
            'airFlowCfm' => $this->airFlowCfm,
            'boostPressureBar' => $this->boostPressureBar,
            'surgeMarginPercent' => $this->surgeMarginPercent,
            'compressorEfficiencyPercent' => $this->compressorEfficiencyPercent,
            'turbineEfficiencyPercent' => $this->turbineEfficiencyPercent,
            'powerGainHp' => $this->powerGainHp,
            'torqueGainNm' => $this->torqueGainNm,
            'powerGainPercent' => $this->powerGainPercent,
            'torqueGainPercent' => $this->torqueGainPercent,
            'spoolTimeMs' => $this->spoolTimeMs,
            'lagMs' => $this->lagMs,
            'maxRpm' => $this->maxRpm,
            'safeRpm' => $this->safeRpm,
            'weightKg' => $this->weightKg,
            'expectedLifeHours' => $this->expectedLifeHours,
            'requiresHighOctane' => $this->requiresHighOctane,
        ];
    }
}
