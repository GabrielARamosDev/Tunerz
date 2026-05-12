
import api from "../services/api";

import { useSelector } from 'react-redux';
import React, { createContext, useContext } from "react";
import type { ReactNode } from "react";

import type { State as StateType } from '../types/state.ts';
import type { GarageContextType } from "../types/garage";
import type { Vehicle } from "../types/vehicle";
import type { UserVehicle } from "../types/userVehicle.ts";

import { useApp } from "./AppContext";

// Contexto em si
const GarageContext = createContext<GarageContextType | undefined>(undefined);

// Provider
export const GarageProvider = ({ children }: { children: ReactNode }) => {
    
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

    const addVehicle = (vehicle: Vehicle) => {
        api.post(`/users/${user?.id}/vehicles`, vehicle)
            .then((response) => {

                const createdVehicle = response.data;

                alert("Veículo criado com sucesso");

                setVehicles(prev => [...prev, createdVehicle]);
                setStatus("Veículo adicionado com sucesso.");
            })
            .catch((error) => {
                alert("Erro ao criar veículo");
                setStatus("Erro ao criar veículo.");
                console.error(error);
            });
    };

    const removeVehicle = (id: number) => {
        api.delete(`/users/${user?.id}/vehicles/${id}`)
            .then(() => {
                alert("Veículo removido");
                setVehicles(prev => prev.filter(c => c.id !== id));
            })
            .catch(() => {
                alert("Erro ao remover veículo");
            });
    };

    /* ============================================================== */

    return (
        <GarageContext.Provider
            value={{
                vehicles, fetchVehicles,
                addVehicle, removeVehicle
            }}
        >
            {children}
        </GarageContext.Provider>
    );
};

// Hook para usar o contexto mais facilmente
export const useGarage = () => {

    const context = useContext(GarageContext);

    if (!context) {
        throw new Error("useGarage must be used within a GarageProvider");
    }
    return context;
};
