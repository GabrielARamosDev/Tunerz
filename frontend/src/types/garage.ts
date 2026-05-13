
import type { Vehicle } from "../types/vehicle";
import type { UserVehicle } from "./userVehicle";

export interface GarageContextType {
    userVehicles: UserVehicle[];
    fetchUserVehicles: () => Promise<void>;
    addVehicle: (vehicle: Vehicle) => void;
    removeVehicle: (id: number) => void;
    vehicleAtWorkshop: UserVehicle | null;
    setVehicleAtWorkshop: (vehicle: UserVehicle | null) => void;
    goToWorkshop: (vehicleId: number) => void;
};
