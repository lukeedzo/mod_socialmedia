import Masonry from 'masonry-layout';
import { showMoreText } from './modules/showmore.module';
import { showMoreButtonTranslate } from './modules/translate.module';
const { showMoreTextTranslate, showLessTextTranslate } =
  showMoreButtonTranslate();

function initSocialMediaMasonry() {
  const grid = document.querySelectorAll('.social-media-masonry__grid');

  const msnryArray = [];

  let msnry;
  // Loop through each grid element and initialize Masonry
  grid.forEach(function (grid) {
    msnry = new Masonry(grid, {
      itemSelector: '.social-media-masonry__grid-item',
      columnWidth: '.social-media-masonry__grid-item',
      percentPosition: true,
      gutter: 12,
    });
    msnryArray.push(msnry);
  });

  showMoreText({
    contentSelector: '.social-media-masonry__card-body-content-container',
    maxHeight: 200,
    showMoreText: showMoreTextTranslate,
    showLessText: showLessTextTranslate,
    showMoreClass: 'social-media-masonry__card-body-btn',
  });

  // Call the layout method for each Masonry instance
  msnryArray.forEach(function (msnry) {
    msnry.layout();
  });

  const showMorebtn = document.querySelectorAll(
    '.social-media-masonry__card-body-btn'
  );

  showMorebtn.forEach(function (btn) {
    btn.addEventListener('click', function () {
      msnryArray.forEach(function (msnry) {
        msnry.layout();
      });
    });
  });
}

document.addEventListener('DOMContentLoaded', initSocialMediaMasonry);
