<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\CrudController;

use Illuminate\Http\Request;

use App\Models\Engine;

class EngineController extends CrudController
{
    public function index(Request $request)
    {
        $engines = Engine::with(['stages', 'specs'])->get();
        return response()->json($engines);
    }

    public function show(Request $request, $id)
    {
        $engine = Engine::with(['stages', 'specs'])->findOrFail($id);
        return response()->json($engine);
    }
}
