
import type { Vehicle } from "../types/vehicle";
import type { UserVehicle } from "./userVehicle";

export interface GarageContextType {
    vehicles: UserVehicle[];
    fetchVehicles: () => Promise<void>;
    addVehicle: (vehicle: Vehicle) => void;
    removeVehicle: (id: number) => void;
};
