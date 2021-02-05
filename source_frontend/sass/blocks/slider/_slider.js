'use strict';
import { isTouchDevice } from  '../../../js/util.js';


const Button = {
  LEFT: 'Назад',
  RIGHT: 'Вперед'
};

const ButtonModClasses = {
  [Button.LEFT]: 'slider__toggle--left',
  [Button.RIGHT]: 'slider__toggle--right'
};

function getButtonHTML(buttonText) {
  let buttonModClass = ButtonModClasses[buttonText];

  return `<button class="button slider__toggle ${buttonModClass}" type="button">
            <span class="visually-hidden">${buttonText}</span>
            <svg class="slider__toggle-icon" viewBox="0 0 24 24" width="24" height="24">
              <polyline points="7,11 12,15 17,11" fill="none" stroke-linejoin="round" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
            </svg>
          </button>`;
}



class Slider {
  constructor(element, overrides) {
    const defaults = {
      sliderSelector: '.slider',
      firstSlideModificator: 'slider--first-slide',
      lastSlideModificator: 'slider--last-slide',
      listSelector: '.slider__list',
      itemSelector: '.slider__item',
      mainNavSelector: '.slider__nav',
      navItemSelector: '.slider__nav-item',
      navItemActiveClass: 'slider__nav-item--active',
      navLinkSelector: '.slider__nav-link',
      buttonToggleSelector: '.slider__toggle',
      buttonToggleLeftClass: 'slider__toggle--left',
      buttonToggleRightClass: 'slider__toggle--right',
      createToggtleButtons: true
    };

    Object.assign(this, defaults, overrides);

    this.element = element;
    this.listElement = this.element.querySelector(this.listSelector);
    this.itemElements = this.element.querySelectorAll(this.itemSelector);

    this.mainNavElement = this.element.querySelector(this.mainNavSelector);
    if (this.mainNavElement) {
      this.navItemElements = this.element.querySelectorAll(this.navItemSelector);
    }

    this.lastIndex = 0; // индекс первого элемента
    this.maxIndex = this.itemElements.length - 1;
    let itemsMarginWithPx = getComputedStyle(this.itemElements[0]).getPropertyValue('margin-right');
    this.itemsMargin = +itemsMarginWithPx.slice(0, itemsMarginWithPx.length - 2);

    // если один слайд - удаляем навигационную панель и выходим
    if (this.maxIndex === 0) {
      this.mainNavElement.remove();
      return;
    }

    if (this.createToggtleButtons && (!isTouchDevice())) {
      this.element.classList.add(this.firstSlideModificator);
      this._createToggleButtons();
    }
    this._createDataAttrIndex();

    this._createIntersectionObserver({
      rootElement: this.listElement,
      targetElements: this.itemElements
    });


    this.element.addEventListener('click', (evt) => {

      const isClickWasOnNavItem = () => {
        // вылавливаем клик по навигационной ссылке => перелистываем
        let navItemElement = evt.target.closest(this.navItemSelector);
        if (!navItemElement) return false;
        // отменяем переход по ссылке
        evt.preventDefault();
        // 1. Определяем индекс clicked item и скроллим
        this._scrollSlide(+navItemElement.dataset.index);
        return true;
      };

      const isClickWasOnToggleButton = () => {
        let target = evt.target.closest(this.buttonToggleSelector);
        if (!target) return false;
        let targetIndex = this.lastIndex;
        target.classList.contains(this.buttonToggleLeftClass) ?  targetIndex += -1 : targetIndex += 1;
        this._scrollSlide(targetIndex);
      };


      if (this.mainNavElement) {
        if (isClickWasOnNavItem()) return;
      }
      if (this.createToggtleButtons) {
        isClickWasOnToggleButton();
      }

    });


    this.element.addEventListener('slideIn', (evt) => {
      // замена активной ссылки
      // Определяем номер активного слайда
      let targetIndex = +evt.detail.targetElement.dataset.index;
      if (this.mainNavElement) {
        this._updateNavItems(targetIndex);
      }
      this.lastIndex = targetIndex;
    });

    // кнопки видны тлько на не тач устройствах
    if (this.createToggtleButtons && !isTouchDevice()) {
      this.element.addEventListener('firstSlideIn', this._updateToggleButtons.bind(this, 'hideLeftToggle'));
      this.element.addEventListener('firstSlideOut', this._updateToggleButtons.bind(this, 'showLeftToggle'));
      this.element.addEventListener('lastSlideIn', this._updateToggleButtons.bind(this, 'hideRightToggle'));
      this.element.addEventListener('lastSlideOut', this._updateToggleButtons.bind(this, 'showRightToggle'));
    }
  }


