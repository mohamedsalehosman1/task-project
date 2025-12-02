const mix = require('laravel-mix');
const WebpackRTLPlugin = require('webpack-rtl-plugin');

mix.js('Modules/Dashboard/Resources/assets/js/backend.js', 'public/js')
    .vue()
    .sass('Modules/Dashboard/Resources/assets/scss/backend.scss', 'public/css', {
        additionalData: "$dashboardChosenColor: #477039;"
    });

mix.webpackConfig({
    plugins: [
        new WebpackRTLPlugin({
            diffOnly: false,
            minify: true,
        }),
    ],
    stats: {
        children: false,
    }
});

mix.version([
    'public/js/*',
    'public/css/*',
]);
