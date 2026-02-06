/* eslint-disable quotes */

import Model from '../contracts/Model';

export const NEW_STATE = {
    id: 0,
    name: '',
    country: '',
};

export default class State extends Model {

    constructor(props = NEW_STATE) {
        const { ...stateProps } = props;

        super(stateProps, 'state');
    }

    static getApiLink = () => `app/state`;

}
