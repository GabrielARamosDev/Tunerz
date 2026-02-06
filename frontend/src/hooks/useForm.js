import React from 'react';

import objectHash from 'object-hash';

export default (options = {}) => {

    const [dataState, setDataState] = React.useState(options.initialValues || {});

    // eslint-disable-next-line react-hooks/exhaustive-deps
    const data = React.useMemo(() => dataState, [objectHash(dataState)]);

    const handleChange = React.useCallback((sanitizeFn = (e) => e.target.value) => (e) => {
        setDataState({
            ...data,
            [e.target.name]: sanitizeFn(e),
        });
    }, [data]);

    const handleSubmit = React.useCallback(async (e) => {
        e.preventDefault();
        if (options?.onSubmit) {
            await options?.onSubmit(data);
        }

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [data, options?.onSubmit]);

    return {
        data,
        handleChange,
        handleSubmit,
        setData: setDataState,
    };
};

