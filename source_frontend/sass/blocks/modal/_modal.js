'use strict';
import { isEscapePressEvent, scrollLock, executeAfterAnimationEnd } from './util.js';


const ModalPosition = {
  CENTER: 'center',
  LEFT: 'left'
};

const ModalPositionClasses = {
  [ModalPosition.CENTER]: 'modal--center',
  [ModalPosition.LEFT]: 'modal--left'
};

const ModalSize = {
  SMALL: 'small',
  BIG: 'big'
};

const ModalSizeClasses = {
  [ModalSize.SMALL]: 'modal--small',
  [ModalSize.BIG]: 'modal--big'
};


class Modal {
  constructor(overrides) {

    const defaults = {
      triggerDataAttributeName: 'data-modal',
      closeModalClass : 'modal__content--closed',
      modalTemplateSelector: '#modal',
      modalBodySelector: '.modal',
      modalTypeDataAttribute: 'modalPosition',
      defaultPosition: ModalPosition.CENTER,
      modalSizeDataAttribute: 'modalSize',
      overlaySelector : 'overlay',
      modalOverlaySelector: 'modal__overlay',
      closeButtonSelector : '.modal__close-button',
      focusElements: [
        // 'a[href]',
        // 'area[href]',
        'input:not([disabled]):not([type="hidden"]):not([aria-hidden])',
        'select:not([disabled]):not([aria-hidden])',
        'textarea:not([disabled]):not([aria-hidden])',
        'button:not([disabled]):not([aria-hidden]):not(.button--modal-close)',
        'iframe',
        '[tabindex]:not([tabindex^="-"])'
      ],
      animationOnCloseClass: 'modal--animation-on-close',
      animationOnCloseName: 'hideModal',

    };

    Object.assign(this, defaults, overrides);

    this._modals = [];
    this._documentKeydownHandlerWasAdded = false;

    this.handleEvent = (evt) => {
      switch(evt.type) {
        case 'keydown':
          isEscapePressEvent(evt, this._closeAfterAnnimationEnd.bind(this));
          break;
      }
    };



    document.addEventListener('click', (evt) => {
      let triggerElement = evt.target.closest('[' + this.triggerDataAttributeName + ']');
      if (!triggerElement) return;

      evt.preventDefault();
      this._open(triggerElement);
    });

  }


