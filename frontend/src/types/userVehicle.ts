
import type { Engine } from "./engine";
import type { Vehicle } from "./vehicle";

export interface UserVehicle {
    id: number;
    user_id: number;
    vehicle_id: number;
    vehicle: Vehicle;
    engine_id: number;
    engine: Engine;
    created_at: string;
    updated_at: string;
}
