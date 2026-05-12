
import type { Vehicle } from "./vehicle";
import type { UserVehicle } from "./userVehicle";

export interface WorkshopContextType {
    vehicles: UserVehicle[];
    fetchVehicles: () => Promise<void>;
};
