import { showMoreText } from './modules/showmore.module';
// import { convertSVGsToInline } from './modules/convertSvg.module';
import { showMoreButtonTranslate } from './modules/translate.module';
const { showMoreTextTranslate, showLessTextTranslate } =
  showMoreButtonTranslate();
document.addEventListener('DOMContentLoaded', function () {
  showMoreText({
    contentSelector: '.social-media-default__card-body-content-container',
    maxHeight: 200,
    showMoreText: showMoreTextTranslate,
    showLessText: showLessTextTranslate,
  });
  // convertSVGsToInline('.social-media-instagram,.social-media-facebook');
});
