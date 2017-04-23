var elixir = require('laravel-elixir');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

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
        '../../../node_modules/js-cookie/src/js.cookie.js',
        '../../../resources/assets/js/app.js',
    ], 'public/js/app.js');
});

gulp.task('compress', function () {
    gulp.src('public/css/app.css')
        .pipe(rename("app.min.css"))
        .pipe(cleanCSS())
        .pipe(gulp.dest('public/css'))

    gulp.src('public/js/app.js')
        .pipe(rename("app.min.js"))
        .pipe(uglify())
        .pipe(gulp.dest('public/js'))
});