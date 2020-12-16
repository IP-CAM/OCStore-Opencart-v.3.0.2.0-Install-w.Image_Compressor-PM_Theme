'use strict';
// меняет текст оценки при выборе звезды и загрузке страницы


const captionSelector = '.stars__selected-input';

class Stars {
  constructor(element) {
    this.captionElement = element.querySelector(captionSelector);

    let selectedElement = element.querySelector(':checked');
    this._setCaption(selectedElement);

    element.addEventListener('change', (evt) => {
      this._setCaption(evt.target);
    });
  }

  _setCaption(selectedElement) {
    this.captionElement.textContent = selectedElement.getAttribute('aria-label');
  }
}



const STARS_SELECTOR = '.stars__fieldset';

function initStars() {
  const starElements = Array.from(document.querySelectorAll(STARS_SELECTOR));
  const stars = starElements.map((elem) => new Stars(elem));
  return stars;
}

export default initStars;