  _open(triggerElement) {
    const _cloneModalTemplate = () => {
      return document.querySelector(this.modalTemplateSelector)
        .content.querySelector(this.modalBodySelector)
        .cloneNode(true);
    };

    const _addPositionClass = (currentModal) => {
      const _readPositionAttribute = () => {
        return triggerElement.dataset[this.modalTypeDataAttribute] || this.defaultPosition;
      };

      let modalPosition = _readPositionAttribute();
      currentModal._modalElement.classList.add(ModalPositionClasses[modalPosition]);
    };

    const _addSizeClass = (currentModal) => {
      let modalSize = triggerElement.dataset[this.modalSizeDataAttribute];
      if (modalSize) {
        currentModal._modalElement.classList.add(ModalSizeClasses[modalSize]);
      }
    };

    const _saveHomelandPosition = (currentModal) => {
      currentModal._modalContentElementHomelandPosition = {
        parentElement: currentModal._modalContentElement.parentElement,
        nextElement: currentModal._modalContentElement.nextElementSibling
      };
    };

    const _changeAriaAttrIfNeeded = (currentModal) => {
      if (currentModal._modalContentElement.getAttribute('aria-hidden')) {
        currentModal._modalContentElement.setAttribute('aria-hidden', false);
        currentModal._ariaAttrWasRemoved = true;
      }
    };

    const addOverlay = (currentModal) => {
      currentModal._overlayElement = document.createElement('div');
      currentModal._overlayElement.classList.add(this.overlaySelector);
      currentModal._overlayElement.classList.add(this.modalOverlaySelector);
      currentModal._modalElement.append(currentModal._overlayElement);
    };

    const _show = (currentModal) => {
      if (currentModal._modalContentElement.classList.contains(this.closeModalClass)) {
        currentModal._modalContentElement.classList.remove(this.closeModalClass);
        currentModal._closedClassWasRemoved = true;
      } else {
        // у него нет класса закрытия (модальное расположено в контенте)
        // могут быть проблемы, если надо flex или grid.
        // При необходимости добавить значение по умолчанию и указание необходимого стиля в data атрибуте
        currentModal._modalContentElement.style.display = 'block';
      }
    };

    const _addHandlers = (currentModal) => {
      let closeButtonElement = currentModal._modalElement.querySelector(this.closeButtonSelector);
      closeButtonElement.addEventListener('click', this._closeAfterAnnimationEnd.bind(this));

      currentModal._overlayElement.addEventListener('click', this._closeAfterAnnimationEnd.bind(this));

      // обработчик на закрытие по Esc - один на все открытые окна
      if (!this._documentKeydownHandlerWasAdded) {
        document.addEventListener('keydown', this);  // см this.handleEvent
        this._documentKeydownHandlerWasAdded = true;
      }
    };


    this._modals.push({});
    let currentModal = this._modals[this._getLastModalIndex()];

    currentModal._triggerElement = triggerElement;
    currentModal._modalElement = _cloneModalTemplate();
    _addPositionClass(currentModal);
    _addSizeClass(currentModal);

    let modalContentSelector = triggerElement.getAttribute(this.triggerDataAttributeName);
    currentModal._modalContentElement = document.querySelector(modalContentSelector);

    // сохранение позиции в DOM, из которой будет выдернут HTML внутренностей окна
    _saveHomelandPosition(currentModal);
    _changeAriaAttrIfNeeded(currentModal);

    currentModal._modalElement.children[0].prepend(currentModal._modalContentElement);
    addOverlay(currentModal);
    document.body.append(currentModal._modalElement);
    _show(currentModal);
    _addHandlers(currentModal);

    // блокируем только на первом окне
    if (this._modals.length === 1) {
      scrollLock({lock: true});
    }

    this._focus(currentModal, {shouldBeInside: true});
  }


  _closeAfterAnnimationEnd () {
    let currentModal = this._modals[this._getLastModalIndex()];
    executeAfterAnimationEnd(
      {
        element: currentModal._modalElement,
        animationClass: this.animationOnCloseClass,
        animationName: this.animationOnCloseName,
        callback: this._close.bind(this)
      });
  }


  _close() {
    const _removeHandlers = () => {
      // удаляем обработчик по keydown только если закрывается единственное окно
      if (this._modals.length === 1) {
        document.removeEventListener('keydown', this);
        this._documentKeydownHandlerWasAdded = false;
      }
    };


    let currentModal = this._modals[this._getLastModalIndex()];
    currentModal._modalContentElement.style.display = '';

    if (currentModal._closedClassWasRemoved) {
      currentModal._modalContentElement.classList.add(this.closeModalClass);
    }

    if (currentModal._ariaAttrWasRemoved) {
      currentModal._modalContentElement.setAttribute('aria-hidden', true);
    }

    let {parentElement, nextElement} =  currentModal._modalContentElementHomelandPosition;
    parentElement.insertBefore(currentModal._modalContentElement, nextElement);

    currentModal._modalElement.remove();

    _removeHandlers();

    this._modals.pop();

    if (this._modals.length === 0) {
      scrollLock({lock: false});
    }

    this._focus(currentModal, {shouldBeInside: false});
  }


  _getLastModalIndex() {
    return this._modals.length - 1;
  }


  _focus(currentModal, {shouldBeInside}) {
    // Метод переносит фокус с элемента открывающего окно
    // в само окно, и обратно, когда окно закрывается
    const nodes = currentModal._modalElement.querySelectorAll(this.focusElements);
    if (shouldBeInside) {
      if (nodes.length) nodes[0].focus();
    } else {
      currentModal._triggerElement.focus();
    }
  }

}





function initModal() {
  return new Modal();
}

export default initModal;
