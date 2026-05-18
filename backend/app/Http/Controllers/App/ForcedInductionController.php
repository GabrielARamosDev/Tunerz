<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\CrudController;

use Illuminate\Http\Request;

use App\Http\Requests\StoreForcedInductionRequest;
use App\Http\Requests\UpdateForcedInductionRequest;

use App\Models\ForcedInduction;

class ForcedInductionController extends CrudController
{
    /**
     * Display a listing of forced induction systems with their specifications.
     */
    public function index(Request $request)
    {
        $forcedInductions = ForcedInduction::with(['specs', 'parts'])->get();
        return response()->json($forcedInductions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified forced induction system with its specifications and parts.
     */
    public function show(Request $request, $id)
    {
        $forcedInduction = ForcedInduction::with(['specs', 'parts'])->findOrFail($id);
        return response()->json($forcedInduction);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForcedInduction $forcedInduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
