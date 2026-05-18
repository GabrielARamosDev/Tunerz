<?php

namespace App\DTO;

class ForcedInductionPartDTO
{
    public ?int $id = null;
    public ?int $forcedInductionId = null;
    public ?string $turbineMaterial = null;
    public ?string $turbineBladeType = null;
    public ?string $compressorMaterial = null;
    public ?string $compressorDesign = null;
    public ?string $superchargerType = null;
    public ?string $superchargerDrive = null;
    public ?string $superchargerMaterial = null;
    public ?string $intercoolerType = null;
    public ?string $intercoolerMaterial = null;
    public ?string $wastegateType = null;
    public ?string $wastergateMaterial = null;
    public ?string $blowOffValveType = null;
    public ?string $blowOffValveMaterial = null;
    public ?string $intakeManifoldMaterial = null;
    public ?string $pipingMaterial = null;

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
            'turbineMaterial' => $this->turbineMaterial,
            'turbineBladeType' => $this->turbineBladeType,
            'compressorMaterial' => $this->compressorMaterial,
            'compressorDesign' => $this->compressorDesign,
            'superchargerType' => $this->superchargerType,
            'intercoolerType' => $this->intercoolerType,
            'wastegateType' => $this->wastegateType,
            'intakeManifoldMaterial' => $this->intakeManifoldMaterial,
            'pipingMaterial' => $this->pipingMaterial,
        ];
    }
}
