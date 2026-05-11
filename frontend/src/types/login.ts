
export interface LoginContextType {
    handleLogin: (email: string, password: string, rememberMe?: boolean) => Promise<any>;
    handleRegister: (registerData: any) => Promise<any>;
    handleForgotPassword: (email: string) => Promise<any>;
    handleResetPassword: (resetData: any) => Promise<any>;
    getSavedEmail: () => string;
};
