<?php

namespace App\DTO;

class EngineDTO
{
    public ?int $id = null;
    public ?string $code = null;
    public ?float $cylinderCapacity = null;
    public ?float $compressionRate = null;
    public ?int $factoryPower = null;
    public ?float $stockTurboLimit = null;
    public ?int $valves = null;
    public ?float $limiteTurboStock = null;

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
            'cylinderCapacity' => $this->cylinderCapacity,
            'compressionRate' => $this->compressionRate,
            'factoryPower' => $this->factoryPower,
            'stockTurboLimit' => $this->stockTurboLimit,
            'valves' => $this->valves,
            'limiteTurboStock' => $this->limiteTurboStock,
        ];
    }
}
