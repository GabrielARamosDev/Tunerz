/* eslint-disable react/no-array-index-key */
/* eslint-disable react/no-multi-comp */

import React from 'react';
import PropTypes from 'prop-types';

import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import Pagination from '@mui/material/Pagination';

import LinearBar from './LinearBar';

const ITEMS_PER_PAGE = 5;

const BasicRow = ({ texto, value, barcolor }) => {
    const newValue = value * 100;

    return (
        <Stack sx={{ mb: 3 }}>
            <Stack
                direction="row"
                alignItems="center"
                justifyContent="space-between"
                sx={{ ml: 1.9375, mr: 2.1875, mb: .375 }}
            >
                <Typography
                    variant="h3"
                    sx={{
                        color: (theme) => theme.palette.primary.main, fontSize: 18, fontWeight: '800', mb: 1.25,
                    }}
                >
                    {texto}
                </Typography>

                <Typography
                    variant="h3"
                    sx={{ color: (theme) => theme.palette.primary.main, fontSize: 18, fontWeight: '800' }}
                >
                    {newValue.toFixed(2).toString()}%
                </Typography>
            </Stack>

            <LinearBar
                valor={newValue}
                barcolor={barcolor}
            />
        </Stack>
    );
};

BasicRow.propTypes = {
    texto: PropTypes.string.isRequired,
    value: PropTypes.number,
    barcolor: PropTypes.string,
};

const WidgetMultipleBars = ({
    widgetValue,
    options,
}) => {
    const [currentPage, setCurrentPage] = React.useState(1);

    const startIndex = React.useMemo(() => (currentPage - 1) * ITEMS_PER_PAGE, [currentPage]);
    const endIndex = React.useMemo(() => startIndex + ITEMS_PER_PAGE, [startIndex]);

    const itemQuant = React.useMemo(
        () => (widgetValue.dados || []).slice(startIndex, endIndex),
        // eslint-disable-next-line react-hooks/exhaustive-deps
        [startIndex, endIndex],
    );

    // Exemplo de objeto a ser passado por parâmetro: [{valor: 90, texto: 'Teste'}, ...];
    // O title é uma String e é usada para o t título de todo widget

    const { titulo, descricao, corItem } = options;

    const {
        invalid,
        message,
    } = widgetValue;

    return (
        <Stack variant="widget-v1" >
            <Typography
                variant="h2"
                className="title"
            >
                {titulo}
            </Typography>

            {descricao && descricao !== '' && (
                <Typography
                    variant="h2"
                    className="description"
                >
                    {descricao}
                </Typography>
            )}

            {invalid
                ? (
                    <Typography
                        variant="h3"
                        className="no-wgt-msg"
                    >
                        {message}
                    </Typography>
                )
                : (
                    <>
                        {itemQuant.map((element, index) => (
                            <BasicRow
                                key={`WidgetMultipleBars-${index}-linha-${element.value}`}
                                texto={element.texto}
                                value={element.value}
                                barcolor={corItem}
                            />
                        ))}

                        <Pagination
                            sx={{ alignSelf: 'center', mb: 2.5 }}
                            count={Math.ceil((widgetValue.dados || []).length / ITEMS_PER_PAGE)}
                            page={currentPage}
                            onChange={(event, page) => setCurrentPage(page)}
                        />
                    </>
                )
            }
        </Stack>
    );
};

WidgetMultipleBars.propTypes = {
    widgetValue: PropTypes.instanceOf(Object).isRequired,
    options: PropTypes.instanceOf(Object),
};

export default WidgetMultipleBars;
