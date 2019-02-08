// Include gulp
var gulp = require('gulp');
// Include plugins
var concat = require('gulp-concat');
// Concatenate JS Files
gulp.task('scripts', function() {
    return gulp.src('src/js/*.js')
      .pipe(concat('main.js'))
      .pipe(gulp.dest('public/js'));
});
// Default Task (https://fettblog.eu/gulp-4-parallel-and-series/)
gulp.task('default', gulp.series('scripts'));
