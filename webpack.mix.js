const mix = require('laravel-mix');
const VueLoaderPlugin = require('vue-loader/lib/plugin')
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
module.exports = {
    plugins: [
        new VueLoaderPlugin()
    ],

}
mix
    // .js('resources/js/admin/app.js','public/admin/js').vue()
    .js('resources/js/company/app.js','public/company/js').vue()
    // .js('resources/js/investor/app.js','public/investor/js').vue()
    // .sass('resources/sass/admin/style.scss', 'public/admin/css')
    .sass('resources/sass/company/style.scss', 'public/company/css')
    // .sass('resources/sass/investor/style.scss', 'public/investor/css')
    // .postCss('resources/css/app.css', 'public/css', [
    // require('postcss-import'),
    // require('tailwindcss'),
    // require('autoprefixer'),
    // ])
;

module.exports = {
    module: {
        rules: [
            // ... other rules
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ]
    },
    plugins: [
        // make sure to include the plugin!
        new VueLoaderPlugin()
    ]
}
