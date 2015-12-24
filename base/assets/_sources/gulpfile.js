"use strict";

require('es6-promise').polyfill();

var gulp /********/ = require('gulp'),
  autoprefixer /**/ = require('gulp-autoprefixer'),
  less /**********/ = require('gulp-less'),
  csso /**********/ = require('gulp-csso'),
  path /**********/ = require('path');

gulp.task('default', function () {

});

gulp.task('less', function () {
  return gulp.src('less/adminlte.less')
    .pipe(less({
      paths: [path.join(__dirname, 'less', 'includes')]
    }))
    .pipe(autoprefixer({
      browsers: ['last 4 versions', '> 1%'],
      cascade: false
    }))
    .pipe(csso())
    .pipe(gulp.dest('css'));
});