const run = require('gulp');
const config = require('../config');

run.task('watch', (cb) => {
  run.watch('./src/scss/*.scss', run.series('build-front-css'));
  run.watch('./src/js/widget.js', run.series('build-widget-js'));
  run.watch('./src/js/default.js', run.series('build-default-js'));
  run.watch('./src/js/masonry.js', run.series('build-masonry-js'));
  run.watch('./src/js/carousel.js', run.series('build-carousel-js'));
  cb();
});
