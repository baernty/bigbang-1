/* Modules
------------------------------------- */
var gulp        = require('gulp'),
    clean       = require('gulp-rimraf'),
    concat      = require('gulp-concat'),
    imagemin    = require('gulp-imagemin'),
    jslint      = require('gulp-jslint'),
    livereload  = require('gulp-livereload'),
    prefix      = require('gulp-autoprefixer'),
    plumber     = require('gulp-plumber'),
    rename      = require('gulp-rename'),
    sass        = require('gulp-ruby-sass'),
    sourcemaps  = require('gulp-sourcemaps'),
    uglify      = require('gulp-uglify');


/* Paths
------------------------------------- */
var assetsDir      = 'assets/',
    srcDir      = assetsDir + 'src/',
    bowerDir    = assetsDir + 'bower_components/';


/* Sass Task
------------------------------------- */
gulp.task('sass', function () {
    return sass(srcDir + 'scss/style.scss', {
        sourcemap: true,
        loadPath: [bowerDir, srcDir + 'scss/']

    })
        .pipe(plumber())
        .pipe(prefix({
            browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1'],
            cascade: true
        }))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('.'))
        .pipe(livereload());
});


/* Modernizr Task
------------------------------------- */
gulp.task('modernizr', function () {
    gulp.src(bowerDir + 'modernizr/modernizr.js')
        .pipe(uglify())
        .pipe(rename('modernizr-min.js'))
        .pipe(gulp.dest(assetsDir + 'js/'));
});


/* Frontend Scripts Task
------------------------------------- */
gulp.task('frontendScripts', function () {
    // Your JS files that should be combined and minified. Order it to suit your needs.
    var concatination = [
        srcDir + 'js/frontend/navigation.js',
        srcDir + 'js/frontend/skip-link-focus-fix.js',
        srcDir + 'js/frontend/main.js'
    ];

    gulp.src(srcDir + 'js/frontend/*.js')
        .pipe(jslint({
            node: true,
            evil: true,
            nomen: true,
            errorsOnly: true
        })).on('error', function(error) {
            console.error(String(error));
        })
        .pipe(gulp.src(concatination))
        .pipe(concat('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(assetsDir + 'js/frontend/'))
        .pipe(livereload());
});


/* Backend Scripts Task
------------------------------------- */
gulp.task('backendScripts', function () {
    var concatination = [
        srcDir + 'js/backend/main.js'
    ];

    gulp.src(srcDir + 'js/backend/*.js')
        .pipe(jslint({
            node: true,
            evil: true,
            nomen: true,
            errorsOnly: true
        })).on('error', function(error) {
            console.error(String(error));
        })
        .pipe(gulp.src(concatination))
        .pipe(concat('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(assetsDir + 'js/backend/'))
        .pipe(livereload());
});


/* Clean Images task
------------------------------------- */
gulp.task('cleanImages', function () {
    return gulp.src(assetsDir + 'images', {read: false})
        .pipe(clean());
});


/* Images Task
------------------------------------- */
gulp.task('imagemin', ['cleanImages'], function () {
    gulp.src(srcDir + 'images/**/*.{png,gif,jpg,jpeg}')
        .pipe(imagemin())
        .pipe(gulp.dest(assetsDir + 'images/'));
});


/* Watch Task
------------------------------------- */
gulp.task('watch', function () {
    var server = livereload();

    gulp.watch(srcDir + 'scss/**/*.scss', ['sass']);
    gulp.watch(srcDir + 'js/frontend/**/*.js', ['frontendScripts']);
    gulp.watch(srcDir + 'js/backend/**/*.js', ['backendScripts']);
    gulp.watch(['**/*.php']).on('change', function (file) {
        server.changed(file.path);
    });
});


/* Default Task
------------------------------------- */
gulp.task('default', ['sass', 'modernizr', 'frontendScripts', 'backendScripts', 'imagemin', 'watch']);


/* Images Task
------------------------------------- */
gulp.task('images', ['imagemin']);
