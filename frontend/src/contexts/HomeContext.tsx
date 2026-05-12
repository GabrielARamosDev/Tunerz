
import api from "../services/api";

import React, { createContext, useContext } from "react";
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

    /* ============================================================== */

    return (
        <HomeContext.Provider
            value={{
                
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
