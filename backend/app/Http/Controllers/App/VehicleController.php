<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\CrudController;

use Illuminate\Http\Request;

use App\Models\Vehicle;

class VehicleController extends CrudController
{    
    public function index(Request $request)
    {
        $vehicles = Vehicle::with([ 
            'specs', 
            'engine.specs', 'engine.parts', 
            'transmission.specs', 'transmission.parts', 
            'frontSuspension.specs', 'frontSuspension.parts', 
            'rearSuspension.specs', 'rearSuspension.parts', 
            'frontBrake.specs', 'frontBrake.parts', 
            'rearBrake.specs', 'rearBrake.parts', 
            'frontWheel.specs', 'rearWheel.specs', 
        ])->get();
        
        // Map year to year for frontend compatibility
        $vehicles = $vehicles->map(function($vehicle) {
            $vehicle->year = $vehicle->year;
            unset($vehicle->year);
            return $vehicle;
        });
        
        return response()->json($vehicles);
    }

    public function show(Request $request, $id)
    {
        $vehicle = Vehicle::with(['engine.specs'])->findOrFail($id);
        
        // Map year to year for frontend compatibility
        $vehicle->year = $vehicle->year;
        unset($vehicle->year);
        
        return response()->json($vehicle);
    }

    public function retrieve(Request $request)
    {
        $manufacturer = $request->query('manufacturer');
        $model = $request->query('model');
        $trim = $request->query('trim');
        $year = $request->query('year');

        $vehicle = Vehicle::where('manufacturer', $manufacturer)
            ->where('model', $model)
            ->where('trim', $trim)
            ->where('year', $year)
            ->with(['engine.specs'])
            ->firstOrFail();

        // // Map year to year for frontend compatibility
        // $vehicle->year = $vehicle->year;
        // unset($vehicle->year);

        return response()->json($vehicle);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Map 'year' to 'year' for database compatibility
        if (isset($data['year'])) {
            $data['year'] = $data['year'];
            unset($data['year']);
        }
        $vehicle = Vehicle::create($data);
        
        // Map year to year for frontend compatibility
        $vehicle->year = $vehicle->year;
        unset($vehicle->year);
        
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

    public function getManufacturers()
    {
        $manufacturers = Vehicle::distinct()
            ->pluck('manufacturer')
            ->sort()
            ->values();
        
        return response()->json($manufacturers);
    }

    public function getModels(Request $request)
    {
        $manufacturer = $request->query('manufacturer');
        
        $models = Vehicle::where('manufacturer', $manufacturer)
            ->distinct()
            ->pluck('model')
            ->sort()
            ->values();
        
        return response()->json($models);
    }

    public function getTrims(Request $request)
    {
        $manufacturer = $request->query('manufacturer');
        $model = $request->query('model');
        
        $trims = Vehicle::where('manufacturer', $manufacturer)
            ->where('model', $model)
            ->distinct()
            ->pluck('trim')
            ->sort()
            ->values();
        
        return response()->json($trims);
    }

    public function getYears(Request $request)
    {
        $manufacturer = $request->query('manufacturer');
        $model = $request->query('model');
        $trim = $request->query('trim');

        $years = Vehicle::where('manufacturer', $manufacturer)
            ->where('model', $model)
            ->where('trim', $trim)
            ->distinct()
            ->pluck('year')
            ->sort()
            ->reverse()
            ->values();
        
        return response()->json($years);
    }

    public function getGenerations(Request $request)
    {
        $manufacturer = $request->query('manufacturer');
        $model = $request->query('model');
        $trim = $request->query('trim');
        $year = $request->query('year');

        $generations = Vehicle::where('manufacturer', $manufacturer)
            ->where('model', $model)
            ->where('trim', $trim)
            ->where('year', $year)
            ->distinct()
            ->pluck('generation')
            ->sort()
            ->reverse()
            ->values();
        
        return response()->json($generations);
    }
}
