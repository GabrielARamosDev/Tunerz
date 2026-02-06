const INITIAL_STATE = {
    countries: [{ id: 1, name: 'Brasil' }],
    states: [],
    cities: [],
    schools: [],
    classrooms: [],
    seasons: [],
    leagues: [],
    games: [],
    subComponents: [],
    start_at: '',
    end_at: '',
};

export default (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case 'FILTER_CHANGE': {
            let temp = {};

            if (action.payload.key === 'states') {
                temp = {
                    cities: [],
                    schools: [],
                    classrooms: [],
                };
            }
            if (action.payload.key === 'cities') {
                temp = {
                    schools: [],
                    classrooms: [],
                };
            }

            if (action.payload.key === 'schools') {
                temp = { classrooms: [] };
            }

            return {
                ...state,
                [action.payload.key]: action.payload.value,
                ...temp,
            };
        }

        default:
            return state;
    }
};
