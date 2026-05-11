
import type { Vehicle } from "../types/vehicle";

export interface GarageContextType {
    vehicles: Vehicle[];
    fetchVehicles: () => Promise<void>;
    addVehicle: (vehicle: Vehicle) => void;
    removeVehicle: (id: number) => void;
};
