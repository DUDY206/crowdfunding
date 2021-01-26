const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/admin/app.js','public/admin/js')
    // .js('resources/js/company/app.js','public/company/js')
    // .js('resources/js/investor/app.js','public/investor/js')
    .sass('resources/sass/admin/style.scss', 'public/admin/css', [])
    .sass('resources/sass/company/style.scss', 'public/company/css', [])
    .sass('resources/sass/investor/style.scss', 'public/investor/css', [])
    // .postCss('resources/css/app.css', 'public/css', [
    // require('postcss-import'),
    // require('tailwindcss'),
    // require('autoprefixer'),
    // ])
;
