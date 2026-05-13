
import api from "../services/api.ts";

import { useSelector } from 'react-redux';
import React, { createContext, useContext } from "react";
import type { ReactNode } from "react";

import type { State as StateType } from '../types/state.ts';
import type { WorkshopContextType } from "../types/workshop.ts";
import type { Vehicle } from "../types/vehicle.ts";
import type { UserVehicle } from "../types/userVehicle.ts";

import { useApp } from "./AppContext.tsx";
import { useGarage } from "./GarageContext.tsx";

// Contexto em si
const WorkshopContext = createContext<WorkshopContextType | undefined>(undefined);

// Provider
export const WorkshopProvider = ({ children }: { children: ReactNode }) => {
    
    /* =========================== State ============================ */

    const user = useSelector((state: StateType) => state.app.user);

    /* ============================================================== */

    const {
        navigate, 
        loading, setLoading,
        fetched, setFetched,
        status, setStatus, 
    } = useApp();

    const { vehicleAtWorkshop, setVehicleAtWorkshop } = useGarage();

    /* ============================================================== */

    React.useEffect(() => {

        console.log("Vehicle at workshop changed: ", vehicleAtWorkshop);

    }, [vehicleAtWorkshop]);

    /* ============================================================== */

    const exitWorkshop = () => {
        setLoading(true);
        setStatus("Saindo da oficina...");
        setVehicleAtWorkshop(null);
        navigate(`garage`);
    };

    /* ============================================================== */

    return (
        <WorkshopContext.Provider
            value={{
                exitWorkshop, 
            }}
        >
            {children}
        </WorkshopContext.Provider>
    );
};

// Hook para usar o contexto mais facilmente
export const useWorkshop = () => {

    const context = useContext(WorkshopContext);

    if (!context) {
        throw new Error("useWorkshop must be used within a WorkshopProvider");
    }
    return context;
};
