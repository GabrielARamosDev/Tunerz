/* eslint-disable react/no-array-index-key */
/* eslint-disable react/no-multi-comp */

import React from 'react';
import PropTypes from 'prop-types';

import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import Collapse from '@mui/material/Collapse';
import ButtonBase from '@mui/material/ButtonBase';
import Pagination from '@mui/material/Pagination';

import LinearBar from './LinearBar';
import CustomIcon from '../layout/CustomIcon';

const ITEMS_PER_PAGE = 5;

const BasicWidget = ({
    valor, lineTitle, description, corItem,
}) => {
    const [isExpanded, setIsExpanded] = React.useState(false);

    const toggleExpansion = () => {
        setIsExpanded(!isExpanded);
    };

    const newValue = valor * 100;

    return (
        <Stack sx={{ mb: 3 }}>
            <Stack
                direction="row"
                alignItems="center"
                justifyContent="space-between"
                sx={{ ml: 1.9375, mr: 2.1875, mb: .375 }}
            >
                <Stack>
                    <ButtonBase
                        onClick={toggleExpansion}
                        sx={{ alignSelf: 'baseline' }}
                    >
                        <Stack
                            direction="row"
                            alignItems="center"
                        >
                            <Typography
                                variant="h3"
                                color="primary"
                                sx={{
                                    fontSize: 18,
                                    fontWeight: '800',
                                    // mb: 1.25,
                                }}
                            >
                                {lineTitle}
                            </Typography>

                            {isExpanded
                                ? (
                                    <CustomIcon
                                        icon="expand-up"
                                        sx={{
                                            color: (theme) => theme.palette.primary.main,
                                            justifyContent: 'center',
                                            fontSize: 30,
                                        }}
                                    />
                                )
                                : (
                                    <CustomIcon
                                        icon="expand-down"
                                        sx={{
                                            color: (theme) => theme.palette.primary.main,
                                            fontSize: 30,
                                        }}
                                    />
                                )
                            }
                        </Stack>
                    </ButtonBase>
                    <Collapse
                        orientation="vertical"
                        in={isExpanded}
                        timeout="auto"
                        unmountOnExit
                    >
                        <Typography
                            variant="h3"
                            color="text.gray"
                            sx={{
                                // color: '#777777',
                                fontSize: 15,
                                fontWeight: '700',
                                mb: 1.25,
                            }}
                        >
                            {description}
                        </Typography>
                    </Collapse>
                </Stack>
                <Typography
                    variant="h3"
                    color="primary"
                    sx={{
                        fontSize: 18,
                        fontWeight: '800',
                    }}
                >
                    {`${newValue.toFixed(0)?.toString()}%`}
                </Typography>
            </Stack>
            <LinearBar
                valor={newValue}
                barcolor={corItem}
            />
        </Stack>
    );
};

BasicWidget.propTypes = {
    valor: PropTypes.number.isRequired,
    lineTitle: PropTypes.string.isRequired,
    description: PropTypes.string.isRequired,
    corItem: PropTypes.string.isRequired,
};

const WidgetMultipleBarsDescription = ({
    widgetValue,
    options,
}) => {
    const [currentPage, setCurrentPage] = React.useState(1);

    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
    const endIndex = startIndex + ITEMS_PER_PAGE;

    const itemQuant = (widgetValue.habilidades_bncc || []).slice(startIndex, endIndex);

    const { titulo, descricao, corItem } = options;

    console.log(widgetValue);

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
                            <BasicWidget
                                key={`WidgetMultipleBarsDescription-${index}-line-${element.value}`}
                                valor={element.value}
                                lineTitle={element.code}
                                description={element.description}
                                corItem={corItem}
                            />
                        ))}

                        <Pagination
                            sx={{ alignSelf: 'center', mb: 2.5 }}
                            count={Math.ceil((widgetValue.habilidades_bncc || []).length / ITEMS_PER_PAGE)}
                            page={currentPage}
                            onChange={(event, page) => setCurrentPage(page)}
                        />
                    </>
                )
            }
        </Stack>
    );
};

WidgetMultipleBarsDescription.propTypes = {
    widgetValue: PropTypes.instanceOf(Object).isRequired,
    options: PropTypes.instanceOf(Object),
};

export default WidgetMultipleBarsDescription;
