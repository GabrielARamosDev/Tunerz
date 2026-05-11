
import api from "../../services/api";

import { useEffect, useState } from "react";

import { useHome } from "../../contexts/HomeContext";

import type { Vehicle } from "../../types/vehicle";

const Home = () => {

    const {
        loading, fetched, status,
        vehicles, fetchVehicles
    } = useHome();

    /* * */

    // Here goes functions!

    /* * */

    if (loading) return <p>{status}</p>;

    if (!fetched) return <p>{status}</p>;

    return (
        <>
            <div>
                <p>Tuner-Z is alive 🚗🔥</p>
            </div>
        </>
    );
}

export default Home;
