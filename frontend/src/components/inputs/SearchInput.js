import React from 'react';
import PropTypes from 'prop-types';

import Paper from '@mui/material/Paper';
import InputBase from '@mui/material/InputBase';
import IconButton from '@mui/material/IconButton';

import SearchIcon from '@mui/icons-material/Search';

const SearchInput = ({
    value, onChange, onSearch = () => { }, sx = {}, placeholder = 'Buscar', ...props
}) => (
    <Paper
        component="form"
        sx={{
            p: '2px 4px', display: 'flex', alignItems: 'center', ...sx,
        }}
        onSubmit={(e) => {
            e.preventDefault();
            onSearch(value);
        }}
    >
        <IconButton
            type="submit"
            sx={{ p: '10px' }}
            aria-label="search"
        >
            <SearchIcon />
        </IconButton>
        <InputBase
            sx={{ ml: 1, flex: 1, color: 'text.primary' }}
            placeholder={placeholder}
            inputProps={{ 'aria-label': placeholder.toLocaleLowerCase() }}
            type="search"
            value={value}
            onChange={onChange}
            {...props}
        />
    </Paper>
);

SearchInput.propTypes = {
    value: PropTypes.string,
    onChange: PropTypes.func,
    onSearch: PropTypes.func,
    sx: PropTypes.object,
    placeholder: PropTypes.string,
};

export default SearchInput;
