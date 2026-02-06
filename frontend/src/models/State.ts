/* eslint-disable quotes */

import Model from '../contracts/Model';
import type { State as StageType } from '../types/state';

export const NEW_STATE: StageType = {
    id: 0,
    name: '',
    country: '',
};

class State extends Model {

    constructor(props: StageType = NEW_STATE) {
        const { ...stateProps } = props;

        super(stateProps, 'state');
    }

    static getApiLink = () => `app/state`;

}

export default State;
