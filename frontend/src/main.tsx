import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'

import App from './App.tsx'

import './index.css'

import axios from 'axios';
import router from './router';

import auth from './controllers/auth/index.ts';
import dialog from './controllers/dialog/index.ts';
import notifications from './controllers/notifications/index.ts';
import state from './controllers/state/index.ts';
import currentUser from './controllers/user/index.ts';

class _main {

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
        createRoot(document.getElementById('root')!).render(
          <StrictMode>
            <App />
          </StrictMode>,
        )

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

const main = new _main();

export default main;
