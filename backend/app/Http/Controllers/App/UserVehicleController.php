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
                    'block_material' => $engine->parts->block_material,
                    'head_material' => $engine->parts->head_material,
                    'piston_head_type' => $engine->parts->piston_head_type,
                    'piston_head_material' => $engine->parts->piston_head_material,
                    'piston_conrod_type' => $engine->parts->piston_conrod_type,
                    'piston_conrod_material' => $engine->parts->piston_conrod_material,
                    'camshaft_material' => $engine->parts->camshaft_material,
                    'camshaft_config' => $engine->parts->camshaft_config,
                    'camshaft_actuation' => $engine->parts->camshaft_actuation,
                    'camshaft_type' => $engine->parts->camshaft_type,
                    'valve_material' => $engine->parts->valve_material,
                    'valve_type' => $engine->parts->valve_type,
                    'fuel_type' => $engine->parts->fuel_type,
                    'fuel_system' => $engine->parts->fuel_system,
                    'carburator_system' => $engine->parts->carburator_system,
                    'intake_manifold_material' => $engine->parts->intake_manifold_material,
                    'intake_type' => $engine->parts->intake_type,
                    'intake_piping_material' => $engine->parts->intake_piping_material,
                ]);

                UserVehicleEngineSpec::create([
                    'engine_id' => $engine->id,
                    'power_hp' => $engine->specs->stock_power_hp,
                    'power_rpm' => $engine->specs->stock_power_rpm,
                    'torque_nm' => $engine->specs->stock_torque_nm,
                    'torque_rpm' => $engine->specs->stock_torque_rpm,
                    'power_to_weight_ratio' => $engine->specs->stock_power_to_weight_ratio,
                    'torque_to_weight_ratio' => $engine->specs->stock_torque_to_weight_ratio,
                    'redline_rpm' => $engine->specs->stock_redline_rpm,
                    'idle_rpm' => $engine->specs->stock_idle_rpm,
                    'cylinders_count' => $engine->specs->cylinders_count,
                    'piston_bore_mm' => $engine->specs->piston_bore_mm,
                    'piston_stroke_mm' => $engine->specs->piston_stroke_mm,
                    'displacement_cc' => $engine->specs->displacement_cc,
                    'compression_ratio' => $engine->specs->compression_ratio,
                    'valve_count' => $engine->specs->valve_count,
                    'intake_valve_diameter_mm' => $engine->specs->intake_valve_diameter_mm,
                    'intake_valve_seat_angle' => $engine->specs->intake_valve_seat_angle,
                    'exhaust_valve_diameter_mm' => $engine->specs->exhaust_valve_diameter_mm,
                    'exhaust_valve_seat_angle' => $engine->specs->exhaust_valve_seat_angle,
                    'carburator_barrel_count' => $engine->specs->carburator_barrel_count,
                    'fuel_injection_time_ms' => $engine->specs->fuel_injection_time_ms,
                    'fuel_flowrate_cc_min' => $engine->specs->fuel_flowrate_cc_min,
                    'fuel_pressure_bar' => $engine->specs->fuel_pressure_bar,
                    'air_fuel_ratio' => $engine->specs->air_fuel_ratio,
                    'intake_lenght_cm' => $engine->specs->intake_lenght_cm,
                    'intake_diameter_in' => $engine->specs->intake_diameter_in,
                    'air_flow_cfm' => $engine->specs->air_flow_cfm,
                    'thermal_efficiency' => $engine->specs->thermal_efficiency,
                    'coolant_capacity_l' => $engine->specs->coolant_capacity_l,
                    'oil_capacity_l' => $engine->specs->oil_capacity_l,
                    'length_mm' => $engine->specs->length_mm,
                    'width_mm' => $engine->specs->width_mm,
                    'height_mm' => $engine->specs->height_mm,
                    'weight_kg' => $engine->specs->weight_kg,
                ]);

                // Get the transmission associated with this vehicle
                $transmission = Transmission::with(['parts', 'specs'])->findOrFail($vehicle->transmission_id);

                if (!$transmission) {
                    DB::rollBack();

                    return response()->json(['message' => 'Nenhuma transmissão encontrada para este veículo!'], 404);
                }

                UserVehicleTransmissionPart::create([
                    'transmission_id' => $transmission->id,
                    'clutch_type' => $transmission->parts->clutch_type,
                    'synchro_type' => $transmission->parts->synchro_type,
                    'material_case' => $transmission->parts->material_case,
                ]);

                UserVehicleTransmissionSpec::create([
                    'transmission_id' => $transmission->id,
                    'gears_count' => $transmission->specs->gears_count,
                    'gear_ratio_1' => $transmission->specs->gear_ratio_1,
                    'gear_ratio_2' => $transmission->specs->gear_ratio_2,
                    'gear_ratio_3' => $transmission->specs->gear_ratio_3,
                    'gear_ratio_4' => $transmission->specs->gear_ratio_4,
                    'gear_ratio_5' => $transmission->specs->gear_ratio_5,
                    'final_drive_ratio' => $transmission->specs->final_drive_ratio,
                    'clutch_diameter_mm' => $transmission->specs->clutch_diameter_mm,
                    'max_torque_nm' => $transmission->specs->max_torque_nm,
                    'weight_kg' => $transmission->specs->weight_kg,
                    'oil_capacity_l' => $transmission->specs->oil_capacity_l,
                ]);

                if ($vehicle->forced_induction_id !== null) {
                    // Get the forced_induction associated with this vehicle
                    $forced_induction = ForcedInduction::with(['parts', 'specs'])->findOrFail($vehicle->forced_induction_id);

                    UserVehicleForcedInductionPart::create([
                        'forced_induction_id' => $forced_induction->id,
                        'twin_turbo_config' => $forced_induction->parts->twin_turbo_config,
                        'turbo_count' => $forced_induction->parts->turbo_count,
                        'turbine_material' => $forced_induction->parts->turbine_material,
                        'turbine_blade_type' => $forced_induction->parts->turbine_blade_type,
                        'compressor_material' => $forced_induction->parts->compressor_material,
                        'compressor_design' => $forced_induction->parts->compressor_design,
                        'supercharger_type' => $forced_induction->parts->supercharger_type,
                        'supercharger_drive' => $forced_induction->parts->supercharger_drive,
                        'supercharger_material' => $forced_induction->parts->supercharger_material,
                        'intercooler_type' => $forced_induction->parts->intercooler_type,
                        'intercooler_material' => $forced_induction->parts->intercooler_material,
                        'wastegate_type' => $forced_induction->parts->wastegate_type,
                        'wastegate_material' => $forced_induction->parts->wastegate_material,
                        'blow_off_valve_type' => $forced_induction->parts->blow_off_valve_type,
                        'blow_off_valve_material' => $forced_induction->parts->blow_off_valve_material,
                    ]);

                    UserVehicleForcedInductionSpec::create([
                        'forced_induction_id' => $forced_induction->id,
                        'turbo_config_pair' => $forced_induction->specs->turbo_config_pair,
                        'turbine_diameter_mm' => $forced_induction->specs->turbine_diameter_mm,
                        'compressor_diameter_mm' => $forced_induction->specs->compressor_diameter_mm,
                        'turbo_max_rpm' => $forced_induction->specs->turbo_max_rpm,
                        'supercharger_displacement_cc' => $forced_induction->specs->supercharger_displacement_cc,
                        'pulley_diameter_mm' => $forced_induction->specs->pulley_diameter_mm,
                        'pulley_ratio' => $forced_induction->specs->pulley_ratio,
                        'intercooler_volume_l' => $forced_induction->specs->intercooler_volume_l,
                        'intercooler_core_length_mm' => $forced_induction->specs->intercooler_core_length_mm,
                        'intercooler_core_width_mm' => $forced_induction->specs->intercooler_core_width_mm,
                        'intercooler_core_height_mm' => $forced_induction->specs->intercooler_core_height_mm,
                        'intercooler_inlet_diameter_mm' => $forced_induction->specs->intercooler_inlet_diameter_mm,
                        'intercooler_outlet_diameter_mm' => $forced_induction->specs->intercooler_outlet_diameter_mm,
                        'intercooler_pressure_drop_bar' => $forced_induction->specs->intercooler_pressure_drop_bar,
                        'max_boost_bar' => $forced_induction->specs->max_boost_bar,
                        'min_boost_bar' => $forced_induction->specs->min_boost_bar,
                        'peak_boost_rpm' => $forced_induction->specs->peak_boost_rpm,
                        'boost_response_ms' => $forced_induction->specs->boost_response_ms,
                        'boost_ramp_time_s' => $forced_induction->specs->boost_ramp_time_s,
                        'max_inlet_temp_celsius' => $forced_induction->specs->max_inlet_temp_celsius,
                        'max_outlet_temp_celsius' => $forced_induction->specs->max_outlet_temp_celsius,
                        'intercooler_temp_drop_celsius' => $forced_induction->specs->intercooler_temp_drop_celsius,
                        'coolant_temp_celsius' => $forced_induction->specs->coolant_temp_celsius,
                        'thermal_efficiency' => $forced_induction->specs->thermal_efficiency,
                        'boost_pressure_bar' => $forced_induction->specs->boost_pressure_bar,
                        'surge_margin_percent' => $forced_induction->specs->surge_margin_percent,
                        'compressor_efficiency_percent' => $forced_induction->specs->compressor_efficiency_percent,
                        'turbine_efficiency_percent' => $forced_induction->specs->turbine_efficiency_percent,
                        'spool_time_ms' => $forced_induction->specs->spool_time_ms,
                        'lag_ms' => $forced_induction->specs->lag_ms,
                        'max_rpm' => $forced_induction->specs->max_rpm,
                        'safe_rpm' => $forced_induction->specs->safe_rpm,
                        'weight_kg' => $forced_induction->specs->weight_kg,
                    ]);
                } else {
                    $user_vehicle->forced_induction_id = null;
                }

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
                        'spring_type' => $front_suspension->parts->spring_type,
                        'spring_material' => $front_suspension->parts->spring_material,
                        'damper_type' => $front_suspension->parts->damper_type,
                        'damper_material' => $front_suspension->parts->damper_material,
                        'has_abs' => $front_suspension->parts->has_abs,
                    ]);

                    UserVehicleSuspensionSpec::create([
                        'suspension_id' => $front_suspension->id,
                        'spring_constant_nm' => $front_suspension->specs->spring_constant_nm,
                        'damping_ratio' => $front_suspension->specs->damping_ratio,
                        'ride_height_mm' => $front_suspension->specs->ride_height_mm,
                        'ground_clearance_mm' => $front_suspension->specs->ground_clearance_mm,
                        'camber_angle_deg' => $front_suspension->specs->camber_angle_deg,
                        'caster_angle_deg' => $front_suspension->specs->caster_angle_deg,
                        'toe_in_mm' => $front_suspension->specs->toe_in_mm,
                        'stabilizer_diameter_mm' => $front_suspension->specs->stabilizer_diameter_mm,
                        'weight_kg' => $front_suspension->specs->weight_kg,
                    ]);
                } else {
                    // Front
                    UserVehicleSuspensionPart::create([
                        'suspension_id' => $front_suspension->id,
                        'spring_type' => $front_suspension->parts->spring_type,
                        'spring_material' => $front_suspension->parts->spring_material,
                        'damper_type' => $front_suspension->parts->damper_type,
                        'damper_material' => $front_suspension->parts->damper_material,
                        'has_abs' => $front_suspension->parts->has_abs,
                    ]);
                    UserVehicleSuspensionSpec::create([
                        'suspension_id' => $front_suspension->id,
                        'spring_constant_nm' => $front_suspension->specs->spring_constant_nm,
                        'damping_ratio' => $front_suspension->specs->damping_ratio,
                        'ride_height_mm' => $front_suspension->specs->ride_height_mm,
                        'ground_clearance_mm' => $front_suspension->specs->ground_clearance_mm,
                        'camber_angle_deg' => $front_suspension->specs->camber_angle_deg,
                        'caster_angle_deg' => $front_suspension->specs->caster_angle_deg,
                        'toe_in_mm' => $front_suspension->specs->toe_in_mm,
                        'stabilizer_diameter_mm' => $front_suspension->specs->stabilizer_diameter_mm,
                        'weight_kg' => $front_suspension->specs->weight_kg,
                    ]);

                    // Rear
                    UserVehicleSuspensionPart::create([
                        'suspension_id' => $rear_suspension->id,
                        'spring_type' => $rear_suspension->parts->spring_type,
                        'spring_material' => $rear_suspension->parts->spring_material,
                        'damper_type' => $rear_suspension->parts->damper_type,
                        'damper_material' => $rear_suspension->parts->damper_material,
                        'has_abs' => $rear_suspension->parts->has_abs,
                    ]);
                    UserVehicleSuspensionSpec::create([
                        'suspension_id' => $rear_suspension->id,
                        'spring_constant_nm' => $rear_suspension->specs->spring_constant_nm,
                        'damping_ratio' => $rear_suspension->specs->damping_ratio,
                        'ride_height_mm' => $rear_suspension->specs->ride_height_mm,
                        'ground_clearance_mm' => $rear_suspension->specs->ground_clearance_mm,
                        'camber_angle_deg' => $rear_suspension->specs->camber_angle_deg,
                        'caster_angle_deg' => $rear_suspension->specs->caster_angle_deg,
                        'toe_in_mm' => $rear_suspension->specs->toe_in_mm,
                        'stabilizer_diameter_mm' => $rear_suspension->specs->stabilizer_diameter_mm,
                        'weight_kg' => $rear_suspension->specs->weight_kg,
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
                        'rotor_type' => $front_brake->parts->rotor_type,
                        'rotor_material' => $front_brake->parts->rotor_material,
                        'caliper_type' => $front_brake->parts->caliper_type,
                        'caliper_material' => $front_brake->parts->caliper_material,
                        'pad_type' => $front_brake->parts->pad_type,
                        'pad_material' => $front_brake->parts->pad_material,
                        'dust_shield' => $front_brake->parts->dust_shield,
                    ]);

                    BrakeSpec::create([
                        'brake_id' => $front_brake->id,
                        'rotor_diameter_mm' => $front_brake->specs->rotor_diameter_mm,
                        'rotor_thickness_mm' => $front_brake->specs->rotor_thickness_mm,
                        'pad_thickness_mm' => $front_brake->specs->pad_thickness_mm,
                        'max_force_kn' => $front_brake->specs->max_force_kn,
                        'friction_coefficient' => $front_brake->specs->friction_coefficient,
                        'weight_kg' => $front_brake->specs->weight_kg,
                    ]);
                } else {
                    // Front
                    BrakePart::create([
                        'brake_id' => $front_brake->id,
                        'rotor_type' => $front_brake->parts->rotor_type,
                        'rotor_material' => $front_brake->parts->rotor_material,
                        'caliper_type' => $front_brake->parts->caliper_type,
                        'caliper_material' => $front_brake->parts->caliper_material,
                        'pad_type' => $front_brake->parts->pad_type,
                        'pad_material' => $front_brake->parts->pad_material,
                        'dust_shield' => $front_brake->parts->dust_shield,
                    ]);
                    BrakeSpec::create([
                        'brake_id' => $front_brake->id,
                        'rotor_diameter_mm' => $front_brake->specs->rotor_diameter_mm,
                        'rotor_thickness_mm' => $front_brake->specs->rotor_thickness_mm,
                        'pad_thickness_mm' => $front_brake->specs->pad_thickness_mm,
                        'max_force_kn' => $front_brake->specs->max_force_kn,
                        'friction_coefficient' => $front_brake->specs->friction_coefficient,
                        'weight_kg' => $front_brake->specs->weight_kg,
                    ]);

                    // Rear
                    BrakePart::create([
                        'brake_id' => $rear_brake->id,
                        'rotor_type' => $rear_brake->parts->rotor_type,
                        'rotor_material' => $rear_brake->parts->rotor_material,
                        'caliper_type' => $rear_brake->parts->caliper_type,
                        'caliper_material' => $rear_brake->parts->caliper_material,
                        'pad_type' => $rear_brake->parts->pad_type,
                        'pad_material' => $rear_brake->parts->pad_material,
                        'dust_shield' => $rear_brake->parts->dust_shield,
                    ]);
                    BrakeSpec::create([
                        'brake_id' => $rear_brake->id,
                        'rotor_diameter_mm' => $rear_brake->specs->rotor_diameter_mm,
                        'rotor_thickness_mm' => $rear_brake->specs->rotor_thickness_mm,
                        'pad_thickness_mm' => $rear_brake->specs->pad_thickness_mm,
                        'max_force_kn' => $rear_brake->specs->max_force_kn,
                        'friction_coefficient' => $rear_brake->specs->friction_coefficient,
                        'weight_kg' => $rear_brake->specs->weight_kg,
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
                        'tire_material' => $front_wheel->parts->tire_material,
                        'wheel_material' => $front_wheel->parts->wheel_material,
                    ]);

                    WheelSpec::create([
                        'wheel_id' => $front_wheel->id,
                        'tire_width_mm' => $front_wheel->specs->tire_width_mm,
                        'tire_profile' => $front_wheel->specs->tire_profile,
                        'wheel_radius_in' => $front_wheel->specs->wheel_radius_in,
                        'expected_pressure_bar' => $front_wheel->specs->expected_pressure_bar,
                    ]);
                } else {
                    // Front
                    WheelPart::create([
                        'wheel_id' => $front_wheel->id,
                        'tire_material' => $front_wheel->parts->tire_material,
                        'wheel_material' => $front_wheel->parts->wheel_material,
                    ]);
                    WheelSpec::create([
                        'wheel_id' => $front_wheel->id,
                        'tire_width_mm' => $front_wheel->specs->tire_width_mm,
                        'tire_profile' => $front_wheel->specs->tire_profile,
                        'wheel_radius_in' => $front_wheel->specs->wheel_radius_in,
                        'expected_pressure_bar' => $front_wheel->specs->expected_pressure_bar,
                    ]);

                    // Rear
                    WheelPart::create([
                        'wheel_id' => $rear_wheel->id,
                        'tire_material' => $rear_wheel->parts->tire_material,
                        'wheel_material' => $rear_wheel->parts->wheel_material,
                    ]);
                    WheelSpec::create([
                        'wheel_id' => $rear_wheel->id,
                        'tire_width_mm' => $rear_wheel->specs->tire_width_mm,
                        'tire_profile' => $rear_wheel->specs->tire_profile,
                        'wheel_radius_in' => $rear_wheel->specs->wheel_radius_in,
                        'expected_pressure_bar' => $rear_wheel->specs->expected_pressure_bar,
                    ]);
                }
                
                /* ================================================ */

                $relation_loader = [
                    'specs', 
                    'engine.specs', 'engine.parts', 
                    'transmission.specs', 'transmission.parts', 
                    'frontSuspension.specs', 'frontSuspension.parts', 
                    'rearSuspension.specs', 'rearSuspension.parts', 
                    'frontBrake.specs', 'frontBrake.parts', 
                    'rearBrake.specs', 'rearBrake.parts', 
                    'frontWheel.specs', 'frontWheel.parts', 
                    'rearWheel.specs', 'rearWheel.parts'
                ];

                if ($user_vehicle->forced_induction_id !== null) {
                    $relation_loader[] = 'forcedInduction.specs';
                    $relation_loader[] = 'forcedInduction.parts';
                }

                // Load and return the created user vehicle with relationships
                $user_vehicle->load($relation_loader);
                $user_vehicle->save();

                DB::commit();

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
