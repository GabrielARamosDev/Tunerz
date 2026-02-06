import React from 'react';
import PropTypes from 'prop-types';
import { Stack, Typography } from '@mui/material';
import WidgetCircular from './WidgetCircular';

const WidgetCircularTextSide = ({ widgetValue, options }) => {
    
    const { texto } = widgetValue;

    return (
        <Stack
            direction="row"
            sx={{ justifyContent: 'space-evenly' }}
        >
            <WidgetCircular
                widgetValue={widgetValue}
                options={{
                    size: 192,
                    color: 'green',
                }}
            />

            <Typography
                variant="h3"
                color="primary"
                sx={{
                    flexWrap: 'wrap',
                    alignSelf: 'center',
                    mx: 8,
                }}
            >
                {texto}
            </Typography>
        </Stack>
    );
};

WidgetCircularTextSide.propTypes = {
    options: PropTypes.object.isRequired,
    widgetValue: PropTypes.object,
};

export default WidgetCircularTextSide;
