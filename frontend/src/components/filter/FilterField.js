/* eslint-disable prefer-destructuring */

import React from 'react';
import PropTypes from 'prop-types';

import { connect } from 'react-redux';

import { useTheme } from '@mui/material';

import AutocompleteInput from '../inputs/AutocompleteInput';

const FilterField = ({
    variant,
    name,
    options = [],
    columnName = 'name',
    dispatch,
    ...props
}) => {
    const theme = useTheme();

    const { FilterFieldAutocomplete } = theme.customized.layout;
    const mainColor = variant.split('-').reverse()[0];

    const onChange = (e, newValue) => {
        dispatch({
            type: 'FILTER_CHANGE',
            payload: {
                key: name,
                value: newValue,
            },
        });
    };

    const InputProps = {
        sx: {
            ...FilterFieldAutocomplete.outerInput,
            ...FilterFieldAutocomplete.outerInput.variants[mainColor],
        },
    };
    const inputProps = {
        sx: {
            ...FilterFieldAutocomplete.innerInput,
            ...FilterFieldAutocomplete.innerInput.variants[mainColor],
        },
    };

    return (
        <AutocompleteInput
            id={`filter-select-${name}`}
            variant="nav-filter"
            color={mainColor}

            columnName={columnName}

            value={props.filter[name]}
            options={options}
            onChange={onChange}

            inputprops={{
                outerInput: InputProps,
                innerInput: inputProps,
            }}

            {...props}
        />
    );
};

FilterField.propTypes = {
    variant: PropTypes.string.isRequired,
    name: PropTypes.string.isRequired,
    options: PropTypes.instanceOf(Array).isRequired,
    columnName: PropTypes.string,
    filter: PropTypes.instanceOf(Object).isRequired,
    dispatch: PropTypes.func.isRequired,
};

const mapStateToProps = ({ filter }) => ({ filter });
export default connect(mapStateToProps)(FilterField);
