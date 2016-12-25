var elixir = require('laravel-elixir');
var uglifycss = require('gulp-uglifycss');
var minify = require('gulp-minify');

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
    mix.sass('app.scss')
    mix.scripts([
        '../../../node_modules/jquery/dist/jquery.js',
        '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        '../../../node_modules/datatables.net/js/jquery.dataTables.js',
    ], 'public/js/app.js');
});

gulp.task('compress', function () {
    gulp.src('public/css/app.css')
        .pipe(uglifycss({
            "maxLineLen": 80,
            "uglyComments": true
        }))
        .pipe(gulp.dest('public/css/min'))

    gulp.src('public/js/app.js')
        .pipe(minify())
        .pipe(gulp.dest('public/js/min'))
});