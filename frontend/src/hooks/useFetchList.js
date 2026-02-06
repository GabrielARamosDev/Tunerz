import React from 'react';

import axios from 'axios';
// import state from '../controllers/state';
// import { useParams } from 'react-router-dom';

import notifications from '../controllers/notifications';
import objectHash from 'object-hash';

export default (options, dependencies = []) => {
    const {
        model: Model,
        page = 1,
        initialRowsPerPage = 10,
        url = React.useMemo(() => Model.getApiLink(), [Model]),
        query = {},
    } = options;

    const [rowsPerPage, setRowsPerPage] = React.useState(initialRowsPerPage);
    const [search, setSearchInput] = React.useState('');
    const [q, setQ] = React.useState('');

    const [collection, setCollection] = React.useState({
        items: [],
        // isLoading: true,
        pagination: {
            from: 0,
            last_page: 1,
            per_page: rowsPerPage,
            to: 1,
            total: 1,
        },
    });

    const urlFinal = React.useMemo(
        () => `/api/${url}?${new URLSearchParams({
            page,
            per_page: rowsPerPage,
            q,
            ...query,
        }).toString()}`
        // eslint-disable-next-line react-hooks/exhaustive-deps
        , [page, q, objectHash(query), rowsPerPage, url],
    );

    const [isLoading, setIsLoading] = React.useState(true);

    // eslint-disable-next-line react-hooks/exhaustive-deps
    const throttledRequest = React.useCallback(
        window._.throttle(() => {
            // console.log('throttled request!!');
            setIsLoading(true);

            // console.log('request to: ', urlFinal);
            axios(urlFinal)
                .then((response) => {
                    // console.log(response);

                    if (response.status !== 200) {
                        console.error('HTTP error', response);
                        notifications.create(`Houve um erro ao buscar a lista: ${response.data.message}`, 'error');
                        return;
                    }

                    const {
                        data: items,
                        // discard these items
                        // eslint-disable-next-line no-unused-vars
                        first_page_url, last_page_url, links, next_page_url, prev_page_url, path,
                        ...pagination
                    } = response.data;

                    if (items == undefined || items == null) {
                        console.log('data: ', response.data);
                        console.log('fetched items: ', items);
                        return;
                    }

                    // state.dispatch({
                    //     type: 'RESOURCES_INCLUDE_LIST',
                    //     payload: {
                    //         entity: modelOptions.name,
                    //         items,
                    //     }
                    // });

                    setCollection({
                        items,
                        // isLoading: false,
                        pagination,
                    });
                    setIsLoading(false);
                })
                .catch((error) => {
                    notifications.create(`Houve um erro ao buscar a lista: ${error.message}`, 'error');
                    console.error(error);
                });
        }, 500),
        [urlFinal],
    );

    React.useEffect(() => {
        // console.log('effect called!! throttling...');
        throttledRequest();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [throttledRequest, ...dependencies]);

    const { items, ...otherCollection } = collection;

    const instantiatedItems = React.useMemo(() => items.map((props) => new Model(props)), [items, Model]);

    return {
        ...otherCollection,
        isLoading,
        items: instantiatedItems,
        setRowsPerPage,
        search,
        setSearchInput: (search) => {
            if (search === '') {
                setQ('');
            }
            setSearchInput(search);
        },
        setSearch: setQ,
        refresh: throttledRequest,
    };
};
