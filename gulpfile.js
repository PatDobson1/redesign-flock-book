var gulp = require('gulp');
var sass = require('gulp-sass');
var cssnano = require('gulp-cssnano');
var sourcemaps = require('gulp-sourcemaps');

gulp.task('compileScss', function(){
  return gulp.src('includes/style/scss/style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(cssnano())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('includes/style'))
});

gulp.task('default',function(){
    return gulp.watch('includes/style/scss/*.scss', gulp.series('compileScss'));
})
