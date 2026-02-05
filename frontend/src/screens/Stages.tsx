
import { useEffect, useState } from "react";
import api from "../services/api";

export default function Stages({ vehicleId }) {
  const [stages, setStages] = useState([]);

  useEffect(() => {
    api.get(`/vehicles/${vehicleId}/stages`)
      .then(res => setStages(res.data))
      .catch(err => console.error(err));
  }, [vehicleId]);

  return (
    <div>
      <h2>Stages disponíveis</h2>

      {stages.map(stage => (
        <div key={stage.id} style={{ margin: 10, padding: 10, border: "1px solid #ccc" }}>
          <h3>{stage.name}</h3>
          <p>Pressão: {stage.boost_pressure} bar</p>
          <p>Potência estimada: {stage.expected_power} cv</p>
          <p>Status: {stage.status}</p>
        </div>
      ))}
    </div>
  );
}
