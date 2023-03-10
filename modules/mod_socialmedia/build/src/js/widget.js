import Swiper, { Navigation, Pagination, Autoplay } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import { showMoreText } from './modules/showmore.module';
import { showMoreButtonTranslate } from './modules/translate.module';
const { showMoreTextTranslate, showLessTextTranslate } =
  showMoreButtonTranslate();

function setBool(value) {
  return value == 1 ? true : false;
}

function adjustButtonPosition(header, btns) {
  const buttons = document.querySelectorAll(btns);
  const slides = document.querySelectorAll('.swiper-slide');

  const hasHeader = Array.from(slides).some((slide) =>
    slide.querySelector(header)
  );

  buttons.forEach((button) => {
    button.style.top = hasHeader ? null : '45px';
  });
}

function initSocialMediaWidget() {
  const containers = document.querySelectorAll('.swiper-container');
  Swiper.use([Navigation, Pagination, Autoplay]);
  containers.forEach((container) => {
    const moduleId = container.getAttribute('module');
    const data = JSON.parse(
      document.getElementById(`social-media-widget-json-${moduleId}`)
        .textContent
    );

    let autoplay;
    if (data.autoplay) {
      autoplay = {
        autoplay: {
          delay: 1000,
          disableOnInteraction: true,
        },
      };

      container.addEventListener('mouseenter', () => {
        if (swiper.autoplay.running) {
          swiper.autoplay.stop();
        }
      });

      container.addEventListener('mouseleave', () => {
        if (!swiper.autoplay.running) {
          swiper.autoplay.start();
        }
      });
    }

    const swiper = new Swiper(`.swiper-widget-${moduleId}`, {
      loop: setBool(data.loop),
      navigation: {
        nextEl: `.next-${moduleId}`,
        prevEl: `.prev-${moduleId}`,
      },
      slidesPerView: 1,
      lazy: {
        loadOnTransitionStart: true,
        elementClass: 'swiper-lazy',
      },

      autoplay,
    });

    const contentContainers = document.querySelectorAll(
      '.social-media-widget__card-body-content-container'
    );

    swiper.on('slideChange', function () {
      const expandedTextElements = container.querySelectorAll(
        '.social-media-widget__card-body-content-container.expanded'
      );
      expandedTextElements.forEach((element) => {
        element.classList.remove('expanded');
        element.classList.add('collapsed');
      });
    });

    adjustButtonPosition(
      `.header-${data.id}`,
      `.next-${data.id}, .prev-${data.id}`
    );
  });

  showMoreText({
    contentSelector: '.social-media-widget__card-body-content-container',
    maxHeight: 200,
    showMoreText: showMoreTextTranslate,
    showLessText: showLessTextTranslate,
    showMoreClass: 'social-media-widget__card-body-btn',
  });
}

document.addEventListener('DOMContentLoaded', initSocialMediaWidget);
