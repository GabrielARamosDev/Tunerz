/* eslint-disable quotes */
/* eslint-disable react/no-unescaped-entities */

import React, { useState } from 'react';
import PropTypes from 'prop-types';

import { connect } from 'react-redux';

import { Outlet } from 'react-router-dom';

import NavMenu from '../../components/layout/NavMenu.tsx';

import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Stack from '@mui/material/Stack';
import Toolbar from '@mui/material/Toolbar';
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';
import Container from '@mui/material/Container';
import Paper from '@mui/material/Paper';
import Typography from '@mui/material/Typography';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';

import Loading from '../../components/loading.tsx';

import NotificationBar from '../../components/dialog/NotificationBar.tsx';
import DialogBar from '../../components/dialog/DialogBar.tsx';
import Footer from '../../components/layout/Footer.tsx';

import dialog from '../../controllers/dialog/index.ts';
import auth from '../../controllers/auth/index.ts';

import type { Layout as LayoutType } from '../../types/layout.ts';
import type { State as StateType } from '../../types/state.ts';

import { useApp } from "../../contexts/AppContext.tsx";
import { useLogin } from '../../contexts/LoginContext.tsx';

const LoginLayout = ({ currentPage }: LayoutType) => {

    const {
        loading, setLoading, 
        theme, appBarHeight,
        footerWindowDiff,
        renderPageTitle
    } = useApp();

    const { handleLogin, getSavedEmail } = useLogin();

    /* * */

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [rememberMe, setRememberMe] = useState(false);

    React.useEffect(() => {
        const savedEmail = getSavedEmail();
        if (savedEmail) {
            setEmail(savedEmail);
            setRememberMe(true);
        }
    }, [getSavedEmail]);

    /* * */

    const handleEmailChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        setEmail(event.target.value);
    };

    const handlePasswordChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        setPassword(event.target.value);
    };

    const handleRememberMeChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        setRememberMe(event.target.checked);
    };

    const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        setLoading(true);

        try {
            await handleLogin(email, password, rememberMe);
        } catch (error) {
            console.error('Login failed:', error);
        } finally {
            setLoading(false);
        }
    };

    /* * */

    return (
        <Stack sx={{ minHeight: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <Container maxWidth="sm">
                <Paper elevation={3} sx={{ p: 4 }}>
                    <Typography variant="h4" component="h1" gutterBottom sx={{ mb: 3, textAlign: 'center' }}>
                        Login
                    </Typography>
                    <Box component="form" onSubmit={handleSubmit} sx={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
                        <TextField
                            label="Email"
                            type="email"
                            fullWidth
                            required
                            value={email}
                            onChange={handleEmailChange}
                            disabled={loading}
                        />
                        <TextField
                            label="Password"
                            type="password"
                            fullWidth
                            required
                            value={password}
                            onChange={handlePasswordChange}
                            disabled={loading}
                        />
                        <FormControlLabel
                            control={
                                <Checkbox
                                    checked={rememberMe}
                                    onChange={handleRememberMeChange}
                                    disabled={loading}
                                />
                            }
                            label="Remember me"
                        />
                        
                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            size="large"
                            disabled={loading}
                            sx={{ mt: 2 }}
                        >
                            {loading ? 'Logging in...' : 'Login'}
                        </Button>
                    </Box>
                </Paper>
            </Container>
        </Stack>
    );

};

LoginLayout.propTypes = { currentPage: PropTypes.object.isRequired };

const mapStateToProps = (state: StateType) => ({ currentPage: state.currentPage });

export default connect(mapStateToProps)(LoginLayout);
