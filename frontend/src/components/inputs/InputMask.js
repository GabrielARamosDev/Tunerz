import React from 'react';

import PropTypes from 'prop-types';

import { IMaskInput } from 'react-imask';

const InputMask = React.forwardRef((props, ref) => {
    const {
        name, type, mask = '', onChange, ...other
    } = props;

    const temp = mask != '' ? mask : name;

    let _mask = '';
    let definitions = {};

    switch (temp) {
        case 'telefone': {
            _mask = '(##) 90000-0000';
            definitions = { '#': /[1-9]/ };
            break;
        }
        case 'cep': {
            _mask = '00000-000';
            break;
        }
        case 'cpf': {
            _mask = '000.000.000-00';
            break;
        }
        case 'cnpj': {
            _mask = '00.000.000/0001-00';
            break;
        }
        case 'oab': {
            _mask = '@@000000';
            definitions = { '@': /[a-z/A-Z]/ };
            break;
        }
    }

    switch (type) {
        case 'input':
        case 'password':
        case 'description': return (
            <IMaskInput
                {...other}
                {..._mask != '' && { mask: _mask }}
                definitions={definitions}
                inputRef={ref}
                onAccept={(value) => onChange({ target: { name, value } })}
                overwrite
            />
        );
    }
});

InputMask.propTypes = {
    name: PropTypes.string.isRequired,
    type: PropTypes.string.isRequired,
    mask: PropTypes.string,
    onChange: PropTypes.func.isRequired,
};

export default InputMask;
