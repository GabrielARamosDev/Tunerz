
import api from "../services/api";

import { createContext, useContext, useState, useEffect } from "react";
import type { ReactNode } from "react";

import type { LoginContextType } from "../types/login";
import type { Vehicle } from "../types/vehicle";

import { useApp } from "./AppContext";

// Contexto em si
const LoginContext = createContext<LoginContextType | undefined>(undefined);

// Provider
export const LoginProvider = ({ children }: { children: ReactNode }) => {

    const {
        loading, setLoading,
        fetched, setFetched,
        status, setStatus
    } = useApp();

    /* * */

    useEffect(() => {
        api.get("/ping")
            .then((response) => {
                console.log("API is alive! ", response.data);
            });
    }, []);

    /* * */

    return (
        <LoginContext.Provider
            value={{

            }}
        >
            {children}
        </LoginContext.Provider>
    );
};

// Hook para usar o contexto mais facilmente
export const useLogin = () => {

    const context = useContext(LoginContext);

    if (!context) {
        throw new Error("useLogin must be used within a LoginProvider");
    }
    return context;
};
