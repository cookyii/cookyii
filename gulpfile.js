"use strict";

require('es6-promise').polyfill();

var gulp = require('gulp'),
  autoprefixer = require('gulp-autoprefixer'),
  less = require('gulp-less'),
  csso = require('gulp-csso'),
  path = require('path'),
  minimist = require('minimist'),
  options = minimist(process.argv.slice(2));

gulp.task('default', function () {

});

gulp.task('less', function () {
  var app = options.app;

  if (typeof app === 'undefined') {
    throw 'It is necessary to pass a parameter `--app`';
  }

  return gulp.src(app + '-assets/less/styles.less')
    .pipe(less({
      paths: [path.join(__dirname, 'less', 'includes')]
    }))
    .pipe(autoprefixer({
      browsers: ['last 4 versions', '> 1%'],
      cascade: false
    }))
    .pipe(csso())
    .pipe(gulp.dest(app + '-assets/css'));
});