const INITIAL_STATE = {
    loaded: false,
    user: null,
};

export default (state = INITIAL_STATE, action) => {
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
