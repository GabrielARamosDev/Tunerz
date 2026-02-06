import React from 'react';
import PropTypes from 'prop-types';

import Box from '@mui/material/Box';
import InputAdornment from '@mui/material/InputAdornment';
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import Select from '@mui/material/Select';
import TextField from '@mui/material/TextField';
import Typography from '@mui/material/Typography';
import Stack from '@mui/material/Stack';

import { Checkbox, useTheme } from '@mui/material';

import { NumericFormat } from 'react-number-format';
import InputMask from './InputMask';

import { DesktopDatePicker } from '@mui/x-date-pickers/DesktopDatePicker';

const FormInput = ({
    name,
    type = 'input',
    label = '',
    placeholder = '',
    value,
    options = [],
    columnName = 'name',
    onChange,
    isCurrency = false,
    currency = 'R$',
    hasAdornment = false,
    adornPos = 'start',
    col = 12,
    sx = {},
    ...props
}) => {
    const theme = useTheme();

    const _type = () => {
        switch (type) {
            case 'number': return 'text';
            case 'description': return 'input';
            default: return type;
        }
    };
    const _placeholder = () => {
        switch (type) {
            case 'number': {
                if (isCurrency) {
                    if (placeholder == '') {
                        return '0,00';
                    }
                } else {
                    if (placeholder == '') {
                        return '0';
                    }
                }
                return placeholder;
            }
            default: return placeholder;
        }
    };

    const adornment = () => {
        switch (type) {
            case 'number': {
                if (isCurrency) {
                    return (
                        <Box sx={{
                            ...theme.customized.layout.flex.ACenter_JBetween,
                            height: '100%',
                            pl: '14px',
                            pr: '6px',
                            mr: '14px',
                            backgroundColor: 'info.light',
                        }}
                        >
                            <InputAdornment position={adornPos} >
                                <Typography color="primary" >
                                    {currency}
                                </Typography>
                            </InputAdornment>
                        </Box>
                    );
                }
                return '';
            }

            default: return '';
        }
    };

    const inputMask = () => {
        const m = [
            'telefone',
            'cpf',
            'cnpj',
            'oab',
            /* 'cep', */
            'cpf_cnpj',
        ];

        if (type == 'input' && m.includes(name)) {
            return { inputComponent: InputMask };
        }
        return {};
    };

    const textFieldStyle = {
        width: '100% !important',
        m: '0 !important',
        mt: '4px',
    };
    const inputText = {
        width: '100%',
        ...type != 'description' && { height: '45px' },
        ...type === 'number' && isCurrency && { padding: '0' },
    };

    /** input parent div */
    const parentProps = () => {
        let temp = { style: { ...inputText } };

        if (hasAdornment) {
            if (adornPos == 'start') {
                temp = { ...temp, startAdornment: adornment() };
            }
            if (adornPos == 'end') {
                temp = { ...temp, endAdornment: adornment() };
            }
        }

        return temp;
    };
    const inputProps = {
        placeholder: _placeholder(),
        mask: props.mask,
    };

    const general = {
        fullWidth: true,
        required: props.required,
    };

    const textFieldProps = {
        /**
         * input parent-div element props
         */
        InputProps: { ...parentProps(), ...inputMask() },
        /**
         * input element props
         */
        inputProps,
        sx: textFieldStyle,
        ...general,
    };

    const descriptionProps = type == 'description' ? {
        multiline: true,
        rows: 4,
    } : {};

    const datePickerProps = {
        /**
         * input parent-div element props
         */
        InputProps: parentProps(),
        inputProps,
        ...general,
    };

    // console.log('field props: ', props);
    const input = () => {
        switch (type) {
            case 'select':
                return (
                    <Select
                        disabled={props.disabled}
                        required={props.required}
                        value={value || 0}
                        name={name}
                        onChange={onChange}
                        sx={inputText}
                        {...props}
                    >
                        <MenuItem
                            sx={inputText}
                            value="0"
                            key="default"
                        >selecione
                        </MenuItem>
                        {options.map((opt) => (
                            <MenuItem
                                sx={inputText}
                                value={opt.id}
                                key={opt.id}
                            >
                                {opt[columnName]}
                            </MenuItem>))}
                    </Select>
                );
            case 'number':
                return (
                    <NumericFormat
                        customInput={TextField}
                        {...textFieldProps}
                        onValueChange={(values) => onChange({
                            target: {
                                name,
                                value: values.value,
                            },
                        })}
                        thousandSeparator="."
                        decimalSeparator={isCurrency ? ',' : ''}
                        {...props}
                    />
                );
            case 'input':
            case 'email':
            case 'password':
            case 'description':
                return (
                    <TextField
                        {...textFieldProps}
                        {...descriptionProps}
                        variant={props.variant}
                        name={name}
                        type={_type()}
                        value={value}
                        onChange={onChange}
                        disabled={props.disabled}
                        {...props}
                    />
                );
            case 'date':
                return (
                    <DesktopDatePicker
                        inputFormat="DD/MM/YYYY"
                        value={value}
                        onChange={onChange}
                        {...datePickerProps}
                        renderInput={(params) => (
                            <TextField
                                {...params}
                                sx={{ ...textFieldStyle }}
                            />
                        )}
                        {...props}
                    />
                );
            case 'checkbox':
                return (
                    <Checkbox
                        {...textFieldProps}
                        {...descriptionProps}
                        name={name}
                        checked={value}
                        onChange={onChange}
                        sx={{
                            p: 0,
                            mx: 1.25,
                            my: 'auto',
                        }}
                        {...props}
                    />
                );
        }
    };

    const boxWidth = () => {
        const m = 100 / 12 * col;
        const w = col < 12 ? m - 1.125 : m;

        return `${w}%`;
    };

    return (
        <Stack
            direction={type === 'checkbox' ? 'row' : 'column'}
            sx={{
                mb: 1,
                width: boxWidth(),
                height: type === 'checkbox' ? 35 : 65,
                alignItems: type === 'checkbox' ? 'center' : 'start',
                ...sx,
            }}
        >
            <InputLabel
                sx={{ 
                    mb: type === 'checkbox' ? 0 : .5,
                    lineHeight: '60%',
                 }}
            >
                <Typography variant="subtitle-1" >
                    {label} {(props.required && '*')}
                </Typography>
            </InputLabel>

            {input()}
        </Stack>
    );
};

FormInput.propTypes = {
    variant: PropTypes.string,
    type: PropTypes.string,

    name: PropTypes.string.isRequired,
    label: PropTypes.string,
    placeholder: PropTypes.string,
    mask: PropTypes.string,

    value: PropTypes.any.isRequired,
    options: PropTypes.array,
    onChange: PropTypes.func.isRequired,
    columnName: PropTypes.string,

    isCurrency: PropTypes.bool,
    currency: PropTypes.string,

    // gender: PropTypes.bool,
    hasAdornment: PropTypes.bool,
    adornPos: PropTypes.bool,
    col: PropTypes.number,

    sx: PropTypes.object,
    required: PropTypes.bool,
    disabled: PropTypes.bool,
};

export default FormInput;
