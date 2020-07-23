
// -- Imports ----------------------------------------- //
    var gulp = require('gulp');
    var sass = require('gulp-sass');
    var cssnano = require('gulp-cssnano');
    var sourcemaps = require('gulp-sourcemaps');
    var concat = require('gulp-concat');
    var rename = require('gulp-rename');
    var uglify = require('gulp-uglify');
// ---------------------------------------------------- //

// -- Variables --------------------------------------- //
    var jsFiles     = 'src/js/**/*.js',
        jsDest      = 'includes/js',
        scssFiles   = 'src/scss/style.scss',
        scssWatch   = 'src/scss/**/*.scss',
        cssDest     = 'includes/style';
// ---------------------------------------------------- //

// -- Scss -------------------------------------------- //
    gulp.task('compileScss', function(){
        return gulp.src(scssFiles)
            .pipe(sourcemaps.init())
            .pipe(sass())
            .pipe(cssnano())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(cssDest))
    });
// ---------------------------------------------------- //

// -- Javascript -------------------------------------- //
    gulp.task('scripts', function(){
        return gulp.src(jsFiles)
            .pipe(concat('functions.js'))
            .pipe(gulp.dest(jsDest));
            // Put into place for production --
            // .pipe(rename('functions.min.js'))
            // .pipe(uglify())
            // .pipe(gulp.dest(jsDest));
    })
// ---------------------------------------------------- //

// -- Watch ------------------------------------------- //
    gulp.task('default',function(){
        gulp.watch(scssWatch, gulp.series('compileScss'));
        gulp.watch(jsFiles, gulp.series('scripts'));
    })
// ---------------------------------------------------- //
