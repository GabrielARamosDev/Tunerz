import state from '../state';

import User from '../../models/User';

class CurrentUser {

    user = null;

    get = () => {
        if (this.user == null) {
            // instancia o usuario somente uma vez (teremos q nos preocupar com 'logoff/login' no futuro)
            this.user = new User(state.store.getState().app.user);
        }
        return this.user;
    };

}

const currentUser = new CurrentUser();

export default currentUser;
