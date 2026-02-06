import { useEffect, useState, useCallback } from 'react';
import axios from 'axios';

const useFetchUrl = (options, dependencies = []) => {
    const { url, query } = options;

    const [responseData, setResponseData] = useState();
    const [isLoading, setIsLoading] = useState(true);

    const urlFinal = query
        ? `${url}?${new URLSearchParams(query).toString()}`
        : url;

    // console.log('urlFinal', urlFinal);

    // eslint-disable-next-line react-hooks/exhaustive-deps
    const throttledRequest = useCallback(
        window._.debounce(() => {
            // console.log('url debounced!');

            axios.get(urlFinal).then((resp) => {
                setResponseData(resp.data);
                setIsLoading(false);
            })
                .catch((error) => {
                    console.log(error);
                });
        }, 500),
        [urlFinal],
    );

    useEffect(() => {
        setIsLoading(true);
        // console.log('url throtling...');
        throttledRequest();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [throttledRequest, ...dependencies]);
    return {
        data: responseData,
        isLoading,
    };
};

export default useFetchUrl;
