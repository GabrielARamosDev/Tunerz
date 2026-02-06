import React from 'react';
import PropTypes from 'prop-types';
import {
    Grid, CircularProgress, Stack, Typography,
} from '@mui/material';

const WidgetCircular = ({
    widgetValue,
    options = {
        cor: '',
        corItem: '',
        dashboard: 'cts',
        icone: '',
        largura: 6,
        titulo: 'Horas Gerais',
        type: 'circular',
        url: 'hours',
    },
}) => {
    // console.log('widgetValue: ', widgetValue);
    // console.log('options: ', options);

    const {
        valor, valorTexto, valorMax = 1,
        texto, message = '', invalid = false,
    } = widgetValue;

    return (
        <Stack variant="widget-v1" >
            {options.titulo && (
                <Typography
                    variant="h2"
                    className="title"
                >
                    {options.titulo}
                </Typography>
            )}
            {invalid
                ? (
                    <Typography
                        variant="h3"
                        className="no-wgt-msg"
                    >
                        {message}
                    </Typography>
                )
                : (
                    <Stack
                        direction="row"
                        justifyContent="space-evenly"
                    >
                        <Grid style={{ position: 'relative', display: 'inline-flex' }}>
                            <CircularProgress
                                variant="determinate"
                                value={100}
                                thickness={6.5}
                                size={!texto ? 240 : 160}
                                sx={{
                                    color: (theme) => theme.palette.other.low[options.cor],
                                    position: 'relative',
                                    mx: 1,
                                    my: 1.333,
                                }}
                            />
                            <CircularProgress
                                variant="determinate"
                                value={parseFloat(valor) * 100 / parseFloat(valorMax)}
                                thickness={6.5}
                                size={!texto ? 240 : 160}
                                sx={{
                                    color: (theme) => theme.palette[options.cor].main,
                                    position: 'absolute',
                                    strokeLinecap: 'round',
                                    mx: 1,
                                    my: 1.333,
                                }}
                            />

                            <Stack
                                direction="row"
                                sx={{
                                    position: 'absolute',
                                    top: '50%',
                                    left: '50%',
                                    transform: 'translate(-50%, -50%)',
                                }}
                            >
                                <Typography
                                    variant="h3"
                                    sx={{
                                        background: (theme) => theme
                                            .palette
                                            .other
                                            .gradient[options.cor],
                                        WebkitBackgroundClip: 'text',
                                        WebkitTextFillColor: 'transparent',
                                        fontSize: texto ? 28 : 42,
                                        fontWeight: 900,
                                        fontStyle: 'italic',
                                        pr: 0.5,
                                    }}
                                >
                                    {valorTexto}
                                    {/* {`${(valor * 100).toFixed(2)?.toString()}%`} */}
                                </Typography>

                                {/* <Typography
                                    variant="h3"
                                    sx={{
                                        background: (theme) => theme
                                            .palette
                                            .other
                                            .gradient[options.cor],
                                        WebkitBackgroundClip: 'text',
                                        WebkitTextFillColor: 'transparent',
                                        fontSize: 32, // options.size / 4.33,
                                        fontWeight: 900,
                                        fontStyle: 'italic',
                                        pr: 0.5,
                                    }}
                                >
                                    {isHour ? 'h' : '%'}
                                </Typography> */}
                            </Stack>
                        </Grid>
                        {texto && (
                            <Typography
                                variant="h3"
                                color="primary"
                                sx={{
                                    flexWrap: 'wrap',
                                    alignSelf: 'center',
                                    // ml: 1,
                                    whiteSpace: 'break-spaces',
                                    textAlign: 'center',
                                }}
                            >
                                {texto}
                            </Typography>
                        )}
                    </Stack>
                )}

        </Stack>

    );
};

WidgetCircular.propTypes = {
    widgetValue: PropTypes.instanceOf(Object).isRequired,
    options: PropTypes.instanceOf(Object),
};

export default WidgetCircular;
