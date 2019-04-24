var gulp = require('gulp'),
    sass = require('gulp-sass'),
    livereload = require('gulp-livereload'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    dest = require('gulp-dest'),
    order = require('gulp-order'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer');

var theme = 'wp-content/themes/tupas/';


gulp.task('sass', function(){
    return gulp.src(theme  + 'src/scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe( sass({
            outputStyle: 'compressed'
        }).on( 'error', sass.logError ) )
        .pipe( sourcemaps.write('.') )
        .pipe( gulp.dest(theme + 'assets/css') )
        .pipe( livereload() )
});


gulp.task('php', function(){
    return gulp.src(theme  + '**/*.php')
        .pipe(livereload())
});


gulp.task('js', function(){
    return gulp.src(theme + 'src/js/**/*.js')
        .pipe( order([
            'libs/*.js',
            '*.js'
        ]) )
        .pipe( concat(theme + 'assets/js/scripts.js') )
        .pipe( gulp.dest('.') )
        .pipe( uglify({ mangle: true }) )
        .pipe( dest('', { ext: '.min.js' }) )
        .pipe( gulp.dest('.') )
        .pipe( livereload() )
});


gulp.task('autoprefixer', ['sass'], function(){
    return gulp.src(theme  + 'assets/css/*.css')
        .pipe(autoprefixer({
            browsers: ['last 5 versions']
        }))
        .pipe(gulp.dest(theme + 'assets/css'))
});


gulp.task('watch', function(){
    livereload.listen();
    gulp.watch(theme  + 'src/scss/**/*.scss', ['sass']);
    
    gulp.watch(theme  + 'assets/css/*.css', ['autoprefixer']);

    gulp.watch(theme  + '**/*.php', ['php']);
    
    gulp.watch(theme  + 'src/js/**/*.js', ['js']);
});