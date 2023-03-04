const run = require('gulp');
const path = require('path');
const config = require('../config');
const cleancss = require('gulp-clean-css');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');

const buildCss = (task, src, dest) => {
  run.task(task, () => {
    return run
      .src(src)
      .pipe(sass().on('error', sass.logError))
      .pipe(cleancss())
      .pipe(rename({ suffix: '.min' }))
      .pipe(run.dest(dest));
  });
};

buildCss('build-front-css', config.css.front_src, config.css.front_dest);
