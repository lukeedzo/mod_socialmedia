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
          module: {
            rules: [
              {
                test: /\.css$/,
                use: ['style-loader', 'css-loader'],
              },
            ],
          },
          optimization: {
            minimize: false,
          },
        })
      )
      .pipe(
        babel({
          presets: ['@babel/env'],
        })
      )
      .pipe(uglify())
      .pipe(rename({ suffix: '.min', basename: filename })) // add basename option
      .pipe(run.dest(dest));
  });
};

buildScripts('build-default-js', config.js.default, config.js.dest, 'default');
buildScripts('build-masonry-js', config.js.masonry, config.js.dest, 'masonry');
buildScripts(
  'build-carousel-js',
  config.js.carousel,
  config.js.dest,
  'carousel'
);
