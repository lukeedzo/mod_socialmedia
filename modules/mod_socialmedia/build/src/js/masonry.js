import Masonry from 'masonry-layout';
document.addEventListener('DOMContentLoaded', function () {
  const grid = document.querySelector('.grid');
  const msnry = new Masonry(grid, {
    // options...
    itemSelector: '.grid-item',
    columnWidth: '.grid-item',
    percentPosition: true,
    gutter: 20,
  });
});