  _createToggleButtons() {
    let setOfButtonsHTML = getButtonHTML(Button.LEFT) + getButtonHTML(Button.RIGHT);
    this.element.firstElementChild.insertAdjacentHTML('beforeend', setOfButtonsHTML);
    if (this.mainNavElement) {
      this.mainNavElement.insertAdjacentHTML('afterbegin', setOfButtonsHTML);
    }
  }


  _createDataAttrIndex() {
    for (let i = 0; i < this.itemElements.length; i++) {
      this.itemElements[i].dataset.index = i;
      if (this.mainNavElement) {
        this.navItemElements[i].dataset.index = i;
      }
    }
  }


  _createIntersectionObserver({rootElement, targetElements}) {
    const options = {
      root: rootElement,
      rootMargin: '0px', // Отступы вокруг root
      threshold: 0.5 // Число или массив чисел, указывающий, при каком проценте видимости целевого элемента должен сработать callback
    };

    const callback = (entries) => {

      entries.forEach((elem)=>{
        if (elem.isIntersecting) {
          let slideIn = new CustomEvent('slideIn', {
            detail: {
              targetElement: elem.target
            }
          });
          this.element.dispatchEvent(slideIn);

          if (elem.target.dataset.index === '0') {
            let firstSlideIn = new CustomEvent('firstSlideIn');
            this.element.dispatchEvent(firstSlideIn);
          }

          if (+elem.target.dataset.index === this.maxIndex) {
            let lastSlideIn = new CustomEvent('lastSlideIn');
            this.element.dispatchEvent(lastSlideIn);
          }
        } else {
          if (elem.target.dataset.index === '0') {
            let firstSlideOut = new CustomEvent('firstSlideOut');
            this.element.dispatchEvent(firstSlideOut);
          }

          if (+elem.target.dataset.index === this.maxIndex) {
            let lastSlideOut = new CustomEvent('lastSlideOut');
            this.element.dispatchEvent(lastSlideOut);
          }
        }
      });
    };

    var observer = new IntersectionObserver(callback, options);

    targetElements.forEach((elem) => {
      observer.observe(elem);
    });
  }


  _scrollSlide(targetIndex) {
    // на сколько элементов надо подвинуться? Положительное знач - вперед, отрицательное - назад
    let indexDiff = targetIndex - this.lastIndex;
    let itemWidth = this.itemElements[0].offsetWidth;
    this.listElement.scrollLeft += (itemWidth + this.itemsMargin) * indexDiff;
  }


  _updateNavItems(targetIndex) {
    // очистить активный класс
    this.navItemElements[this.lastIndex].classList.remove(this.navItemActiveClass);
    // 3. Установить в навигацию по установленному номеру активный класс
    this.navItemElements[targetIndex].classList.add(this.navItemActiveClass);
  }


  _updateToggleButtons(action) {
    let operations = {};
    operations['showLeftToggle'] = () => this.element.classList.remove(this.firstSlideModificator);
    operations['hideLeftToggle'] = () => this.element.classList.add(this.firstSlideModificator);
    operations['showRightToggle'] = () => this.element.classList.remove(this.lastSlideModificator);
    operations['hideRightToggle'] = () => this.element.classList.add(this.lastSlideModificator);

    operations[action]();
  }

}


const SLIDER_SELECTOR = '.slider';
function initSliders() {
  const sliderElements = Array.from(document.querySelectorAll(SLIDER_SELECTOR));
  const sliders = sliderElements.map((elem) => new Slider(elem));
  return sliders;
}

export default initSliders;
