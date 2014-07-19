// ==========================================================================
//
//  Gulp Config
//    Default build for development will watch and recompile, with debug
//    information on each change of local styleheets + javascript files.
//
// ==========================================================================


var gulp = require('gulp')
  , gutil = require('gulp-util');


// --------------------------------------------------------------------------
//   plugins
// --------------------------------------------------------------------------

var compass = require('gulp-compass')
  , jshint = require('gulp-jshint-cached')
  , autoprefixer = require('gulp-autoprefixer')
  , clean = require('gulp-clean')
  , concat = require('gulp-concat')
  , uglify = require('gulp-uglify')
  , minify = require('gulp-minify-css')
  , imagemin = require('gulp-imagemin');


// --------------------------------------------------------------------------
//   Configuration
// --------------------------------------------------------------------------

var config = {
    stylesheets: './scss',
    scripts: './js',
    images: './images',
    vendor: './js/vendor',
}

config.plugins = [
  config.vendor + '/modernizr/modernizr.js',
  config.vendor + '/jquery-easing-original/jquery.easing.1.3.js',
  config.vendor + '/slick-carousel/slick/slick.js',
  config.vendor + '/matchHeight/jquery.matchHeight.js',
  config.vendor + '/moment/moment.js',
  config.vendor + '/fitvids/jquery.fitvids.js',
  config.vendor + '/chosen/chosen.jquery.js',
  config.vendor + '/enquire/dist/enquire.js',
  config.vendor + '/jQInstaPics/js/jqinstapics.js'

]


// --------------------------------------------------------------------------
//   Remove all existing compiled files
// --------------------------------------------------------------------------

gulp.task('clean', function () {
    gulp.src(['./style.css'])
        .pipe(clean({ force: true, read: false }));
});


// --------------------------------------------------------------------------
//   Compile SCSS into CSS stylesheet
// --------------------------------------------------------------------------

gulp.task('styles', function () {
    gulp.src(config.stylesheets + '/style.scss')
        .pipe(compass({
            css: './',
            sass: config.stylesheets + '/',
            outputStyle: 'expanded',
            debugInfo: true
        }))
        .pipe(autoprefixer("last 3 version", "> 1%", "ie 8", "ie 7"))
        .pipe(gulp.dest('./'));
});


// --------------------------------------------------------------------------
//   Compile SCSS and minify into CSS stylesheet
// --------------------------------------------------------------------------

gulp.task('ugly-styles', function () {
    gulp.src(config.stylesheets + '/style.scss')
        .pipe(compass({
            css: './',
            sass: config.stylesheets + '/',
            outputStyle: 'compressed',
            debugInfo: true
        }))
        .pipe(autoprefixer("last 3 version", "> 1%", "ie 8", "ie 7"))
        .pipe(minify())
        .pipe(gulp.dest('./'));
});


// --------------------------------------------------------------------------
//   Concat all script files required into `all.min.js`
// --------------------------------------------------------------------------

gulp.task('scripts', function () {
     gulp.src(config.plugins)
        .pipe(concat('plugins.js'))
        .pipe(gulp.dest(config.scripts));
});


// --------------------------------------------------------------------------
//   Concat + uglify all script files required into `all.min.js`
// --------------------------------------------------------------------------

gulp.task('ugly-scripts', function () {
     gulp.src(config.plugins)
        .pipe(uglify({
            mangle: true,
            compress: true,
            preserveComments: false
        }))
        .pipe(concat('plugins.js'))
        .pipe(gulp.dest(config.scripts));
});


// --------------------------------------------------------------------------
//   Optimise all images
// --------------------------------------------------------------------------

gulp.task('images', function () {
    return gulp.src([
          config.images + "/*",
          config.images + "/**/*"])
        .pipe(imagemin({
            optimizationLevel: 5,
            progressive: true
        }))
        .pipe(gulp.dest(config.images));
});


// --------------------------------------------------------------------------
//   Run development level tasks, and watch for changes
// --------------------------------------------------------------------------

gulp.task('default', ['clean', 'styles', 'scripts'], function () {
    gulp.watch(config.scripts + '/**/*.js', ['scripts']);
    gulp.watch(config.stylesheets + '/**/*.scss', ['styles']);
});

// Run production tasks including minfication, and without watch
gulp.task('production', ['clean', 'ugly-styles', 'ugly-scripts', 'images']);
