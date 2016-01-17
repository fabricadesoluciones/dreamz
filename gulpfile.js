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
    // mix.sass(['app.scss','grid.scss']);
    mix.sass(['app.scss']);
    mix.scripts([
        
		'vendor/react.min.js',
		'vendor/react-dom.min.js',
		'vendor/browser.min.js',
		'vendor/jquery.min.js',
		'vendor/select2.min.js',
		'vendor/datatables.min.js',
		'vendor/moment.min.js',
    ]);
});
