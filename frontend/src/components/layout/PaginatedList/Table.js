/* eslint-disable prefer-destructuring */
/* eslint-disable radix */

import React from 'react';
import { useNavigate } from 'react-router-dom';

import PropTypes from 'prop-types';

import SearchInput from '../../inputs/SearchInput';

import { useTheme } from '@mui/material';
import Stack from '@mui/material/Stack';
import MuiTable from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableFooter from '@mui/material/TableFooter';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Typography from '@mui/material/Typography';
import Pagination from '@mui/material/Pagination';
import Button from '@mui/material/Button';

import ModeEditIcon from '@mui/icons-material/ModeEdit';
import DeleteForeverIcon from '@mui/icons-material/DeleteForever';

const Table = ({
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
    themeVariant,
    page,
    pagination,
    paginationBase,
    paginationCols,
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
        <TableContainer variant={themeVariant} >
            <MuiTable
                sx={{ minWidth: 500 }}
                aria-label={`tabela paginada ${title.toLocaleLowerCase()}`}
            >
                <TableHead>
                    {showSearchBar && (
                        <TableRow>
                            <TableCell
                                component="th"
                                // scope="row"
                                sx={{ borderBottom: 'none' }}
                                colSpan={paginationCols}
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
                            </TableCell>
                        </TableRow>
                    )}

                    <TableRow>
                        {columns.map((column) => (
                            <TableCell
                                key={column}
                                component="th"
                            >
                                <Typography
                                    variant="body2"
                                    color="primary"
                                >
                                    {typeof columnDefinitions[column] === 'string'
                                        ? columnDefinitions[column]
                                        : columnDefinitions[column].name
                                    }
                                </Typography>
                            </TableCell>
                        ))}
                    </TableRow>
                </TableHead>
                <TableBody sx={{ px: '16px' }} >
                    {items.map((item) => {
                        const itemData = item.getTableData();
                        // console.log(itemData);

                        return (
                            <TableRow
                                key={item.id}
                                sx={{ px: '0' }}
                            >
                                {columns.map((column) => {
                                    const headData = columnDefinitions[column];
                                    let options = { sx: { width: 'auto' } };

                                    if (typeof headData === 'object') {
                                        // eslint-disable-next-line no-unused-vars
                                        const { name, ...other } = headData;

                                        options = other;
                                    }

                                    const data = itemData[column];

                                    let content = null;

                                    if (['string', 'number', 'undefined'].includes(typeof data)) {
                                        content = (
                                            <Typography variant="tableCell-3" >
                                                {data}
                                            </Typography>
                                        );
                                    } else if (typeof data.render === 'function') {
                                        content = data.render();
                                    } else {
                                        content = (
                                            <Typography variant={`tableCell-${data.variant || 3}`} >
                                                {data.text}
                                            </Typography>
                                        ) || 'conteúdo inválido';
                                    }

                                    return (
                                        <TableCell
                                            key={column}
                                            component="td"
                                            // component={i === 0 ? 'th' : 'td'}
                                            // scope={i === 0 ? 'row' : undefined}

                                            {...options}
                                        >
                                            {content}
                                        </TableCell>
                                    );
                                })}

                                {Model.getTableActions(item)
                                    .map((action) => (
                                        <TableCell
                                            key={action.key}
                                            component="td"
                                            variant="button"
                                            color={action.color}
                                        >
                                            {action.render}
                                        </TableCell>
                                    ))
                                }

                                {showEditButton && (
                                    <TableCell
                                        component="td"
                                        variant="button"
                                        color="success"
                                    >
                                        <Button onClick={() => onClickEdit(item)} >
                                            <ModeEditIcon />
                                        </Button>
                                    </TableCell>
                                )}

                                {showDeleteButton && (
                                    <TableCell
                                        component="td"
                                        variant="button"
                                        color="error"
                                    >
                                        <Button onClick={() => handleItemDelete(item)} >
                                            <DeleteForeverIcon />
                                        </Button>
                                    </TableCell>
                                )}
                            </TableRow>
                        );
                    })}
                </TableBody>
                <TableFooter>
                    <TableRow>
                        <TableCell
                            variant="pagination"
                            colSpan={paginationCols}
                        >
                            <Stack
                                direction="row"
                                sx={{
                                    ...theme.customized.layout.flex.ACenter_JBetween,
                                    mt: '22px',
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
                        </TableCell>
                    </TableRow>
                </TableFooter>
            </MuiTable>
        </TableContainer>
    );
};

Table.propTypes = {
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
    themeVariant: PropTypes.number,
    page: PropTypes.number,
    pagination: PropTypes.instanceOf(Object),
    paginationBase: PropTypes.string,
    paginationCols: PropTypes.number,
    totalPageItems: PropTypes.number,
    refresh: PropTypes.func.isRequired,
};

export default Table;
