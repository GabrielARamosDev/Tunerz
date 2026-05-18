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
    public ?int $engine_id = null;
    public ?int $transmission_id = null;
    public ?int $forced_induction_id = null;
    public ?int $front_s_id = null;
    public ?int $rear_s_id = null;
    public ?int $front_brake_id = null;
    public ?int $rear_brake_id = null;
    public ?int $front_wheel_id = null;
    public ?int $rear_wheel_id = null;
    public ?string $imageUrl = null;
    
    // Spec properties
    public ?array $specs = null;
    public ?array $engine = null;
    public ?array $transmission = null;
    public ?array $forced_induction = null;
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
            'forced_induction' => $this->forced_induction, 
            'suspension' => $this->suspension, 
            'brake' => $this->brake, 
            'wheel' => $this->wheel, 
        ];
    }
}
