var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('compileScss', function(){
  return gulp.src('includes/style/scss/style.scss')
    .pipe(sass())
    .pipe(gulp.dest('includes/style'))
});

// gulp.task('watch', function(){
//   gulp.watch('includes/style/scss/**/*.scss', ['sass']);
// })

gulp.task('default',function(){
    return gulp.watch('includes/style/scss/*.scss', gulp.series('compileScss'));
})
