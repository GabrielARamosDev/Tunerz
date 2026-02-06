/* eslint-disable quotes */

import Model from '../contracts/Model';

import type { RoleAbility as RoleAbilityType } from '../types/roleAbility.ts';

export const NEW_ROLEABILITY: RoleAbilityType = {
    id: 0,
    name: '',
    ability: '',
    enabled: 0,
};

class RoleAbility extends Model {

    constructor(props: RoleAbilityType = NEW_ROLEABILITY) {
        const { ...stateProps } = props;

        super(stateProps, 'roleAbilities');
    }

    static getApiLink = () => `app/roleAbilities`;

}

export default RoleAbility;
