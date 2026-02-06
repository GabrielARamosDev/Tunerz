import React from 'react';
import PropTypes from 'prop-types';

import { Typography, Stack } from '@mui/material';

import WidgetImageTextSide from './WidgetImageTextSide';

import useWindowWidth from '../../hooks/useWindowWidth';

const WidgetReportHour = ({ widgetValue }) => {
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
                    <WidgetImageTextSide
                        widgetValue={widgetValue}
                        options={{ size: windowWidth * .17875, color: 'yellow' }}
                    />
                )}
        </Stack>
    );
};

WidgetReportHour.propTypes = { widgetValue: PropTypes.object.isRequired };

export default WidgetReportHour;
