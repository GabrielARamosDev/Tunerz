
import api from "../../services/api";

import { useEffect, useState } from "react";

import { useApp } from "../../contexts/AppContext";
import { useHome } from "../../contexts/HomeContext";

import type { Vehicle } from "../../types/vehicle";

const Home = () => {

    const {
        loading, status, fetched
    } = useApp();

    const {
        vehicles, fetchVehicles
    } = useHome();

    /* * */

    return (
        <>
            <div>
                <p>Tuner-Z is alive 🚗🔥</p>
            </div>
        </>
    );
}

export default Home;
