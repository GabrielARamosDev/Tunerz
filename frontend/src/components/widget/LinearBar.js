import React from 'react';
import PropTypes from 'prop-types';

import Stack from '@mui/material/Stack';
import LinearProgress from '@mui/material/LinearProgress';

const LinearBar = ({
    valor = 0,
    barcolor,
    sx = {},
}) => (
    <Stack
        sx={{
            px: 2,
            ...sx,
        }}
    >
        <LinearProgress
            variant="determinate"
            value={valor}
            sx={{
                width: '100%',
                height: 22,
                borderRadius: 50,
                '& .MuiLinearProgress-bar':
                    { background: (theme) => theme.palette.other.gradient[barcolor] },
                '& .MuiLinearProgress-bar1Determinate': { borderRadius: 50 },
            }}
        />
    </Stack>
);

LinearBar.propTypes = {
    valor: PropTypes.number,
    barcolor: PropTypes.string,
    sx: PropTypes.instanceOf(Object),
};

export default LinearBar;
