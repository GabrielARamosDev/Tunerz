<?php

namespace App\DTO;

class WheelDTO
{
    public ?int $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $manufacturer = null;
    
    // Spec properties
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
            'code' => $this->code,
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
            'tireWidthMm' => $this->tireWidthMm,
            'tireProfile' => $this->tireProfile,
            'wheelRadiusIn' => $this->wheelRadiusIn,
            'expectedPressureBar' => $this->expectedPressureBar,
            'tireTreadwear' => $this->tireTreadwear,
        ];
    }
}
