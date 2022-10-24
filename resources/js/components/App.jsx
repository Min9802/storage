import React from "react";
import { Route, Routes, Outlet } from "react-router-dom";
import AppRoute from "./routers";
import AuthRoutes from "./routers/AuthRoutes";

import Layout from "./views/Layout";
import NotFound from "./views/NotFound";

const App = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                {AppRoute.map((route, key) => {
                    return (
                        <Route
                            key={key}
                            path={route.path}
                            element={route.component}
                        />
                    );
                })}
            </Route>
            {
                AuthRoutes.map((route, key) => {
                    return (
                        <Route
                            key={key}
                            path={route.path}
                            element={route.component}
                        />
                    );
                })
            }
            <Route path="*" element={<NotFound />} />
        </Routes>
    );
};

export default App;
