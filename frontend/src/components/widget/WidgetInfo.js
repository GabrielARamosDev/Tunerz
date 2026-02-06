import React from 'react';
import PropTypes from 'prop-types';

import { connect } from 'react-redux';

import Typography from '@mui/material/Typography';
import Grid from '@mui/material/Grid';
// import Box from '@mui/material/Box';
import Stack from '@mui/material/Stack';

const WidgetInfo = ({
    stateName,
    cityName,
    schoolName,
    seasonName,
    leagueName,
    classNumber,
    gameName,
}) => {
    const ballIcon = '/img/icons/ball.png';
    const trophyIcon = '/img/icons/trophy.png';
    const kickBallIcon = '/img/icons/ball_kick.png';
    const locationIcon = '/img/icons/locations.png';
    const schoolIcon = '/img/icons/escolas_gray.png';
    const peopleIcon = '/img/icons/group.png';

    return (
        <Stack sx={{ borderTop: '2px dashed #5E5E5E80' }} >
            {(seasonName[0] || leagueName[0] || gameName[0]) && (
                <Grid
                    container
                    xs={12}
                    md={12}
                    lg={12}
                    direction="row"
                    variant="active-filters"
                >
                    <Typography
                        variant="h3"
                        className="title"
                    >
                        Fases:
                    </Typography>

                    {seasonName[0] && (
                        <Grid
                            item
                            xs={12}
                            md={3}
                            lg={3}
                        >
                            <Stack
                                direction="row"
                                alignItems="center"
                            >
                                <img
                                    className="filter-icon"
                                    src={ballIcon}
                                    alt="ball-icon"
                                />

                                <Typography
                                    variant="h3"
                                    sx={{ pr: 1.5 }}
                                    color="text.gray"
                                >{seasonName[0]}
                                </Typography>
                            </Stack>
                        </Grid>
                    )}
                    {leagueName[0] && (
                        <Grid
                            item
                            xs={12}
                            md={3}
                            lg={3}
                        >
                            <Stack
                                direction="row"
                                alignItems="center"
                            >
                                <img
                                    className="filter-icon"
                                    src={trophyIcon}
                                    alt="trophy-icon"
                                />

                                <Typography
                                    variant="h3"
                                    sx={{ pr: 1.5 }}
                                    color="text.gray"
                                >{leagueName[0]}
                                </Typography>
                            </Stack>
                        </Grid>
                    )}
                    {gameName[0] && (
                        <Grid
                            item
                            xs={12}
                            md={3}
                            lg={3}
                        >
                            <Stack
                                direction="row"
                                alignItems="center"
                            >
                                <img
                                    className="filter-icon"
                                    src={kickBallIcon}
                                    alt="kickball-icon"
                                />

                                <Typography
                                    variant="h3"
                                    sx={{ pr: 1.5 }}
                                    color="text.gray"
                                >{gameName[0]}
                                </Typography>
                            </Stack>
                        </Grid>
                    )}
                </Grid>
            )}

            {(cityName[0] || schoolName[0] || classNumber[0]) && (
                <Grid
                    container
                    xs={12}
                    md={12}
                    lg={12}
                    direction="row"
                    variant="active-filters"
                >
                    <Typography
                        variant="h3"
                        className="title"
                    >Local:
                    </Typography>

                    {cityName[0] && (
                        <Grid
                            item
                            xs={12}
                            md={3}
                            lg={3}
                        >
                            <Stack
                                direction="row"
                                alignItems="center"
                            >
                                <img
                                    className="filter-icon"
                                    src={locationIcon}
                                    alt="location-icon"
                                />

                                <Typography
                                    variant="h3"
                                    sx={{ pr: 1.5 }}
                                    color="text.gray"
                                >{stateName[0]}, {cityName}
                                </Typography>
                            </Stack>
                        </Grid>
                    )}
                    {schoolName[0] && (
                        <Grid
                            item
                            xs={12}
                            md={3}
                            lg={3}
                        >
                            <Stack
                                direction="row"
                                alignItems="center"
                            >
                                <img
                                    className="filter-icon"
                                    src={schoolIcon}
                                    alt="school-icon"
                                />

                                <Typography
                                    variant="h3"
                                    sx={{ pr: 1.5 }}
                                    color="text.gray"
                                >{schoolName[0]}
                                </Typography>
                            </Stack>
                        </Grid>
                    )}
                    {classNumber[0] && (
                        <Grid
                            item
                            xs={12}
                            md={3}
                            lg={3}
                        >
                            <Stack
                                direction="row"
                                alignItems="center"
                            >
                                <img
                                    className="filter-icon"
                                    src={peopleIcon}
                                    alt="people-icon"
                                />

                                <Typography
                                    variant="h3"
                                    sx={{ pr: 1.5 }}
                                    color="text.gray"
                                >{classNumber[0]}
                                </Typography>
                            </Stack>
                        </Grid>
                    )}
                </Grid>
            )}
        </Stack>
    );
};

WidgetInfo.propTypes = {
    stateName: PropTypes.array,
    cityName: PropTypes.array,
    schoolName: PropTypes.array,
    seasonName: PropTypes.array,
    leagueName: PropTypes.array,
    classNumber: PropTypes.array,
    gameName: PropTypes.array,
};

const mapStateToProps = ({ filter }) => ({
    stateName: filter.states.map((state) => state.name),
    cityName: filter.cities.map((city) => city.name),
    schoolName: filter.schools.map((school) => school.name),
    seasonName: filter.seasons.map((season) => season.name),
    leagueName: filter.leagues.map((league) => league.name),
    classNumber: filter.classrooms.map((classrooms) => classrooms.name),
    gameName: filter.games.map((game) => game.name),
});
export default connect(mapStateToProps)(WidgetInfo);
