<?php

namespace App\Services\Context;

use App\DTO\VehicleDTO;
use App\DTO\EngineDTO;
use App\DTO\InductionDTO;
use App\DTO\FuelDTO;

class BuildContext
{
    public VehicleDTO $vehicle;
    public EngineDTO $engine;
    public InductionDTO $induction;
    public FuelDTO $fuel;
    public array $components;
    public array $userOverrides;
}
