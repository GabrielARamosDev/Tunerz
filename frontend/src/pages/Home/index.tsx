
import api from "../../services/api";

import { useEffect, useState } from "react";

import { useApp } from "../../contexts/AppContext";
import { useHome } from "../../contexts/HomeContext";

import type { Vehicle } from "../../types/vehicle";

import Stack from "@mui/material/Stack";
import Typography from "@mui/material/Typography";

const Home = () => {

    const { loading, status } = useApp();

    /* * */

    return (
        <>
            <Stack>
                <Typography>Tuner-Z is alive 🚗🔥</Typography>
            </Stack>
        </>
    );
}

export default Home;
