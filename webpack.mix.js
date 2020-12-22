const mix = require('laravel-mix');
const tailwind = require('tailwindcss')
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

mix.ts('resources/js/app.ts', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        // require('autoprefixer'),
        // require('postcss-mixins'),
        tailwind('./tailwind.config.js'),
    ])
    .webpackConfig(require('./webpack.config'))
    .version()
    // .browserSync({
    //     proxy: 'js.test',
    //     ui: false,
    //     files: [
    //         'public/css/*.css',
    //         'public/js/*.js',
    //         'resources/views/**/*.blade.php',
    //     ]
    // });
