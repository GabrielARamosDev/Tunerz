
import api from "../services/api";

import { createContext, useContext, useState } from "react";
import type { ReactNode } from "react";

import type { StageContextType } from "../types/stage";
import type { Vehicle } from "../types/vehicle";
import type { Engine } from "../types/engine";

// Contexto em si
const StageContext = createContext<StageContextType | undefined>(undefined);

// Provider
export const StageProvider = ({ children }: { children: ReactNode }) => {

  const avaliarTurbo = (engine: Engine, pressure: number) => {
    if (engine.stockTurboLimit && pressure <= engine.stockTurboLimit) {
      return {
        status: "OK",
        aviso: "Compatível com motor original"
      };
    }

    if (pressure <= 1.0) {
      return {
        status: "ATENCAO",
        aviso: "Recomendado uso de bielas forjadas"
      };
    }

    return {
      status: "RISCO",
      aviso: "Setup não recomendado para este motor"
    };
  }

  return (
    <StageContext.Provider
      value={{
        avaliarTurbo,
      }}
    >
      {children}
    </StageContext.Provider>
  );
};

// Hook para usar o contexto mais facilmente
export const useStage = () => {

  const context = useContext(StageContext);

  if (!context) {
    throw new Error("useStage must be used within a StageProvider");
  }
  return context;
};
