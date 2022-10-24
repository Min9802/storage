import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter } from "react-router-dom";

import { Provider } from "react-redux";
import { CookiesProvider } from "react-cookie";
import { Helmet, HelmetProvider } from "react-helmet-async";

// import store from "./store/reducers/store";
import * as serviceWorker from "../serviceWorker";
import reduxStore, { persistor } from "./store/reducers/redux";
import IntlProviderWrapper from "./utils/IntlProviderWrapper";
import App from "./App";
const root = ReactDOM.createRoot(document.getElementById("root"));

root.render(
    <React.StrictMode>
        <HelmetProvider>
            <CookiesProvider>
                <Provider store={reduxStore}>
                    <IntlProviderWrapper>
                        <BrowserRouter>
                            <App persistor={persistor} />
                        </BrowserRouter>
                    </IntlProviderWrapper>
                </Provider>
            </CookiesProvider>
        </HelmetProvider>

    </React.StrictMode>

);
serviceWorker.unregister();
