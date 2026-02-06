import React from 'react';
import PropTypes from 'prop-types';

import { Pie } from 'react-chartjs-2';

import Typography from '@mui/material/Typography';
import Stack from '@mui/material/Stack';

// import useWindowWidth from '../../hooks/useWindowWidth';

const WidgetPie = ({ widgetValue /* , options */ }) => {
    // const windowWidth = useWindowWidth();

    const { labels, datasets, message = '' } = widgetValue;

    const pieData = {
        labels,
        datasets,
    };
    // console.log('pie data: ', pieData);

    // const sizeMultiplier = .049479 * options.largura; /* .17875 .049479 */
    // const size = windowWidth * sizeMultiplier;

    return (
        <Stack variant="widget-v1" >
            <Typography
                variant="h2"
                className="title"
            >
                Distribuição de alunos por ano escolar:
            </Typography>

            {pieData.datasets[0].data.every((val, i, arr) => val === arr[0])
                ? (
                    <Typography
                        variant="h3"
                        className="no-wgt-msg"
                    >
                        {message}
                    </Typography>
                )
                : (
                    <Stack
                        sx={{
                            maxHeight: 400,
                            mx: 3.5,
                            mt: -8.5,
                            mb: -7.75,
                            alignItems: 'center',
                        }}
                    >
                        <Pie
                            data={pieData}
                            options={widgetValue.newOptions}
                        />
                    </Stack>
                )
            }
        </Stack>
    );
};

WidgetPie.propTypes = {
    widgetValue: PropTypes.object.isRequired,
    options: PropTypes.object.isRequired,
};

export default WidgetPie;
