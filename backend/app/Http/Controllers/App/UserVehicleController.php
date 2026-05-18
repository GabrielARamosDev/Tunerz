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

class UserVehicleController extends CrudController
{
    protected $entity = UserVehicle::class;

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
                    'engine_id' => $engine->id,
                    'block_material' => $engine->block_material,
                    'head_material' => $engine->head_material,
                    'piston_head_type' => $engine->piston_head_type,
                    'piston_head_material' => $engine->piston_head_material,
                    'piston_conrod_type' => $engine->piston_conrod_type,
                    'piston_conrod_material' => $engine->piston_conrod_material,
                    'camshaft_material' => $engine->camshaft_material,
                    'camshaft_config' => $engine->camshaft_config,
                    'camshaft_actuation' => $engine->camshaft_actuation,
                    'camshaft_type' => $engine->camshaft_type,
                    'valve_material' => $engine->valve_material,
                    'valve_type' => $engine->valve_type,
                    'fuel_type' => $engine->fuel_type,
                    'fuel_system' => $engine->fuel_system,
                    'carburator_system' => $engine->carburator_system,
                    'intake_manifold_material' => $engine->intake_manifold_material,
                    'intake_type' => $engine->intake_type,
                    'intake_piping_material' => $engine->intake_piping_material,
                ]);

                UserVehicleEngineSpec::create([
                    'engine_id' => $engine->id,
                    'power_hp' => $engine->stock_power_hp,
                    'power_rpm' => $engine->stock_power_rpm,
                    'torque_nm' => $engine->stock_torque_nm,
                    'torque_rpm' => $engine->stock_torque_rpm,
                    'power_to_weight_ratio' => $engine->stock_power_to_weight_ratio,
                    'torque_to_weight_ratio' => $engine->stock_torque_to_weight_ratio,
                    'redline_rpm' => $engine->stock_redline_rpm,
                    'idle_rpm' => $engine->stock_idle_rpm,
                    'cylinders_count' => $engine->cylinders_count,
                    'piston_bore_mm' => $engine->piston_bore_mm,
                    'piston_stroke_mm' => $engine->piston_stroke_mm,
                    'displacement_cc' => $engine->displacement_cc,
                    'compression_ratio' => $engine->compression_ratio,
                    'valve_count' => $engine->valve_count,
                    'intake_valve_diameter_mm' => $engine->intake_valve_diameter_mm,
                    'intake_valve_seat_angle' => $engine->intake_valve_seat_angle,
                    'exhaust_valve_diameter_mm' => $engine->exhaust_valve_diameter_mm,
                    'exhaust_valve_seat_angle' => $engine->exhaust_valve_seat_angle,
                    'carburator_barrel_count' => $engine->carburator_barrel_count,
                    'fuel_injection_time_ms' => $engine->fuel_injection_time_ms,
                    'fuel_flowrate_cc_min' => $engine->fuel_flowrate_cc_min,
                    'fuel_pressure_bar' => $engine->fuel_pressure_bar,
                    'air_fuel_ratio' => $engine->air_fuel_ratio,
                    'intake_lenght_cm' => $engine->intake_lenght_cm,
                    'intake_diameter_in' => $engine->intake_diameter_in,
                    'air_flow_cfm' => $engine->air_flow_cfm,
                    'thermal_efficiency' => $engine->thermal_efficiency,
                    'coolant_capacity_l' => $engine->coolant_capacity_l,
                    'oil_capacity_l' => $engine->oil_capacity_l,
                    'length_mm' => $engine->length_mm,
                    'width_mm' => $engine->width_mm,
                    'height_mm' => $engine->height_mm,
                    'weight_kg' => $engine->weight_kg,
                ]);

                // Get the transmission associated with this vehicle
                $transmission = Transmission::with(['parts', 'specs'])->findOrFail($vehicle->transmission_id);

                if (!$transmission) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma transmissão encontrada para este veículo!'], 404);
                }

                UserVehicleTransmissionPart::create([
                    'transmission_id' => $transmission->id,
                    'clutch_type' => $transmission->clutch_type,
                    'synchro_type' => $transmission->synchro_type,
                    'material_case' => $transmission->material_case,
                ]);

                UserVehicleTransmissionSpec::create([
                    'transmission_id' => $transmission->id,
                    'gears_count' => $transmission->gears_count,
                    'gear_ratio_1' => $transmission->gear_ratio_1,
                    'gear_ratio_2' => $transmission->gear_ratio_2,
                    'gear_ratio_3' => $transmission->gear_ratio_3,
                    'gear_ratio_4' => $transmission->gear_ratio_4,
                    'gear_ratio_5' => $transmission->gear_ratio_5,
                    'final_drive_ratio' => $transmission->final_drive_ratio,
                    'clutch_diameter_mm' => $transmission->clutch_diameter_mm,
                    'max_torque_nm' => $transmission->max_torque_nm,
                    'weight_kg' => $transmission->weight_kg,
                    'oil_capacity_l' => $transmission->oil_capacity_l,
                ]);

                // Get the forced_induction associated with this vehicle
                $forced_induction = ForcedInduction::with(['parts', 'specs'])->findOrFail($vehicle->forced_induction_id);

                if (!$forced_induction) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma indução encontrada para este veículo!'], 404);
                }

                UserVehicleForcedInductionPart::create([
                    'forced_induction_id' => $forced_induction->id,
                    'twin_turbo_config' => $forced_induction->twin_turbo_config,
                    'turbo_count' => $forced_induction->turbo_count,
                    'turbine_material' => $forced_induction->turbine_material,
                    'turbine_blade_type' => $forced_induction->turbine_blade_type,
                    'compressor_material' => $forced_induction->compressor_material,
                    'compressor_design' => $forced_induction->compressor_design,
                    'supercharger_type' => $forced_induction->supercharger_type,
                    'supercharger_drive' => $forced_induction->supercharger_drive,
                    'supercharger_material' => $forced_induction->supercharger_material,
                    'intercooler_type' => $forced_induction->intercooler_type,
                    'intercooler_material' => $forced_induction->intercooler_material,
                    'wastegate_type' => $forced_induction->wastegate_type,
                    'wastegate_material' => $forced_induction->wastegate_material,
                    'blow_off_valve_type' => $forced_induction->blow_off_valve_type,
                    'blow_off_valve_material' => $forced_induction->blow_off_valve_material,
                ]);

                UserVehicleForcedInductionSpec::create([
                    'forced_induction_id' => $forced_induction->id,
                    'turbo_config_pair' => $forced_induction->turbo_config_pair,
                    'turbine_diameter_mm' => $forced_induction->turbine_diameter_mm,
                    'compressor_diameter_mm' => $forced_induction->compressor_diameter_mm,
                    'turbo_max_rpm' => $forced_induction->turbo_max_rpm,
                    'supercharger_displacement_cc' => $forced_induction->supercharger_displacement_cc,
                    'pulley_diameter_mm' => $forced_induction->pulley_diameter_mm,
                    'pulley_ratio' => $forced_induction->pulley_ratio,
                    'intercooler_volume_l' => $forced_induction->intercooler_volume_l,
                    'intercooler_core_length_mm' => $forced_induction->intercooler_core_length_mm,
                    'intercooler_core_width_mm' => $forced_induction->intercooler_core_width_mm,
                    'intercooler_core_height_mm' => $forced_induction->intercooler_core_height_mm,
                    'intercooler_inlet_diameter_mm' => $forced_induction->intercooler_inlet_diameter_mm,
                    'intercooler_outlet_diameter_mm' => $forced_induction->intercooler_outlet_diameter_mm,
                    'intercooler_pressure_drop_bar' => $forced_induction->intercooler_pressure_drop_bar,
                    'max_boost_bar' => $forced_induction->max_boost_bar,
                    'min_boost_bar' => $forced_induction->min_boost_bar,
                    'peak_boost_rpm' => $forced_induction->peak_boost_rpm,
                    'boost_response_ms' => $forced_induction->boost_response_ms,
                    'boost_ramp_time_s' => $forced_induction->boost_ramp_time_s,
                    'max_inlet_temp_celsius' => $forced_induction->max_inlet_temp_celsius,
                    'max_outlet_temp_celsius' => $forced_induction->max_outlet_temp_celsius,
                    'intercooler_temp_drop_celsius' => $forced_induction->intercooler_temp_drop_celsius,
                    'coolant_temp_celsius' => $forced_induction->coolant_temp_celsius,
                    'thermal_efficiency' => $forced_induction->thermal_efficiency,
                    'boost_pressure_bar' => $forced_induction->boost_pressure_bar,
                    'surge_margin_percent' => $forced_induction->surge_margin_percent,
                    'compressor_efficiency_percent' => $forced_induction->compressor_efficiency_percent,
                    'turbine_efficiency_percent' => $forced_induction->turbine_efficiency_percent,
                    'spool_time_ms' => $forced_induction->spool_time_ms,
                    'lag_ms' => $forced_induction->lag_ms,
                    'max_rpm' => $forced_induction->max_rpm,
                    'safe_rpm' => $forced_induction->safe_rpm,
                    'weight_kg' => $forced_induction->weight_kg,
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
                        'suspension_id' => $front_suspension->id,
                        'spring_type' => $front_suspension->spring_type,
                        'spring_material' => $front_suspension->spring_material,
                        'damper_type' => $front_suspension->damper_type,
                        'damper_material' => $front_suspension->damper_material,
                        'has_abs' => $front_suspension->has_abs,
                    ]);

                    UserVehicleSuspensionSpec::create([
                        'suspension_id' => $front_suspension->id,
                        'spring_constant_nm' => $front_suspension->spring_constant_nm,
                        'damping_ratio' => $front_suspension->damping_ratio,
                        'ride_height_mm' => $front_suspension->ride_height_mm,
                        'ground_clearance_mm' => $front_suspension->ground_clearance_mm,
                        'camber_angle_deg' => $front_suspension->camber_angle_deg,
                        'caster_angle_deg' => $front_suspension->caster_angle_deg,
                        'toe_in_mm' => $front_suspension->toe_in_mm,
                        'stabilizer_diameter_mm' => $front_suspension->stabilizer_diameter_mm,
                        'weight_kg' => $front_suspension->weight_kg,
                    ]);
                } else {
                    // Front
                    UserVehicleSuspensionPart::create([
                        'suspension_id' => $front_suspension->id,
                        'spring_type' => $front_suspension->spring_type,
                        'spring_material' => $front_suspension->spring_material,
                        'damper_type' => $front_suspension->damper_type,
                        'damper_material' => $front_suspension->damper_material,
                        'has_abs' => $front_suspension->has_abs,
                    ]);
                    UserVehicleSuspensionSpec::create([
                        'suspension_id' => $front_suspension->id,
                        'spring_constant_nm' => $front_suspension->spring_constant_nm,
                        'damping_ratio' => $front_suspension->damping_ratio,
                        'ride_height_mm' => $front_suspension->ride_height_mm,
                        'ground_clearance_mm' => $front_suspension->ground_clearance_mm,
                        'camber_angle_deg' => $front_suspension->camber_angle_deg,
                        'caster_angle_deg' => $front_suspension->caster_angle_deg,
                        'toe_in_mm' => $front_suspension->toe_in_mm,
                        'stabilizer_diameter_mm' => $front_suspension->stabilizer_diameter_mm,
                        'weight_kg' => $front_suspension->weight_kg,
                    ]);

                    // Rear
                    UserVehicleSuspensionPart::create([
                        'suspension_id' => $rear_suspension->id,
                        'spring_type' => $rear_suspension->spring_type,
                        'spring_material' => $rear_suspension->spring_material,
                        'damper_type' => $rear_suspension->damper_type,
                        'damper_material' => $rear_suspension->damper_material,
                        'has_abs' => $rear_suspension->has_abs,
                    ]);
                    UserVehicleSuspensionSpec::create([
                        'suspension_id' => $rear_suspension->id,
                        'spring_constant_nm' => $rear_suspension->spring_constant_nm,
                        'damping_ratio' => $rear_suspension->damping_ratio,
                        'ride_height_mm' => $rear_suspension->ride_height_mm,
                        'ground_clearance_mm' => $rear_suspension->ground_clearance_mm,
                        'camber_angle_deg' => $rear_suspension->camber_angle_deg,
                        'caster_angle_deg' => $rear_suspension->caster_angle_deg,
                        'toe_in_mm' => $rear_suspension->toe_in_mm,
                        'stabilizer_diameter_mm' => $rear_suspension->stabilizer_diameter_mm,
                        'weight_kg' => $rear_suspension->weight_kg,
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
                        'brake_id' => $front_brake->id,
                        'rotor_type' => $front_brake->rotor_type,
                        'rotor_material' => $front_brake->rotor_material,
                        'caliper_type' => $front_brake->caliper_type,
                        'caliper_material' => $front_brake->caliper_material,
                        'pad_type' => $front_brake->pad_type,
                        'pad_material' => $front_brake->pad_material,
                        'dust_shield' => $front_brake->dust_shield,
                    ]);

                    BrakeSpec::create([
                        'brake_id' => $front_brake->id,
                        'rotor_diameter_mm' => $front_brake->rotor_diameter_mm,
                        'rotor_thickness_mm' => $front_brake->rotor_thickness_mm,
                        'pad_thickness_mm' => $front_brake->pad_thickness_mm,
                        'max_force_kn' => $front_brake->max_force_kn,
                        'friction_coefficient' => $front_brake->friction_coefficient,
                        'weight_kg' => $front_brake->weight_kg,
                    ]);
                } else {
                    // Front
                    BrakePart::create([
                        'brake_id' => $front_brake->id,
                        'rotor_type' => $front_brake->rotor_type,
                        'rotor_material' => $front_brake->rotor_material,
                        'caliper_type' => $front_brake->caliper_type,
                        'caliper_material' => $front_brake->caliper_material,
                        'pad_type' => $front_brake->pad_type,
                        'pad_material' => $front_brake->pad_material,
                        'dust_shield' => $front_brake->dust_shield,
                    ]);
                    BrakeSpec::create([
                        'brake_id' => $front_brake->id,
                        'rotor_diameter_mm' => $front_brake->rotor_diameter_mm,
                        'rotor_thickness_mm' => $front_brake->rotor_thickness_mm,
                        'pad_thickness_mm' => $front_brake->pad_thickness_mm,
                        'max_force_kn' => $front_brake->max_force_kn,
                        'friction_coefficient' => $front_brake->friction_coefficient,
                        'weight_kg' => $front_brake->weight_kg,
                    ]);

                    // Rear
                    BrakePart::create([
                        'brake_id' => $rear_brake->id,
                        'rotor_type' => $rear_brake->rotor_type,
                        'rotor_material' => $rear_brake->rotor_material,
                        'caliper_type' => $rear_brake->caliper_type,
                        'caliper_material' => $rear_brake->caliper_material,
                        'pad_type' => $rear_brake->pad_type,
                        'pad_material' => $rear_brake->pad_material,
                        'dust_shield' => $rear_brake->dust_shield,
                    ]);
                    BrakeSpec::create([
                        'brake_id' => $rear_brake->id,
                        'rotor_diameter_mm' => $rear_brake->rotor_diameter_mm,
                        'rotor_thickness_mm' => $rear_brake->rotor_thickness_mm,
                        'pad_thickness_mm' => $rear_brake->pad_thickness_mm,
                        'max_force_kn' => $rear_brake->max_force_kn,
                        'friction_coefficient' => $rear_brake->friction_coefficient,
                        'weight_kg' => $rear_brake->weight_kg,
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
                        'wheel_id' => $front_wheel->id,
                        'tire_material' => $front_wheel->tire_material,
                        'wheel_material' => $front_wheel->wheel_material,
                    ]);

                    WheelSpec::create([
                        'wheel_id' => $front_wheel->id,
                        'tire_width_mm' => $front_wheel->tire_width_mm,
                        'tire_profile' => $front_wheel->tire_profile,
                        'wheel_radius_in' => $front_wheel->wheel_radius_in,
                        'expected_pressure_bar' => $front_wheel->expected_pressure_bar,
                    ]);
                } else {
                    // Front
                    WheelPart::create([
                        'wheel_id' => $front_wheel->id,
                        'tire_material' => $front_wheel->tire_material,
                        'wheel_material' => $front_wheel->wheel_material,
                    ]);
                    WheelSpec::create([
                        'wheel_id' => $front_wheel->id,
                        'tire_width_mm' => $front_wheel->tire_width_mm,
                        'tire_profile' => $front_wheel->tire_profile,
                        'wheel_radius_in' => $front_wheel->wheel_radius_in,
                        'expected_pressure_bar' => $front_wheel->expected_pressure_bar,
                    ]);

                    // Rear
                    WheelPart::create([
                        'wheel_id' => $rear_wheel->id,
                        'tire_material' => $rear_wheel->tire_material,
                        'wheel_material' => $rear_wheel->wheel_material,
                    ]);
                    WheelSpec::create([
                        'wheel_id' => $rear_wheel->id,
                        'tire_width_mm' => $rear_wheel->tire_width_mm,
                        'tire_profile' => $rear_wheel->tire_profile,
                        'wheel_radius_in' => $rear_wheel->wheel_radius_in,
                        'expected_pressure_bar' => $rear_wheel->expected_pressure_bar,
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

    public function removeVehicle(Request $request, $id) {
        
    }
}
