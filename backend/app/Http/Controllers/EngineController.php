<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Engine;

class EngineController extends Controller
{
    public function index()
    {
        $engines = Engine::with(['stages', 'specs'])->get();
        return response()->json($engines);
    }

    public function show($id)
    {
        $engine = Engine::with(['stages', 'specs'])->findOrFail($id);
        return response()->json($engine);
    }
}
