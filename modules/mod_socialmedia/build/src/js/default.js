import { showMoreText } from './modules/showmore.module';
import { showMoreButtonTranslate } from './modules/translate.module';
const { showMoreTextTranslate, showLessTextTranslate } =
  showMoreButtonTranslate();

function initSocialMediaDefault() {
  showMoreText({
    contentSelector: '.social-media-default__card-body-content-container',
    maxHeight: 200,
    showMoreText: showMoreTextTranslate,
    showLessText: showLessTextTranslate,
  });
}

document.addEventListener('DOMContentLoaded', initSocialMediaDefault);
