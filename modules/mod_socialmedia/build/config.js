module.exports = {
  // module version
  version: '1.0.6',

  css: {
    front_src: './src/scss/*.scss',
    front_dest: './../../../modules/mod_socialmedia/assets/css/',
  },

  js: {
    default: './src/js/default.js',
    masonry: './src/js/masonry.js',
    carousel: './src/js/carousel.js',
    dest: '../assets/js/',
  },

  package: {
    module_src: './.././**/*.*',
    module_dest: './pkg/',

    update_file_src: './.././updates.xml',
    indexhtml_file_src: './.././index.html',
  },
};
