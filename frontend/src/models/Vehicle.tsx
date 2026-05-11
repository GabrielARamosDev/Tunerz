/* eslint-disable quotes */

import Model from '../contracts/Model.tsx';
import State from './State.ts';
import Role from './Role.ts';

import Typography from '@mui/material/Typography';
import Stack from '@mui/material/Stack';
import Divider from '@mui/material/Divider';
import Avatar from '@mui/material/Avatar';

import type { FormFields } from '../types/basemodel.ts';
import type { Vehicle as VehicleType } from '../types/vehicle.ts';

export const NEW_VEHICLE: VehicleType = {
    id: 0,
    name: '',
};

class Vehicle extends Model {
    
}

export default Vehicle;
