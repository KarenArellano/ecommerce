const mix = require('laravel-mix');

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
 mix
 .scripts(['resources/js/landing/vendor/bundle.js', 'resources/js/landing/vendor/active.js'], 'public/js/bundle.js')
 .js('resources/js/landing/app.js', 'public/js/landing.js')
 .sass('resources/sass/landing.scss', 'public/css/landing.css')
 .options({
 	processCssUrls: false
 })
 .copyDirectory('resources/fonts/landing', 'public/fonts')
 .copyDirectory('resources/images/landing', 'public/images');

 mix
 .js('resources/js/dashboard/app.js', 'public/js/dashboard.js')
 .js('resources/js/dashboard/modal.js', 'public/js/modal.js')
 .sass('resources/sass/dashboard.scss', '../resources/css/dashboard/app.css')
 .combine([
 	'resources/css/dashboard/app.css',
 	'resources/css/dashboard/vendor/dashforge.css',
 	'resources/css/dashboard/vendor/demo.css',
 	'resources/css/dashboard/vendor/dashboard.css',
 	'resources/css/dashboard/vendor/auth.css',
 	'resources/css/dashboard/vendor/skin.cool.css'
 	], 'public/css/dashboard.css')
 .copyDirectory('resources/fonts/dashboard', 'public/fonts')
 .copyDirectory('resources/images/dashboard', 'public/images');