
import api from "../services/api";

import { useEffect, useState } from "react";
import { useGarage } from "../contexts/GarageContext";

import type { Vehicle } from "../types/vehicle";

export default function Garage() {

  const [loading, setLoading] = useState(true);
  const [status, setStatus] = useState("Carregando Garagem...");

  const { vehicles: garageVehicles, addVehicle, removeVehicle } = useGarage();
  
  const [vehicles, setVehicles] = useState([]);

  /* * */

  useEffect(() => {
    api.get("/ping")
      .then((response) => {
        setStatus(response.data.message);
      });
  }, []);

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

  /* * */

  const handleAddVehicle = () => {
    const newVehicle = { id: Date.now(), model: "Astra", year: 2020 };
    addVehicle(newVehicle);
  };

  /* * */

  if (loading) return <p>{status}</p>;

  return (
    <div>
      <p>Tunerz is alive 🚗🔥</p>
      <h2>Minha Garagem</h2>

      {vehicles.length > 0 ? (
        <>
          {status}

          <ul>
            {vehicles.map((vehicle: Vehicle) => (
              <li key={vehicle.id}>
                <div style={{ padding: 10, borderBottom: "1px solid #ddd" }}>
                  <strong>{vehicle.manufacturer} {vehicle.model}</strong>
                  <p>{vehicle.trim}</p>
                </div>
              </li>
            ))}
          </ul>
        </>
      ) : ( <p>Nenhum veículo na garagem.</p> )}

      <button onClick={handleAddVehicle}>Adicionar Veículo</button>
    </div>
  );
}
