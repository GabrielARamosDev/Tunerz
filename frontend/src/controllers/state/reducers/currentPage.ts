const INITIAL_STATE = {
    name: 'home',
    title: 'Home Page',
    icon: 'list_dot',
    route: '/',
    filters: [],
};

export default (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case 'CURRENT_PAGE': {
            return {
                ...state,
                ...action.payload,
            };
        }

        case 'RESET_PAGE':
            return INITIAL_STATE;

        default:
            return state;
    }
};
