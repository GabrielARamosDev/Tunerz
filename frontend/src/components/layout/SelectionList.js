import React, { useState } from 'react';
import PropTypes from 'prop-types';

import useFetchList from '../../hooks/useFetchList';

import { useTheme } from '@mui/material';
import Button from '@mui/material/Button';
import Stack from '@mui/material/Stack';
import Icon from '@mui/material/Icon';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import Typography from '@mui/material/Typography';
import CircularProgress from '@mui/material/CircularProgress';
import Avatar from '@mui/material/Avatar';

const SelectionList = ({
    model: Model,
    query = {},
    openButtonText = 'Ver Todos',
    showMoreText = 'Outros',
    buttonIcon = null,
    style = {},
    onItemSelect = () => null,
}) => {
    const theme = useTheme();

    const [open, setOpen] = useState(false);
    const [selected, setSelected] = useState(new Model);

    const handleItem = (item) => {
        setSelected(item);
        onItemSelect(item);
        setOpen(false);
    };

    const { items, isLoading } = useFetchList({
        model: Model,
        initialRowsPerPage: 9999,
        query,
    });

    if (isLoading) {
        return (
            <CircularProgress />
        );
    }

    return (
        <Stack sx={style}>
            <Button
                variant="contained"
                className="selection-list-btn"
                color="gradientPink"
                onClick={() => setOpen(!open)}
                sx={{
                    ...theme.customized.layout.flex.ACenter_JBetween,
                    borderRadius: !open || items.length <= 0 ? '13px' : '13px 13px 0 0',
                }}
            >
                <Stack
                    direction="row"
                    sx={{ alignItems: 'center' }}
                >
                    {selected.id > 0
                        ? (
                            <Avatar
                                alt={selected.attributes.name}
                                src="/img/icons/profile_menu.png"
                                sx={{ m: 0 }}
                            />
                        )
                        : buttonIcon !== null && (
                            <React.Fragment>
                                {typeof buttonIcon === 'string'
                                    ? (
                                        <img
                                            alt="icon"
                                            src={`/img/icons/${buttonIcon}.png`}
                                            style={{ width: 70.4, height: 52.8 }}
                                        />
                                    )
                                    : buttonIcon
                                }
                            </React.Fragment>
                        )
                    }
                    <Typography
                        variant="selection-list-btn"
                        sx={{ ml: (selected.id > 0 || buttonIcon !== null) && 3 }}
                    >
                        {selected.id > 0
                            ? selected.attributes.name
                            : openButtonText
                        }
                    </Typography>
                </Stack>

                <Stack
                    direction="row"
                    alignItems="center"
                >
                    {selected.id > 0 && (
                        <Typography variant="selection-list-btn" >
                            {showMoreText}
                        </Typography>
                    )}
                    <Icon sx={{ ...open && theme.customized.layout.rotate['180'] }} >
                        <img
                            alt="arrow_icon"
                            src="/img/icons/arrow_down.png"
                        />
                    </Icon>
                </Stack>
            </Button>

            {open && items.length > 0 && (
                <List variant="selection-list" >
                    {items.map((item) => (
                        <ListItem
                            key={item.attributes.id}
                            variant="selection-list-opt"
                        >
                            <Button
                                fullWidth
                                variant="text"
                                className="selection-list-opt-btn"
                                onClick={() => handleItem(item)}
                                sx={{ ...theme.customized.layout.flex.ACenter_JStart }}
                            >
                                <Typography
                                    variant="selection-list-opt-txt"
                                    color="primary"
                                >
                                    {item.attributes.name}
                                </Typography>
                            </Button>
                        </ListItem>
                    ))}
                </List>
            )}
        </Stack>
    );
};

SelectionList.propTypes = {
    model: PropTypes.oneOfType([PropTypes.any]).isRequired,
    query: PropTypes.instanceOf(Object),
    openButtonText: PropTypes.string,
    showMoreText: PropTypes.string,
    buttonIcon: PropTypes.oneOfType([PropTypes.any]),
    style: PropTypes.instanceOf(Object),
    onItemSelect: PropTypes.func,
};

export default SelectionList;
