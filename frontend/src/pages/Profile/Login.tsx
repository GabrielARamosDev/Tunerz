/* eslint-disable quotes */
/* eslint-disable react/no-unescaped-entities */

import React from 'react';
import PropTypes from 'prop-types';

import { connect } from 'react-redux';

import { Outlet } from 'react-router-dom';

import NavMenu from '../../components/layout/NavMenu.tsx';

import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Stack from '@mui/material/Stack';
import Toolbar from '@mui/material/Toolbar';

import Loading from '../../components/loading.tsx';

import NotificationBar from '../../components/dialog/NotificationBar.tsx';
import DialogBar from '../../components/dialog/DialogBar.tsx';
import Footer from '../../components/layout/Footer.tsx';

import dialog from '../../controllers/dialog/index.ts';
import auth from '../../controllers/auth/index.ts';

import type { Layout as LayoutType } from '../../types/layout.ts';
import type { State as StateType } from '../../types/state.ts';

import { useApp } from "../../contexts/AppContext.tsx";

const LoginLayout = ({ currentPage }: LayoutType) => {

    const {
        theme, appBarHeight,
        footerWindowDiff,
        renderPageTitle
    } = useApp();

    return (
        <Stack>
            Login
        </Stack>
    );

};

LoginLayout.propTypes = { currentPage: PropTypes.object.isRequired };

const mapStateToProps = (state: StateType) => ({ currentPage: state.currentPage });

export default connect(mapStateToProps)(LoginLayout);
