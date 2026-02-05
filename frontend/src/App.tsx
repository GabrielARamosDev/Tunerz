
import './App.css';

import { BrowserRouter, Routes, Route } from "react-router-dom";

import { GarageProvider } from "./contexts/GarageContext";
import Garage from "./screens/Garage";
import { StageProvider } from "./contexts/StageContext.tsx";
import Stages from "./screens/Stages";

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route 
          path="/" 
          element={
            <GarageProvider>
              <Garage />
            </GarageProvider>
          }
        />
        {/* <Route 
          path="/stages" 
          element={
            <StageProvider>
              <Stages />
            </StageProvider>
          } 
        /> */}
      </Routes>
    </BrowserRouter>
  );
}
