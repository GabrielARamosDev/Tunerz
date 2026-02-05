<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StageResource;
use App\Services\Tuning\StageEvaluationService;

use App\Models\EngineStage;

class StageController extends Controller
{
    public function byVehicle($id)
    {
        return EngineStage::where('vehicle_id', $id)
            ->with(['requirements','warnings'])
            ->get();
    }

    public function show($id, StageEvaluationService $service)
    {
        $stage = EngineStage::with('vehicle.engine')->findOrFail($id);

        $evaluation = $service->evaluate($stage);

        return response()->json([
            'stage' => $stage->only([
                'id','name','boost_pressure','expected_power'
            ]),
            'evaluation' => $evaluation
        ]);
    }

    public function resourceByVehicle($id)
    {
        return StageResource::collection(
            EngineStage::where('vehicle_id', $id)
            ->with(['requirements','warnings'])
            ->get()
        );
    }
}
