<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StageResource;
use App\Services\Tuning\StageEvaluationService;

use App\Models\Stage;

class StageController extends Controller
{
    public function byVehicle($id)
    {
        return Stage::where('vehicle_id', $id)
            ->with(['requirements','warnings'])
            ->get();
    }

    public function show($id, StageEvaluationService $service)
    {
        $stage = Stage::with('vehicle.engine')->findOrFail($id);

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
            Stage::where('vehicle_id', $id)
            ->with(['requirements','warnings'])
            ->get()
        );
    }
}
