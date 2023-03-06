import Masonry from 'masonry-layout';
import { showMoreText } from './modules/showmore.module';
import { showMoreButtonTranslate } from './modules/translate.module';
const { showMoreTextTranslate, showLessTextTranslate } =
  showMoreButtonTranslate();

document.addEventListener('DOMContentLoaded', function () {
  const grid = document.querySelector('.social-media-masonry__grid');
  const msnry = new Masonry(grid, {
    itemSelector: '.social-media-masonry__grid-item',
    columnWidth: '.social-media-masonry__grid-item',
    percentPosition: true,
    gutter: 12,
  });

  showMoreText({
    contentSelector: '.social-media-masonry__card-body-content-container',
    maxHeight: 200,
    showMoreText: showMoreTextTranslate,
    showLessText: showLessTextTranslate,
    showMoreClass: 'social-media-masonry__card-body-btn',
  });
  msnry.layout();

  const showMorebtn = document.querySelectorAll(
    '.social-media-masonry__card-body-btn'
  );

  showMorebtn.forEach(function (btn) {
    btn.addEventListener('click', function () {
      msnry.layout();
    });
  });
});
