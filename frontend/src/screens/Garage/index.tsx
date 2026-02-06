
import api from "../../services/api";

import { useEffect, useState } from "react";

import { useGarage } from "../../contexts/GarageContext";

import type { Vehicle } from "../../types/vehicle";

const Garage = () => {

  const { 
    loading, fetched, status,
    vehicles, fetchVehicles, 
    addVehicle, removeVehicle, 
  } = useGarage();

  /* * */

  const handleAddVehicle = () => {
    // const newVehicle = { id: Date.now(), model: "Astra", year: 2020 };
    // addVehicle(newVehicle);
  };

  /* * */

  if (loading) return <p>{status}</p>;

  if (!fetched) return <p>{status}</p>;

  return (
    <>
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
        <button onClick={fetchVehicles}>Atualizar Garagem</button>
      </div>
    </>
  );
}

export default Garage;
