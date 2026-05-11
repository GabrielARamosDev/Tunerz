/* eslint-disable react-hooks/exhaustive-deps */

import React from 'react';

import main from '../main';

export default (options: any, dependencies = []) => {
    // console.log('update current page: ', options.name);

    React.useEffect(() => {
        // envia a configuração atual
        main.state.dispatch({
            type: 'CURRENT_PAGE',
            payload: options,
        });

        document.title = `${options.title} | Base de Dados`;

        // reseta o titulo qnd sair da pagina
        return () => {
            document.title = 'Base de Dados';
            main.state.dispatch({ type: 'RESET_PAGE' });
        };
    }, [options.name, ...dependencies]);
};
