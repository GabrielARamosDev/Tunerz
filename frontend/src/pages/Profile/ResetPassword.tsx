/* eslint-disable quotes */
/* eslint-disable react/no-unescaped-entities */

import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';

import { connect } from 'react-redux';
import { useSearchParams } from 'react-router-dom';

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

const ResetPasswordLayout = ({ currentPage }: LayoutType) => {

    const { loading, setLoading } = useApp();
    const { handleResetPassword } = useLogin();
    const [searchParams] = useSearchParams();

    const token = searchParams.get('token') || '';
    const email = searchParams.get('email') || '';

    const [formData, setFormData] = useState({
        password: '',
        password_confirmation: '',
    });

    const [errors, setErrors] = useState<Record<string, string[]>>({});
    const [message, setMessage] = useState('');
    const [messageType, setMessageType] = useState<'success' | 'error'>('success');
    const [invalidToken, setInvalidToken] = useState(false);

    useEffect(() => {
        if (!token || !email) {
            setInvalidToken(true);
            setMessage('Link inválido ou expirado.');
            setMessageType('error');
        }
    }, [token, email]);

    const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = event.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
        // Clear error for this field
        if (errors[name]) {
            setErrors(prev => {
                const newErrors = { ...prev };
                delete newErrors[name];
                return newErrors;
            });
        }
    };

    const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        setLoading(true);
        setErrors({});
        setMessage('');

        try {
            await handleResetPassword({
                token,
                email,
                password: formData.password,
                password_confirmation: formData.password_confirmation,
            });
            setMessageType('success');
            setMessage('Senha redefinida com sucesso! Redirecionando para login...');
            setFormData({
                password: '',
                password_confirmation: '',
            });
        } catch (error: any) {
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setMessageType('error');
                setMessage(error.response?.data?.message || 'Erro ao redefinir senha');
            }
        } finally {
            setLoading(false);
        }
    };

    if (invalidToken) {
        return (
            <Stack sx={{ minHeight: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                <Container maxWidth="sm">
                    <Paper elevation={3} sx={{ p: 4, textAlign: 'center' }}>
                        <Alert severity="error" sx={{ mb: 2 }}>
                            {message}
                        </Alert>
                        <Typography variant="body2">
                            <a href="/forgot-password">Solicitar novo link de redefinição</a>
                        </Typography>
                    </Paper>
                </Container>
            </Stack>
        );
    }

    return (
        <Stack sx={{ minHeight: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <Container maxWidth="sm">
                <Paper elevation={3} sx={{ p: 4 }}>
                    <Typography variant="h4" component="h1" gutterBottom sx={{ mb: 3, textAlign: 'center' }}>
                        Redefinir Senha
                    </Typography>

                    {message && (
                        <Alert severity={messageType} sx={{ mb: 2 }}>
                            {message}
                        </Alert>
                    )}

                    <Box component="form" onSubmit={handleSubmit} sx={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
                        <FormInput
                            type="password"
                            name="password"
                            label="Nova Senha"
                            placeholder="Digite sua nova senha"
                            value={formData.password}
                            onChange={handleChange}
                        />

                        <FormInput
                            type="password"
                            name="password_confirmation"
                            label="Confirmar Senha"
                            placeholder="Confirme sua nova senha"
                            value={formData.password_confirmation}
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
                            {loading ? 'Redefinindo...' : 'Redefinir Senha'}
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

ResetPasswordLayout.propTypes = { currentPage: PropTypes.object.isRequired };

const mapStateToProps = (state: StateType) => ({ currentPage: state.currentPage });

export default connect(mapStateToProps)(ResetPasswordLayout);
