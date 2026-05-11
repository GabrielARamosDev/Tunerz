
import api from "../services/api";

import React, { createContext, useContext } from "react";
import type { ReactNode } from "react";

import type { LoginContextType } from "../types/login";
import type { Vehicle } from "../types/vehicle";

import { useApp } from "./AppContext";
import main from "../main";

interface LoginResponse {
    data: {
        access_token: string;
        token_type: string;
        user: {
            id: number;
            name: string;
            email: string;
            roles: string[];
        };
    };
    message: string;
}

const REMEMBER_ME_EMAIL_KEY = 'remember_me_email';
const REMEMBER_ME_FLAG = 'remember_me_enabled';

// Contexto em si
const LoginContext = createContext<LoginContextType | undefined>(undefined);

// Provider
export const LoginProvider = ({ children }: { children: ReactNode }) => {

    const {
        navigate,
        loading, setLoading,
        fetched, setFetched,
        status, setStatus
    } = useApp();

    /* * */

    React.useEffect(() => {
        main.state.dispatch({
            type: 'CURRENT_PAGE',
            payload: {
                name: 'login',
                title: '',
                icon: '',
                route: '/login',
                filters: [],
            }
        });
    }, []);

    /* * */

    const getSavedEmail = () => {
        const isRemembered = localStorage.getItem(REMEMBER_ME_FLAG) === 'true';
        if (isRemembered) {
            return localStorage.getItem(REMEMBER_ME_EMAIL_KEY) || '';
        }
        return '';
    };

    const handleLogin = async (email: string, password: string, rememberMe: boolean = false) => {
        setLoading(true);

        try {
            const { data: response } = await api.post<LoginResponse>('login', {
                email, 
                password, 
                remember_me: rememberMe,
            });
            console.log('Login response:', response.data);

            const { user, access_token } = response.data;

            if (access_token) {
                // Store token in localStorage
                localStorage.setItem('auth_token', access_token);

                // Handle remember me functionality
                if (rememberMe) {
                    localStorage.setItem(REMEMBER_ME_EMAIL_KEY, email);
                    localStorage.setItem(REMEMBER_ME_FLAG, 'true');
                } else {
                    // Clear remember me data if unchecked
                    localStorage.removeItem(REMEMBER_ME_EMAIL_KEY);
                    localStorage.setItem(REMEMBER_ME_FLAG, 'false');
                }

                // Set authorization header for future requests
                api.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;

                setStatus(response.message);

                main.state.dispatch({
                    type: 'APP_CREDENTIALS',
                    payload: user,
                });

                navigate('home');
            }
        } catch (error) {
            console.error('Login error:', error);
            setStatus('Erro ao realizar login.');

            throw error;
        } finally {
            setLoading(false);
        }
    };

    const handleRegister = async (registerData: any) => {
        setLoading(true);

        try {
            const { data: response } = await api.post('register', registerData);
            console.log('Register response:', response);

            setStatus(response.message);

            // Redirect to login after successful registration
            setTimeout(() => {
                navigate('login');
            }, 2000);
        } catch (error) {
            console.error('Register error:', error);
            setStatus('Erro ao registrar.');

            throw error;
        } finally {
            setLoading(false);
        }
    };

    const handleForgotPassword = async (email: string) => {
        setLoading(true);

        try {
            const { data: response } = await api.post('forgot-password', {
                email,
            });
            console.log('Forgot password response:', response);

            setStatus(response.message);
        } catch (error) {
            console.error('Forgot password error:', error);
            setStatus('Erro ao processar solicitação.');

            throw error;
        } finally {
            setLoading(false);
        }
    };

    const handleResetPassword = async (resetData: any) => {
        setLoading(true);

        try {
            const { data: response } = await api.post('reset-password', resetData);
            console.log('Reset password response:', response);

            setStatus(response.message);

            // Redirect to login after successful password reset
            setTimeout(() => {
                navigate('login');
            }, 2000);
        } catch (error) {
            console.error('Reset password error:', error);
            setStatus('Erro ao redefinir senha.');

            throw error;
        } finally {
            setLoading(false);
        }
    };

    /* * */

    return (
        <LoginContext.Provider
            value={{
                handleLogin,
                handleRegister,
                handleForgotPassword,
                handleResetPassword,
                getSavedEmail
            }}
        >
            {children}
        </LoginContext.Provider>
    );
};

// Hook para usar o contexto mais facilmente
export const useLogin = () => {

    const context = useContext(LoginContext);

    if (!context) {
        throw new Error("useLogin must be used within a LoginProvider");
    }
    return context;
};
