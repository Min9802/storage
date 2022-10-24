import React from "react";

import { AiFillHome } from "react-icons/ai";

import Home from "../views/Home";
const TopbarRoute = [
    {
        name: "/",
        icon: <AiFillHome />,
        path: "/",
        component: <Home />,
        collapse: false,
        protected: true,
    },
];

export default TopbarRoute;
