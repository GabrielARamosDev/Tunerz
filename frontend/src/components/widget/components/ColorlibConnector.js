// import React from 'react';
// import PropTypes from 'prop-types';

import { styled } from '@mui/material/styles';

import StepConnector, { stepConnectorClasses } from '@mui/material/StepConnector';

const ColorlibConnector = styled(StepConnector)(({ theme }) => ({
    [`&.${stepConnectorClasses.alternativeLabel}`]: {
        top: 19,
        left: 'calc(-50% - 5.5px)',
    },
    [`&.${stepConnectorClasses.active}`]: {
        [`& .${stepConnectorClasses.line}`]: { // 95deg
            background: theme.palette.primary.main,
        },
    },
    [`&.${stepConnectorClasses.completed}`]: {
        [`& .${stepConnectorClasses.line}`]: { // 95deg
            background: theme.palette.primary.main,
        },
    },
    [`& .${stepConnectorClasses.line}`]: {
        height: 7,
        border: 0,
        backgroundColor: theme.palette.mode === 'dark'
            ? theme.palette.common.gray['800']
            : '#eaeaf0',
        borderRadius: 1,
    },
}));

export default ColorlibConnector;
