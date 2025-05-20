const mix = require('laravel-mix');
const { VueLoaderPlugin } = require("vue-loader");
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

__webpack_nonce__ = 'c29tZSBjb29sIHN0cmluZyB3aWxsIHBvcCB1cCAxMjM=';

resolve: {
    alias: {
        vue: 'vue/dist/vue.js'
    }
}

mix.js('resources/js/backend_app.js', 'public/js')
    .sass('resources/sass/backend_app.scss', 'public/css')
    .sourceMaps()
    .vue();

mix.js('resources/js/frontend_app.js', 'public/js')
    .sass('resources/sass/frontend_app.scss', 'public/css')
    .sourceMaps()
    .vue();

