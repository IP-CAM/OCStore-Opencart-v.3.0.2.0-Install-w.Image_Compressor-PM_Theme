'use strict';


// * BASE HREF
let baseHref;
function getBaseHref() {
  if (baseHref !== undefined)  return baseHref;
  baseHref = document.querySelector('base').href;
  return baseHref;
}


// * SEARCH FIELD
function initSearch() {
  const FORM_SELECTOR = '.search-form';
  const INPUT_SELECTOR = '.search-form__input';

  const formElement = document.querySelectorAll(FORM_SELECTOR);
  formElement.forEach((elem) => {
    elem.addEventListener('submit', (evt) => {
      evt.preventDefault();

      let url = getBaseHref() + 'index.php?route=product/search';
      let searchValue = elem.querySelector(INPUT_SELECTOR).value;
      if (searchValue) {
        url += '&search=' + encodeURIComponent(searchValue);
      }
      window.location = url;
    });
  });
}

initSearch();
