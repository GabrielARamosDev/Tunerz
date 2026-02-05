
import type { Engine } from "./engine";

export interface StageContextType {
    avaliarTurbo: (engine: Engine, pressure: number) => { status: string; aviso: string };
};

export interface Stage {
    id: number;
    vehicle_id: number;
    name: string;
    boost_pressure: number;
    fuel_map: string;
    ignition_map: string;
    expected_power: number;
    status: string;
}
