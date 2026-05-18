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

use App\DTO\VehicleDTO;

use App\Http\Controllers\CrudController;

use App\Models\Engine;
use App\Models\EngineSpec;
use App\Models\User;
use App\Models\UserVehicle;
use App\Models\UserVehicleTransmission;
use App\Models\UserVehicleBrake;
use App\Models\UserVehicleSuspension;
use App\Models\UserVehicleEngine;
use App\Models\UserVehicleEngineSpec;
use App\Models\UserVehicleSpecs;
use App\Models\Transmission;
use App\Models\Brake;
use App\Models\Suspension;
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
                    'specs', 
                    'engine.specs', 'engine.parts', 
                    'transmission.specs', 'transmission.parts', 
                    'forcedInduction.specs', 'forcedInduction.parts', 
                    'frontSuspension.specs', 'frontSuspension.parts', 
                    'rearSuspension.specs', 'rearSuspension.parts', 
                    'frontBrake.specs', 'frontBrake.parts', 
                    'rearBrake.specs', 'rearBrake.parts', 
                    'frontWheel.specs', 'frontWheel.parts', 
                    'rearWheel.specs', 'rearWheel.parts'
                ])
                ->get();

            $items = $user_vehicles->map(function ($user_vehicle) {
                $DTO = new VehicleDTO($user_vehicle->toArray());
                return $DTO->toArray();
            });

            return response()->json($items, 200);
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
                'year' => 'required_without:generation|integer',
                'generation' => 'required_without:year|integer',
                'transmission_id' => 'nullable|exists:transmissions,id',
                'brake_id' => 'nullable|exists:brakes,id',
                'suspension_id' => 'nullable|exists:suspensions,id',
            ]);

            // Find the vehicle by its specifications
            $vehicle = Vehicle::where('manufacturer', $request->manufacturer)
                ->where('model', $request->model)
                ->where('trim', $request->trim)
                ->where(function ($query) use ($request) {
                    $query->where('year', $request->year)->orWhere('generation', $request->generation);
                })
                ->with([
                    'specs', 
                    'engine.specs', 'engine.parts', 
                    'transmission.specs', 'transmission.parts', 
                    'forcedInduction.specs', 'forcedInduction.parts', 
                    'frontSuspension.specs', 'frontSuspension.parts', 
                    'rearSuspension.specs', 'rearSuspension.parts', 
                    'frontBrake.specs', 'frontBrake.parts', 
                    'rearBrake.specs', 'rearBrake.parts', 
                    'frontWheel.specs', 'frontWheel.parts', 
                    'rearWheel.specs', 'rearWheel.parts'
                ])
                ->firstOrFail();

            if (!$vehicle) {
                return response()->json(['message' => 'Veículo não encontrado!'], 404);
            }

            DB::beginTransaction();

            try {

                // // Get the engine associated with this vehicle
                // $engine = Engine::with(['parts', 'specs'])->findOrFail($vehicle->engine_id);

                // if (!$engine) {
                //     return response()->json(['message' => 'Nenhum motor encontrado para este veículo!'], 404);
                // }

                // Create user vehicle record
                $user_vehicle = UserVehicle::create([
                    'user_id' => $user->id,
                    ###
                    'manufacturer' => $vehicle->manufacturer,
                    'model' => $vehicle->model,
                    'trim' => $vehicle->trim,
                    'year' => $vehicle->year,
                    'generation' => $vehicle->generation,
                    ###
                    'engine_id' => $vehicle->engine_id,
                    'transmission_id' => $vehicle->transmission_id,
                    'forced_induction_id' => $vehicle->forced_induction_id,
                    'front_suspension_id' => $vehicle->front_suspension_id,
                    'rear_suspension_id' => $vehicle->rear_suspension_id,
                    'front_brake_id' => $vehicle->front_brake_id,
                    'rear_brake_id' => $vehicle->rear_brake_id,
                    'front_wheel_id' => $vehicle->front_wheel_id,
                    'rear_wheel_id' => $vehicle->rear_wheel_id,
                ]);

                $specs = $vehicle->specs;

                // Create user vehicle specs
                UserVehicleSpecs::create([
                    'user_vehicle_id' => $user_vehicle->id,
                    'body_type' => $specs->body_type,
                    'drivetrain' => $specs->drivetrain,
                    'steering_type' => $specs->steering_type,
                    ###
                    'length' => $specs->length,
                    'width' => $specs->width,
                    'height' => $specs->height,
                    ###
                    'wheel_base_mm' => $specs->wheel_base_mm,
                    'front_track_mm' => $specs->front_track_mm,
                    'rear_track_mm' => $specs->rear_track_mm,
                    ###
                    'weight' => $specs->weight,
                    'fuel_tank_l' => $specs->fuel_tank_l,
                    'drag_coefficient' => $specs->drag_coefficient,
                ]);

                DB::commit();

                // Load and return the created user vehicle with relationships
                $user_vehicle->load([
                    'specs', 
                    'engine.specs', 'engine.parts', 
                    'transmission.specs', 'transmission.parts', 
                    'forcedInduction.specs', 'forcedInduction.parts', 
                    'frontSuspension.specs', 'frontSuspension.parts', 
                    'rearSuspension.specs', 'rearSuspension.parts', 
                    'frontBrake.specs', 'frontBrake.parts', 
                    'rearBrake.specs', 'rearBrake.parts', 
                    'frontWheel.specs', 'frontWheel.parts', 
                    'rearWheel.specs', 'rearWheel.parts'
                ]);

                $DTO = new VehicleDTO($vehicle->toArray());
                $new_vehicle = $DTO->toArray();

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
