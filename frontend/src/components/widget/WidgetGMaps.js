import React from 'react';
import PropTypes from 'prop-types';

import { connect } from 'react-redux';

import useFetchList from '../../hooks/useFetchList';

import School from '../../models/School';

import Typography from '@mui/material/Typography';
import Stack from '@mui/material/Stack';
import Box from '@mui/material/Box';
// import CircularProgress from '@mui/material/CircularProgress';

const WidgetGMaps = ({
    widgetValue,
    options,
    countries: filteredCountries,
    states: filteredStates,
    cities: filteredCities,
    schools: filteredSchools,
}) => {
    const mapCanvas = React.useRef();
    const [map, setMap] = React.useState(null);

    const { L } = window;

    const defaultBounds = [
        [7, -30], // MAX
        [-35, -80], // MIN
    ];

    React.useEffect(() => {
        if (map === null) {
            const tempMap = new L.Map('map')
                .fitBounds(defaultBounds);

            tempMap.addLayer(new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'));
            setMap(tempMap);
        }
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [
        mapCanvas,
        map,
    ]);

    const { items: schools } = useFetchList({
        model: School,
        initialRowsPerPage: 9999,
        query: {
            country_ids: filteredCountries.map((c) => c.id),
            state_ids: filteredStates.map((s) => s.id),
            city_ids: filteredCities.map((c) => c.id),
        },
    }, [
        filteredCountries.length,
        filteredStates.length,
        filteredCities.length,
    ]);

    React.useEffect(() => {
        if (map !== null) {
            const schoolArray = filteredSchools.length > 0
                ? filteredSchools.filter((f) => !f.map_hidden)
                : schools.filter((f) => !f.attributes.map_hidden);

            if (schoolArray.length > 0) {
                if (filteredStates.length > 0
                    || filteredCities.length > 0
                    || filteredSchools.length > 0
                ) {
                    const { bounds } = schoolsBounds(schoolArray);
                    map.fitBounds([
                        [bounds.maxLat, bounds.maxLng],
                        [bounds.minLat, bounds.minLng],
                    ]);
                }

                pinSchools(schoolArray);
            }
        }
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [
        filteredStates,
        filteredCities,
        filteredSchools,
        schools,
        map,
    ]);

    const schoolsBounds = (schs) => {
        const data = {
            lat: -14.3842716,
            lng: -51.1575597,
            zoom: 4,
            bounds: {
                maxLat: 0,
                maxLng: 0,
                minLat: 0,
                minLng: 0,
            },
        };

        schs.forEach((school, i) => {
            const { latitude, longitude } = school.attributes ? school.attributes : school;

            data.lat += latitude;
            data.lng += longitude;

            if (i === 0) {
                data.bounds.maxLat = latitude;
                data.bounds.maxLng = longitude;
            } else {
                if (data.bounds.maxLat < latitude) {
                    data.bounds.maxLat = latitude;
                }
                if (data.bounds.maxLng < longitude) {
                    data.bounds.maxLng = longitude;
                }
            }

            if (data.bounds.minLat > latitude) {
                data.bounds.minLat = latitude;
            }
            if (data.bounds.minLng > longitude) {
                data.bounds.minLng = longitude;
            }
        });

        data.lat = data.lat / schs.length;
        data.lng = data.lng / schs.length;

        data.zoom = schs.length > 1
            ? Math.round(Math.sqrt(Math.pow(data.bounds.minLat - data.bounds.maxLat, 2)
                    + Math.pow(data.bounds.minLng - data.bounds.maxLng, 2)) / 3)
            : 17;

        // console.log('geoData: ', data);
        return data;
    };

    const pinSchools = (schs) => {
        const myIcon = L.icon({
            iconUrl: '/img/icons/Map-Pin-3.png',
            iconSize: [40, 40],
        });

        schs.forEach((school) => {
            const {
                name,
                latitude,
                longitude,
            } = school.attributes
                ? school.attributes
                : school;

            new L.Marker([latitude, longitude], {
                title: name,
                draggable: false,
                icon: myIcon,
            })
                .addTo(map)
                .bindPopup(name);
            // .openPopup();
        });
    };

    return (
        <Stack variant="widget-v1" >
            <Typography
                variant="h2"
                className="title"
            >
                {options.titulo}
            </Typography>

            <Box
                id="map"
                ref={mapCanvas}
                sx={{ width: '100%', height: 550 }}
            />
        </Stack>
    );
};

WidgetGMaps.propTypes = {
    widgetValue: PropTypes.object.isRequired,
    options: PropTypes.object.isRequired,
    countries: PropTypes.array,
    states: PropTypes.array.isRequired,
    cities: PropTypes.array.isRequired,
    schools: PropTypes.array.isRequired,
};

const mapStateToProps = ({ filter }) => ({
    countries: filter.countries.map((country) => country),
    states: filter.states.map((state) => state),
    cities: filter.cities.map((city) => city),
    schools: filter.schools.map((school) => school),
});
export default connect(mapStateToProps)(WidgetGMaps);
