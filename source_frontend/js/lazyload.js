// https://web.dev/browser-level-image-lazy-loading/


function appendLazysizesScript() {
  const script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.0/lazysizes.min.js';
  document.head.append(script);
}


function initLazyload() {
  let nativeLazyloadIsEnabled = false;

  if ('loading' in HTMLImageElement.prototype) {
    // Если поддержка есть - браузер покажет заглушку - dummy.svg
    // надо заменить заглушку на реальные изображения
    const dataSrcsetElements = document.querySelectorAll('[data-srcset]');
    dataSrcsetElements.forEach((dataSrcsetElement) => {
      dataSrcsetElement.srcset = dataSrcsetElement.dataset.srcset;
      delete dataSrcsetElement.dataset.srcset;
    });
    nativeLazyloadIsEnabled = true;
  } else {
    const lazyElements = document.querySelectorAll('[loading="lazy"]');
    lazyElements.forEach((lazyElement) => {
      lazyElement.classList.add('lazyload');
    });
    appendLazysizesScript();
  }

  return { nativeLazyloadIsEnabled };
}


export default initLazyload;
