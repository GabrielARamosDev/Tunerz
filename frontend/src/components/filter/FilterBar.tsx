import React from 'react';
import PropTypes from 'prop-types';

import { connect, useSelector } from 'react-redux';

import useFetchList from '../../hooks/useFetchList';

import Country from '../../models/Country';
import State from '../../models/State';
import City from '../../models/City';
// import School from '../../models/School';
// import Classroom from '../../models/Classroom';

// import Season from '../../models/Season';
// import League from '../../models/League';
// import Game from '../../models/Game';
// import SubComponent from '../../models/SubComponent';

import Filter from './Filter.tsx';
import FilterField from './FilterField.tsx';

import type { State as StateType } from '../../types/state';
import type { Filter as FilterType } from '../../types/filter';

const DEFAULT_OBJ = {
    label: 'label',
    key: 'key',
    options: [],
    tableColumn: 'name',
    disabled: false,
};

const FilterBar = ({
    currentPage,
    countryIds,
    stateIds,
    cityIds,
    schoolIds,
    seasonIds,
    leagueIds,
    gameIds,
}: FilterType) => {

    const user = useSelector((state: StateType) => state.app.user);
    const userRole = user.roles[0];

    // Locations
    const { items: countries } = useFetchList({
        model: Country,
        initialRowsPerPage: 9999,
    });
    const { items: states } = useFetchList({
        model: State,
        initialRowsPerPage: 9999,
        query: { country_ids: countryIds },
    }, [countryIds.length]);
    const { items: cities } = useFetchList({
        model: City,
        initialRowsPerPage: 9999,
        query: { state_ids: stateIds },
    }, [stateIds.length]);
    // const { items: schools } = useFetchList({
    //     model: School,
    //     initialRowsPerPage: 9999,
    //     query: {
    //         country_ids: countryIds,
    //         state_ids: stateIds,
    //         city_ids: cityIds,
    //     },
    // }, [cityIds.length]);
    // const { items: classrooms } = useFetchList({
    //     model: Classroom,
    //     initialRowsPerPage: 9999,
    //     query: { school_ids: schoolIds },
    // }, [schoolIds.length]);

    // // Phases
    // const { items: seasons } = useFetchList({
    //     model: Season,
    //     initialRowsPerPage: 9999,
    // });
    // const { items: leagues } = useFetchList({
    //     model: League,
    //     initialRowsPerPage: 9999,
    // });
    // const { items: games } = useFetchList({
    //     model: Game,
    //     initialRowsPerPage: 9999,
    // });
    // const { items: subComponents } = useFetchList({
    //     model: SubComponent,
    //     initialRowsPerPage: 9999,
    //     query: { game_ids: gameIds },
    // }, [gameIds.length]);

    const FILTER_LOCATIONS: any = {
        variant: 'gradient-cyan',
        items: [
            {
                props: {
                    ...DEFAULT_OBJ,
                    label: 'País',
                    key: 'countries',
                    options: countries,
                    disabled: true,
                },
                permitted: [1, 2], // de acordo com a 'roleId'
            },
            {
                props: {
                    ...DEFAULT_OBJ,
                    label: 'Estado',
                    key: 'states',
                    options: states,
                },
                permitted: [1, 2], // de acordo com a 'roleId'
            },
            {
                props: {
                    ...DEFAULT_OBJ,
                    label: 'Cidade',
                    key: 'cities',
                    options: cities,
                },
                permitted: [1, 2], // de acordo com a 'roleId'
            },
            // {
            //     props: {
            //         ...DEFAULT_OBJ,
            //         label: 'Escola',
            //         key: 'schools',
            //         options: schools,
            //     },
            //     permitted: [1, 2, 3, 5], // de acordo com a 'roleId'
            // },
            // {
            //     props: {
            //         ...DEFAULT_OBJ,
            //         label: 'Turma',
            //         key: 'classrooms',
            //         options: classrooms,
            //         disabled: schoolIds.length === 0,
            //     },
            //     permitted: [], // de acordo com a 'roleId'
            // },
        ],
    };
    const FILTER_PHASES: any = {
        variant: 'gradient-orange',
        items: [
            // {
            //     ...DEFAULT_OBJ,
            //     label: 'Temporada',
            //     key: 'seasons',
            //     options: seasons,
            // },
            // {
            //     ...DEFAULT_OBJ,
            //     label: 'Liga',
            //     key: 'leagues',
            //     options: leagues,
            // },
            // {
            //     ...DEFAULT_OBJ,
            //     label: 'Partida',
            //     key: 'games',
            //     options: games,
            //     // disabled: (seasonIds.length === 0 && leagueIds.length === 0)
            // },
            // {
            //     ...DEFAULT_OBJ,
            //     label: 'Unid. Temática',
            //     key: 'subComponents',
            //     options: subComponents,
            //     tableColumn: 'description',
            //     disabled: gameIds.length === 0 || ['monitoring'].includes(currentPage.name),
            // },
        ],
    };

    // React.useEffect(() => {
    //     if (schools.length > 0) {
    //         if ([4].includes(userRole.id)) {
    //             schoolIds.push(schools[0].id);
    //         }
    //     }
    // }, [schools.length]);

    const verifyPermission = (module: any) => {
        if (module.permitted.length <= 0) {
            return true;
        }
        if (module.permitted.length > 0 && module.permitted.includes(userRole.id)) {
            return true;
        }
        return false;
    };

    return (
        <React.Fragment>
            <Filter
                variant={FILTER_LOCATIONS.variant}
                title="Filtrar por Território"
            >
                {FILTER_LOCATIONS.items
                    .map((location: any) => {
                        // eslint-disable-next-line prefer-destructuring
                        const {
                            key,
                            label,
                            options,
                            tableColumn,
                            disabled,
                            ...props
                        } = location.props;

                        return (
                            <React.Fragment key={`${key}_${tableColumn}`}>
                                {verifyPermission(location) && (
                                    <FilterField
                                        variant={FILTER_LOCATIONS.variant}

                                        label={label}
                                        name={key}

                                        options={options.map((opt: any) => opt.serialize())}
                                        columnName={tableColumn}

                                        disabled={disabled}

                                        {...props}
                                    />
                                )}
                            </React.Fragment>
                        );
                    })
                }
            </Filter>

            <Filter
                variant={FILTER_PHASES.variant}
                title="Filtrar por Etapa"
            >
                {FILTER_PHASES.items
                    .map((phase: any) => {
                        const {
                            key,
                            label,
                            options,
                            tableColumn,
                            disabled,
                            ...props
                        } = phase;

                        return (
                            <FilterField
                                key={`${key}_${tableColumn}`}
                                variant={FILTER_PHASES.variant}

                                label={label}
                                name={key}

                                options={options.map((opt: any) => opt.serialize())}
                                columnName={tableColumn}

                                disabled={disabled}

                                {...props}
                            />
                        );
                    })
                }
            </Filter>
        </React.Fragment>
    );
};

FilterBar.propTypes = {
    currentPage: PropTypes.instanceOf(Object).isRequired,
    countryIds: PropTypes.instanceOf(Array).isRequired,
    stateIds: PropTypes.instanceOf(Array).isRequired,
    cityIds: PropTypes.instanceOf(Array).isRequired,
    schoolIds: PropTypes.instanceOf(Array).isRequired,
    seasonIds: PropTypes.instanceOf(Array).isRequired,
    leagueIds: PropTypes.instanceOf(Array).isRequired,
    gameIds: PropTypes.instanceOf(Array).isRequired,
};

const mapStateToProps = ({ filter, currentPage }: StateType) => ({
    currentPage,
    countryIds: filter.countries.map((country: any) => country.id),
    stateIds: filter.states.map((state: any) => state.id),
    cityIds: filter.cities.map((city: any) => city.id),
    schoolIds: filter.schools.map((school: any) => school.id),
    seasonIds: filter.seasons.map((season: any) => season.id),
    leagueIds: filter.leagues.map((league: any) => league.id),
    gameIds: filter.games.map((game: any) => game.id),
});
export default connect(mapStateToProps)(FilterBar);
