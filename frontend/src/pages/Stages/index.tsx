
import api from "../../services/api";

import React from "react";

import { useStage } from "../../contexts/StageContext";

import type { Stage, StageContextType } from "../../types/stage";
import type { Vehicle } from "../../types/vehicle";
import type { Engine } from "../../types/engine";

const Stages = ({ vehicleId }: { vehicleId: number }) => {

  const [loading, setLoading] = React.useState(true);
  const [status, setStatus] = React.useState("Carregando Estágios...");

  const { avaliarTurbo } = useStage();

  const [vehicles, setVehicles] = React.useState<Vehicle[]>([]);
  const [vehicle, setVehicle] = React.useState<Vehicle | null>(null);

  const [stages, setStages] = React.useState<Stage[]>([]);

  const [pressao, setPressao] = React.useState(0.5);
  const [resultado, setResultado] = React.useState<{ status: string; aviso: string }>({ status: "loading", aviso: "" });

  /* * */

  React.useEffect(() => {

    const found = vehicles.find(v => v.id === vehicleId);

    if (found) {
      setVehicle(found);
    } else if (vehicles.length > 0) {
      setVehicle(vehicles[0]);
    } else {
      setStatus("Veículo não encontrado na garagem.");
    }
  }, [vehicleId, vehicles]);

  React.useEffect(() => {
    if (vehicle) {
      const result = avaliarTurbo(vehicle.engine, pressao);
      setResultado(result);
    }
  }, [vehicle, pressao]);

  React.useEffect(() => {
    api.get(`/vehicles/${vehicleId}/stages`)
      .then(res => setStages(res.data))
      .catch(err => console.error(err));
  }, [vehicleId]);

  /* * */

  if (loading) return <p>{status}</p>;

  return (
    <div>
      <h2>Stages disponíveis:</h2>

      {stages.map((stage: Stage) => (
        <div key={stage.id} style={{ margin: 10, padding: 10, border: "1px solid #ccc" }}>
          <h3>{stage.name}</h3>
          <p>Pressão: {stage.boost_pressure} bar</p>
          <p>Potência estimada: {stage.expected_power} cv</p>
          <p>Status: {stage.status}</p>
        </div>
      ))}

      {vehicle && (
        <div style={{ padding: 20 }}>
          <h2>{vehicle.model}</h2>

          <label>Pressão do turbo (bar):</label>
          <input
            type="number"
            step="0.1"
            value={pressao}
            onChange={(e) => setPressao(Number(e.target.value))}
          />

          <p><strong>Status:</strong> {resultado.status}</p>
          <p><strong>Aviso:</strong> {resultado.aviso}</p>
        </div>
      )}
    </div>
  );
}

export default Stages;
