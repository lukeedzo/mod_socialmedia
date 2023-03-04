const run = require('gulp');
const babel = require('gulp-babel');
const config = require('../config');
const uglify = require('gulp-uglify');
const webpack = require('webpack-stream');
const rename = require('gulp-rename');

const buildScripts = (task, src, dest, filename) => {
  run.task(task, () => {
    return run
      .src(src)
      .pipe(
        webpack({
          mode: 'production',
          optimization: {
            minimize: true,
          },
        })
      )
      .pipe(
        babel({
          presets: ['@babel/env'],
        })
      )
      .pipe(uglify())
      .pipe(rename({ suffix: '.min' }))
      .pipe(run.dest(dest));
  });
};

buildScripts('build-scripts', config.js.facebook_default, config.js.dest);
