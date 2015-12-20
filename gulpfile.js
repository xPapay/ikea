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

    mix.copy('node_modules/jquery/dist/jquery.js', 'resources/assets/js/jquery.js');
    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap');

    var pathToSelect2 = 'node_modules/select2/dist/';
    mix.copy(pathToSelect2 + 'js/select2.js', 'public/js');
    mix.copy(pathToSelect2 + 'css/select2.css', 'public/css');

    mix.scripts([
            'jquery.js'
        ])
});
