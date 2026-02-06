import React, { useState } from 'react';
import PropTypes from 'prop-types';

import Box from '@mui/material/Box';
import Paper from '@mui/material/Paper';

import { useTheme } from '@mui/material';
import Button from '@mui/material/Button';
import Collapse from '@mui/material/Collapse';
import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import Icon from '@mui/material/Icon';

const Filter = ({
    title = 'Filtros',
    children,
    variant,
    ...props
}) => {
    const theme = useTheme();

    const [open, setOpen] = useState(false);

    return (
        <Paper
            {...props}
            color={variant}
            sx={{ mb: '20px' }}
        >
            <Button
                size="large"
                onClick={() => setOpen(!open)}
                fullWidth
            >
                <Box
                    sx={{
                        ...theme.customized.layout.flex.ACenter_JBetween,
                        width: '100%',
                    }}
                >
                    <Typography
                        variant="h3"
                        className="text-start"
                        sx={{ lineHeight: '130%' }}
                    >{title}
                    </Typography>
                    <Icon sx={{ ...open && theme.customized.layout.rotate['180'] }} >
                        <img src="/img/icons/arrow_down.png" />
                    </Icon>
                </Box>
            </Button>

            <Collapse
                in={open}
                sx={{ px: '10px' }}
            >
                <Stack>
                    {children}
                </Stack>
            </Collapse>
        </Paper>
    );
};

Filter.propTypes = {
    title: PropTypes.string,
    children: PropTypes.any.isRequired,
    variant: PropTypes.string.isRequired,
};

export default Filter;
