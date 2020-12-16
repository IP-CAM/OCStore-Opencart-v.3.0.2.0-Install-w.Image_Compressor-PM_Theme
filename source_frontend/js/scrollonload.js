'use strict';

// Скрипт выполняет скролл до элемента с data-атрибутом DATA_ATTR_SELECTOR при наступлении события DOMContentLoaded
// Значения Data атрибутов data-scroll-minvw и data-scroll-maxvw определяет промежуток viewport,
// в котором будет выполняться скрипт



const DATA_ATTR_SELECTOR = '[data-scroll-on-load]';
const MIN_RESOLUTION_DATA_ATTR = 'scrollMinvw';
const MAX_RESOLUTION_DATA_ATTR = 'scrollMaxvw';


function initScrollOnLoad() {
  let element = document.querySelector(DATA_ATTR_SELECTOR);
  if (!element) return;

  let minVieportWidth = +element.dataset[MIN_RESOLUTION_DATA_ATTR] || 0;
  let maxVieportWidth = +element.dataset[MAX_RESOLUTION_DATA_ATTR] || Infinity;
  let currentViewportWidth = window.innerWidth;
  if (currentViewportWidth < minVieportWidth || currentViewportWidth > maxVieportWidth) return;

  document.addEventListener('DOMContentLoaded', () => {
    let elementCoords = element.getBoundingClientRect();
    let elementTop = pageYOffset + elementCoords.top;

    window.scrollTo(0, elementTop);
  }, {once: true});

}


export default initScrollOnLoad;
