/* eslint-disable quotes */
/* eslint-disable react/no-unescaped-entities */

import React, { useState } from 'react';
import PropTypes from 'prop-types';

import { connect } from 'react-redux';

import Box from '@mui/material/Box';
import Stack from '@mui/material/Stack';
import Button from '@mui/material/Button';
import Container from '@mui/material/Container';
import Paper from '@mui/material/Paper';
import Typography from '@mui/material/Typography';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';

import FormInput from '../../components/inputs/FormInput.tsx';

import type { Layout as LayoutType } from '../../types/layout.ts';
import type { State as StateType } from '../../types/state.ts';

import { useApp } from "../../contexts/AppContext.tsx";
import { useLogin } from '../../contexts/LoginContext.tsx';

const LoginLayout = ({ currentPage }: LayoutType) => {

    const { loading, setLoading, navigate } = useApp();
    const { handleLogin, getSavedEmail } = useLogin();

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
                        <FormInput
                            type="email"
                            name="email"
                            label="Email"
                            placeholder="Digite seu email"
                            value={email}
                            onChange={(e: any) => setEmail(e.target.value)}
                        />
                        <FormInput
                            type="password"
                            name="password"
                            label="Senha"
                            placeholder="Digite sua senha"
                            value={password}
                            onChange={(e: any) => setPassword(e.target.value)}
                        />
                        <FormControlLabel
                            control={
                                <Checkbox
                                    checked={rememberMe}
                                    onChange={(e) => setRememberMe(e.target.checked)}
                                    disabled={loading}
                                />
                            }
                            label="Lembrar-me"
                        />
                        
                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            size="large"
                            disabled={loading}
                            sx={{ mt: 2 }}
                        >
                            {loading ? 'Conectando...' : 'Conectar'}
                        </Button>

                        <Box sx={{ mt: 2, textAlign: 'center' }}>
                            <Typography variant="body2">
                                Não tem conta? 
                                <Button
                                    size="small"
                                    sx={{ textTransform: 'none', ml: 0.5 }}
                                    onClick={() => navigate('register')}
                                    disabled={loading}
                                >
                                    Registre-se aqui!
                                </Button>
                            </Typography>

                            <Typography variant="body2" sx={{ mt: 1 }}>
                                Esqueceu sua senha? 
                                <Button
                                    size="small"
                                    sx={{ textTransform: 'none', ml: 0.5 }}
                                    onClick={() => navigate('forgot-password')}
                                    disabled={loading}
                                >
                                    Redefina aqui!
                                </Button>
                            </Typography>
                        </Box>                            
                    </Box>
                </Paper>
            </Container>
        </Stack>
    );

};

LoginLayout.propTypes = { currentPage: PropTypes.object.isRequired };

const mapStateToProps = (state: StateType) => ({ currentPage: state.currentPage });

export default connect(mapStateToProps)(LoginLayout);
