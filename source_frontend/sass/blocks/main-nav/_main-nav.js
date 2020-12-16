import { isTouchDevice } from  './util.js';
// Определить поддержку hover
// Если поддержки нет - блокировать первый клик по меню первого уровня


class MainNav {
  constructor(overrides) {
    const defaults = {
      mainSelector: '.main-nav',
      mainListSelector: '.main-nav__list--lvl1',
      firstLevelLinkSelector: '.main-nav__link--lvl1'
    };

    Object.assign(this, defaults, overrides);

    this._mainElement = null;
    this._firstClickedElement = null;


    if (isTouchDevice()) {
      this._init();
      this._enableFirstClickPrevention();
    }
  }

  _init() {
    this._mainElement = document.querySelector(this.mainSelector);
  }

  _enableFirstClickPrevention() {
    this._mainElement.addEventListener('click', (evt) => {
      let target = evt.target.closest(this.firstLevelLinkSelector);
      if (!target) return;

      // если по элементу кликнули первый раз
      if (this._firstClickedElement !== target) {
        //отменяем переход по ссылке
        evt.preventDefault();
        // При клике за пределами меню (закрытие меню)
        // обнулить _firstClickedElement и удалить обработчик
        document.addEventListener('click', (evt) => {
          let target = evt.target.closest(this.mainListSelector);
          if (!target) {
            this._firstClickedElement = null;
          }
        }, {capture: true, once: true});
      }

      this._firstClickedElement = target;
    });
  }

}


function initMainNav() {
  return new MainNav();
}

export default initMainNav;
