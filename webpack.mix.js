const { mix } = require('laravel-mix');
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

mix.js('resources/assets/js/app.js', 'public/js');

mix.styles([
	'public/css/app.css',
    'public/css/glyphicon.min.css',
    'public/css/bootstrap-multiselect.css',
    'public/css/custom.css'
], 'public/css/all.css');

mix.version();