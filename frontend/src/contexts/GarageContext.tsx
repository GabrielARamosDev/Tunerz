
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
        navigate, 
        loading, setLoading,
        fetched, setFetched,
        status, setStatus
    } = useApp();

    const [userVehicles, setUserVehicles] = React.useState<UserVehicle[]>([]);

    const [vehicleAtWorkshop, setVehicleAtWorkshop] = React.useState<UserVehicle | null>(null);

    /* ============================================================== */

    React.useEffect(() => {
        if (!user) return;

        api.get(`/user/vehicles`)
            .then((response) => {
                setStatus("Garagem carregada com sucesso.");
                setUserVehicles(response.data);
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

    const fetchUserVehicles = async () => {

        setFetched(false);
        setLoading(true);

        setStatus("Atualizando garagem...");

        api.get(`/user/vehicles`)
            .then((response) => {
                setStatus("Garagem atualizada.");
                setFetched(true);
                setLoading(false);

                setUserVehicles(response.data);
            })
            .catch(() => {
                setStatus("Erro ao atualizar a garagem.");
                setLoading(false);
            });

        return;
    };

    const addVehicle = (vehicle: Vehicle) => {
        api.post(`/user/vehicle`, vehicle)
            .then((response) => {

                const createdVehicle = response.data;

                alert("Veículo criado com sucesso");

                setUserVehicles(prev => [...prev, createdVehicle]);
                setStatus("Veículo adicionado com sucesso.");
            })
            .catch((error) => {
                alert("Erro ao criar veículo");
                setStatus("Erro ao criar veículo.");
                console.error(error);
            });
    };

    const removeVehicle = (id: number) => {
        api.delete(`/user/vehicle/${id}`)
            .then(() => {
                alert("Veículo removido");
                setUserVehicles(prev => prev.filter(c => c.id !== id));
            })
            .catch(() => {
                alert("Erro ao remover veículo");
            });
    };

    const goToWorkshop = (vehicleId: number) => {
        setLoading(true);

        const vehicle = userVehicles.find((item) => item.id === vehicleId) || null;

        if (!vehicle || vehicle === null) {
            alert("Veículo não encontrado.");
            setStatus("Veículo não encontrado.");
            setLoading(false);
            return;
        }
        console.log(`Vehicle at workshop set: `, vehicle);

        setVehicleAtWorkshop(vehicle);
        setStatus("Carregando oficina...");

        navigate(`garage/workshop`);
    }

    /* ============================================================== */

    return (
        <GarageContext.Provider
            value={{
                userVehicles, fetchUserVehicles,
                addVehicle, removeVehicle, 
                goToWorkshop,
                vehicleAtWorkshop, setVehicleAtWorkshop
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
