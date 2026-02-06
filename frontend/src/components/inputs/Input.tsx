/* eslint-disable no-unused-vars */
import React from 'react';
import PropTypes from 'prop-types';
import objectHash from 'object-hash';

import Autocomplete from '@mui/material/Autocomplete';
import TextField from '@mui/material/TextField';
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import Select from '@mui/material/Select';
import Typography from '@mui/material/Typography';
import Grid from '@mui/material/Unstable_Grid2';
import FormControl from '@mui/material/FormControl';
import FormLabel from '@mui/material/FormLabel';
import FormGroup from '@mui/material/FormGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import RadioGroup from '@mui/material/RadioGroup';
import Radio from '@mui/material/Radio';

import InputMask from 'react-input-mask';

import _ from 'lodash';
// import notifications from '../controllers/notifications';

const VALID_TYPES = [
    'text',
    'textarea',
    'tel',
    'email',
    'date',
    'datetime-local',
    'number',
    'password',
    'autocomplete',
    'select',
    'radio',
    'checkbox',
    'file',
];

const defaultSanitize = (type) => (e) => {
    if (['radio', 'checkbox'].includes(type)) {
        return e.target.checked;
    }
    return e.target.value;
};

const Input = ({
    type = 'text', form, name, mask = null, maskProps = {}, label,
    options = [], gridItem = false, onQuery = async () => [],
    sanitize = defaultSanitize(type), getOptionLabel = (item) => item?.attributes.nome || '',
    debounce = 500,
    ...props
}) => {

    if (form && !Object.keys(form.data).includes(name)) {
        console.warn(`[Input error] input named "${name}" does not exist in data`);
    }

    const [autoCompleteText, setAutoCompleteText] = React.useState('');
    const [autoCompleteOptions, setAutoCompleteOptions] = React.useState([]);
    const [isFetchingOptions, setIsFetchingOptions] = React.useState(false);

    // eslint-disable-next-line react-hooks/exhaustive-deps
    const debouncedSearch = React.useCallback(
        _.debounce((nextValue) => {
            console.log('debounced');
            setIsFetchingOptions(true);
            onQuery(nextValue).then((items) => {
                setAutoCompleteOptions(items);
                setIsFetchingOptions(false);
            });
        }, debounce),
        [onQuery],
    );

    const handleAutoCompleteTextChange = React.useCallback((_e, value) => {
        setAutoCompleteText(value);
        if (value && !form?.data[name]) {
            console.log('triggering debounce', value);
            debouncedSearch(value);
            return;
        }
        setAutoCompleteOptions([]);
    }, [debouncedSearch, form?.data, name]);

    const gridItemHash = objectHash(gridItem);

    const wrapperProps = React.useMemo(() => {
        if (gridItem) {
            return gridItem === true ? { xs: 12 } : gridItem;
        }
        return {};
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [gridItemHash]);

    const Wrapper = React.useMemo(() => {
        if (gridItem) {
            return Grid;
        }
        return React.Fragment;
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [gridItemHash]);

    const theInput = React.useMemo(() => {
        // console.log('rendering input for ' + name);
        switch (type) {
            case 'radio':
                return (
                    <FormControl>
                        <FormLabel id={`form-control-radio-${name}`}>
                            {label}
                        </FormLabel>
                        <RadioGroup
                            aria-labelledby={`form-control-radio-${name}`}
                            name={name}
                            value={form?.data[name] || ''}
                            onChange={form?.handleChange(sanitize)}
                            {...props}
                        >
                            {(options || []).map((option) => (
                                <FormControlLabel
                                    key={option.value}
                                    label={option.label}
                                    value={option.value}
                                    control={<Radio />}
                                />
                            ))}
                        </RadioGroup>
                    </FormControl>
                );

            case 'checkbox':
                if (props.multiple) {
                    // multiple checkboxes
                    return (
                        <FormGroup sx={{ mx: 1 }} >
                            <FormLabel sx={{ mt: 1 }} >
                                {label}
                            </FormLabel>

                            {(options || []).map((option) => (
                                <FormControlLabel
                                    key={option.value}
                                    control={
                                        <Checkbox
                                            name={name}
                                            checked={form?.data[name]?.includes(option.value) || false}
                                            onChange={form?.handleChange((e) => {
                                                const nextValue = form?.data[name] || [];
                                                if (e.target.checked) {
                                                    nextValue.push(option.value);
                                                } else {
                                                    nextValue.splice(nextValue.indexOf(option.value), 1);
                                                }
                                                return nextValue;
                                            })}
                                            {...props}
                                        />
                                    }
                                    label={option.label}
                                    sx={{ ml: label ? .5 : 0 }}
                                />
                            ))}
                        </FormGroup>
                    );
                }
                return (
                    <FormControlLabel
                        control={
                            <Checkbox
                                name={name}
                                checked={form?.data[name] || false}
                                onChange={form?.handleChange(sanitize)}
                                {...props}
                            />
                        }
                        label={label}
                    />
                );

            case 'select':
                return (
                    <Select
                        fullWidth={!!gridItem}
                        name={name}
                        type={type}
                        value={form?.data[name] || ''}
                        onChange={form?.handleChange(sanitize)}
                        {...props}
                    >
                        {(options || []).map((option) => (
                            <MenuItem
                                key={option.value}
                                value={option.value}
                            >
                                {option.label}
                            </MenuItem>
                        ))}
                    </Select>
                );
            case 'autocomplete':
                return (
                    <Autocomplete
                        fullWidth={!!gridItem}
                        value={form?.data[name] || null}
                        // onChange={form?.handleChange(sanitize)}
                        onChange={(_e, value) => form?.handleChange(() => value)({ target: { name } })}
                        inputValue={autoCompleteText}
                        onInputChange={handleAutoCompleteTextChange}
                        options={autoCompleteOptions}
                        renderInput={(inputProps) => (
                            <TextField
                                name={name}
                                {...inputProps}
                            />
                        )}
                        isOptionEqualToValue={(option, value) => option.id == value.id}
                        noOptionsText={
                            autoCompleteText
                                ? (isFetchingOptions ? 'Pesquisando...' : 'Nenhum item foi encontrado')
                                : 'Digite para pesquisar...'
                        }
                        getOptionLabel={getOptionLabel}
                        {...props}
                    />
                );

            default:
                if (mask) {
                    return (
                        <InputMask
                            fullWidth={!!gridItem}
                            name={name}
                            type={type}
                            value={form?.data[name] || ''}
                            onChange={form?.handleChange(sanitize)}
                            mask={mask}
                            {...props}
                            {...maskProps}
                        >
                            {(inputProps) => <TextField {...inputProps} />}
                        </InputMask>
                    );
                }
                return (
                    <TextField
                        fullWidth={!!gridItem}
                        name={name}
                        type={type}
                        value={form?.data[name] || ''}
                        onChange={form?.handleChange(sanitize)}
                        {...props}
                    />
                );

        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [name, type, objectHash(options), form?.data, autoCompleteOptions, autoCompleteText,
        isFetchingOptions, handleAutoCompleteTextChange, props.disabled, mask]);

    return (
        <Wrapper {...wrapperProps}>
            {!['checkbox', 'radio'].includes(type) && label && (
                <InputLabel sx={{ mb: 0.5 }} >
                    <Typography
                        variant="subtitle1"
                        color="text.primary"
                    >
                        {label} {(props.required && '*')}
                    </Typography>
                </InputLabel>
            )}

            {theInput}
        </Wrapper>
    );
};

Input.propTypes = {
    type: PropTypes.oneOf(VALID_TYPES),
    form: PropTypes.shape({
        data: PropTypes.object,
        handleChange: PropTypes.func,
        handleSubmit: PropTypes.func,
        setData: PropTypes.func,
    }),
    name: PropTypes.string,
    mask: PropTypes.string,
    maskProps: PropTypes.object,
    label: PropTypes.node,
    options: PropTypes.any,
    groupProps: PropTypes.any,
    sanitize: PropTypes.func,
    placeholder: PropTypes.string,
    required: PropTypes.bool,
    gridItem: PropTypes.oneOfType([
        PropTypes.object,
        PropTypes.bool,
    ]),
    onQuery: PropTypes.func,
    getOptionLabel: PropTypes.func,
    disabled: PropTypes.bool,
    debounce: PropTypes.number,
};

export default Input;