const run = require('gulp');
const config = require('../config');
const path = require('path');
const clean = require('gulp-clean');
const replace = require('gulp-string-replace');
const zip = require('gulp-zip');

run.task('clean', () => {
  return run.src(['./pkg/', './package/'], { read: false }).pipe(clean());
});

run.task('module', () => {
  return run
    .src([config.package.module_src, '!build/**/*.*'], {
      dot: true,
    })
    .pipe(replace(/CVS(.{7})/g, `CVS: ${config.version}`))
    .pipe(run.dest(config.package.module_dest));
});

run.task('update-file', () => {
  return run
    .src(config.package.update_file_src, {
      dot: true,
    })
    .pipe(replace(/CVS(.{7})/g, `CVS: ${config.version}`))
    .pipe(run.dest('./package/'));
});

run.task('indexhtml-file', () => {
  return run
    .src([config.package.indexhtml_file_src])
    .pipe(run.dest('./build/'));
});

run.task('zip', () => {
  return run
    .src(['./pkg/**/*.*', '!./pkg/build/**/*.*'], { dot: true })
    .pipe(zip(`mod_socialmedia-${config.version}.zip`))
    .pipe(run.dest('./package/'));
});
