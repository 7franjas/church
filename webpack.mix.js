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

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/app-landing.js', 'public/js/app-landing.js')
    //.sass('resources/sass/app.scss', 'public/css')
    .less('node_modules/bootstrap-less/bootstrap/bootstrap.less', 'public/css/bootstrap.css')
    .copyDirectory('resources/assets/img/*.*','public/img/')
    .copyDirectory('node_modules/font-awesome/fonts/*.*','public/fonts/')
    .copyDirectory('node_modules/ionicons/dist/fonts/*.*','public/fonts/')
    .copyDirectory('node_modules/bootstrap/fonts/*.*','public/fonts/')
    .copyDirectory('node_modules/admin-lte/dist/css/skins/*.*','public/css/skins')
    .copyDirectory('node_modules/admin-lte/dist/img','public/img')
    .copyDirectory('node_modules/admin-lte/plugins','public/plugins')
    .copy('node_modules/icheck/skins/square/blue.png','public/css')
    .copy('node_modules/icheck/skins/square/blue@2x.png','public/css')
    .copy('vendor/yajra/laravel-datatables-buttons/src/resources/assets/buttons.server-side.js','public/plugins/datatables/extensions/button-serve-side')
    .combine([
        //'public/css/app.css',
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/font-awesome.min.css',
        'resources/assets/css/ionicons.min.css',
        'node_modules/admin-lte/dist/css/AdminLTE.min.css',
        'node_modules/admin-lte/dist/css/skins/_all-skins.css',
        'node_modules/icheck/skins/square/blue.css',
        'node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
        'node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.css',
        'node_modules/datatables.net-buttons-bs/css/buttons.bootstrap.css',
        'node_modules/fullcalendar/dist/fullcalendar.css',
        'node_modules/croppie/croppie.css',
        'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
        'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.css',
        'node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css',
        'resources/assets/css/custom-app.css'
    ], 'public/css/all.css')
    .combine([
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/pratt_landing.min.css'
    ], 'public/css/all-landing.css')
    .sourceMaps();

if (mix.config.inProduction) {
  mix.version();
  mix.minify();
}

