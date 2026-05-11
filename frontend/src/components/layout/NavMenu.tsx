/* eslint-disable padded-blocks */
/* eslint-disable quotes */

import React from 'react';
import PropTypes, { bool } from 'prop-types';

import { useSelector } from 'react-redux';
import { Link, useNavigate } from 'react-router-dom';

import { useTheme } from '@mui/material';
import Box from '@mui/material/Box';
import List from '@mui/material/List';
// import Divider from '@mui/material/Divider';
import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
// import ListItemText from '@mui/material/ListItemText';
import Typography from '@mui/material/Typography';
// import Button from '@mui/material/Button';
// import Paper from '@mui/material/Paper';
import Stack from '@mui/material/Stack';
import Button from '@mui/material/Button';
import ListSubheader from '@mui/material/ListSubheader';

import FilterBar from '../filter/FilterBar';

// import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
// import InboxIcon from '@mui/icons-material/MoveToInbox';
// import MailIcon from '@mui/icons-material/Mail';
import PsychologyIcon from '@mui/icons-material/Psychology';
// import PeopleAltIcon from '@mui/icons-material/PeopleAlt';
// import SchoolIcon from '@mui/icons-material/School';
// import DownhillSkiingIcon from '@mui/icons-material/DownhillSkiing';

import { useApp } from '../../contexts/AppContext';

const MENU_ITEMS = [
    // Add items to menu here
    {
        name: 'Home',
        items: [
            {
                component: Link,
                to: '/home',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/football_field_gray.png"
                    />
                ),
                name: "Safe House",
                shouldAppear: () => true,
            },
            {
                component: Link,
                to: '/garage',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/football_field_gray.png"
                    />
                ),
                name: "Garagem",
                shouldAppear: () => true,
            },
            {
                component: Link,
                to: '/profile',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/profile_gray.png"
                    />
                ),
                name: 'Perfil',
                shouldAppear: () => true,
            },
        ],
    },
];

const NavMenu = ({ width, toggleDrawer }) => {

    const theme = useTheme();
    const navigate = useNavigate();

    const { isTablet } = useApp();

    /* =========================== State ============================ */

    /* ============================================================== */

    const [selectedIndex, setSelectedIndex] = React.useState('/v1/dashboard/cts');

    const handleListItemClick = (index) => {
        if (index !== selectedIndex) {
            setSelectedIndex(index);
        } else {
            setSelectedIndex(undefined);
        }
    };

    const renderItems = (module, i) => (
        <React.Fragment key={i}>
            <List sx={{ p: '7.5% 0 0' }}>
                {/* {module.name !== '' && (
                    <ListSubheader
                        variant="nav-menu"
                        sx={{ top: -1 }}
                    >
                        {module.name}
                    </ListSubheader>
                )} */}

                {module.items
                    .filter((item) => item.shouldAppear())
                    .map((item) => (
                        <ListItem
                            disablePadding
                            key={item.name}
                            sx={{ mb: 0.75 }}
                        >
                            <ListItemButton
                                component={item.component}
                                variant="text"
                                color="purple"
                                to={item.to}

                                onClick={() => handleListItemClick(item.to)}
                                selected={selectedIndex === item.to}
                            >
                                <ListItemIcon
                                    sx={{
                                        ...theme.customized.layout.flex.ACenter_JCenter,
                                        minWidth: '40px',
                                    }}
                                >
                                    {item.icon}
                                </ListItemIcon>

                                <Typography variant="nav-listItemButton" >
                                    {item.name}
                                </Typography>
                            </ListItemButton>
                        </ListItem>
                    ))
                }
            </List>
        </React.Fragment>
    );

    return (
        <Box
            sx={{
                ...theme.components.NavBar,
                width,
            }}
            role="presentation"
            onClick={toggleDrawer(false)}
            onKeyDown={toggleDrawer(false)}
        >
            <Stack>
                <Stack
                    direction="row"
                    sx={{
                        ...theme.customized.layout.flex.ACenter_JCenter,
                        mb: 5,
                    }}
                >
                    <Button
                        onClick={() => navigate('/')}
                        sx={{ py: 0 }}
                    >
                        <img
                            alt=""
                            src="/img/logo/logo_2.png"
                        />
                    </Button>
                </Stack>

                {/* <FilterBar /> */}

                <Stack
                    sx={{
                        'overflowY': 'auto',
                        'maxHeight': 'calc(66.25vh - 38px) !important',
                    }}
                >
                    {MENU_ITEMS.map(renderItems)}
                </Stack>
            </Stack>
        </Box>
    );
};

NavMenu.propTypes = {
    width: PropTypes.number.isRequired,
    toggleDrawer: PropTypes.func,
    isTablet: PropTypes.bool,
};

export default NavMenu;
