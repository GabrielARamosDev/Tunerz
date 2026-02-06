import React from 'react';
import PropTypes from 'prop-types';

// import Paper from '@mui/material/Paper';
import Stack from '@mui/material/Stack';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import Stepper from '@mui/material/Stepper';
import Step from '@mui/material/Step';
import StepLabel from '@mui/material/StepLabel';
import Typography from '@mui/material/Typography';

import { useTheme } from '@mui/material';

import ColorlibConnector from './components/ColorlibConnector';
import ColorlibStepIcon from './components/ColorlibStepIcon';

const groupings = [
    {
        grid: 3,
        width: 124.5,
        margin: '0 0 0 0',
        spacing: 70,
        text: 'Aquecimento',
        color: 'green',
        colorMode: 'dark',
    },
    {
        grid: 3,
        width: 146,
        margin: '0 0 0 -8.5px',
        spacing: 60,
        text: 'Pontapé Inicial',
        color: 'vibrant-blue',
        colorMode: 'main',
    },
    {
        grid: 3,
        width: 67,
        margin: '0 0 0 -8.5px',
        spacing: 99,
        text: 'Jogo',
        color: 'teal',
        colorMode: 'main',
    },
    {
        grid: 2,
        width: 97.5,
        margin: '0 0 0 0',
        spacing: 23,
        text: 'Mesa Redonda',
        color: 'green',
        colorMode: 'main',
    },
];

const WidgetStep = ({
    widgetValue,
    options = {},
}) => {
    const theme = useTheme();

    const {
        escola = null,
        status_all: statusAll,
        invalid,
        message,
    } = widgetValue;

    return (
        <Stack variant="widget-v1" >
            <Stack
                direction="row"
                alignItems="center"
            >
                <Typography
                    variant="h2"
                    className="title"
                >
                    {'Evolução do CT:'}
                </Typography>

                {escola && (
                    <Typography
                        variant="h2"
                        color="secondary"
                        sx={{ margin: '12px -5px 24px' }}
                    >
                        <b>{escola.nome}</b>
                    </Typography>
                )}
            </Stack>

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
                    <Box sx={{ overflowX: 'auto' }}>
                        <Stack
                            direction="row"
                            justifyContent="space-between"
                            sx={{
                                width: 1367.5,
                                mx: 8.25,
                                pt: .75,
                            }}
                        >
                            {groupings.map((group) => (
                                <Grid
                                    key={`WidgetStep-${group.text}`}
                                    xs={group.grid}
                                    sx={{ margin: group.margin }}
                                >
                                    <Stack direction="row">
                                        <Box
                                            sx={{
                                                width: group.spacing,
                                                height: 35,
                                                borderTop: `3px solid ${theme.palette[group.color][group.colorMode]}`,
                                                borderLeft: `3px solid ${theme.palette[group.color][group.colorMode]}`,
                                            }}
                                        />
                                        <Box
                                            sx={{ width: group.width }}
                                            mt={-.575}
                                        >
                                            <Typography
                                                color="primary"
                                                sx={{
                                                    fontSize: 16,
                                                    fontWeight: 700,
                                                    textAlign: 'center',
                                                }}
                                            >
                                                {group.text.toUpperCase()}
                                            </Typography>
                                        </Box>
                                        <Box
                                            sx={{
                                                width: group.spacing,
                                                height: 35,
                                                borderTop: `3px solid ${theme.palette[group.color][group.colorMode]}`,
                                                borderRight: `3px solid ${theme.palette[group.color][group.colorMode]}`,
                                            }}
                                        />
                                    </Stack>
                                </Grid>
                            ))}
                        </Stack>

                        <Stepper
                            alternativeLabel
                            activeStep={escola.status_atual - 1}
                            /** As linhas de conexão entre cada 'step' */
                            connector={<ColorlibConnector />}
                            sx={{
                                width: 1500,
                                pt: .875,
                                pb: .75,
                            }}
                        >
                            {statusAll.map((step) => (
                                <Step
                                    key={`WidgetStep-${step.id}`}
                                    sx={{ ml: 1, mr: 1 }}
                                >
                                    <StepLabel
                                        active={(escola.status_atual === step.id)}
                                        completed={(escola.status_atual > step.id)}
                                        /** As bolinhas de cada 'step' */
                                        StepIconComponent={ColorlibStepIcon}
                                        StepIconProps={{
                                            icon: step.icon ?? null,
                                            color: step.color,
                                            colorMode: step.colorMode,
                                            gradient: false,
                                        }}
                                    >
                                        {step.name}
                                    </StepLabel>
                                </Step>
                            ))}
                        </Stepper>
                    </Box>
                )
            }
        </Stack>
    );
};

WidgetStep.propTypes = {
    widgetValue: PropTypes.instanceOf(Object).isRequired,
    options: PropTypes.instanceOf(Object),
};

export default WidgetStep;
