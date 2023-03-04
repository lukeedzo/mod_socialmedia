const run = require('gulp');
const config = require('../config');

run.task('watch', (cb) => {
  run.watch('./src/scss/*.scss', run.series('build-front-css'));
  run.watch('./src/js/**/*.js', run.series('build-scripts'));
  cb();
});
