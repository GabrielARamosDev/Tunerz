<?php

namespace App\DTO;

class EnginePartDTO
{
    public ?int $id = null;
    public ?int $engineId = null;
    public ?string $blockMaterial = null;
    public ?string $headMaterial = null;
    public ?string $pistonHeadType = null;
    public ?string $pistonHeadMaterial = null;
    public ?string $pistonConrodType = null;
    public ?string $pistonConrodMaterial = null;
    public ?string $camshaftMaterial = null;
    public ?string $camshaftConfig = null;
    public ?string $camshaftActuation = null;
    public ?string $camshaftType = null;
    public ?string $valveMaterial = null;
    public ?string $valveType = null;
    public ?string $fuelType = null;
    public ?string $fuelSystem = null;
    public ?string $carburatorSystem = null;
    public ?string $intakeMaterial = null;
    public ?string $intakeType = null;

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
            'blockMaterial' => $this->blockMaterial,
            'headMaterial' => $this->headMaterial,
            'pistonHeadType' => $this->pistonHeadType,
            'pistonHeadMaterial' => $this->pistonHeadMaterial,
            'camshaftConfig' => $this->camshaftConfig,
            'fuelType' => $this->fuelType,
            'fuelSystem' => $this->fuelSystem,
            'intakeMaterial' => $this->intakeMaterial,
            'intakeType' => $this->intakeType,
        ];
    }
}
