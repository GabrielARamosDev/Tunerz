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

use App\Models\User;
###
use App\Models\Vehicle;
use App\Models\VehicleSpec;
use App\Models\Engine;
use App\Models\Transmission;
use App\Models\ForcedInduction;
use App\Models\Suspension;
use App\Models\Brake;
use App\Models\BrakePart;
use App\Models\BrakeSpec;
use App\Models\Wheel;
use App\Models\WheelPart;
use App\Models\WheelSpec;
###
use App\Models\UserVehicle;
use App\Models\UserVehicleSpecs;
use App\Models\UserVehicleEnginePart;
use App\Models\UserVehicleEngineSpec;
use App\Models\UserVehicleTransmissionPart;
use App\Models\UserVehicleTransmissionSpec;
use App\Models\UserVehicleForcedInductionPart;
use App\Models\UserVehicleForcedInductionSpec;
use App\Models\UserVehicleSuspensionPart;
use App\Models\UserVehicleSuspensionSpec;

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
            
                /* ================================================ */

                // Get the engine associated with this vehicle
                $engine = Engine::with(['parts', 'specs'])->findOrFail($vehicle->engine_id);

                if (!$engine) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhum motor encontrado para este veículo!'], 404);
                }

                UserVehicleEnginePart::create([

                ]);

                UserVehicleEngineSpec::create([
                    
                ]);

                // Get the transmission associated with this vehicle
                $transmission = Transmission::with(['parts', 'specs'])->findOrFail($vehicle->transmission_id);

                if (!$transmission) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma transmissão encontrada para este veículo!'], 404);
                }

                UserVehicleTransmissionPart::create([

                ]);

                UserVehicleTransmissionSpec::create([
                    
                ]);

                // Get the forced_induction associated with this vehicle
                $forced_induction = ForcedInduction::with(['parts', 'specs'])->findOrFail($vehicle->forced_induction_id);

                if (!$forced_induction) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma indução encontrada para este veículo!'], 404);
                }

                UserVehicleForcedInductionPart::create([

                ]);

                UserVehicleForcedInductionSpec::create([
                    
                ]);

                // Get the front suspension associated with this vehicle
                $front_suspension = Suspension::with(['parts', 'specs'])->findOrFail($vehicle->front_suspension_id);

                if (!$front_suspension) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma suspensão dianteira encontrada para este veículo!'], 404);
                }

                // Get the rear suspension associated with this vehicle
                $rear_suspension = Suspension::with(['parts', 'specs'])->findOrFail($vehicle->rear_suspension_id);

                if (!$rear_suspension) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma suspensão traseira encontrada para este veículo!'], 404);
                }

                if ($vehicle->front_suspension_id == $vehicle->rear_suspension_id) {
                    UserVehicleSuspensionPart::create([

                    ]);

                    UserVehicleSuspensionSpec::create([
                        
                    ]);
                } else {
                    // Front
                    UserVehicleSuspensionPart::create([

                    ]);
                    UserVehicleSuspensionSpec::create([
                        
                    ]);

                    // Rear
                    UserVehicleSuspensionPart::create([

                    ]);
                    UserVehicleSuspensionSpec::create([
                        
                    ]);
                }

                // Get the front brake associated with this vehicle
                $front_brake = Brake::with(['parts', 'specs'])->findOrFail($vehicle->front_brake_id);

                if (!$front_brake) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhum freio dianteiro encontrada para este veículo!'], 404);
                }

                // Get the rear brake associated with this vehicle
                $rear_brake = Brake::with(['parts', 'specs'])->findOrFail($vehicle->rear_brake_id);

                if (!$rear_brake) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhum freio traseiro encontrada para este veículo!'], 404);
                }

                if ($vehicle->front_brake_id == $vehicle->rear_brake_id) {
                    BrakePart::create([

                    ]);

                    BrakeSpec::create([
                        
                    ]);
                } else {
                    // Front
                    BrakePart::create([

                    ]);
                    BrakeSpec::create([
                        
                    ]);

                    // Rear
                    BrakePart::create([

                    ]);
                    BrakeSpec::create([
                        
                    ]);
                }

                // Get the front wheel associated with this vehicle
                $front_wheel = Wheel::with(['parts', 'specs'])->findOrFail($vehicle->front_wheel_id);

                if (!$front_wheel) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma roda dianteira encontrada para este veículo!'], 404);
                }

                // Get the rear wheel associated with this vehicle
                $rear_wheel = Wheel::with(['parts', 'specs'])->findOrFail($vehicle->rear_wheel_id);

                if (!$rear_wheel) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma roda traseira encontrada para este veículo!'], 404);
                }

                if ($vehicle->front_wheel_id == $vehicle->rear_wheel_id) {
                    WheelPart::create([

                    ]);

                    WheelSpec::create([
                        
                    ]);
                } else {
                    // Front
                    WheelPart::create([

                    ]);
                    WheelSpec::create([
                        
                    ]);

                    // Rear
                    WheelPart::create([

                    ]);
                    WheelSpec::create([
                        
                    ]);
                }
                
                /* ================================================ */

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
