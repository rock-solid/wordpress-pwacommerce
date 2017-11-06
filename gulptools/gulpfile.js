var gulp = require('gulp'),
  sass = require('gulp-sass'),
  minify = require('gulp-minify');

/**
*
* Compile admin CSS file
*/
gulp.task('admin:processcss', function() {
  // Compile SCSS file and write it in the resources folder
  gulp
    .src('./../admin/sass/general.scss')
    .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
    .pipe(gulp.dest('./../admin/css/'));
});

/**
*
* Minify admin JS files
*
*/
gulp.task('admin:processjs', function() {
  gulp
    .src(['./../admin/js/**/*.js', '!./../admin/js/**/*.min.js'])
    .pipe(
      minify({
        ext: {
          min: '.min.js'
        },
        noSource: true
      })
    )
    .pipe(gulp.dest('./../admin/js/'));
});
