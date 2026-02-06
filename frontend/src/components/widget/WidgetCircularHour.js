import React from 'react';
import PropTypes from 'prop-types';

import { Typography, Stack } from '@mui/material';

import WidgetCircular from './WidgetCircular';

import useWindowWidth from '../../hooks/useWindowWidth';

const WidgetCircularHour = ({ widgetValue }) => {
    const { invalid, message } = widgetValue;

    const windowWidth = useWindowWidth();

    return (
        <Stack variant="widget-v1" >
            <Typography
                variant="h2"
                className="title"
            >
                Horas Gerais
            </Typography>

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
                    <WidgetCircular
                        widgetValue={widgetValue}
                        options={{ size: windowWidth * .17875, color: 'yellow' }}
                    />
                )}
        </Stack>
    );
};

WidgetCircularHour.propTypes = { widgetValue: PropTypes.object.isRequired };

export default WidgetCircularHour;
