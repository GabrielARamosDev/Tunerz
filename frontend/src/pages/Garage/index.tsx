
import api from "../../services/api";

import { useEffect, useState } from "react";

import { useApp } from "../../contexts/AppContext";
import { useGarage } from "../../contexts/GarageContext";

import type { Vehicle as VehicleType } from "../../types/vehicle";
import type { UserVehicle } from "../../types/userVehicle.ts";

import Vehicle from "../../models/Vehicle.tsx";

import Stack from "@mui/material/Stack";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";

import AddVehicleDialog from "../../components/dialog/AddVehicleDialog";

const Garage = () => {

  const { loading, fetched, status } = useApp();

  const {
    vehicles, fetchVehicles,
    addVehicle, removeVehicle
  } = useGarage();

  const [openAddDialog, setOpenAddDialog] = useState(false);

  /* ============================================================== */

  const handleAddVehicle = () => {
    setOpenAddDialog(true);
  };

  const handleAddVehicleSubmit = (vehicleData: VehicleType) => {
    addVehicle(vehicleData as VehicleType);
  };

  /* ============================================================== */

  return (
    <>
      <Stack>
        <Typography variant="h2">Minha Garagem</Typography>

        {vehicles.length > 0 ? (
          <>
            <List>
              {vehicles.map((item: UserVehicle) => (
                <ListItem key={item.id}>
                  <Stack style={{ padding: 10, borderBottom: "1px solid #ddd" }}>
                    <Typography variant="body1">
                      {item.vehicle.manufacturer} {item.vehicle.model}
                    </Typography>
                    <Typography variant="body2" color="textSecondary">
                      {item.vehicle.trim} - {item.vehicle.year}
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

      <AddVehicleDialog
        open={openAddDialog}
        onClose={() => setOpenAddDialog(false)}
        onAddVehicle={handleAddVehicleSubmit}
      />
    </>
  );
}

export default Garage;
