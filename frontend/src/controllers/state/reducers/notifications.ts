const INITIAL_STATE = {
    items: [
        // {
        //     key: '0f889-d5714',
        //     message: 'This is sample notification!',
        //     type: 'success'
        // },
        // {
        //     key: '0f889-d5716',
        //     message: 'This is sample notification!',
        //     type: 'info'
        // },
        // {
        //     key: '0f889-d5718',
        //     message: 'This is sample notification!',
        //     type: 'error'
        // }
    ],
};

export default (state = INITIAL_STATE, action) => {
    switch (action.type) {
        // case 'APP_LOADED':
        //     return {
        //         ...state,
        //         loaded: true,
        //     };

        // case 'APP_CREDENTIALS':
        //     return {
        //         ...state,
        //         user: action.payload,
        //     };
        case 'NOTIFICATIONS_CREATE':
            return {
                items: [
                    action.payload,
                    ...state.items,
                ],
            };

        case 'NOTIFICATIONS_DISMISS':

            return { items: state.items.filter((item) => item.key !== action.payload) };

        default:
            return state;
    }
};
