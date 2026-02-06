import React from 'react';
import PropTypes from 'prop-types';

import FormInput from '../inputs/FormInput';
import FormSubmitButton from './FormSubmitButton';

import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import Paper from '@mui/material/Paper';
import Model from '../../contracts/Model';

const ModelForm = ({
    title = '',
    item,
    model = null,
    id = 0,
    mode = 'create',
    onChange = () => null,
    onClickEdit = () => null,
    onBeforeSave = () => null,
    onSaved = () => null,
}) => {

    const {
        setData,
        save,
        isDirty,
    } = item?.useData();

    const form = useForm({
        initialValues: {
            ...item?.attributes,
        },
        onSubmit: (data) => {
            console.log(data);

            setData(data);
            save().then(() => {

            });
        }
    });
    // console.log('form data: ', form.data);

    React.useEffect(() => {
        setData(item?.attributes);
    }, [item, setData]);

    // const FIELDS = React.useMemo(() => model.getFormFields({
        
    // }), [
        
    // ]);

    return (
        <Paper sx={{ mt: 1.5, p: '17px 20px' }} >
            <Stack>
                <Typography
                    variant="h2"
                    color="primary"
                    sx={{ mb: 2 }}
                >
                    Editar Função
                </Typography>

                <Box
                    component="form"
                    onSubmit={form.handleSubmit}
                >
                    {/* input .map goes here */}
                    {/* 
                    <Input
                        form={form}
                        name={}
                        label={}
                        placeholder={}
                        col={}
                        required={}
                        disabled={}
                    /> 
                    */}

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
}

ModelForm.propTypes = {
    title: PropTypes.string,
    item: PropTypes.instanceOf(Model).isRequired,
    model: PropTypes.instanceOf(Model),
    id: PropTypes.number,
    mode: PropTypes.oneOf(['edit', 'create']),
    onChange: PropTypes.func,
    onClickEdit: PropTypes.func,
    onBeforeSave: PropTypes.func,
    onSaved: PropTypes.func,
};

export default ModelForm;
