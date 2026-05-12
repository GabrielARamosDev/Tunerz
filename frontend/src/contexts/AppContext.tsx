/* eslint-disable quotes */
/* eslint-disable react/no-unescaped-entities */

import api from "../services/api";
import main from "../main.tsx";

import { useNavigate } from "react-router-dom";
import { createContext, useContext } from "react";
import type { ReactNode } from "react";

import type { App as AppContextType } from "../types/app";

import React from 'react';
import PropTypes from 'prop-types';

import { useSelector } from 'react-redux';

import { useMediaQuery } from 'react-responsive';

import { useTheme } from '@mui/material';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';

import Loading from '../components/loading.tsx';

import useWindowWidth from '../hooks/useWindowWidth.ts';
import useWindowHeight from '../hooks/useWindowHeight.ts';
import useFooterConfig from '../hooks/useFooterConfig.ts';

import dialog from '../controllers/dialog';
import auth from '../controllers/auth';

import type { State as StateType } from '../types/state.ts';
import type { Theme as ThemeType } from '../types/style.ts';

const NAV_BAR_WIDTH = 300;
const NAV_BAR_WIDTH_MOBILE = 250;

const APP_BAR_HEIGHT = 64;
const APP_BAR_HEIGHT_MOBILE = 56;

// Contexto em si
const AppContext = createContext<AppContextType | undefined>(undefined);

// Provider
export const AppProvider = ({ children }: { children: ReactNode }) => {

    /* =========================== State ============================ */

    const user = useSelector((state: StateType) => state.app.user);

    const authenticated = useSelector((state: StateType) =>
        state.app.user !== null
        && state.app.user?.id !== null
        && state.app.user?.status !== 'unauthenticated'
    );

    const currentPage = useSelector((state: StateType) => {

        const c_p = state.currentPage;

        if (c_p === null || c_p.name === 'root') {

        }

        return c_p;
    });

    const filters = useSelector((state: StateType) => {

        const temp: any = {};

        currentPage.filters.forEach((filter: any) => {
            temp[filter] = state.filter[filter];
        });

        return temp;
    });

    /* ============================================================== */

    const navigateHook = useNavigate();

    const [loading, setLoading] = React.useState(true);
    const [fetched, setFetched] = React.useState(false);

    const [status, setStatus] = React.useState("Carregando Garagem...");

    /* ============================================================== */

    const theme: ThemeType = useTheme();

    const isTablet = useMediaQuery({ query: '(min-width: 768px)' });
    const windowWidth = useWindowWidth();
    const windowHeight = useWindowHeight();

    // const { collapseSidebar } = useProSidebar();
    const [drawerOpen, setDrawerOpen] = React.useState(false);

    const [popAnchorEl, setPopAnchorEl] = React.useState(null);
    const popOpen = Boolean(popAnchorEl);

    const { footerBarHeight, footerWindowDiff } = useFooterConfig();

    const navBarWidth = isTablet ? NAV_BAR_WIDTH : NAV_BAR_WIDTH_MOBILE;
    const appBarHeight = isTablet ? APP_BAR_HEIGHT : APP_BAR_HEIGHT_MOBILE;

    /* ============================================================== */

    const navigate = React.useCallback((path: string) => {

        const _route = `/${path}`;

        main.state.dispatch({
            type: 'CURRENT_PAGE',
            payload: {
                name: path,
                title: '',
                icon: '',
                route: _route,
                filters: [],
            },
        });

        navigateHook(_route);

        setFetched(true);
        setLoading(false);
    }, [navigateHook]);

    React.useEffect(() => {
        api.get("ping")
            .then((response) => {
                console.log("API is alive! ", response.data);
            });
    }, []);

    React.useEffect(() => {
        setLoading(true);

        if (!authenticated) {
            setStatus("Sessão expirada.");
            navigate('login');
        } else {
            setStatus("Bem-vindo de volta, " + user?.name + "!");
            navigate('home');
        }
    }, [user, authenticated]);

    /* ============================================================== */

    const toggleDrawer = (open: boolean) => (event: any) => {
        if (event.type === 'keydown' && (event.key === 'Tab' || event.key === 'Shift')) return;

        setDrawerOpen(open);
    };

    const handleLogout = () => {
        const dialogOptions = {
            title: 'Sair',
            message: 'Deseja realmente encerrar a sessão?',
            type: 'confirm',
            confirmText: 'Sim',
            cancelText: 'Não',
        };
        dialog.show(dialogOptions).then((result) => {
            if (result) {
                auth.logout();
            }
        });
    };

    const renderPageTitle = () => {

        let title = currentPage.title;

        switch (currentPage.name) {
            default:
                break;
        }

        const icon = (typeof currentPage.icon === 'string')
            ? (<img src={`/img/icons/${currentPage.icon}.png`} />)
            : currentPage.icon;

        return (
            <Box
                sx={{
                    ...theme.customized.layout.flex.ACenter_JCenter,
                    color: theme.palette.text.gray,
                }}
            >
                {(currentPage?.icon !== null && currentPage?.icon !== '') && icon}

                <Typography
                    variant="h3"
                    color="text.gray"
                    marginLeft={2.5}
                >
                    {title}
                </Typography>
            </Box>
        );
    };

    /* ============================================================== */

    return (
        <AppContext.Provider
            value={{
                // State
                navigate,

                // Parameters #1
                NAV_BAR_WIDTH, NAV_BAR_WIDTH_MOBILE,
                APP_BAR_HEIGHT, APP_BAR_HEIGHT_MOBILE,

                // Parameters #2
                loading, setLoading,
                fetched, setFetched,
                status, setStatus,
                theme, isTablet, windowWidth, windowHeight,
                drawerOpen, setDrawerOpen,
                popAnchorEl, setPopAnchorEl, popOpen,
                navBarWidth, appBarHeight,
                footerBarHeight, footerWindowDiff,

                // Functions
                toggleDrawer,
                handleLogout,
                renderPageTitle
            }}
        >
            {children}
        </AppContext.Provider>
    );
};

export const useApp = () => {

    const context = useContext(AppContext);

    if (!context) {
        throw new Error("useApp must be used within a AppProvider");
    }
    return context;
};
