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

document.addEventListener('DOMContentLoaded', function () {
  const containers = document.querySelectorAll('.swiper-container');
  Swiper.use([Navigation, Pagination, Autoplay]);
  containers.forEach((container) => {
    const moduleId = container.getAttribute('module');
    const data = JSON.parse(
      document.getElementById(`social-media-carousel-json-${moduleId}`)
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

    const swiper = new Swiper(`.swiper-carousel-${moduleId}`, {
      loop: setBool(data.loop),
      navigation: {
        nextEl: `.slider-next-${moduleId}`,
        prevEl: `.slider-prev-${moduleId}`,
      },
      slidesPerView: 4,
      spaceBetween: 20,
      lazy: {
        loadOnTransitionStart: true,
        elementClass: 'swiper-lazy',
      },
      autoplay,
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        480: {
          slidesPerView: 1,
        },
        320: {
          slidesPerView: 1,
        },
        540: {
          slidesPerView: 2,
        },
        640: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        1024: {
          slidesPerView: 4,
        },
      },
    });
  });

  showMoreText({
    contentSelector: '.social-media-carousel__card-body-content-container',
    maxHeight: 200,
    showMoreText: showMoreTextTranslate,
    showLessText: showLessTextTranslate,
    showMoreClass: 'social-media-carousel__card-body-btn',
  });
});
