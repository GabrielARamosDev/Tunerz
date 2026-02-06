/* eslint-disable react/no-array-index-key */
/* eslint-disable no-extra-parens */
/* eslint-disable react/no-multi-comp */

import React from 'react';
import PropTypes from 'prop-types';

import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import Pagination from '@mui/material/Pagination';

import LinearBar from './LinearBar';

const ITEMS_PER_PAGE = 5;

const WidgetMultipleBarsCount = ({
    widgetValue,
    options,
}) => {
    const [currentPage, setCurrentPage] = React.useState(1);

    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
    const endIndex = startIndex + ITEMS_PER_PAGE;

    const itemQuant = (widgetValue.dados || []).slice(startIndex, endIndex);

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
                        {itemQuant.sort((a, b) => b.value - a.value)
                            .map((element, i, arr) => (
                                <BasicRow
                                    key={`WidgetMultipleBarsCount-${i}-linha-${element.value}`}
                                    texto={element.texto}
                                    value={element.value}
                                    valueToCompare={arr[0].value}
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

WidgetMultipleBarsCount.propTypes = {
    widgetValue: PropTypes.instanceOf(Object).isRequired,
    options: PropTypes.instanceOf(Object),
};

export default WidgetMultipleBarsCount;

const BasicRow = ({
    texto, value, valueToCompare, barcolor,
}) => {
    const percentValue = valueToCompare !== null
        ? (value / valueToCompare) * 100
        : 100;

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
                    {value.toFixed(0).toString()}
                </Typography>
            </Stack>

            <LinearBar
                valor={percentValue}
                barcolor={barcolor}
            />
        </Stack>
    );
};

BasicRow.propTypes = {
    texto: PropTypes.string.isRequired,
    value: PropTypes.number,
    valueToCompare: PropTypes.number,
    barcolor: PropTypes.string,
};
