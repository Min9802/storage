const mix = require("laravel-mix");
require("dotenv").config();
let webpack = require("webpack");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
let dotenvplugin = new webpack.DefinePlugin({
    "process.env": {
        APP_ENV: JSON.stringify(process.env.APP_ENV),
        APP_URL_LOCAL: JSON.stringify(process.env.APP_URL_LOCAL),
        APP_URL: JSON.stringify(process.env.APP_URL || "http://127.0.0.1:8001"),
        APP_NAME: JSON.stringify(process.env.APP_NAME || "Min Services"),
        APP_KEY: JSON.stringify(process.env.APP_KEY),
        NODE_ENV: JSON.stringify(process.env.NODE_ENV || "development"),
        RECAPTCHA_SITE_KEY: JSON.stringify(
            process.env.GOOGLE_RECAPTCHA_SITE_KEY
        ),
        RECAPTCHA_SECRET: JSON.stringify(process.env.GOOGLE_RECAPTCHA_SECRET),
        CLIENT_ID: JSON.stringify(process.env.CLIENT_ID),
        CLIENT_SECRET: JSON.stringify(process.env.CLIENT_SECRET),
    },
});
mix.webpackConfig({
    plugins: [dotenvplugin],
});
mix.js("resources/js/app.js", "public/js")
    .react()
    .sass("resources/sass/app.scss", "public/css")
    .version();

mix.browserSync(
    process.env.APP_ENV == "production"
        ? process.env.APP_URL
        : process.env.APP_URL_LOCAL || "http://127.0.0.1:8001"
);
