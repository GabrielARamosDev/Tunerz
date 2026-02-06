import React from 'react';
import PropTypes from 'prop-types';

import ArrowDropDownIcon from '@mui/icons-material/ArrowDropDown';
import ArrowDropUpIcon from '@mui/icons-material/ArrowDropUp';
import CloseIcon from '@mui/icons-material/Close';
import DeleteForeverIcon from '@mui/icons-material/DeleteForever';
import DownhillSkiingIcon from '@mui/icons-material/DownhillSkiing';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import InboxIcon from '@mui/icons-material/MoveToInbox';
import LogoutIcon from '@mui/icons-material/Logout';
import MailIcon from '@mui/icons-material/Mail';
import ManageHistoryIcon from '@mui/icons-material/ManageHistory';
import MenuIcon from '@mui/icons-material/Menu';
import ModeEditIcon from '@mui/icons-material/ModeEdit';
import PeopleAltIcon from '@mui/icons-material/PeopleAlt';
import PsychologyIcon from '@mui/icons-material/Psychology';
import SchoolIcon from '@mui/icons-material/School';
import SearchIcon from '@mui/icons-material/Search';

const Icons = {
    ArrowDropDownIcon,
    ArrowDropUpIcon,
    CloseIcon,
    DeleteForeverIcon,
    DownhillSkiingIcon,
    ExpandMoreIcon,
    HomeOutlinedIcon,
    InboxIcon,
    LogoutIcon,
    MailIcon,
    ManageHistoryIcon,
    MenuIcon,
    ModeEditIcon,
    PeopleAltIcon,
    PsychologyIcon,
    SchoolIcon,
    SearchIcon,
};

// const bsIcons = {
//     repeat: Repeat,
//     upc: Upc,
//     x: X,
//     'graph-up': GraphUpArrow,
//     warning: ExclamationTriangle,
// };

const Icon = ({ icon, ...props }) => {
    // if (Object.keys(bsIcons).includes(icon)) {
    //     const { [icon]: Icon } = bsIcons;
    //     return <Icon {...props} />;
    // }

    // return (
    //     <FontAwesomeIcon
    //         icon={Object.keys(Icons).includes(icon) ? Icons[icon] : faQuestion}
    //         {...props}
    //     />
    // );

    return (
        <>
            {Object.keys(Icons).includes(icon) ? Icons[icon] : ('n/a')}
        </>
    );
};

Icon.propTypes = { icon: PropTypes.oneOf(Object.keys({ ...Icons/*, ...bsIcons*/ })) };

export default Icon;