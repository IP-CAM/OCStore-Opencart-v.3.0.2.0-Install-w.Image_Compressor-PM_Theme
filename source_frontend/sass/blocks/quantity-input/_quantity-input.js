class QuantityInput {
  constructor(overrides) {

    const defaults = {
      buttonSelector: '.quantity-input__button',
      buttonMoreClass: 'quantity-input__button--more'
    };

    Object.assign(this, defaults, overrides);

    if (document.querySelector(this.buttonSelector)) {
      this._init();
    }
  }


  _init() {
    document.addEventListener('click', (evt) => {
      let target = evt.target.closest(this.buttonSelector);

      if (!target) return;

      if (target.classList.contains(this.buttonMoreClass)) {
        target.previousElementSibling.value++;
      } else {
        if (target.nextElementSibling.value <= 1) return;
        target.nextElementSibling.value--;
      }
    });
  }
}


function initQuantityInput() {
  return new QuantityInput();
}

export default initQuantityInput;
