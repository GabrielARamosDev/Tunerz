
import type { State as StateType, StateAction } from "../../../types/state";

const INITIAL_STATE = {
    loaded: false,
    user: null,
};

export default (state: StateType = INITIAL_STATE, action: StateAction) => {
    switch (action.type) {
        case 'APP_LOADED':
            return {
                ...state,
                loaded: true,
            };

        case 'APP_CREDENTIALS':
            return {
                ...state,
                user: action.payload,
            };

        default:
            return state;
    }
};
