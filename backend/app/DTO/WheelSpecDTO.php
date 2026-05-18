<?php

namespace App\DTO;

class WheelSpecDTO
{
    public ?int $id = null;
    public ?int $wheelId = null;
    public ?float $tireWidthMm = null;
    public ?string $tireProfile = null;
    public ?float $wheelRadiusIn = null;
    public ?float $expectedPressureBar = null;
    public ?int $tireTreadwear = null;

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
            'wheelId' => $this->wheelId,
            'tireWidthMm' => $this->tireWidthMm,
            'tireProfile' => $this->tireProfile,
            'wheelRadiusIn' => $this->wheelRadiusIn,
            'expectedPressureBar' => $this->expectedPressureBar,
            'tireTreadwear' => $this->tireTreadwear,
        ];
    }
}
