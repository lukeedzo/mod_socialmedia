function showMoreText(options) {
  const DEFAULT_OPTIONS = {
    contentSelector: '.social-media-default__card-body-content-container',
    maxHeight: 300,
    showMoreText: 'Show more',
    showLessText: 'Show less',
    showMoreClass: 'social-media-default__card-body-btn',
  };

  const {
    contentSelector,
    maxHeight,
    showMoreText,
    showLessText,
    showMoreClass,
  } = {
    ...DEFAULT_OPTIONS,
    ...options,
  };

  function updateTextContent(contentContainer, fullText, croppedText) {
    contentContainer.querySelector('div').innerHTML = croppedText;

    const showMoreButton = createShowMoreButton(showMoreText, showMoreClass);

    contentContainer.appendChild(showMoreButton);

    showMoreButton.addEventListener('click', () => {
      if (contentContainer.classList.contains('collapsed')) {
        contentContainer.classList.remove('collapsed');
        contentContainer.classList.add('expanded');
        contentContainer.querySelector('div').innerHTML =
          encodeAndBreakText(fullText);
        showMoreButton.textContent = showLessText;
      } else {
        contentContainer.classList.remove('expanded');
        contentContainer.classList.add('collapsed');
        contentContainer.querySelector('div').innerHTML = croppedText;
        showMoreButton.textContent = showMoreText;
      }
    });
  }

  function createShowMoreButton(text, className) {
    const button = document.createElement('button');
    button.classList.add(className);
    button.textContent = text;
    return button;
  }

  function cropText(text, maxLength) {
    return text.length > maxLength
      ? text.substring(0, maxLength) + '...'
      : text;
  }

  function replaceUrlsWithAnchorTags(text) {
    const MAX_URL_LENGTH = 30;
    const urlRegex =
      /(https?:\/\/[^\s]+)|(www\.[^\s]+)|(bit\.ly\/[^\s]+)|([\w\.-]+@[\w\.-]+\.[\w]+)/g;
    const urlsAndEmails = text.match(urlRegex);

    if (!urlsAndEmails) {
      return text;
    }

    let result = text;

    urlsAndEmails.forEach((urlOrEmail) => {
      if (urlOrEmail.includes('@')) {
        const mailtoLink = `mailto:${urlOrEmail}`;
        const anchorTag = `<a href="${mailtoLink}">${urlOrEmail}</a>`;
        result = result.replace(urlOrEmail, anchorTag);
      } else {
        const displayUrl =
          urlOrEmail.length > MAX_URL_LENGTH
            ? urlOrEmail.substring(0, MAX_URL_LENGTH) + '...'
            : urlOrEmail;
        const href = urlOrEmail.includes('bit.ly/')
          ? 'https://' + urlOrEmail
          : urlOrEmail;
        const anchorTag = `<a href="${href}">${removeUrlPrefix(
          displayUrl
        )}</a>`;
        result = result.replace(urlOrEmail, anchorTag);
      }
    });

    return result;
  }

  document.querySelectorAll(contentSelector).forEach((contentContainer) => {
    const text = contentContainer.querySelector('div').textContent;
    const croppedText = cropText(text, maxHeight);
    const fullText = replaceUrlsWithAnchorTags(text);
    const croppedFullText = replaceUrlsWithAnchorTags(croppedText);

    updateTextContent(contentContainer, fullText, croppedFullText);
  });
}

function removeUrlPrefix(url) {
  return url.replace(/^(https?:\/\/)?(www\.)?/, '');
}

function createAnchorTag(url) {
  const MAX_URL_LENGTH = 30;
  if (url.includes('bit.ly/')) {
    url = 'https://' + url;
  }
  const displayUrl =
    url.length > MAX_URL_LENGTH
      ? url.substring(0, MAX_URL_LENGTH) + '...'
      : url;
  return `<a href="${url}">${removeUrlPrefix(displayUrl)}</a>`;
}

function encodeAndBreakText(text) {
  let encodedText = encodeURIComponent(text);
  encodedText = encodedText.replace(/(%0A)+/g, '<br><br>');
  encodedText = encodedText.replace(/^(<br>)+/, '');
  return decodeURIComponent(encodedText);
}

export { showMoreText };
