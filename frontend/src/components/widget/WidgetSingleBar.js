import React from 'react';
import PropTypes from 'prop-types';
import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import LinearBar from './LinearBar';

const WidgetSingleBar = ({ widgetValue }) => {
    /**
     * const Exemplo de objeto a ser passado por parâmetro:
     * {enunciado: 'Testando 6 7 8', valor: 44, texto: 'Para completar os widgets'};
     */

    const { enunciado, texto, valor } = widgetValue;

    const newValue = valor * 100;

    return (
        <Stack direction="column" >
            <Typography
                variant="h2"
                color="primary"
                sx={{
                    ml: 8,
                    mt: 1.5,
                    mb: 1,
                }}
            >
                {enunciado}
            </Typography>

            <Typography
                variant="h1"
                sx={{
                    background: (theme) => theme.palette.other.gradient.yellow,
                    WebkitBackgroundClip: 'text',
                    WebkitTextFillColor: 'transparent',
                    fontSize: 40,
                    fontWeight: '900',
                    alignSelf: 'center',
                    mb: 3,
                }}
            >
                {`${newValue.toFixed(2)?.toString()}%`}
            </Typography>
            <LinearBar valor={newValue} />

            <Typography
                variant="h3"
                color="primary"
                sx={{
                    fontWeight: '700',
                    textAlign: 'center',
                    flexWrap: 'wrap',
                    alignSelf: 'center',
                    mt: 3.5,
                    ml: 13.5,
                    mr: 13.5,
                    mb: 2,
                }}
            >
                {texto}
            </Typography>
        </Stack>
    );
};

WidgetSingleBar.propTypes = {
    // options: PropTypes.instanceOf(Object),
    widgetValue: PropTypes.instanceOf(Object).isRequired,
};

export default WidgetSingleBar;
