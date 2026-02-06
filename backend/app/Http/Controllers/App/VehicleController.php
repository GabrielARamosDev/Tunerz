<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\CrudController;

use Illuminate\Http\Request;

use App\Models\Vehicle;

class VehicleController extends CrudController
{    
    public function index(Request $request)
    {
        $vehicles = Vehicle::with(['engines.stages', 'engines.specs'])->get();
        return response()->json($vehicles);
    }

    public function show(Request $request, $id)
    {
        $vehicle = Vehicle::with(['engines.stages', 'engines.specs'])->findOrFail($id);
        return response()->json($vehicle);
    }

    public function store(Request $request)
    {
        $vehicle = Vehicle::create($request->all());
        return response()->json($vehicle, 201);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());
        return response()->json($vehicle);
    }

    public function destroy($id)
    {
        Vehicle::destroy($id);
        return response()->json(null, 204);
    }
}
