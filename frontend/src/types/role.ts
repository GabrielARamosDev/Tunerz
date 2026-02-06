
import type { RoleAbility } from './roleAbility.ts';

export interface Role {
    id: number;
    name: string;
    roleAbilities: RoleAbility[];
    role_abilities_ids: number[];
}

export interface FormData {
    name: string;
    type?: string;
    label?: string;
    placeholder?: string;
    value: any;
    sx?: object;
    col: number;
    required?: boolean;
    disabled?: boolean;
    hidden?: boolean;
};
