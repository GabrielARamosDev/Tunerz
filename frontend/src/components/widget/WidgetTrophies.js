import React from 'react';
import PropTypes from 'prop-types';

import {
    Stack, Box, Typography, Grid, Paper,
} from '@mui/material';

const WidgetTrophies = ({ widgetValue }) => {
    const DEFAULT_VALUES = [
        {
            liga: 'Regional',
            bimestre: '1º',
            image: '/img/icons/1bim.png',
            status: widgetValue.regional === 1,
        },
        {
            liga: 'Nacional',
            bimestre: '2º',
            image: '/img/icons/2bim.png',
            status: widgetValue.nacional === 1,
        },
        {
            liga: 'Continental',
            bimestre: '3º',
            image: '/img/icons/3bim.png',
            status: widgetValue.continental === 1,
        },
        {
            liga: 'Mundial',
            bimestre: '4º',
            image: '/img/icons/4bim.png',
            status: widgetValue.mundial === 1,
        },
    ];

    const done = '/img/icons/trophyDone.png';

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
                Troféus da Temporada
            </Typography>

            <Grid
                container
                spacing={2}
            >
                {(DEFAULT_VALUES || [])?.map((data) => {
                    const {
                        image, liga, bimestre, status,
                    } = data;

                    return (
                        <Grid
                            key={`WidgetTrophies-${data.bimestre}`}
                            item
                            xs={12}
                            sm={12}
                            md={3}
                            sx={{
                                alignContent: 'center',
                                mb: 2,
                            }}
                        >
                            <Stack
                                sx={{
                                    position: 'relative',
                                    justifyContent: 'end',
                                    mb: 2,
                                }}
                            >
                                <Box
                                    component="img"
                                    variant="rounded"
                                    sx={{
                                        maxHeight: '70px',
                                        alignSelf: 'center',
                                    }}
                                    src={image}
                                />
                                {status && (
                                    <Box
                                        component="img"
                                        variant="rounded"
                                        sx={{
                                            width: 40, // 60,
                                            height: 40, // 60,
                                            position: 'absolute',
                                            alignSelf: 'flex-end',
                                            mr: 3,
                                            zIndex: 500,
                                        }}
                                        src={done}
                                    />
                                )}
                            </Stack>
                            <Typography
                                variant="h3"
                                sx={{
                                    fontWeight: '400',
                                    fontSize: 17,
                                    textAlign: 'center',
                                    whiteSpace: 'break-spaces',
                                    mb: 1.25,
                                }}
                            >
                                {liga}
                            </Typography>
                            <Typography
                                variant="h3"
                                sx={{
                                    fontWeight: '400',
                                    fontSize: 14,
                                    textAlign: 'center',
                                    whiteSpace: 'break-spaces',
                                }}
                            >
                                {`${bimestre.toUpperCase()} Bimestre`}
                            </Typography>
                        </Grid>
                    );
                })}
            </Grid>
        </>
    );
};

WidgetTrophies.propTypes = { widgetValue: PropTypes.object.isRequired };

export default WidgetTrophies;
