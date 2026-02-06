import React from 'react';
import PropTypes from 'prop-types';

import {
    Grid,
    CircularProgress,
    Stack,
    Typography,
} from '@mui/material';

import getMonth from '../../utils/DateTime/getMonth';

const WidgetImageTextSide = ({
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
        valor, valorTexto, valorMax = 1, valorMes,
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
                    {/* {`(${getMonth(valorMes)})`} */}
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
                        sx={{
                            m: 'auto',
                            // mt: 2,
                            alignItems: 'center',
                            justifyContent: 'space-evenly',
                        }}
                    >
                        <Stack
                            direction="row"
                            sx={{
                                mb: 2,
                                alignItems: 'center',
                            }}
                        >
                            <Stack>
                                <img
                                    alt="horas trabalhadas"
                                    src="/img/icons/ball_report.png"
                                />
                            </Stack>

                            <Stack
                                direction="row"
                                sx={{ ml: 2.5 }}
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
                                        fontSize: 62,
                                        fontWeight: 900,
                                        fontStyle: 'italic',
                                        pr: 0.5,
                                    }}
                                >
                                    {valorTexto}
                                </Typography>
                            </Stack>
                        </Stack>

                        {texto && (
                            <Typography
                                variant="h3"
                                color="primary"
                                sx={{
                                    m: 1,
                                    flexWrap: 'wrap',
                                    alignSelf: 'center',
                                    textAlign: 'center',
                                    whiteSpace: 'break-spaces',
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

WidgetImageTextSide.propTypes = {
    widgetValue: PropTypes.object.isRequired,
    options: PropTypes.object,
};

export default WidgetImageTextSide;
