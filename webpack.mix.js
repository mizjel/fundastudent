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

mix.js('resources/assets/js/app.js', 'public/js/app.js').extract(['jquery', 'toastr', 'bootstrap-sass']);
mix.js('resources/assets/js/donation/donation.js', 'public/js/donation.js');
mix.js('resources/assets/js/plugins/browse_image.js', 'public/js/browse_image.js');
mix.js('resources/assets/js/academic_year/academic_year.js', 'public/js/academic_year.js');

mix.scripts([
    'resources/assets/js/plugins/datepicker/bootstrap-datepicker.js',
    'resources/assets/js/plugins/datepicker/bootstrap-datepicker.nl.js',
    'resources/assets/js/plugins/datepicker/bootstrap-datepicker.defaults.js',
], 'public/js/datepicker.js');

mix.sass('resources/assets/sass/app.scss', 'public/css/app.css');

mix.styles('resources/assets/css/bootstrap-datepicker3.css', 'public/css/datepicker.css');
