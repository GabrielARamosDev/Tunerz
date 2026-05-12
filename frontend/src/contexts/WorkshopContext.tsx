
import api from "../services/api.ts";

import { useSelector } from 'react-redux';
import React, { createContext, useContext } from "react";
import type { ReactNode } from "react";

import type { State as StateType } from '../types/state.ts';
import type { WorkshopContextType } from "../types/workshop.ts";
import type { Vehicle } from "../types/vehicle.ts";
import type { UserVehicle } from "../types/userVehicle.ts";

import { useApp } from "./AppContext.tsx";

// Contexto em si
const WorkshopContext = createContext<WorkshopContextType | undefined>(undefined);

// Provider
export const WorkshopProvider = ({ children }: { children: ReactNode }) => {
    
    /* =========================== State ============================ */

    const user = useSelector((state: StateType) => state.app.user);

    /* ============================================================== */

    const {
        loading, setLoading,
        fetched, setFetched,
        status, setStatus
    } = useApp();

    const [vehicles, setVehicles] = React.useState<UserVehicle[]>([]);

    /* ============================================================== */

    React.useEffect(() => {
        if (!user) return;

        api.get(`/users/${user?.id}/vehicles`)
            .then((response) => {
                setStatus("Garagem carregada com sucesso.");
                setVehicles(response.data);
                setFetched(true);
            })
            .catch(() => {
                setStatus("Erro ao carregar a garagem.");
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    /* ============================================================== */

    const fetchVehicles = async () => {

        setFetched(false);
        setLoading(true);

        setStatus("Atualizando garagem...");

        api.get(`/users/${user?.id}/vehicles`)
            .then((response) => {
                setStatus("Garagem atualizada.");
                setFetched(true);
                setLoading(false);

                setVehicles(response.data);
            })
            .catch(() => {
                setStatus("Erro ao atualizar a garagem.");
                setLoading(false);
            });

        return;
    };

    /* ============================================================== */

    return (
        <WorkshopContext.Provider
            value={{
                vehicles, fetchVehicles,
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
