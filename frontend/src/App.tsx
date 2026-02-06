
import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client';

import { RouterProvider } from "react-router-dom";
import { Provider as ReduxProvider } from 'react-redux';

import axios from 'axios';
import router from './router';

import auth from './controllers/auth';
import dialog from './controllers/dialog';
import notifications from './controllers/notifications';
import state from './controllers/state';
import currentUser from './controllers/user';

import { ThemeProvider } from '@mui/material';
import AppTheme from './theme';
import './App.css';

// import { GarageProvider } from "./contexts/GarageContext";

// import Garage from "./screens/Garage/index.tsx";

// const App = () => {
//   return (
//     <BrowserRouter>
//       <Routes>
//         <Route 
//           path="/" 
//           element={
//             <GarageProvider>
//               <Garage />
//             </GarageProvider>
//           }
//         />
//       </Routes>
//     </BrowserRouter>
//   );
// }

// export default App;

class _App {

  #auth;
  #dialog;
  #notifications;
  #router;
  #state;
  #currentUser;

  constructor() {
    this.#auth = auth;
    this.#dialog = dialog;
    this.#notifications = notifications;
    this.#router = router;
    this.#state = state;
    this.#currentUser = currentUser;

    const rootElement = document.getElementById('root');

    if (rootElement) {
      axios.get('/sanctum/csrf-cookie').then(() => {
        createRoot(rootElement).render(
          <StrictMode>
              <ReduxProvider store={state.store}>
                  <ThemeProvider theme={AppTheme}>
                    <RouterProvider router={router.createRouter()} />
                  </ThemeProvider>
              </ReduxProvider>
          </StrictMode>
        );

        window.addEventListener('load', () => {
          state.dispatch({
            type: 'APP_LOADED',
            payload: {},
          });
        });

        axios.get('/api/me').then((response) => {
          state.dispatch({
            type: 'APP_CREDENTIALS',
            payload: response.data,
          });
        });
      });
    }
  }

  get auth() {
    return this.#auth;
  }

  get dialog() {
    return this.#dialog;
  }

  get notifications() {
    return this.#notifications;
  }

  get router() {
    return this.#router;
  }

  get state() {
    return this.#state;
  }

  get currentUser() {
    return this.#currentUser;
  }
}

const App = new _App();

export default App;
