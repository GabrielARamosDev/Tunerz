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
import Alert from '@mui/material/Alert';

import FormInput from '../../components/inputs/FormInput.tsx';

import { useApp } from "../../contexts/AppContext.tsx";
import { useLogin } from '../../contexts/LoginContext.tsx';

import type { Layout as LayoutType } from '../../types/layout.ts';
import type { State as StateType } from '../../types/state.ts';

const ForgotPasswordLayout = ({ currentPage }: LayoutType) => {

    const { loading, setLoading } = useApp();
    const { handleForgotPassword } = useLogin();

    const [email, setEmail] = useState('');
    const [message, setMessage] = useState('');
    const [messageType, setMessageType] = useState<'success' | 'error'>('success');
    const [submitted, setSubmitted] = useState(false);

    const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        setEmail(event.target.value);
    };

    const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        setLoading(true);
        setMessage('');

        try {
            await handleForgotPassword(email);
            setMessageType('success');
            setMessage('Se este e-mail está registrado, você receberá um link para redefinir sua senha.');
            setSubmitted(true);
            setEmail('');
        } catch (error: any) {
            setMessageType('error');
            setMessage(error.response?.data?.message || 'Erro ao processar sua solicitação');
        } finally {
            setLoading(false);
        }
    };

    return (
        <Stack sx={{ minHeight: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <Container maxWidth="sm">
                <Paper elevation={3} sx={{ p: 4 }}>
                    <Typography variant="h4" component="h1" gutterBottom sx={{ mb: 3, textAlign: 'center' }}>
                        Esqueceu sua Senha?
                    </Typography>

                    <Typography variant="body2" sx={{ mb: 3, textAlign: 'center', color: 'gray' }}>
                        Digite seu e-mail para receber um link de redefinição de senha.
                    </Typography>

                    {message && (
                        <Alert severity={messageType} sx={{ mb: 2 }}>
                            {message}
                        </Alert>
                    )}

                    <Box component="form" onSubmit={handleSubmit} sx={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
                        <FormInput
                            type="email"
                            name="email"
                            label="Email"
                            placeholder="Digite seu email"
                            value={email}
                            onChange={handleChange}
                        />

                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            size="large"
                            disabled={loading}
                            sx={{ mt: 2 }}
                        >
                            {loading ? 'Enviando...' : 'Enviar Link de Redefinição'}
                        </Button>

                        <Box sx={{ mt: 2, textAlign: 'center' }}>
                            <Typography variant="body2">
                                Lembrou sua senha? <a href="/login">Faça login aqui!</a>
                            </Typography>
                        </Box>
                    </Box>
                </Paper>
            </Container>
        </Stack>
    );

};

ForgotPasswordLayout.propTypes = { currentPage: PropTypes.object.isRequired };

const mapStateToProps = (state: StateType) => ({ currentPage: state.currentPage });

export default connect(mapStateToProps)(ForgotPasswordLayout);
