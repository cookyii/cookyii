"use strict";

var es6 /*********/ = require('es6-promise'),
  gulp /**********/ = require('gulp'),
  autoprefixer /**/ = require('gulp-autoprefixer'),
  less /**********/ = require('gulp-less'),
  csso /**********/ = require('gulp-csso'),
  _ /*************/ = require('lodash');

es6.polyfill();

var deps,
  apps = require('./.apps.json');

gulp.task('default', function () {

});

gulp.task('watch', function () {
  _.each(apps, function (app) {
    gulp.watch(app + '-assets/less/**/*.less', ['less/' + app]);
  });
});

deps = [];
_.each(apps, function (app) {
  var task = 'less/' + app;

  deps.push(task);

  gulp.task(task, function () {
    return gulp.src(app + '-assets/less/styles.less')
      .pipe(less())
      .pipe(gulp.dest(app + '-assets/css'));
  });
});

gulp.task('less', deps);

deps = [];
_.each(apps, function (app) {
  var task = 'css/' + app + '/optimize';

  deps.push(task);

  gulp.task(task, ['less/' + app], function () {
    return gulp.src(app + '-assets/css/styles.css')
      .pipe(autoprefixer({
        browsers: ['last 4 versions', '> 1%'],
        cascade: false
      }))
      .pipe(csso())
      .pipe(gulp.dest(app + '-assets/css'));
  });
});

gulp.task('css/optimize', deps);
