<?php

namespace App\DTO;

class VehicleDTO
{
    public ?int $id = null;
    public ?string $manufacturer = null;
    public ?string $model = null;
    public ?string $trim = null;
    public ?int $year = null;
    public ?int $generation = null;
    public ?int $engineId = null;
    public ?int $transmissionId = null;
    public ?int $forcedInductionId = null;
    public ?int $frontSuspensionId = null;
    public ?int $rearSuspensionId = null;
    public ?int $frontBrakeId = null;
    public ?int $rearBrakeId = null;
    public ?int $frontWheelId = null;
    public ?int $rearWheelId = null;
    public ?string $imageUrl = null;
    
    // Spec properties
    public ?array $specs = null;
    public ?array $engine = null;
    public ?array $transmission = null;
    public ?array $forcedInduction = null;
    public ?array $suspension = null;
    public ?array $brake = null;
    public ?array $wheel = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'front_suspension':
                case 'rear_suspension':
                case 'front_brake':
                case 'rear_brake':
                case 'front_wheel':
                case 'rear_wheel': {

                    $prefix = explode('_', $key)[0];

                    $_key = str_replace(($prefix.'_'), '', $key);

                    if (property_exists($this, $_key)) {
                        if (!$this->$_key) {
                            $this->$_key = [];
                        }

                        $this->$_key[$prefix] = $value;
                    }
                }
                ###
                default: {
                    if (property_exists($this, $key)) {
                        $this->$key = $value;
                    }
                }
            }
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'manufacturer' => $this->manufacturer,
            'model' => $this->model,
            'trim' => $this->trim,
            'year' => $this->year,
            'generation' => $this->generation,
            'specs' => $this->specs, 
            'engine' => $this->engine, 
            'transmission' => $this->transmission, 
            'forcedInduction' => $this->forcedInduction, 
            'suspension' => $this->suspension, 
            'brake' => $this->brake, 
            'wheel' => $this->wheel, 
        ];
    }
}
