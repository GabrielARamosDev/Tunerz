export default (
    filters = {},
    useCountry = true,
    onlyKeys = false,
) => {
    const temp = [];

    Object.entries(filters).forEach((filter) => {
        if (filter[0] == 'countries') {
            if (useCountry) {
                temp.countries = filter[1];
            }
        } else {
            if (filter[1].length > 0) {
                temp[filter[0]] = filter[1];
            }
        }
    });
    // console.log('active filters: ', temp);

    if (onlyKeys) {
        return Object.keys(temp);
    }
    return temp;
};
