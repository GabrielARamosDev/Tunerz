
import api from "../../../services/api";

import { useEffect, useState } from "react";

import { useApp } from "../../../contexts/AppContext";
import { useWorkshop } from "../../../contexts/WorkshopContext.tsx";

import type { Vehicle as VehicleType } from "../../../types/vehicle";
import type { UserVehicle } from "../../../types/userVehicle.ts";

import Vehicle from "../../../models/Vehicle.tsx";

import Stack from "@mui/material/Stack";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";

const Workshop = () => {

  // const { loading, fetched, status } = useApp();

  const {
    
  } = useWorkshop();

  /* ============================================================== */

  

  /* ============================================================== */

  return (
    <>
      <Stack>
        <Typography variant="h2">Minha Oficina</Typography>

        
      </Stack>
    </>
  );
}

export default Workshop;
