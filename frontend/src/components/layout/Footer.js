import React from 'react';

import { useTheme } from '@mui/material';
import AppBar from '@mui/material/AppBar';
import Typography from '@mui/material/Typography';

import useFooterConfig from '../../hooks/useFooterConfig';

const Footer = () => {
    const theme = useTheme();

    const { footerBarHeight: height } = useFooterConfig();

    return (
        <AppBar
            position="fixed"
            component="footer"
            variant="footer"
            sx={{
                ...theme.customized.layout.flex.ACenter_JEnd,
                height,
            }}
        >
            <Typography
                sx={{ textAlign: 'end' }}
                color="white"
            >Powered by <b>Instituto Vini Jr.</b>
            </Typography>
        </AppBar>
    );
};

export default Footer;
