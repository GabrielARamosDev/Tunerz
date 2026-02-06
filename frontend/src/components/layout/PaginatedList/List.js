/* eslint-disable prefer-destructuring */
/* eslint-disable radix */

import React from 'react';
import { useNavigate } from 'react-router-dom';

import PropTypes from 'prop-types';

import SearchInput from '../../inputs/SearchInput';

import { useTheme } from '@mui/material';
import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import Pagination from '@mui/material/Pagination';
import Button from '@mui/material/Button';
import MuiList from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import Divider from '@mui/material/Divider';
import Paper from '@mui/material/Paper';

import ModeEditIcon from '@mui/icons-material/ModeEdit';
import DeleteForeverIcon from '@mui/icons-material/DeleteForever';

const List = ({
    Model,
    title,
    columns,
    columnDefinitions,
    items,
    variant,
    showSearchBar,
    showEditButton,
    showDeleteButton,
    onClickEdit,
    search,
    setSearchInput,
    setSearch,
    page,
    pagination,
    paginationBase,
    totalPageItems,
    refresh,
}) => {
    const theme = useTheme();
    const navigate = useNavigate();

    const handleItemDelete = (item) => {
        item.delete();
        refresh();
    };

    return (
        <Paper variant="outlined" >
            {showSearchBar && (
                <Stack
                    direction="column"
                    alignItems="center"
                    justifyContent="center"
                >
                    {variant === 1 && (
                        <SearchInput
                            value={search}
                            onChange={(e) => setSearchInput(e.target.value)}
                            onSearch={(search) => setSearch(search)}
                            sx={{ ...theme.components.SearchInput }}
                        />
                    )}
                    {variant === 2 && (
                        <React.Fragment>
                            <Typography
                                variant="h2"
                                color="text.secondary"
                            >
                                {title}
                            </Typography>

                            <Stack />
                        </React.Fragment>
                    )}
                </Stack>
            )}

            <MuiList sx={{ px: 1.5 }} >
                {items.map((item, i, arr) => {
                    const itemData = item.getTableData();

                    return (
                        <>
                            <ListItem
                                key={item.id}
                                alignItems="flex-start"
                                sx={{ px: 0 }}
                            >
                                <Stack direction="column" >
                                    {columns.map((column) => {
                                        const data = itemData[column];

                                        const name = typeof columnDefinitions[column] === 'string'
                                            ? columnDefinitions[column]
                                            : columnDefinitions[column].name;

                                        return (
                                            <ListItemText
                                                key={`item_${item.id}_${column}`}
                                                secondary={
                                                    <>
                                                        <Typography
                                                            component="span"
                                                            variant="body2"
                                                            color="primary"
                                                            fontWeight="bold"
                                                            sx={{ display: 'inline' }}
                                                        >
                                                            {`${name}: `}
                                                        </Typography>

                                                        <Typography
                                                            component="span"
                                                            variant="body2"
                                                            color="black"
                                                            sx={{
                                                                display: 'inline',
                                                                lineHeight: '22px',
                                                            }}
                                                        >
                                                            {` ${data}`}
                                                        </Typography>
                                                    </>
                                                }
                                            />
                                        );
                                    })}

                                    {Model.getTableActions(item)
                                        .map((action) => (
                                            <Button
                                                key={action.key}
                                                color={action.color}
                                            >
                                                {action.render}
                                            </Button>
                                        ))
                                    }

                                    {showEditButton && (
                                        <Button color="success" >
                                            <Button onClick={() => onClickEdit(item)} >
                                                <ModeEditIcon />
                                            </Button>
                                        </Button>
                                    )}

                                    {showDeleteButton && (
                                        <Button color="error" >
                                            <Button onClick={() => handleItemDelete(item)} >
                                                <DeleteForeverIcon />
                                            </Button>
                                        </Button>
                                    )}
                                </Stack>
                            </ListItem>

                            {i < arr.length - 1 && (
                                <Divider
                                    variant="inset"
                                    component="li"
                                    sx={{ mx: 1.5, my: 1 }}
                                />
                            )}
                        </>
                    );
                })}
            </MuiList>

            <Stack
                direction="column"
                alignItems="center"
                justifyContent="center"
                gap={2.25}
                sx={{
                    width: '100%',
                    ...theme.customized.layout.flex.ACenter_JBetween,
                    mt: 2.75,
                    mb: 2.25,
                }}
            >
                <Typography
                    variant="body2"
                    color="primary"
                >
                    {items.length === 0
                        ? 'Nenhum resultado encontrado'
                        : `
                            Mostrando 
                            ${totalPageItems + 1} - ${totalPageItems + items.length} 
                            de 
                            ${pagination.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')} 
                            resultados
                        `
                    }
                </Typography>
                <Pagination
                    shape="rounded"
                    color="primary"

                    count={pagination.last_page}
                    siblingCount={0}
                    page={parseInt(page)}

                    onChange={(e, page) => navigate(`${paginationBase}/pagina/${page}`)}
                />
            </Stack>
        </Paper>
    );
};

List.propTypes = {
    Model: PropTypes.instanceOf(Object).isRequired,
    title: PropTypes.string,
    columns: PropTypes.arrayOf(PropTypes.string).isRequired,
    columnDefinitions: PropTypes.instanceOf(Object).isRequired,
    items: PropTypes.arrayOf(PropTypes.instanceOf(Object)).isRequired,
    variant: PropTypes.number.isRequired,
    showSearchBar: PropTypes.bool,
    showEditButton: PropTypes.bool,
    showDeleteButton: PropTypes.bool,
    onClickEdit: PropTypes.func,
    search: PropTypes.string,
    setSearchInput: PropTypes.func,
    setSearch: PropTypes.func,
    page: PropTypes.number,
    pagination: PropTypes.instanceOf(Object),
    paginationBase: PropTypes.string,
    totalPageItems: PropTypes.number,
    refresh: PropTypes.func.isRequired,
};

export default List;
