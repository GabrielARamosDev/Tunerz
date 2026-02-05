<?php

namespace App\Http\Controllers;

use App\Models\Module;

class ModuleController extends Controller
{
    public function byVehicle($vehicleId)
    {
        $modules = Module::where('vehicle_id', $vehicleId)->get();
        return response()->json($modules);
    }
}
