<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\CrudController;

use App\Models\Module;

class ModuleController extends CrudController
{
    public function byVehicle($vehicleId)
    {
        $modules = Module::where('vehicle_id', $vehicleId)->get();
        return response()->json($modules);
    }
}
