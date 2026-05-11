
import { RouterProvider } from "react-router-dom";
import { Provider as ReduxProvider } from 'react-redux';

// import { ProSidebarProvider } from 'react-pro-sidebar';

import main from "./main.tsx";
import router from './router';

import '../src/assets/css/App.css';
import AppTheme from './assets/theme/index.ts';
import { ThemeProvider } from '@mui/material';

const App = () => {
  return (
    <ReduxProvider store={main.state.store}>
      {/* <ProSidebarProvider> */}
        <ThemeProvider theme={AppTheme}>
          <RouterProvider router={router.createRouter()} />
        </ThemeProvider>
      {/* </ProSidebarProvider> */}
    </ReduxProvider>
  );
}

export default App;
