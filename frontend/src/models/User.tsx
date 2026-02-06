/* eslint-disable quotes */

import Model from '../contracts/Model.tsx';
import State from './State.ts';
import Role from './Role.ts';

import Typography from '@mui/material/Typography';
import Stack from '@mui/material/Stack';
import Divider from '@mui/material/Divider';
import Avatar from '@mui/material/Avatar';

import type { FormFields } from '../types/basemodel.ts';
import type { User as UserType } from '../types/user.ts';

export const NEW_USER: UserType = {
    id: 0,
    name: '',
    email: '',
    role_id: 0,
    state_id: 0,
    roles: [],
    states: [],
};

class User extends Model {

    #roles;
    #states;

    constructor(props: UserType = NEW_USER) {
        const {
            roles = [],
            states = [],
            ...userProps
        } = props;

        super(userProps, 'user');

        this.#roles = roles.map((r) => new Role(r));
        this.#states = states.map((s) => new State(s));
    }

    get roles() {
        return this.#roles;
    }

    get states() {
        return this.#states;
    }

    serialize = () => ({
        ...this.attributes,
        id: this.id,
        roles: this.roles.map((role) => role.serialize()),
        states: this.states.map((state) => state.serialize()),
        created_at: this.createdAt,
        updated_at: this.updatedAt,
    });

    getApiLink = () => `app/users`;

    getLink = () => `v1/gestao/usuarios/${this.id}`;

    static getFormFields = (args: FormFields) => [
        {
            name: 'name',
            label: 'Nome',
            placeholder: 'Insira um nome',
            value: '',
            col: 6,
            required: true,
        },
        {
            name: 'email',
            label: 'E-mail',
            placeholder: 'insira um e-mail',
            value: '',
            col: 6,
            required: true,
        },
        {
            type: 'password',
            name: 'password',
            label: 'Senha',
            placeholder: 'Insira uma senha',
            value: '',
            col: 6,
            required: (params: { mode: string }) => params.mode == 'create',
            autoComplete: 'new-password',
        },
        {
            type: 'password',
            name: 'password_confirmation',
            label: 'Confirmar Senha',
            placeholder: 'Confirme sua senha senha',
            value: '',
            col: 6,
            required: (params: { mode: string }) => params.mode == 'create',
        },
        {
            type: 'select',
            name: 'role_id',
            label: 'Função',
            value: args.role,
            options: args.roles,
            col: 6,
            required: true,
        },
        {
            type: 'select',
            name: 'state_id',
            label: 'Estado Agenciado',
            value: args.state,
            options: args.states,
            col: 3,
            required: true,
            visible: [5].includes(args.role),
        },
    ];

    static getTableHead = () => ({
        name: {
            name: 'Nome',
            sx: { width: '22.5%' },
        },
        email: 'E-mail',
        role: {
            name: 'Função/Cargo',
            sx: { width: '15%' },
        },
    });

    getTableData = () => ({
        name: {
            render: () => (
                <Stack direction="row" >
                    <Avatar
                        alt={this.attributes.name}
                        // src=""
                        sx={{ mr: '10px' }}
                    >
                        <Typography
                            variant="body2"
                            color="primary"
                        >
                            {this.attributes.name.charAt(0)}
                        </Typography>
                    </Avatar>

                    <Stack sx={{ justifyContent: 'center' }} >
                        <Typography variant="tableCell-1">
                            {this.attributes.name}
                        </Typography>
                        <Divider
                            variant="no-deco"
                            sx={{ mt: .5 }}
                        />
                        <Typography variant="tableCell-2">
                            {this.attributes.email}
                        </Typography>
                    </Stack>
                </Stack>
            ),
        },
        email: this.attributes.email,
        role: this.roles[0].attributes.name,
    });

}

export default User;
