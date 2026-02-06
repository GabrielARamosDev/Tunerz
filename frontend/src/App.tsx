
import { RouterProvider } from "react-router-dom";
import { Provider as ReduxProvider } from 'react-redux';

import router from './router';

import state from './controllers/state/index.ts';

import { ThemeProvider } from '@mui/material';
import AppTheme from './theme';

import './App.css';

const App = () => {
  return (
    <ReduxProvider store={state.store}>
        <ThemeProvider theme={AppTheme}>
          <RouterProvider router={router.createRouter()} />
        </ThemeProvider>
    </ReduxProvider>
  );
}

export default App;
