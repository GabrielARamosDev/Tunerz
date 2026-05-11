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
    manufacturer: '',
    model: '',
    trim: '',
    year: 0,
    engine: {
        id: 0,
        code: '',
        cylinderCapacity: 0,
        compressionRate: 0,
        factoryPower: 0,
        factoryTorque: 0,
        valves: 0,
    }
};

class Vehicle extends Model {
    
    constructor(props: VehicleType = NEW_VEHICLE) {
        const {
            ...vechicleProps
        } = props;

        super(vechicleProps, 'vehicle');
    }

    serialize = () => ({
        ...this.attributes,
        id: this.id,
        created_at: this.createdAt,
        updated_at: this.updatedAt,
    });

    getApiLink = () => `/vehicles`;

    getLink = () => `/vehicles/${this.id}`;

}

export default Vehicle;
