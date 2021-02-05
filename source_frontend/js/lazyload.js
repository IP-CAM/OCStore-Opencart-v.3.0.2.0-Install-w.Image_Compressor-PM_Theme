'use script';

// модуль определяет поддержку loading="lazy"
// Если есть:
// заменяет атрибуты data-srcset и data-src на соответсвующие без data, позволяя работать нативному алгоритму
// Если нет:
// подключается скрипт lazysizes

// https://web.dev/browser-level-image-lazy-loading/

// отключить модуль при браузерной поддержке loading >85%


function initLazyload() {
  let nativeLazyloadIsEnabled;

  if ('loading' in HTMLImageElement.prototype) {

    const srcsetElements = document.querySelectorAll('[data-srcset]');
    srcsetElements.forEach(srcsetElement => {
      srcsetElement.setAttribute('srcset', srcsetElement.dataset.srcset);
      delete srcsetElement.dataset.srcset;
    });

    const images = document.querySelectorAll('[data-src]');
    images.forEach((img) => {
      img.src = img.dataset.src;
      delete img.dataset.src;
    });

    nativeLazyloadIsEnabled = true;

  } else {

    const lazyImages = document.querySelectorAll('[loading = "lazy"]');
    lazyImages.forEach(lazyImage => {
      lazyImage.classList.add('lazyload');
    });

    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.0/lazysizes.min.js';
    document.head.append(script);

    nativeLazyloadIsEnabled = false;

  }

  return { nativeLazyloadIsEnabled };
}


export default initLazyload;
