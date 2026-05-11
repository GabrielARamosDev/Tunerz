
import type { Vehicle } from "./vehicle";

export interface HomeContextType {
    vehicles: Vehicle[];
    fetchVehicles: () => Promise<void>;
};
