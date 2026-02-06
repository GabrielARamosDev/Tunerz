import _ from 'lodash';

import React from 'react';
import PropTypes from 'prop-types';

import { Box, Stack, Typography } from '@mui/material';

const WidgetKpi = ({ options, widgetValue }) => {

    const { icone, titulo } = options;

    return (
        <>
            {_.isEmpty(icone) || icone === 'none'
                ? (
                    <Stack
                        direction="row"
                        alignItems="center"
                        justifyContent="space-between"
                        px={2}
                        py={2.4375}
                    >
                        <Typography
                            variant="h2"
                            sx={{ lineHeight: '24px' }}
                        >
                            {titulo}
                        </Typography>
                        <Typography
                            variant="h2"
                            sx={{
                                fontSize: 64,
                                fontWeight: 800,
                                fontStyle: 'italic',
                            }}
                        >
                            {widgetValue.valor}
                        </Typography>
                    </Stack>
                )
                : (
                    <Stack
                        direction="row"
                        justifyContent="space-between"
                        sx={{
                            mt: 1.25,
                            ml: .875,
                            mr: .875,
                            alignContent: 'center',
                        }}
                    >
                        <Stack alignItems="baseline">
                            <Typography variant="h2" >
                                {titulo}
                            </Typography>
                            <Typography
                                variant="h2"
                                sx={{
                                    fontSize: 36,
                                    fontWeight: 900,
                                    fontStyle: 'italic',
                                    mt: 4.25,
                                    mb: .75,
                                }}
                            >
                                {widgetValue.valor}
                            </Typography>
                        </Stack>

                        <Box
                            component="img"
                            variant="rounded"
                            sx={{
                                maxWidth: '30%',
                                mt: 3,
                                alignSelf: 'center',
                            }}
                            src={`${icone}`}
                        />
                    </Stack>
                )
            }
        </>
    );
};

WidgetKpi.propTypes = {
    options: PropTypes.object.isRequired,
    widgetValue: PropTypes.object,
};

export default WidgetKpi;
