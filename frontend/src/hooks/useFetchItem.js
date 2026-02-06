import React from 'react';
// import state from '../controllers/state';

import axios from 'axios';
import { useNavigate } from 'react-router-dom';

import notifications from '../controllers/notifications';

export default (options, dependencies = []) => {
    const {
        model: Model,
        id,
        newItemData,
        url = React.useMemo(() => Model.getApiLink(), [Model]),
    } = options;

    const navigate = useNavigate();

    const [collection, setCollection] = React.useState({
        item: null,
        isLoading: true,
    });

    const handleSubmit = (additionalPayload = {}) => (e) => {
        e.preventDefault();
        collection.item.save(additionalPayload).then((saved) => {
            if (saved) {
                navigate(-1);
            }
        })
            .catch((err) => {
                console.log(err);
            });
    };

    React.useEffect(() => {
        const _dispatch = (item) => {
            // console.log('dispatching item. . .', item);

            // state.dispatch({
            //     type: 'RESOURCES_INCLUDE_ITEM',
            //     payload: {
            //         entity: modelOptions.name,
            //         item,
            //     }
            // });

            setCollection({
                item: new Model(id),
                isLoading: false,
            });
        };

        if (id == 0) {
            _dispatch(newItemData);
        } else {
            // call api
            axios(`/api/${url}/${id}`)
                .then((response) => {
                    if (response.status !== 200) {
                        console.error('HTTP error', response);
                        notifications.create(`Houve um erro ao buscar o item: ${response.data.message}`, 'error');
                        return;
                    }

                    const { data: item } = response;

                    _dispatch(item);
                })
                .catch((error) => {
                    notifications.create(`Houve um erro ao buscar o item: ${error.message}`, 'error');
                    console.error(error);
                });
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, dependencies);

    return {
        ...collection,
        handleSubmit,
    };
};
