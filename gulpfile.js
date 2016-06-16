var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
    mix.copy('resources/assets/css/comment.css', 'public/css');
    mix.copy('resources/assets/css/login-page.css', 'public/css');

    
    mix.copy('node_modules/jquery/dist/jquery.js', 'public/js');
    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap');
    mix.copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.js', 'public/js');

    mix.copy('resources/assets/js/lity.js', 'public/js');
    
    var pathToToolTipster = 'node_modules/tooltipster/';
    mix.copy(pathToToolTipster + 'css/tooltipster.css', 'public/css/tooltipster');
    mix.copy(pathToToolTipster + 'css/themes/tooltipster-light.css', 'public/css/tooltipster');
    mix.copy(pathToToolTipster + 'css/themes/tooltipster-noir.css', 'public/css/tooltipster');
    mix.copy(pathToToolTipster + 'css/themes/tooltipster-punk.css', 'public/css/tooltipster');
    mix.copy(pathToToolTipster + 'css/themes/tooltipster-shadow.css', 'public/css/tooltipster');
    
    mix.copy(pathToToolTipster + 'js/jquery.tooltipster.js', 'public/js');
    
    var pathToSelect2 = 'node_modules/select2/dist/';
    mix.copy(pathToSelect2 + 'js/select2.js', 'public/js');
    mix.copy(pathToSelect2 + 'css/select2.css', 'public/css');

    var pathToDateTimepicker = 'node_modules/eonasdan-bootstrap-datetimepicker/';
    mix.copy(pathToDateTimepicker + 'build/js/bootstrap-datetimepicker.min.js', 'public/js');
    mix.copy(pathToDateTimepicker + 'build/css/bootstrap-datetimepicker.css', 'public/css');
    
    var pathToMoment = 'node_modules/eonasdan-bootstrap-datetimepicker/bower_components/moment/';
    mix.copy(pathToMoment + 'moment.js', 'public/js/moment');
    mix.copy(pathToMoment + 'locale/sk.js', 'public/js/moment');

    mix.scripts([
       'moment/moment.js',
       'moment/sk.js'
    ], 'public/js/moment.js', 'public/js');

    mix.scripts([
        'jquery.js',
        'bootstrap.js',
        'lity.js',
        ], 'public/js/libs.js', 'public/js');

    mix.styles([
        'lity.css'
    ], 'public/css/libs.css');
});
