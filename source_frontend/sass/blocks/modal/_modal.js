import { isEscapePressEvent, scrollLock, executeAfterAnimationEnd } from '../../../js/util.js';





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
  BIG: 'big',
  EXTRABIG: 'extrabig',
  AUTO: 'auto'
};

const ModalSizeClasses = {
  [ModalSize.SMALL]: 'modal--small',
  [ModalSize.BIG]: 'modal--big',
  [ModalSize.EXTRABIG]: 'modal--extrabig',
  [ModalSize.AUTO]: 'modal--width-auto'
};


class Modal {
  constructor(overrides) {

    const defaults = {
      triggerDataAttributeName: 'data-modal',
      modalClass: 'modal',
      modalTypeDataAttribute: 'modalPosition',
      defaultPosition: ModalPosition.CENTER,
      modalSizeDataAttribute: 'modalSize',
      overlaySelector : 'overlay',
      modalOverlaySelector: 'modal__overlay',
      closeButtonSelector : '[data-modal-close]',
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
    this._stateIsClosing = false;

    this.handleEvent = (evt) => {
      switch(evt.type) {
        case 'keydown':
          isEscapePressEvent(evt, this.closeAfterAnnimationEnd.bind(this));
          break;
      }
    };

    // открытие по клику
    document.addEventListener('click', (evt) => {
      const triggerElement = evt.target.closest('[' + this.triggerDataAttributeName + ']');
      if (!triggerElement) return;
      evt.preventDefault();


      const _getHomelandPosition = (modalContentElement) => {
        return {
          parentElement: modalContentElement.parentElement,
          nextElement: modalContentElement.nextElementSibling
        };
      };

      const modalContentSelector = triggerElement.getAttribute(this.triggerDataAttributeName);
      const modalContentElement = document.querySelector(modalContentSelector);
      const homelandPosition = _getHomelandPosition(modalContentElement); // сохранение позиции в DOM, из которой будет выдернут HTML внутренностей окна

      const modalParams = {
        contentElement: modalContentElement,
        modalPosition: triggerElement.dataset[this.modalTypeDataAttribute],
        modalSize: triggerElement.dataset[this.modalSizeDataAttribute],
        callbackOnClose: () => {
          // возвращаем внутренности на первоначальную позицию
          let {parentElement, nextElement} =  homelandPosition;
          parentElement.insertBefore(modalContentElement, nextElement);
        },
        triggerElement: triggerElement
      };

      this.open(modalParams);
    });

  }


  open({header, content, contentElement, modalPosition, modalSize, callbackOnClose, triggerElement, focusOnOpen = true}) {

    const addOverlay = (currentModal) => {
      currentModal._overlayElement = document.createElement('div');
      currentModal._overlayElement.classList.add(this.overlaySelector);
      currentModal._overlayElement.classList.add(this.modalOverlaySelector);
      currentModal._modalElement.append(currentModal._overlayElement);
    };

    const _showIfNeeded = (contentElement) => {
      if (contentElement.hidden) {
        contentElement.hidden = false;
        currentModal._hiddenWasRemoved = true;
      }

      if (getComputedStyle(contentElement).display === 'none') {
        // у него нет класса закрытия (модальное расположено в контенте)
        // могут быть проблемы, если надо flex или grid.
        // При необходимости добавить значение по умолчанию и указание необходимого стиля в data атрибуте
        contentElement.style.display = 'block';
        currentModal._blockStyleWasAdded = true;
      }
    };

    const _addHandlers = (currentModal) => {

      const closeHandler = () => {
        this.closeAfterAnnimationEnd();
      };
      const closeButtonElements = currentModal._modalElement.querySelectorAll(this.closeButtonSelector);
      closeButtonElements.forEach(closeButtonElement => {
        closeButtonElement.addEventListener('click', closeHandler);
      });

      currentModal._overlayElement.addEventListener('click', closeHandler);

      // обработчик на закрытие по Esc - один на все открытые окна
      if (!this._documentKeydownHandlerWasAdded) {
        document.addEventListener('keydown', this);  // см this.handleEvent
        this._documentKeydownHandlerWasAdded = true;
      }
    };


    this._modals.push({});
    let currentModal = this._modals[this._getLastModalIndex()];
    currentModal._modalElement = this._createModalElement(header, content, contentElement, modalPosition, modalSize);
    currentModal._contentElement = contentElement;
    currentModal._triggerElement = triggerElement;
    currentModal._callbackOnClose = callbackOnClose;
    addOverlay(currentModal);
    document.body.append(currentModal._modalElement);

    if (contentElement) {
      _showIfNeeded(contentElement);
    }

    _addHandlers(currentModal);

    // блокируем только на первом окне
    if (this._modals.length === 1) {
      scrollLock({lock: true});
    }

    if (focusOnOpen) this._focus(currentModal, {shouldBeInside: true});
    this._stateIsClosing = false;
  }


  _createModalElement(headerText, content, contentElement, modalPosition = this.defaultPosition, modalSize) {
    const modalElement = document.createElement('div');
    modalElement.setAttribute('class', `${this.modalClass} ${ModalPositionClasses[modalPosition]} ${ModalSizeClasses[modalSize] || ''}`);
    modalElement.innerHTML = `<div class="modal__inner" role="dialog" aria-modal="true">
                                <button class="button button--modal-close modal__close-button" data-modal-close type="button">
                                  <span class="visually-hidden">Закрыть</span>
                                  <svg class="button__close-icon" viewBox="0 0 24 24" width="48" height="48" fill="none" stroke-linecap="round" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" d="M7 7l10 10M7 17L17 7"></path>
                                  </svg>
                                </button>
                                ${this._getHtmlContent(headerText, content)}
                              </div>`;

    if (contentElement) {
      modalElement.querySelector('.modal__inner').append(contentElement);
    }

    return modalElement;
  }


  _getHtmlContent(headerText, content) {
    const headerHtml = (headerText) ? `<h2 class="modal__header">${headerText}</h2>` : '';
    const contentHtml = (content) ? content : '';

    return headerHtml + contentHtml;
  }


  closeAfterAnnimationEnd () {
    if (this._stateIsClosing) return;

    this._stateIsClosing = true;
    const currentModal = this._modals[this._getLastModalIndex()];
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

    if (currentModal._hiddenWasRemoved) {
      currentModal._contentElement.hidden = true;
    }

    if (currentModal._blockStyleWasAdded) {
      currentModal._contentElement.style.display = '';
    }

    if (currentModal._callbackOnClose) currentModal._callbackOnClose();

    currentModal._modalElement.remove();

    _removeHandlers();

    this._modals.pop();

    if (this._modals.length === 0) {
      scrollLock({lock: false});
    }

    this._focus(currentModal, {shouldBeInside: false});

    this._stateIsClosing = false;
  }


  _getLastModalIndex() {
    return this._modals.length - 1;
  }


  _focus(currentModal, {shouldBeInside}) {
    // Метод переносит фокус с элемента открывающего окно
    // в само окно, и обратно, когда окно закрывается
    if (shouldBeInside) {
      const nodes = currentModal._modalElement.querySelectorAll(this.focusElements);
      if (nodes.length) nodes[0].focus();
    } else {
      if (currentModal._triggerElement) {
        currentModal._triggerElement.focus();
      }
    }
  }

}





function initModal() {
  return new Modal();
}

export default initModal;
