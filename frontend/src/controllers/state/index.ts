import { configureStore } from '@reduxjs/toolkit';

import rootReducer from './reducers';

import { createLogger } from 'redux-logger';

const PRELOADED = {
    app: {}, 
    currentPage: {}, 
    filter: {},
    notifications: {},
    resources: {},
};

const loggerMiddleware = createLogger({
    // ...options
});

class State {

    #store;

    constructor(preloadedState: any) {
        this.#store = configureStore({
            reducer: rootReducer,
            middleware: (getDefaultMiddleware) => getDefaultMiddleware().concat(loggerMiddleware),
            preloadedState,
        });
    }

    get store() {
        return this.#store;
    }

    dispatch = (action) => this.#store.dispatch(action);

}

const state = new State(/* PRELOADED */);

export default state;
