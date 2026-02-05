
import { useState } from "react";

import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'

import './App.css'

import { vehicles } from "./data/vehicles.ts";
import { avaliarTurbo } from "./logic/compatibility";

export default function App() {

  const [pressao, setPressao] = useState(0.5);
  
  const vehicle = vehicles[0];
  const resultado = avaliarTurbo(vehicle.engine, pressao);

  return (
    <div style={{ padding: 20 }}>
      <h2>{vehicle.model}</h2>
      <label>Pressão do turbo (bar):</label>
      <input
        type="number"
        step="0.1"
        value={pressao}
        onChange={(e) => setPressao(Number(e.target.value))}
      />

      <p><strong>Status:</strong> {resultado.status}</p>
      <p><strong>Aviso:</strong> {resultado.aviso}</p>
    </div>
  );
}
