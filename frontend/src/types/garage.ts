
import type { Vehicle } from "../types/vehicle";

export interface GarageContextType {
    loading: boolean;
    fetched: boolean;
    status: string;
    vehicles: Vehicle[];
    fetchVehicles: () => Promise<void>;
    addVehicle: (vehicle: Vehicle) => void;
    removeVehicle: (id: number) => void;
};
