import React from 'react';
import { connect } from 'react-redux';

import PropTypes from 'prop-types';

import useFetchUrl from '../../hooks/useFetchUrl';

import WidgetKpi from './WidgetKpi';
import WidgetPie from './WidgetPie';
import WidgetStep from './WidgetStep';

import WidgetSingleBar from './WidgetSingleBar';
import WidgetMultipleBars from './WidgetMultipleBars';
import WidgetMultipleBarsCount from './WidgetMultipleBarsCount';
import WidgetMedals from './WidgetMedals';
import WidgetTrophies from './WidgetTrophies';
import WidgetMultipleBarsDescription from './WidgetMultipleBarsDescription';
import WidgetCircular from './WidgetCircular';
import WidgetImageTextSide from './WidgetImageTextSide';
import WidgetGMaps from './WidgetGMaps';

import Skeleton from '@mui/material/Skeleton';
import Paper from '@mui/material/Paper';

const mapTypesToComponents = {
    number: WidgetKpi,
    pie: WidgetPie,
    circular: WidgetCircular,
    'image-text-side': WidgetImageTextSide,
    metro: WidgetStep,
    'single-bar': WidgetSingleBar,
    'multiple-bar': WidgetMultipleBars,
    'multiple-bar-descp': WidgetMultipleBarsDescription,
    'multiple-bar-count': WidgetMultipleBarsCount,
    medals: WidgetMedals,
    trophies: WidgetTrophies,
    'g-maps': WidgetGMaps,
};

const Widget = ({
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
    options,
    additionalQuery = {},
    //
    version = 1,
}) => {
    const { cor, type, url } = options;

    const { data: widgetValue, isLoading } = useFetchUrl({
        url: `/api/v${version}/scout/widgets/${url}`,
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

    /**
     * additionalQuery será usado para a seleção do relatório do aluno
     * e deverá ser enviado caso necessário. Caso não, objeto vazio
     *
     * Buscar maneira de enviar o school_id juntamente no objeto de parâmetro do hook acima,
     * SOMENTE QUANDO o url for widget/hours
     */

    const WidgetComponent = React.useMemo(() => mapTypesToComponents[type], [type]);

    return (
        <Paper
            variant="outlined"
            color={cor}
            // sx={{ height: '100%' }}
        >
            {isLoading
                ? (
                    <Skeleton
                        variant="rounded"
                        height={60}
                    />
                )
                : (
                    <WidgetComponent
                        widgetValue={widgetValue}
                        options={options}
                    />
                )
            }
        </Paper>
    );
};

Widget.propTypes = {
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
    options: PropTypes.instanceOf(Object).isRequired,
    additionalQuery: PropTypes.instanceOf(Object),
    //
    version: PropTypes.number,
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
export default connect(mapStateToProps)(Widget);
