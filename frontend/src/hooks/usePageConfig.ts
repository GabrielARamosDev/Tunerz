/* eslint-disable react-hooks/exhaustive-deps */

import React from 'react';

import state from '../controllers/state';

export default (options, dependencies = []) => {
    // console.log('update current page: ', options.name);

    React.useEffect(() => {
        // envia a configuração atual
        state.dispatch({
            type: 'CURRENT_PAGE',
            payload: options,
        });

        document.title = `${options.title} | Base de Dados`;

        // reseta o titulo qnd sair da pagina
        return () => {
            document.title = 'Base de Dados';
            state.dispatch({ type: 'RESET_PAGE' });
        };
    }, [options.name, ...dependencies]);
};
