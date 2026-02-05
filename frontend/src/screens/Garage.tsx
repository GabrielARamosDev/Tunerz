
import { useEffect, useState } from "react";
import api from "../services/api";

export default function Garage() {
  const [vehicles, setVehicles] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api.get("/vehicles")
      .then(response => {
        setVehicles(response.data);
      })
      .catch(err => {
        console.error("Erro ao buscar veículos", err);
      })
      .finally(() => setLoading(false));
  }, []);

  if (loading) return <p>Carregando garagem...</p>;

  return (
    <div>
      <h2>Minha Garagem</h2>

      {vehicles.map(vehicle => (
        <div key={vehicle.id} style={{ padding: 10, borderBottom: "1px solid #ddd" }}>
          <strong>{vehicle.manufacturer} {vehicle.model}</strong>
          <p>{vehicle.version}</p>
        </div>
      ))}
    </div>
  );
}
