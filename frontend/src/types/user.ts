
import type { Role } from './role';
import type { State } from './state';

export interface User {
    id: number;
    name: string;
    email: string;
    role_id: number;
    state_id: number;
    roles: Role[];
    states: State[];
}
