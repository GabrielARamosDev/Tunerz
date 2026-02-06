import React from 'react';

import PropTypes from 'prop-types';

import { Link/* , useNavigate*/ } from 'react-router-dom';

// import { useTheme } from '@mui/material';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';

const FormSubmitButton = ({
    id,
    label = 'Cadastrar',
    isLink = false,
    href = '',
    isDirty = true,
    onCancel = () => null,
    ...props
}) =>

// const theme = useTheme();
// const navigate = useNavigate();

    (
        <Box
            display="flex"
            sx={{ justifyContent: 'end', ...props.sx }}
        >
            {!isLink && (
                <React.Fragment>
                    <Button
                        variant="outlined"
                        color="error"
                        sx={{ mr: '24px' }}
                        onClick={onCancel}
                    >
                        Cancelar
                    </Button>

                    <Button
                        variant="contained"
                        color="success"
                        type="submit"
                        disabled={!isDirty}
                    >
                        {id == 0
                            ? label
                            : 'Salvar'
                        }
                    </Button>
                </React.Fragment>
            )}

            {isLink && (
                <Link to={href} >
                    <Button variant="link" >
                        {label}
                    </Button>
                </Link>
            )}
        </Box>
    )
;

FormSubmitButton.propTypes = {
    id: PropTypes.number.isRequired,
    label: PropTypes.string,
    isLink: PropTypes.bool,
    href: PropTypes.string,
    isDirty: PropTypes.bool,
    onCancel: PropTypes.func,
    sx: PropTypes.object,
};

export default FormSubmitButton;
