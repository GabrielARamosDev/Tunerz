
import { createBrowserRouter } from 'react-router-dom';

import AppLayout from '../components/layout/index.tsx';

import { AppProvider } from '../contexts/AppContext.tsx';
import { LoginProvider } from '../contexts/LoginContext.tsx';
import { HomeProvider } from '../contexts/HomeContext.tsx';
import { GarageProvider } from "../contexts/GarageContext.tsx";

import LoginPage from '../pages/Profile/Login.tsx';
import HomePage from '../pages/Home/index.tsx';
// import ProfilePage from '../pages/Profile/index.tsx';
import Garage from "../pages/Garage/index.tsx";

class Router {

    createRouter = () => createBrowserRouter([
        {
            path: '/',
            element: (
                <AppProvider>
                    <AppLayout />
                </AppProvider>
            ),
            children: [
                {
                    path: '/login',
                    element: (
                        <LoginProvider>
                            <LoginPage />
                        </LoginProvider>
                    ),
                    children: [
                        // {
                        //     path: '/login/register',
                        //     element: <RegisterPage />
                        // },
                    ],
                },
                {
                    path: '/home',
                    element: (
                        <HomeProvider>
                            <HomePage />
                        </HomeProvider>
                    ),
                    children: [
                        // {
                        //     path: '/home/profile',
                        //     element: <ProfilePage />
                        // },
                    ],
                },
                {
                    path: '/garage',
                    element: (
                        <GarageProvider>
                            <Garage />
                        </GarageProvider>
                    ),
                    children: [
                        // {
                        //     path: '/garage/dashboard',
                        //     element: <GarageDashboardPage />
                        // },
                        // {
                        //     path: '/garage/settings',
                        //     element: <GarageSettingsPage />
                        // },
                    ],
                }
            ],
        }
    ]);

}

const router = new Router();

export default router;
