import React from 'react';
import propTypes from 'prop-types';

// Icons import
import ArrowDropDownIcon from '@mui/icons-material/ArrowDropDown';
import ArrowDropUpIcon from '@mui/icons-material/ArrowDropUp';

// Uso do Component
// Importe o componente e passe, como propriedade, o nome do respectivo nome setado para o ícone importado.

const iconNameMap = {
    // Adicione o ícone desejado aqui com o respectivo nome e o nome do Import (lembree-se do import)
    'expand-down': ArrowDropDownIcon,
    'expand-up': ArrowDropUpIcon,
};

const CustomIcon = ({ icon, ...props }) => {
    const UsedIcon = React.useMemo(() => iconNameMap[icon], [icon]);
    return (
        <UsedIcon {...props} />
    );
};

CustomIcon.propTypes = { icon: propTypes.string.isRequired };

export default CustomIcon;
