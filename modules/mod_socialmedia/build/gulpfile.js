const run = require('gulp');
const requireDir = require('require-dir');
const runSequence = require('gulp4-run-sequence');

requireDir('./tasks', { recurse: true });

// Build css and js
run.task('dev', (cb) => {
  runSequence(run.series('build-front-css', 'build-scripts'), 'watch');
  cb();
});

// Build installer package
run.task('build-package', (cb) => {
  runSequence('clean', 'module', 'indexhtml-file', 'update-file', 'zip');
  cb();
});
