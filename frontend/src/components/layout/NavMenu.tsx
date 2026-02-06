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

const MENU_ITEMS = [
    // Add items to menu here
    {
        name: 'Dashboard',
        items: [
            {
                component: Link,
                to: '/v1/dashboard/cts',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/football_field_gray.png"
                    />
                ),
                name: "CT's",
                shouldAppear: () => true,
            },
            {
                component: Link,
                to: '/v2/dashboard/relatorios',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/reports_gray.png"
                    />
                ),
                name: 'Relatórios',
                shouldAppear: () => true,
            },
            {
                component: Link,
                to: '/v1/dashboard/utilizacao',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/reports_gray.png"
                    />
                ),
                name: 'Utilização',
                shouldAppear: () => true,
            },
        ],
        permitted: [], // de acordo com a 'roleAbilityId'
    },
    {
        name: 'Gestão',
        items: [
            {
                component: Link,
                to: '/v1/gestao/funcoes',
                icon: <PsychologyIcon />,
                name: 'Funções',
                shouldAppear: () => true,
            },
            {
                component: Link,
                to: '/v1/gestao/usuarios',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/users-2.png"
                    />
                ),
                name: 'Usuários',
                shouldAppear: () => true,
            },
            {
                component: Link,
                to: '/v1/gestao/escolas',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/escolas_gray.png"
                    />
                ),
                name: 'Escolas',
                shouldAppear: () => true,
            },
            {
                component: Link,
                to: '/v1/gestao/habilidades',
                icon: (
                    <img
                        alt=""
                        src="/img/icons/badge-check-2.png"
                    />
                ),
                name: 'Habilidades',
                shouldAppear: () => true,
            },
        ],
        permitted: ['ability_manager_menu'], // de acordo com a 'roleAbilityId'
    },
    {
        name: 'Configurações',
        items: [
            {
                component: Link,
                to: '/perfil',
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
        permitted: [], // de acordo com a 'roleAbilityId'
    },
];

const NavMenu = ({
    width,
    toggleDrawer,
    isTablet = true,
}) => {

    const theme = useTheme();
    const navigate = useNavigate();

    const user = useSelector((state) => state.app.user);
    const userRole = user.roles[0];
    const userRoleAbilitiesIds = userRole.role_abilities.map((ra) => ra.ability);

    const [selectedIndex, setSelectedIndex] = React.useState('/v1/dashboard/cts');

    const handleListItemClick = (index) => {
        if (index !== selectedIndex) {
            setSelectedIndex(index);
        } else {
            setSelectedIndex(undefined);
        }
    };

    const verifyPermission = (module) => {
        if (module.permitted.length <= 0) {
            return true;
        }
        if (module.permitted.length > 0) {
            let bool = false;

            module.permitted.forEach((permission) => {
                if (userRoleAbilitiesIds.includes(permission)) {
                    bool = true;
                }
            });
            return bool;
        }

        return false;
    };

    const renderItems = (module, i) => (
        <React.Fragment key={i}>
            {verifyPermission(module) && (
                <List sx={{ p: '7.5% 0 0' }}>
                    {module.name !== '' && (
                        <ListSubheader
                            variant="nav-menu"
                            sx={{ top: -1 }}
                        >
                            {module.name}
                        </ListSubheader>
                    )}

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
            )}
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

                <FilterBar />

                <Stack
                    sx={{
                        'overflow-y': 'auto',
                        'max-height': 'calc(66.25vh - 38px) !important',
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
