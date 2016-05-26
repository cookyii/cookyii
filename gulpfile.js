"use strict";

var es6 /*********/ = require('es6-promise'),
  gulp /**********/ = require('gulp'),
  autoprefixer /**/ = require('gulp-autoprefixer'),
  less /**********/ = require('gulp-less'),
  csso /**********/ = require('gulp-csso'),
  combiner /******/ = require('stream-combiner2'),
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
  var taskName = 'less/' + app;

  deps.push(taskName);

  gulp.task(taskName, function () {
    return combiner.obj([
      gulp.src(app + '-assets/less/styles.less'),
      less(),
      gulp.dest(app + '-assets/css')
    ]);
  });
});

gulp.task('less', deps);

deps = [];
_.each(apps, function (app) {
  var taskName = 'css/' + app;

  deps.push(taskName);

  gulp.task(taskName, ['less/' + app], function () {
    return gulp.src(app + '-assets/css/styles.css')
      .pipe(autoprefixer({
        browsers: ['last 4 versions', '> 1%'],
        cascade: false
      }))
      .pipe(csso())
      .pipe(gulp.dest(app + '-assets/css'));
  });
});

gulp.task('css', deps);
