/* eslint-disable quotes */

import Model from '../contracts/Model';

export const NEW_COUNTRY = {
    id: 0,
    name: '',
};

export default class Country extends Model {

    constructor(props = NEW_COUNTRY) {
        super(props, 'country');
    }

    static getApiLink = () => `app/country`;

}
