
import api from "../services/api";

import { createContext, useContext, useState } from "react";
import type { ReactNode } from "react";

import type { GarageContextType } from "../types/garage";
import type { Vehicle } from "../types/vehicle";

// Contexto em si
const GarageContext = createContext<GarageContextType | undefined>(undefined);

// Provider
export const GarageProvider = ({ children }: { children: ReactNode }) => {

    const [vehicles, setVehicles] = useState<Vehicle[]>([]);

    const fetchVehicles = async () => {
        const response = await fetch("/api/vehicles");
        const data = await response.json();
        setVehicles(data);
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

    return (
        <GarageContext.Provider 
            value={{ 
                vehicles, 
                fetchVehicles, 
                addVehicle, 
                removeVehicle, 
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
