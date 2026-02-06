<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\CrudController;
use App\Http\Resources\StageResource;
use App\Services\Tuning\StageEvaluationService;

use Illuminate\Http\Request;

use App\Models\EngineStage;

class StageController extends CrudController
{
    public function __construct(
        protected StageEvaluationService $service
    ) {

    }

    public function show(Request $request, $id)
    {
        $stage = EngineStage::with('vehicle.engine')->findOrFail($id);

        $evaluation = $this->service->evaluate($stage);

        return response()->json([
            'stage' => $stage->only([
                'id','name','boost_pressure','expected_power'
            ]),
            'evaluation' => $evaluation
        ]);
    }

    public function byVehicle($id)
    {
        return EngineStage::where('vehicle_id', $id)
            ->with(['requirements','warnings'])
            ->get();
    }
}
