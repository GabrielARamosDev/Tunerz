
import api from "../../services/api";

import { useEffect, useState } from "react";

import { useApp } from "../../contexts/AppContext";
import { useGarage } from "../../contexts/GarageContext";

import type { Vehicle as VehicleType } from "../../types/vehicle";

import Vehicle from "../../models/Vehicle.tsx";

import Stack from "@mui/material/Stack";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";

const Garage = () => {

  const { loading, fetched, status } = useApp();

  const { 
    vehicles, fetchVehicles, 
    addVehicle, removeVehicle
  } = useGarage();

  /* * */

  const handleAddVehicle = () => {
    // const newVehicle = { id: Date.now(), model: "Astra", year: 2020 };
    // addVehicle(newVehicle);
  };

  return (
    <>
      <Stack>
        <Typography variant="h2">Minha Garagem</Typography>

        {vehicles.length > 0 ? (
          <>
            <List>
              {vehicles.map((vehicle: VehicleType) => (
                <ListItem key={vehicle.id}>
                  <Stack style={{ padding: 10, borderBottom: "1px solid #ddd" }}>
                    <Typography variant="body1">
                      {vehicle.manufacturer} {vehicle.model}
                    </Typography>
                    <Typography variant="body2" color="textSecondary">
                      {vehicle.trim}
                    </Typography>
                  </Stack>
                </ListItem>
              ))}
            </List>
          </>
        ) : (
          <Typography>Nenhum veículo na garagem.</Typography>
        )}

        <Button onClick={handleAddVehicle}>Adicionar Veículo</Button>
        <Button onClick={fetchVehicles}>Atualizar Garagem</Button>
      </Stack>
    </>
  );
}

export default Garage;
