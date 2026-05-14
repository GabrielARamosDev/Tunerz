<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Constants\Roles;
use App\Constants\User as UserConstants;
use App\Constants\UserStatus;

use App\Http\Controllers\CrudController;
use App\Models\Engine;
use App\Models\EngineSpec;
use App\Models\User;
use App\Models\UserVehicle;
use App\Models\UserVehicleEngine;
use App\Models\UserVehicleEngineSpec;
use App\Models\UserVehicleSpecs;
use App\Models\Vehicle;
use App\Models\VehicleSpec;

class UserController extends CrudController
{
    protected $entity = User::class;

    public function validateForCreate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'roles' => 'array|exists:roles,id',
        ]);
    }

    public function validateForUpdate(Request $request)
    {
        $request->validate([
            'name' => 'string',
            'email' => 'string|email',
            'password' => 'confirmed',
            'roles' => 'array|exists:roles,id',
        ]);
    }

    /* ============================================================== */

    public function fill(Request $request, $user)
    {
        parent::fill($request, $user);

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if (null == $user->email_verified_at) {
            $user->email_verified_at = now();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function beginQuery(Request $request)
    {
        $query = parent::beginQuery($request);

        if ($request->has('role_id') && $request['role_id'] > 0) {
            $query->whereHas('roles', function ($query) use ($request) {
                $query->where('id', $request['role_id']);
            });
        }

        return $query->with(['roles', 'states']);
    }

    public function search($query, $search)
    {
        return User::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
            $query->orWhere('email', 'like', '%' . $search . '%');
        })->get();
    }

    /**
     * Dispara após o salvamento de um model
     *
     * @param \App\Models\User $user
     */
    public function afterModelSaved(Request $request, $user)
    {
        if ($request->has('role_id') && $request['role_id'] > 0) {
            $user->roles()->sync([$request['role_id']]);
        }
        if ($request->has('state_id') && $request['state_id'] > 0) {
            $user->states()->sync([$request['state_id']]);
        }
    }

    /* ============================================================== */

    public function vehicles(Request $request)
    {
        if (Auth::check()) {

            $user = $request->user();

            $user_vehicles = UserVehicle::where('user_id', $user->id)
                ->with([
                    'vehicle', 'vehicleSpecs',
                    'engines.specs'
                ])
                ->get();

            foreach ($user_vehicles as $i => $vehicle) {
                $user_vehicles[$i] = UserVehicle::mountFrontendModel($vehicle);
            }

            return response()->json($user_vehicles, 200);
        }

        return response()->json([
            'message' => 'Usuário não autenticado!',
        ], 400);
    }

    public function addVehicle(Request $request)
    {
        if (Auth::check()) {

            $user = $request->user();

            $user_roles = $user->roles->pluck('name')->toArray();

            $user_vehicles_count = UserVehicle::where('user_id', $user->id)->count();

            if (!in_array('Admin', $user_roles) && $user_vehicles_count >= UserConstants::MAX_VEHICLES) {
                return response()->json(['message' => 'Limite de veículos atingido!'], 400);
            }

            $request->validate([
                'manufacturer' => 'required|string',
                'model' => 'required|string',
                'trim' => 'required|string',
                'year' => 'required|integer',
            ]);

            // Find the vehicle by its specifications
            $vehicle = Vehicle::where('manufacturer', $request->manufacturer)
                ->where('model', $request->model)
                ->where('trim', $request->trim)
                ->where('year', $request->year)
                ->with(['specs', 'engine'])
                ->firstOrFail();

            if (!$vehicle) {
                return response()->json(['message' => 'Veículo não encontrado!'], 404);
            }

            $specs = $vehicle->specs;

            // Get the engine associated with this vehicle
            $engine = Engine::with(['specs'])
                ->findOrFail($vehicle->engine_id);

            if (!$engine) {
                return response()->json(['message' => 'Nenhum motor encontrado para este veículo!'], 404);
            }

            DB::beginTransaction();

            try {
                // Create user vehicle record
                $user_vehicle = UserVehicle::create([
                    'user_id' => $user->id,
                    'vehicle_id' => $vehicle->id,
                ]);

                // Create user vehicle specs
                UserVehicleSpecs::create([
                    'user_vehicle_id' => $user_vehicle->id,
                    'generation' => null,
                    'platform' => null,
                    'series' => null,
                    'drivetrain' => $specs->drivetrain,
                    'transmission' => $specs->transmission,
                    'weight' => $specs->weight,
                    'weight_unit' => $specs->weight_unit,
                    'width' => $specs->width,
                    'length' => $specs->length,
                    'height' => $specs->height,
                ]);

                // Create user vehicle engine record with engine data
                $user_vehicle_engines = UserVehicleEngine::create([
                    'user_vehicle_id' => $user_vehicle->id,
                    'code' => $engine->code,
                    'manufacturer' => $engine->manufacturer,
                    'displacement' => $engine->displacement,
                    'valve_count' => $engine->valve_count,
                    'propulsion' => $engine->propulsion,
                    'fuel_type' => $engine->fuel_type,
                    'active' => 1,
                ]);

                // Get and create engine specs
                $engine_specs = EngineSpec::findOrFail($engine->id);
                UserVehicleEngineSpec::create([
                    'user_vehicle_engine_id' => $user_vehicle_engines->id,
                    'place' => $engine_specs->place,
                    'orientation' => $engine_specs->orientation,
                    'cylinder_configuration' => $engine_specs->cylinder_configuration,
                    'cylinders_count' => $engine_specs->cylinders_count,
                    'valves_per_cylinder' => $engine_specs->valves_per_cylinder,
                    'valve_tappet' => $engine_specs->valve_tappet,
                    'compression_ratio' => $engine_specs->compression_ratio,
                    'aspiration' => $engine_specs->aspiration,
                    'fuel_system' => $engine_specs->fuel_system,
                    'camshaft_type' => $engine_specs->camshaft_type,
                    'command_drive' => $engine_specs->command_drive,
                    'bore_mm' => $engine_specs->bore_mm,
                    'stroke_mm' => $engine_specs->stroke_mm,
                    'stock_power_hp' => $engine_specs->stock_power_hp,
                    'stock_power_rpm' => $engine_specs->stock_power_rpm,
                    'stock_torque_nm' => $engine_specs->stock_torque_nm,
                    'stock_torque_rpm' => $engine_specs->stock_torque_rpm,
                    'specific_power_hp_per_liter' => $engine_specs->specific_power_hp_per_liter,
                    'power_to_weight_ratio' => $engine_specs->power_to_weight_ratio,
                    'torque_to_weight_ratio' => $engine_specs->torque_to_weight_ratio,
                    'active' => 1,
                ]);

                DB::commit();

                // Load and return the created user vehicle with relationships
                $user_vehicle->load([
                    'vehicle', 'vehicleSpecs', 
                    'engines.specs'
                ]);

                $new_vehicle = UserVehicle::mountFrontendModel($user_vehicle);

                return response()->json($new_vehicle, 201);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'message' => 'Erro ao adicionar veículo: ' . $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Usuário não autenticado!',
        ], 400);
    }

    public function removeVehicle(Request $request) {}
}
