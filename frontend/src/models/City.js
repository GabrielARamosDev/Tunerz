/* eslint-disable quotes */

import Model from '../contracts/Model';
import State from './State';

export const NEW_CITY = {
    id: 0,
    name: '',
    state_id: 0,
};

export default class City extends Model {

    #state;

    constructor(props = NEW_CITY) {
        const { state = {}, ...cityProps } = props;

        super(cityProps, 'city');

        this.#state = new State(state);
    }

    get state() {
        return this.#state;
    }

    serialize = () => ({
        ...this.attributes,
        id: this.id,
        state: this.state.serialize(),
        created_at: this.createdAt,
        updated_at: this.updatedAt,
    });

    static getApiLink = () => `app/city`;

}
