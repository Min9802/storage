import Login from "../views/Login";
import Logout from "../views/Logout";
import { FaSignInAlt, FaSignOutAlt } from "react-icons/fa";
const AuthRoutes = [
    {
        name: "login",
        icon: <FaSignInAlt />,
        path: "/login",
        component: <Login />,
        collapse: false,
        protected: false,
    },
    {
        name: "logout",
        icon: <FaSignOutAlt />,
        path: "/logout",
        component: <Logout />,
        collapse: false,
        protected: true,
    },
];
export default AuthRoutes;
