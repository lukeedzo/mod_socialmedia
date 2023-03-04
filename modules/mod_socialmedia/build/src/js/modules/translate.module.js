const lang = document.documentElement.getAttribute('lang');

function showMoreButtonTranslate(params) {
  let showMoreTextTranslate;
  let showLessTextTranslate;
  if (lang === 'lt-lt' || 'lt-LT') {
    showMoreTextTranslate = 'Rodyti daugiau';
    showLessTextTranslate = 'Rodyti mažiau';
  } else {
    showMoreTextTranslate = 'Show more';
    showLessTextTranslate = 'Show less';
  }

  return { showMoreTextTranslate, showLessTextTranslate };
}

export { showMoreButtonTranslate };
