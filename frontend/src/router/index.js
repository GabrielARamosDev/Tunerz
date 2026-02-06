
import { createBrowserRouter } from 'react-router-dom';

import Layout from '../components/layout/Layout';

import HomePage from '../screens/Home';
import ProfilePage from '../screens/Profile';

import { GarageProvider } from "../contexts/GarageContext";

import Garage from "../screens/Garage/index.tsx";

class Router {

    createRouter = () => createBrowserRouter([
        {
            path: '/',
            element: <Layout />,
            children: [
                {
                    path: '/',
                    element: <HomePage />,
                },
                {
                    path: '/perfil',
                    element: <ProfilePage />,
                },
            ],
        },
        {
            path: '/garage/',
            element: <Layout />,
            children: [
                {
                    path: '/garage/dashboard',
                    children: [
                        {
                            path: '/garage/dashboard/relatorios',
                            element: (
                                <GarageProvider>
                                    <Garage />
                                </GarageProvider>
                            ),
                        },
                    ],
                },
                {
                    path: '/garage/settings',
                    children: [

                    ],
                },
            ],
        },
    ]);

}

const router = new Router();

export default router;
