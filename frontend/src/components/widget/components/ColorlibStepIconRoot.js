// import React from 'react';
// import PropTypes from 'prop-types';

import { styled } from '@mui/material/styles';

const ColorlibStepIconRoot = styled('div')(({
    ownerState,
    theme,
    color = 'yellow',
    colorMode = 'main',
    gradient = true,
}) => ({
    backgroundColor: theme.palette.mode === 'dark' ? theme.palette.common.gray['700'] : '#ccc',
    zIndex: 1,
    color: theme.palette.common.white,
    width: 45,
    height: 45,
    display: 'flex',
    borderRadius: '50%',
    justifyContent: 'center',
    alignItems: 'center',
    ...ownerState.active && { // 136deg
        background: gradient ? theme.palette.other.gradient[color] : theme.palette[color][colorMode],
        boxShadow: `0 0 6.5px 2.25px ${theme.palette[color][colorMode]}`,
    },
    ...ownerState.completed && { // 136deg
        background: gradient ? theme.palette.other.gradient[color] : theme.palette[color][colorMode],
    },
}));

export default ColorlibStepIconRoot;
