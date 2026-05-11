
import api from "../services/api";

import React, { createContext, useContext } from "react";
import type { ReactNode } from "react";

import type { GarageContextType } from "../types/garage";
import type { Vehicle } from "../types/vehicle";

import { useApp } from "./AppContext";

// Contexto em si
const GarageContext = createContext<GarageContextType | undefined>(undefined);

// Provider
export const GarageProvider = ({ children }: { children: ReactNode }) => {

    const {
        loading, setLoading,
        fetched, setFetched,
        status, setStatus
    } = useApp();

    const [vehicles, setVehicles] = React.useState<Vehicle[]>([]);

    /* * */

    React.useEffect(() => {
        api.get("/vehicles")
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

    /* * */

    const fetchVehicles = async () => {

        setFetched(false);
        setLoading(true);

        setStatus("Atualizando garagem...");

        api.get("/vehicles")
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
        api.post("/vehicles", vehicle)
            .then(() => {
                alert("Veículo criado");
                setVehicles(prev => [...prev, vehicle]);
            })
            .catch(() => {
                alert("Erro ao criar veículo");
            });
    };

    const removeVehicle = (id: number) => {
        api.delete(`/vehicles/${id}`)
            .then(() => {
                alert("Veículo removido");
                setVehicles(prev => prev.filter(c => c.id !== id));
            })
            .catch(() => {
                alert("Erro ao remover veículo");
            });
    };

    /* * */

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
