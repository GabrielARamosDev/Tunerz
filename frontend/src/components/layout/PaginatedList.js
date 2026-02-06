import React from 'react';
import { connect } from 'react-redux';
import { useNavigate, useParams } from 'react-router-dom';
import { useMediaQuery } from 'react-responsive';

import PropTypes from 'prop-types';

import useFetchList from '../../hooks/useFetchList';

import { useTheme } from '@mui/material';
import Grid from '@mui/material/Unstable_Grid2';
import CircularProgress from '@mui/material/CircularProgress';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';

import Table from './PaginatedList/Table';
import List from './PaginatedList/List';

const PaginatedList = ({
    myRef,
    model: Model,
    fetchListOptions = {},
    variant = 1,
    themeVariant = '',
    title = '',
    subTitle = '',
    paginationBase,
    rowsPerPage = 10,
    createButtonText = 'Novo',
    showBackButton = false,
    showSearchBar = true,
    showCreateButton = true,
    showEditButton = true,
    showDeleteButton = false,
    onClickEdit = () => null,
    onClickNew = () => null,
    //
    startAt,
    endAt,
    countryIds,
    stateIds,
    cityIds,
    schoolIds,
    classroomIds,
    playerIds,
    seasonIds,
    leagueIds,
    gameIds,
    subComponentIds,
    //
    additionalQuery = {},
}) => {
    const theme = useTheme();
    const navigate = useNavigate();

    const isTablet = useMediaQuery({ query: '(min-width: 768px)' });

    const { page = 1 } = useParams();

    const {
        items,
        isLoading,
        pagination,
        // setRowsPerPage,
        search,
        setSearchInput,
        setSearch,
        refresh,
    } = useFetchList({
        model: Model,
        page,
        initialRowsPerPage: rowsPerPage,
        ...fetchListOptions,
        query: {
            start_at: startAt,
            end_at: endAt,
            country_ids: countryIds,
            state_ids: stateIds,
            city_ids: cityIds,
            school_ids: schoolIds,
            classroom_ids: classroomIds,
            player_id: playerIds,
            season_ids: seasonIds,
            league_ids: leagueIds,
            game_ids: gameIds,
            sub_component_ids: subComponentIds,
            ...additionalQuery,
        },
    });

    React.useImperativeHandle(myRef, () => ({ refresh }), [refresh]);

    const columnDefinitions = Model.getTableHead();
    const columns = Object.keys(columnDefinitions);
    const paginationCols = columns.length + Model.getTableActions().length + 2;

    const totalPageItems = React.useMemo(
        () => {
            if (!pagination) {
                return 0;
            }

            return (page - 1) * pagination.per_page;
        },
        [page, pagination],
    );

    if (isLoading) {
        return (
            <CircularProgress />
        );
    }

    return (
        <React.Fragment>
            {variant === 1 && (
                <Box>
                    <Typography
                        variant="h2"
                        color="primary"
                    >
                        {title}
                    </Typography>

                    {subTitle !== '' && (
                        <Typography
                            variant="subtitle-1"
                            color="primary"
                        >
                            {subTitle}
                        </Typography>
                    )}
                </Box>
            )}

            <Grid
                item
                xs={12}
                // lg={options.largura}
            >
                {isTablet
                    ? (
                        <Table
                            Model={Model}
                            title={title}
                            columns={columns}
                            columnDefinitions={columnDefinitions}
                            items={items}
                            variant={variant}
                            showSearchBar={showSearchBar}
                            showEditButton={showEditButton}
                            showDeleteButton={showDeleteButton}
                            onClickEdit={onClickEdit}
                            search={search}
                            setSearchInput={setSearchInput}
                            setSearch={setSearch}
                            themeVariant={themeVariant}
                            page={page}
                            pagination={pagination}
                            paginationBase={paginationBase}
                            paginationCols={paginationCols}
                            totalPageItems={totalPageItems}
                            refresh={refresh}
                        />
                    )
                    : (
                        <>
                            <List
                                Model={Model}
                                title={title}
                                columns={columns}
                                columnDefinitions={columnDefinitions}
                                items={items}
                                variant={variant}
                                showSearchBar={showSearchBar}
                                showEditButton={showEditButton}
                                showDeleteButton={showDeleteButton}
                                onClickEdit={onClickEdit}
                                search={search}
                                setSearchInput={setSearchInput}
                                setSearch={setSearch}
                                page={page}
                                pagination={pagination}
                                paginationBase={paginationBase}
                                totalPageItems={totalPageItems}
                                refresh={refresh}
                            />
                        </>
                    )
                }
            </Grid>

            <Box
                sx={{
                    ...theme.customized.layout.flex.ACenter_JBetween,
                    mt: '20px',
                    pr: '13px',
                }}
            >
                {showBackButton && (
                    <Button
                        onClick={() => navigate(-1)}
                        variant="outlined"
                        color="error"
                    >
                        Voltar
                    </Button>
                )}

                {showCreateButton && (
                    <Button
                        onClick={() => onClickNew(new Model)}
                        variant="contained"
                        color="success"
                    >
                        + {createButtonText}
                    </Button>)
                }
            </Box>
        </React.Fragment>
    );
};

PaginatedList.propTypes = {
    myRef: PropTypes.instanceOf(React.Ref).isRequired,
    model: PropTypes.instanceOf(Object).isRequired,
    fetchListOptions: PropTypes.instanceOf(Object),
    variant: PropTypes.number,
    themeVariant: PropTypes.string,
    title: PropTypes.string,
    subTitle: PropTypes.string,
    paginationBase: PropTypes.string.isRequired,
    rowsPerPage: PropTypes.number,
    createButtonText: PropTypes.string,
    showBackButton: PropTypes.bool,
    showSearchBar: PropTypes.bool,
    showCreateButton: PropTypes.bool,
    showDeleteButton: PropTypes.bool,
    showEditButton: PropTypes.bool,
    onClickEdit: PropTypes.func,
    onClickNew: PropTypes.func,
    //
    startAt: PropTypes.string,
    endAt: PropTypes.string,
    countryIds: PropTypes.instanceOf(Array),
    stateIds: PropTypes.instanceOf(Array).isRequired,
    cityIds: PropTypes.instanceOf(Array).isRequired,
    schoolIds: PropTypes.instanceOf(Array).isRequired,
    classroomIds: PropTypes.instanceOf(Array).isRequired,
    playerIds: PropTypes.number.isRequired, // PropTypes.instanceOf(Array).isRequired,
    seasonIds: PropTypes.instanceOf(Array).isRequired,
    leagueIds: PropTypes.instanceOf(Array).isRequired,
    gameIds: PropTypes.instanceOf(Array).isRequired,
    subComponentIds: PropTypes.instanceOf(Array).isRequired,
    //
    additionalQuery: PropTypes.instanceOf(Object),
};

const mapStateToProps = ({ filter }) => ({
    startAt: filter.start_at || '',
    endAt: filter.end_at || '',
    countryIds: filter.countries.map((country) => country.id),
    stateIds: filter.states.map((state) => state.id),
    cityIds: filter.cities.map((city) => city.id),
    schoolIds: filter.schools.map((school) => school.id),
    classroomIds: filter.classrooms.map((classroom) => classroom.id),
    playerIds: 0, // filter.players.map((player) => player.id),
    seasonIds: filter.seasons.map((season) => season.id),
    leagueIds: filter.leagues.map((league) => league.id),
    gameIds: filter.games.map((game) => game.id),
    subComponentIds: filter.subComponents.map((subComponent) => subComponent.id),
});

// export default PaginatedList;
export default connect(mapStateToProps)(PaginatedList);
