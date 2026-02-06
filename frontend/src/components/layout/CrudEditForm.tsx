import React from 'react';
import PropTypes from 'prop-types';

import FormInput from '../inputs/FormInput';
import FormSubmitButton from './FormSubmitButton';

import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
// import Button from '@mui/material/Button';
import Paper from '@mui/material/Paper';
import Model from '../../contracts/Model';

const CrudEditForm = ({
    title = '',
    item,
    fields,
    mode = 'create',
    serialize = true,
    onChange = () => null,
    onClickEdit = () => null,
    onBeforeSave = () => null,
    onSaved = () => null,
}) => {
    // console.log('item: ', item);

    const {
        data,
        setData,
        setProp,
        save,
        isDirty,
    } = item.useData();
    // console.log('item: ', data);

    React.useEffect(() => {
        setData(item.attributes);
        console.log(item);
    }, [item, setData]);

    const params = { mode };

    const handleSubmit = (e) => {
        e.preventDefault();

        onBeforeSave(item, data);

        save().then(() => {
            onSaved(item);
        });
    };

    const handleChange = (e, name, type, disabled) => {

        const checked = e.target.checked;
        const value = e.target.value;

        if (!disabled) {
            setProp(
                name,
                type === 'checkbox'
                    ? checked
                    : value
            );
            onChange(
                name,
                type === 'checkbox'
                    ? checked
                    : value
            );
        }
    }

    return (
        <Paper sx={{ mt: 1.5, p: '17px 20px' }} >
            <Stack>
                <Typography
                    variant="h2"
                    color="primary"
                    sx={{ mb: 2 }}
                >{title}
                </Typography>

                <Box
                    component="form"
                    // noValidate
                    autoComplete="off"
                    onSubmit={handleSubmit}
                >
                    <Stack
                        direction="row"
                        sx={{ flexWrap: 'wrap', justifyContent: 'space-between' }}
                    >
                        {fields.map((input, i) => {
                            const {
                                type,
                                name,
                                label,
                                placeholder,
                                value,
                                options,
                                tableColumn,
                                col,
                                required,
                                disabled = false,
                                visible = true,
                                ...props
                            } = input;

                            return (
                                <React.Fragment key={`${i}_${name}`}>
                                    {visible && (
                                        <FormInput
                                            key={name}
                                            type={type}
                                            variant="outlined"

                                            name={name}
                                            label={label}
                                            placeholder={placeholder}

                                            value={data[name] ?? value ?? ''}
                                            options={serialize
                                                ? options?.map((opt) => opt.serialize())
                                                : options}
                                            onChange={(e) => handleChange(e, name, type, disabled)}
                                            columnName={tableColumn}

                                            col={col}

                                            required={typeof required === 'function'
                                                ? required(params)
                                                : required}
                                            disabled={disabled}

                                            {...props}
                                        />
                                    )}
                                </React.Fragment>
                            );
                        })}
                    </Stack>

                    <FormSubmitButton
                        id={item.id}
                        isDirty={isDirty}
                        onCancel={() => onClickEdit('')}
                        sx={{ mt: 1.5 }}
                    />
                </Box>
            </Stack>
        </Paper>
    );
};

CrudEditForm.propTypes = {
    title: PropTypes.string,
    item: PropTypes.instanceOf(Model).isRequired,
    fields: PropTypes.arrayOf(PropTypes.shape({

        type: PropTypes.string,
        name: PropTypes.string.isRequired,
        label: PropTypes.string,
        placeholder: PropTypes.string,
        value: PropTypes.oneOfType([
            PropTypes.string,
            PropTypes.number,
            PropTypes.bool,
        ]),
        options: PropTypes.arrayOf(PropTypes.shape({
            id: PropTypes.number.isRequired,
            name: PropTypes.string,
        })),
        col: PropTypes.number,
        required: PropTypes.bool,

    })).isRequired,
    mode: PropTypes.oneOf(['edit', 'create']),
    serialize: PropTypes.bool,
    onChange: PropTypes.func,
    onClickEdit: PropTypes.func,
    onBeforeSave: PropTypes.func,
    onSaved: PropTypes.func,
};

export default CrudEditForm;
