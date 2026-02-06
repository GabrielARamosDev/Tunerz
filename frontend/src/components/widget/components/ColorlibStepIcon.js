import React from 'react';
import PropTypes from 'prop-types';

import ColorlibStepIconRoot from './ColorlibStepIconRoot';

const ColorlibStepIcon = ({
    active,
    completed,
    icons = [],
    icon = null,
    //
    color = 'yellow',
    colorMode = 'main',
    gradient = true,
}) => (
    <ColorlibStepIconRoot
        ownerState={{ completed, active }}
        color={color}
        colorMode={colorMode}
        gradient={gradient}
    >
        {icon && (
            <img
                alt={`${icon}-step-icon`}
                src={`/img/icons/${icon}.svg`}
                style={{
                    width: 24,
                    height: 24,
                }}
            />
        )}
    </ColorlibStepIconRoot>
);

ColorlibStepIcon.propTypes = {
    active: PropTypes.bool.isRequired,
    completed: PropTypes.bool.isRequired,
    icons: PropTypes.instanceOf(Array),
    icon: PropTypes.string,
    //
    color: PropTypes.string,
    colorMode: PropTypes.string,
    gradient: PropTypes.bool,
};

export default ColorlibStepIcon;
