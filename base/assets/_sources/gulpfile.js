"use strict";

var es6 /*********/ = require('es6-promise'),
  gulp /**********/ = require('gulp'),
  autoprefixer /**/ = require('gulp-autoprefixer'),
  less /**********/ = require('gulp-less'),
  csso /**********/ = require('gulp-csso');

es6.polyfill();

gulp.task('default', function () {

});

gulp.task('less', function () {
  return gulp.src('less/adminlte.less')
    .pipe(less())
    .pipe(gulp.dest('css'));
});

gulp.task('css/optimize', ['less'], function () {
  return gulp.src('css/adminlte.css')
    .pipe(autoprefixer({
      browsers: ['last 4 versions', '> 1%'],
      cascade: false
    }))
    .pipe(csso())
    .pipe(gulp.dest('css'));
});
