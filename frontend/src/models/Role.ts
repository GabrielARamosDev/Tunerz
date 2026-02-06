import Model from '../contracts/Model';
import RoleAbility from './RoleAbility.ts';

import type { FormFields } from '../types/basemodel.ts';
import type { Role as RoleType, FormData } from '../types/role.ts';
import type { RoleAbility as RoleAbilityType } from '../types/roleAbility.ts';

export const NEW_ROLE: RoleType = {
    id: 0,
    name: '',
    roleAbilities: [],
    role_abilities_ids: [],
};

class Role extends Model {

    #roleAbilities;

    constructor(props: RoleType = NEW_ROLE) {
        const { 
            roleAbilities = [], 
            ...roleProps 
        } = props;

        super(roleProps, 'role');

        this.#roleAbilities = roleAbilities.map((ra) => new RoleAbility(ra));
    }

    get roleAbilities() {
        return this.#roleAbilities;
    }

    serialize = () => ({
        ...this.attributes,
        id: this.id,
        roleAbilities: this.#roleAbilities.map((a) => a.serialize()),
    });

    getApiLink = () => 'app/roles';

    getLink = () => `v1/gestao/funcoes/${this.id}`;

    static getFormFields = (args: FormFields) => {
        // console.log('form fields args: ', args);

        const data: FormData[] = [
            {
                name: 'name',
                label: 'Nome',
                placeholder: 'Insira um nome',
                value: '',
                col: 4,
                required: true,
                // disabled: args.isProfile,
            },
            {
                name: 'role_abilities_ids',
                value: args.roleAbilitiesIds.toString(),
                col: 0,
                // disabled: true,
                // hidden: true,
            },
        ];

        if (args.roleAbilities.length > 0) {
            args.roleAbilities.forEach(({ id, attributes: ra }: { id: number, attributes: RoleAbilityType }) => {
                data.push({
                    type: 'checkbox',
                    name: ra.ability,
                    label: ra.name,
                    value: args.roleAbilitiesIds.includes(id),
                    col: 12,
                    sx: { m: 0 },
                    disabled: !ra.enabled,
                });
            });
        }
        console.log('form fields: ', data);

        return data;
    };

    static getTableHead = () => ({
        name: {
            name: 'Nome',
            sx: { width: '22.5%' },
        },
    });

    getTableData = () => ({
        name: this.attributes.name,
    });
}

export default Role;
