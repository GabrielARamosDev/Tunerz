/* eslint-disable react/no-array-index-key */
/* eslint-disable react/no-multi-comp */

import React from 'react';
import PropTypes from 'prop-types';
import {
    Stack,
    Box,
    Typography,
    Grid,
} from '@mui/material';
import LinearBar from './LinearBar';

const DEFAULT_BAR = [100, 75, 50];

const MedalColumn = ({
    image, texto, quantity, defaultBar,
}) => (
    <Grid
        item
        xs={12}
        md={4}
        sm={2}
        sx={{
            alignContent: 'center',
            mb: 2.33,
        }}
    >
        <Stack sx={{ position: 'relative', mb: 2 }}>
            <Box
                component="img"
                variant="rounded"
                sx={{
                    maxHeight: '70px',
                    alignSelf: 'center',
                }}
                src={image}
            />
            {quantity >= 0
                && (
                    <Box
                        sx={{
                            position: 'absolute',
                            top: '-17.5%',
                            right: '10%',
                            zIndex: 500,
                            background: (theme) => theme.palette.other.gradient.green,
                            borderRadius: 90,
                        }}
                    >
                        <Typography
                            variant="h1"
                            sx={{
                                width: 40,
                                height: 40,
                                fontSize: 25,
                                fontWeight: '900',
                                textAlign: 'center',
                                lineHeight: 1.7,
                            }}
                        >
                            {quantity}
                        </Typography>
                    </Box>
                )}
        </Stack>

        <Typography
            variant="h3"
            sx={{
                fontWeight: '400',
                fontSize: 17,
                textAlign: 'center',
                mb: .75,
            }}
        >
            {texto.toUpperCase()}
        </Typography>

        {/* Barras de 'percentual requerido' p/ cada medalha */}
        {/* <Stack sx={{
            position: 'relative',
            alignItems: 'center',
            justifyContent: 'center',
            ml: 3,
            mr: 3,
        }}
        >
            <LinearBar
                valor={defaultBar}
                barcolor="green"
                sx={{ p: 0 }}
            />
            <Typography
                variant="h3"
                sx={{
                    fontWeight: '900',
                    fontSize: 17,
                    textAlign: 'center',
                    color: '#FFF',
                    position: 'absolute',
                }}
            >
                {defaultBar.toString()}%
            </Typography>
        </Stack> */}
    </Grid>
);

MedalColumn.propTypes = {
    image: PropTypes.string,
    texto: PropTypes.string,
    quantity: PropTypes.number,
    defaultBar: PropTypes.number,
};

const WidgetMedals = ({ widgetValue }) => {
    console.log('WidgetMedals widgetValue', widgetValue);

    const { ouro, prata, bronze } = widgetValue;

    const DEFAULT_VALUES = [
        {
            texto: 'OURO',
            quantity: ouro || 0,
            image: '/img/icons/ouro.png',
        },
        {
            texto: 'PRATA',
            quantity: prata || 0,
            image: '/img/icons/prata.png',
        },
        {
            texto: 'BRONZE',
            quantity: bronze || 0,
            image: '/img/icons/bronze.png',
        },
    ];

    return (
        <>
            <Typography
                variant="h2"
                sx={{
                    color: '#FFF',
                    mt: 1.87,
                    ml: 3,
                    mb: 3.75,
                }}
            >
                Medalhas da Temporada
            </Typography>
            <Grid
                container
                spacing={0}
            >
                {(DEFAULT_VALUES || [])?.map((medal, index) => (
                    <MedalColumn
                        key={`WidgetMedals-medal-${index}`}
                        image={medal.image}
                        texto={medal.texto}
                        quantity={medal.quantity}
                        defaultBar={DEFAULT_BAR[index]}
                    />
                ))}
            </Grid>
        </>
    );
};

WidgetMedals.propTypes = { widgetValue: PropTypes.object.isRequired };

export default WidgetMedals;
