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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/common.scss', 'public/css')
   .sourceMaps();
   
  // mix.copy('node_modules/jquery/dist/jquery.js', 'public/js');
  // mix.copy('node_modules/font-awesome/fonts', 'public/build/fonts');

  
if (mix.inProduction()) {
    mix.version();
}

// mix.browserSync({
//     proxy: 'localhost:8000'
// });