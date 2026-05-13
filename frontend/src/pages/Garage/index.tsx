
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

  // const { 
  //   navigate, 
  //   loading, fetched, status 
  // } = useApp();

  const {
    userVehicles, fetchUserVehicles,
    addVehicle, 
    goToWorkshop
  } = useGarage();

  const [openAddDialog, setOpenAddDialog] = useState(false);

  /* ============================================================== */

  const handleAddVehicle = () => {
    setOpenAddDialog(true);
  };

  const handleAddVehicleSubmit = (vehicleData: VehicleType) => {
    addVehicle(vehicleData as VehicleType);
  };

  const handleEditVehicle = (vehicleId: number) => {
    goToWorkshop(vehicleId);
  }

  /* ============================================================== */

  return (
    <>
      <Stack>
        <Typography variant="h2">Minha Garagem</Typography>

        {userVehicles.length > 0 ? (
          <>
            <List>
              {userVehicles.map((item: UserVehicle) => (
                <ListItem key={item.id}>
                  <Button 
                    style={{ padding: 0, borderBottom: "1px solid #ddd" }} 
                    onClick={() => handleEditVehicle(item.id)}
                  >
                    <Stack style={{ padding: 10 }} >
                      <Typography variant="body1">
                        {item.vehicle.manufacturer} {item.vehicle.model} ({item.vehicle.year})
                      </Typography>
                      <Typography variant="body2" color="textSecondary">
                        {item.vehicle.trim}
                      </Typography>
                    </Stack>
                  </Button>
                </ListItem>
              ))}
            </List>
          </>
        ) : (
          <Typography>Nenhum veículo na garagem.</Typography>
        )}

        <Button onClick={handleAddVehicle}>Adicionar Veículo</Button>
        <Button onClick={fetchUserVehicles}>Atualizar Garagem</Button>
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
