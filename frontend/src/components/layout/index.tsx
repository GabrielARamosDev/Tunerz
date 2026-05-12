/* eslint-disable quotes */
/* eslint-disable react/no-unescaped-entities */

import React from 'react';
import PropTypes from 'prop-types';

import { connect, useSelector } from 'react-redux';

import { Sidebar, /* useProSidebar */ } from 'react-pro-sidebar';
import { Outlet } from 'react-router-dom';

import NavMenu from './NavMenu';

import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Drawer from '@mui/material/Drawer';
import IconButton from '@mui/material/IconButton';
import Stack from '@mui/material/Stack';
import Toolbar from '@mui/material/Toolbar';
import Avatar from '@mui/material/Avatar';
import Menu from '@mui/material/Menu';
import MenuItem from '@mui/material/MenuItem';
import MenuList from '@mui/material/MenuList';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';

import LogoutIcon from '@mui/icons-material/Logout';
import MenuIcon from '@mui/icons-material/Menu';

import Loading from '../loading.tsx';

import NotificationBar from '../dialog/NotificationBar.tsx';
import DialogBar from '../dialog/DialogBar.tsx';
import Footer from './Footer';

import dialog from '../../controllers/dialog';
import auth from '../../controllers/auth';

import type { Layout as LayoutType } from '../../types/layout.ts';
import type { State as StateType } from '../../types/state.ts';

import { useApp } from "../../contexts/AppContext.tsx";

const AppLayout = ({ currentPage }: LayoutType) => {

    /* =========================== State ============================ */

    const userName = useSelector((state: StateType) => state.app.user?.name || 'Player');

    const authenticated = useSelector((state: StateType) =>
        state.app.user !== null
        && state.app.user?.id !== null
        && state.app.user?.status !== 'unauthenticated'
    );

    /* ============================================================== */

    const {
        loading, fetched, status, 
        theme, isTablet, windowWidth, windowHeight,
        drawerOpen,
        popAnchorEl, setPopAnchorEl, popOpen,
        navBarWidth, appBarHeight,
        footerBarHeight, footerWindowDiff,
        toggleDrawer,
        handleLogout,
        renderPageTitle
    } = useApp();

    /* ============================================================== */

    if (loading) return <p>{status}</p>;

    if (!fetched) return <p>{status}</p>;

    return (
        <>
            <Stack>
                <Stack
                    direction="row"
                    spacing={0}
                    sx={{ overflow: 'hidden', height: footerWindowDiff }}
                >
                    {authenticated && isTablet && (
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
                        {authenticated && (
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
                                                        // collapseSidebar();
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
                        )}

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

AppLayout.propTypes = { currentPage: PropTypes.object.isRequired };

const mapStateToProps = (state: StateType) => ({ currentPage: state.currentPage });

export default connect(mapStateToProps)(AppLayout);
