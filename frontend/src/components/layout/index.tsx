/* eslint-disable quotes */
/* eslint-disable react/no-unescaped-entities */

import React from 'react';
import PropTypes from 'prop-types';

import { connect, useSelector } from 'react-redux';

import { Sidebar, useProSidebar } from 'react-pro-sidebar';
import { Outlet } from 'react-router-dom';
import { useMediaQuery } from 'react-responsive';

import NavMenu from './NavMenu';

import { useTheme } from '@mui/material';
import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Drawer from '@mui/material/Drawer';
import IconButton from '@mui/material/IconButton';
import Stack from '@mui/material/Stack';
import Toolbar from '@mui/material/Toolbar';
import Avatar from '@mui/material/Avatar';
import Typography from '@mui/material/Typography';
import Menu from '@mui/material/Menu';
import MenuItem from '@mui/material/MenuItem';
import MenuList from '@mui/material/MenuList';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';

import Loading from '../loading.tsx';

import NotificationBar from '../dialog/NotificationBar.tsx';
import DialogBar from '../dialog/DialogBar.tsx';
import Footer from './Footer';

import useWindowWidth from '../../hooks/useWindowWidth.ts';
import useWindowHeight from '../../hooks/useWindowHeight.ts';
import useFooterConfig from '../../hooks/useFooterConfig.ts';

import LogoutIcon from '@mui/icons-material/Logout';
import MenuIcon from '@mui/icons-material/Menu';

import dialog from '../../controllers/dialog';
import auth from '../../controllers/auth';

import type { Layout as LayoutType } from '../../types/layout.ts';
import type { State as StateType } from '../../types/state.ts';
import type { Theme as ThemeType } from '../../types/style.ts';

const NAV_BAR_WIDTH = 300;
const NAV_BAR_WIDTH_MOBILE = 250;

const APP_BAR_HEIGHT = 64;
const APP_BAR_HEIGHT_MOBILE = 56;

const Layout = ({ currentPage }: LayoutType) => {
    
    /* =========================== State ============================ */
    const userName = useSelector((state: StateType) => state.app.user?.name);

    const filters = useSelector((state: StateType) => {

        const temp: any = {};

        currentPage.filters.forEach((filter: any) => {
            temp[filter] = state.filter[filter];
        });

        return temp;
    });
    /* ============================================================== */

    const theme: ThemeType = useTheme();

    const isTablet = useMediaQuery({ query: '(min-width: 768px)' });
    const windowWidth = useWindowWidth();
    const windowHeight = useWindowHeight();

    const { collapseSidebar } = useProSidebar();
    const [drawerOpen, setDrawerOpen] = React.useState(false);

    const [popAnchorEl, setPopAnchorEl] = React.useState(null);
    const popOpen = Boolean(popAnchorEl);

    const { footerBarHeight, footerWindowDiff } = useFooterConfig();

    const navBarWidth = isTablet ? NAV_BAR_WIDTH : NAV_BAR_WIDTH_MOBILE;
    const appBarHeight = isTablet ? APP_BAR_HEIGHT : APP_BAR_HEIGHT_MOBILE;

    /* * */

    const toggleDrawer = (open: boolean) => (event: any) => {
        if (
            event.type === 'keydown'
            && (event.key === 'Tab'
                || event.key === 'Shift')
        ) {
            return;
        }

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
            case 'cts': {
                if (filters.schools.length === 1) {
                    title = `CT - ${filters.schools[0]?.name}`;
                }
                break;
            }

            default:
                break;
        }

        const icon = typeof currentPage.icon === 'string'
            ? <img src={`/img/icons/${currentPage.icon}.png`} />
            : currentPage.icon;

        return (
            <Box
                sx={{
                    ...theme.customized.layout.flex.ACenter_JCenter,
                    color: theme.palette.text.gray,
                }}
            >
                {icon}

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

    /* * */

    if (!userName) return <Loading />

    return (
        <>
            <Stack>
                <Stack
                    direction="row"
                    spacing={0}
                    sx={{ overflow: 'hidden', height: footerWindowDiff }}
                >

                    {isTablet && (
                        <Sidebar
                            width="327"
                            collapsedWidth="58px"
                            rootStyles={{ ...theme.components.Sidebar }}
                        >
                            <NavMenu
                                width={navBarWidth}
                                toggleDrawer={toggleDrawer}
                                isTablet={isTablet}
                            />
                        </Sidebar>
                    )}

                    <Stack
                        spacing={0}
                        sx={{
                            ...theme.components.MainView,
                            width: isTablet ? windowWidth - navBarWidth : '100%',
                        }}
                    >
                        <AppBar
                            position="static"
                            sx={{
                                height: appBarHeight,
                                zIndex: 1,
                            }}
                        >
                            <Toolbar>
                                {!isTablet && (
                                    <React.Fragment>
                                        <IconButton
                                            size="large"
                                            edge="start"
                                            color="inherit"
                                            aria-label="menu"
                                            sx={{ mr: 2 }}
                                            onClick={(e) => {
                                                if (isTablet) {
                                                    collapseSidebar();
                                                    return;
                                                }
                                                toggleDrawer(true)(e);
                                            }}
                                        >
                                            <MenuIcon />
                                        </IconButton>

                                        <Drawer
                                            anchor="left"
                                            open={drawerOpen}
                                            onClose={toggleDrawer(false)}
                                        >
                                            <NavMenu
                                                width="100%"
                                                toggleDrawer={toggleDrawer}
                                                isTablet={isTablet}
                                            />
                                        </Drawer>
                                    </React.Fragment>
                                )}

                                {renderPageTitle()}

                                {/* Pop-up user menu */}
                                <Button
                                    id="popMenu-btn"
                                    variant="avatar"
                                    aria-controls={drawerOpen ? 'popMenu' : undefined}
                                    aria-haspopup="true"
                                    aria-expanded={drawerOpen ? 'true' : undefined}
                                    onClick={(e: any) => setPopAnchorEl(e.currentTarget)}
                                >
                                    <Avatar
                                        alt={userName}
                                        src="/img/icons/profile_menu.png"
                                        sx={{ margin: 0, color: 'info.dark' }}
                                    >
                                        {/* {userName?.charAt(0)} */}
                                    </Avatar>
                                </Button>

                                <Menu
                                    id="popMenu"
                                    anchorEl={popAnchorEl}
                                    open={popOpen}
                                    onClose={() => setPopAnchorEl(null)}
                                    MenuListProps={{ 'aria-labelledby': 'popMenu-btn' }}
                                >
                                    <MenuList id="popMenu-list" >
                                        <MenuItem onClick={handleLogout}>
                                            <ListItemIcon>
                                                <LogoutIcon />
                                            </ListItemIcon>
                                            <ListItemText>
                                                Sair
                                            </ListItemText>
                                        </MenuItem>
                                    </MenuList>
                                </Menu>
                            </Toolbar>
                        </AppBar>

                        <Box
                            sx={{
                                height: windowHeight - appBarHeight - footerBarHeight,
                                p: '24px 31px',
                                overflowY: 'auto',
                                flexGrow: 1,
                            }}
                        >
                            <Outlet />
                        </Box>
                    </Stack>
                </Stack>

                <Footer />
            </Stack>

            <NotificationBar />
            <DialogBar />

        </>
    );
};

Layout.propTypes = { currentPage: PropTypes.object.isRequired };

const mapStateToProps = (state: StateType) => ({ currentPage: state.currentPage });

export default connect(mapStateToProps)(Layout);
