import { useTheme } from '@mui/material';

export default (button, isDirty = true) => {
    const theme = useTheme();

    let temp = { ...theme.typography[button] };

    if (!isDirty) {
        temp = { ...temp, ...theme.typography.btnDisabled };
    }

    return temp;
};
