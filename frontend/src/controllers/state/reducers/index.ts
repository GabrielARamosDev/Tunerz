
import { combineReducers } from '@reduxjs/toolkit';

import app from './app';
import currentPage from './currentPage';
import filter from './filter';
import notifications from './notifications';
import resources from './resources';

const rootReducer = combineReducers({
    app,
    currentPage,
    filter,
    notifications,
    resources,
});

export default rootReducer;

