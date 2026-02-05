
import type { Engine } from "./engine";

export interface Vehicle {
    id: number;
    manufacturer: string;
    model: string;
    trim: string;
    year: number;
    engine: Engine;
}
