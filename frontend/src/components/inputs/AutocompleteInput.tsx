import React from 'react';
import PropTypes from 'prop-types';

import TextField from '@mui/material/TextField';
import Autocomplete from '@mui/material/Autocomplete';
// import CircularProgress from '@mui/material/CircularProgress';
// import InputAdornment from '@mui/material/InputAdornment';

const AutocompleteInput = ({
    variant = '',
    color = '',
    id,
    label,
    value,
    options,
    onChange,
    columnName,
    inputprops = {},
    ...props
}) => {
    const mountInputprops = (params) => ({
        InputProps: {
            ...params.InputProps,
            ...{ sx: {} },
            ...inputprops.outerInput,
        },
        inputProps: {
            ...params.inputProps,
            ...{ sx: {} },
            autoComplete: 'new-password',
            ...inputprops.innerInput,
        },
    });

    return (
        <Autocomplete
            multiple
            filterSelectedOptions

            id={id}
            variant={variant}
            color={color}

            options={options}
            value={value}
            onChange={onChange}

            isOptionEqualToValue={(option, value) => option?.id === value?.id}
            getOptionLabel={(option) => option[columnName] ?? ''}

            renderInput={(params) => (
                <TextField
                    {...params}
                    label={label}
                    {...mountInputprops(params)}
                />
            )}

            {...props}
        />
    );
};

AutocompleteInput.propTypes = {
    variant: PropTypes.string,
    color: PropTypes.string,
    id: PropTypes.string.isRequired,
    label: PropTypes.string.isRequired,
    value: PropTypes.any.isRequired,
    options: PropTypes.array.isRequired,
    columnName: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
    inputprops: PropTypes.object,
};

export default AutocompleteInput;
