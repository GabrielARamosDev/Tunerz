import { v4 as uuidv4 } from 'uuid';
import state from '../state';

const NOTIFICATION_TIMEOUT = 10000;

class Notifications {

    create = (message, type = 'info') => {
        const key = uuidv4();

        state.dispatch({
            type: 'NOTIFICATIONS_CREATE',
            payload: {
                key,
                message,
                type,
            },
        });

        setTimeout(() => this.dismiss(key), NOTIFICATION_TIMEOUT);
    };

    success = (message) => this.create(message, 'success');
    error = (message) => this.create(message, 'error');
    info = (message) => this.create(message, 'info');
    warning = (message) => this.create(message, 'warning');

    dismiss = (key) => {
        state.dispatch({
            type: 'NOTIFICATIONS_DISMISS',
            payload: key,
        });
    };

}

const notifications = new Notifications();

export default notifications;
