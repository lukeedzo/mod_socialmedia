module.exports = {
  // module version
  version: '1.0.0',

  css: {
    front_src: './src/scss/*.scss',
    front_dest: './../../../modules/mod_socialmedia/assets/css/',
  },

  js: {
    facebook_default: './src/js/index.js',
    dest: '../assets/js/',
  },

  package: {
    module_src: './.././**/*.*',
    module_dest: './pkg/',

    update_file_src: './.././updates.xml',
    indexhtml_file_src: './.././index.html',
  },
};
