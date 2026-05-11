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

const RegisterLayout = ({ currentPage }: LayoutType) => {

    const { loading, setLoading } = useApp();
    const { handleRegister } = useLogin();

    const [formData, setFormData] = useState({
        name: '',
        email: '',
        phone: '',
        password: '',
        password_confirmation: '',
    });

    const [errors, setErrors] = useState<Record<string, string[]>>({});
    const [successMessage, setSuccessMessage] = useState('');

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
        setSuccessMessage('');

        try {
            await handleRegister(formData);
            setSuccessMessage('Registrado com sucesso! Redirecionando para login...');
            setFormData({
                name: '',
                email: '',
                phone: '',
                password: '',
                password_confirmation: '',
            });
        } catch (error: any) {
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setErrors({ form: [error.response?.data?.message || 'Erro ao registrar'] });
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <Stack sx={{ minHeight: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <Container maxWidth="sm">
                <Paper elevation={3} sx={{ p: 4 }}>
                    <Typography variant="h4" component="h1" gutterBottom sx={{ mb: 3, textAlign: 'center' }}>
                        Registrar
                    </Typography>

                    {successMessage && (
                        <Alert severity="success" sx={{ mb: 2 }}>
                            {successMessage}
                        </Alert>
                    )}

                    {errors.form && (
                        <Alert severity="error" sx={{ mb: 2 }}>
                            {errors.form[0]}
                        </Alert>
                    )}

                    <Box component="form" onSubmit={handleSubmit} sx={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
                        <FormInput
                            type="text"
                            name="name"
                            label="Nome Completo"
                            placeholder="Digite seu nome"
                            value={formData.name}
                            onChange={handleChange}
                        />

                        <FormInput
                            type="email"
                            name="email"
                            label="Email"
                            placeholder="Digite seu email"
                            value={formData.email}
                            onChange={handleChange}
                        />

                        <FormInput
                            type="tel"
                            name="phone"
                            label="Telefone"
                            placeholder="Digite seu telefone"
                            value={formData.phone}
                            onChange={handleChange}
                        />

                        <FormInput
                            type="password"
                            name="password"
                            label="Senha"
                            placeholder="Digite sua senha"
                            value={formData.password}
                            onChange={handleChange}
                        />

                        <FormInput
                            type="password"
                            name="password_confirmation"
                            label="Confirmar Senha"
                            placeholder="Confirme sua senha"
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
                            {loading ? 'Registrando...' : 'Registrar'}
                        </Button>

                        <Box sx={{ mt: 2, textAlign: 'center' }}>
                            <Typography variant="body2">
                                Já tem uma conta? <a href="/login">Faça login aqui!</a>
                            </Typography>
                        </Box>
                    </Box>
                </Paper>
            </Container>
        </Stack>
    );

};

RegisterLayout.propTypes = { currentPage: PropTypes.object.isRequired };

const mapStateToProps = (state: StateType) => ({ currentPage: state.currentPage });

export default connect(mapStateToProps)(RegisterLayout);
