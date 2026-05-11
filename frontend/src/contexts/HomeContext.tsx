
import api from "../services/api";

import { createContext, useContext, useState, useEffect } from "react";
import type { ReactNode } from "react";

import type { HomeContextType } from "../types/home";
import type { Vehicle } from "../types/vehicle";

import { useApp } from "./AppContext.tsx";

// Contexto em si
const HomeContext = createContext<HomeContextType | undefined>(undefined);

// Provider
export const HomeProvider = ({ children }: { children: ReactNode }) => {

    const {
        loading, setLoading,
        fetched, setFetched,
        status, setStatus
    } = useApp();

    const [vehicles, setVehicles] = useState<Vehicle[]>([]);

    /* * */

    useEffect(() => {
        api.get("/ping")
            .then((response) => {
                console.log("API is alive! ", response.data);
            });
    }, []);

    useEffect(() => {
        api.get("/vehicles")
            .then((response) => {
                setStatus("Veículos carregados com sucesso.");
                setVehicles(response.data);
                setFetched(true);
            })
            .catch(() => {
                setStatus("Erro ao carregar os veículos.");
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    /* * */

    const fetchVehicles = async () => {

        setFetched(false);
        setLoading(true);

        setStatus("Atualizando...");

        api.get("/vehicles")
            .then((response) => {
                setStatus("Veículos atualizados.");
                setFetched(true);
                setLoading(false);

                setVehicles(response.data);
            })
            .catch(() => {
                setStatus("Erro ao atualizar os veículos.");
                setLoading(false);
            });

        return;
    };

    /* * */

    return (
        <HomeContext.Provider
            value={{
                vehicles, fetchVehicles
            }}
        >
            {children}
        </HomeContext.Provider>
    );
};

// Hook para usar o contexto mais facilmente
export const useHome = () => {

    const context = useContext(HomeContext);

    if (!context) {
        throw new Error("useHome must be used within a HomeProvider");
    }
    return context;
};
