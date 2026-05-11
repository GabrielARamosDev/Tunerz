
export interface LoginContextType {
    handleLogin: (email: string, password: string, rememberMe?: boolean) => Promise<any>;
    getSavedEmail: () => string;
};
