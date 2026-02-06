// import { applyMiddleware, compose } from 'redux';
import { configureStore } from '@reduxjs/toolkit';
// import thunkMiddleware from 'redux-thunk';

// import monitorReducersEnhancer from './enhancers/monitorReducers';
// import loggerMiddleware from './middleware/logger';
import rootReducer from './reducers';

import { createLogger } from 'redux-logger';

const loggerMiddleware = createLogger({
    // ...options
});

class State {

    #store;

    constructor(preloadedState) {
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

const state = new State(/* preloadedState */);

export default state;
