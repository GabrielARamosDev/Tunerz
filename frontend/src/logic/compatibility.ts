
import type { Engine } from "../types/engine";

export function avaliarTurbo(engine: Engine, pressure: number) {
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
