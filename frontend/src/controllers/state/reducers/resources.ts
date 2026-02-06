const INITIAL_STATE = {
    items: {
        // management
        role: {},
        user: {},
        skill: {},
        // locations
        country: {},
        state: {},
        city: {},
        school: {},
        classroom: {},
        // phases
        season: {},
        league: {},
        game: {},
        subComponent: {},
    },
};

export default (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case 'RESOURCES_INCLUDE_LIST':
            return {
                items: {
                    ...state.items,
                    [action.payload.entity]: {
                        ...state.items[action.payload.entity] || {},
                        ...action.payload.items.reduce((acc, item) => ({
                            ...acc,
                            [item.id]: {
                                original: item,
                                attributes: item,
                                hasChanges: false,
                            },
                        }), {}),
                    },
                },
            };

        case 'RESOURCES_INCLUDE_ITEM':
            return {
                items: {
                    ...state.items,
                    [action.payload.entity]: {
                        ...state.items[action.payload.entity] || {},
                        [action.payload.item.id]: {
                            original: action.payload.item,
                            attributes: action.payload.item,
                            hasChanges: false,
                        },
                    },
                },
            };

        case 'RESOURCES_EDITING':
            return {
                items: {
                    ...state.items,
                    [action.payload.entity]: {
                        ...state.items[action.payload.entity] || {},
                        [action.payload.item.id]: {
                            original: state.items[action.payload.entity][action.payload.item.id].original,
                            attributes: {
                                ...state.items[action.payload.entity][action.payload.item.id].attributes,
                                ...action.payload.item.attributes,
                            },
                            hasChanges: true,
                        },
                    },
                },
            };

        default:
            return state;
    }
};
