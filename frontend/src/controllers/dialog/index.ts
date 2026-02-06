// import React from 'react';

class Dialog {

    onShow = null;

    show = (options) =>

    // const { message, type = 'alert', title = '' } = options;

        new Promise((resolve) => {
            if (typeof this.onShow === 'function') {
                this.onShow({
                    ...options,
                    resolve,
                });
            }
        })
        ;

    alert = (message) => this.show({ message });

    confirm = (message) => this.show({
        message,
        type: 'confirm',
    });

}

const dialog = new Dialog();

export default dialog;
