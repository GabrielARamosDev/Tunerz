<?php

namespace App\DTO;

class ForcedInductionDTO
{
    public ?int $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $manufacturer = null;
    public ?string $type = null;
    public ?string $twinTurboConfig = null;
    public ?int $twinTurboCount = null;
    public ?string $superchargerConfig = null;
    public ?int $maxBoostBar = null;
    public ?int $powerGainHp = null;
    public ?int $torqueGainNm = null;
    public ?float $spoolTimeMs = null;

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
            'twinTurboConfig' => $this->twinTurboConfig,
            'twinTurboCount' => $this->twinTurboCount,
            'superchargerConfig' => $this->superchargerConfig,
            'maxBoostBar' => $this->maxBoostBar,
            'powerGainHp' => $this->powerGainHp,
            'torqueGainNm' => $this->torqueGainNm,
            'spoolTimeMs' => $this->spoolTimeMs,
        ];
    }
}
