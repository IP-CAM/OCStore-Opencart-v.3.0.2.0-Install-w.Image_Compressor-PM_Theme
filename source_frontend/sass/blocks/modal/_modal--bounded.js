import { isEscapePressEvent } from '../../../js/util.js';


class ModalBounded {
  constructor(overrides) {

    const defaults = {
      openButtonSelector: undefined,
      modalSelector: undefined,
      parentSelector: undefined,
      parentBoundSelector: 'modal__parent-bound',
      closeModalClass : 'modal--closed',
      // closeButtonSelector : '.modal__close-button',
      overlaySelector : 'overlay',
      showDelay : 150,
      closeDelay : 200
    };

    Object.assign(this, defaults, overrides);

    this._parentElement = undefined;
    this._modalElement = undefined;
    this._isOpened = false;

    this._buttonElement = document.querySelector(this.openButtonSelector);
    this._buttonElement.addEventListener('click', this._showModal.bind(this));
    this._buttonElement.addEventListener('mouseenter', (evt) => {
      this._timerOpenId = setTimeout(() => this._showModal(evt), this.showDelay);
    });
    this._buttonElement.addEventListener('mouseleave', () => clearTimeout(this._timerOpenId));

  }


  _showModal (evt) {

    const createElements = () => {
      if (!this._parentElement || !this._modalElement) {
        this._parentElement = document.querySelector(this.parentSelector);
        this._modalElement = this._parentElement.querySelector(this.modalSelector);
      }
      // if (!this._closeButtonElement) {
      //   this._closeButtonElement = this._modalElement.querySelector(this.closeButtonSelector);
      // }
    };

    const addOverlay = () => {
      this._overlayElement = document.createElement('div');
      this._overlayElement.classList.add(this.overlaySelector);
      this._parentElement.before(this._overlayElement);
    };

    const configClasses = () => {
      this._parentElement.classList.add(this.parentBoundSelector);
      this._modalElement.classList.remove(this.closeModalClass);
    };

    const addHandlers = () => {
      this._onOverlayClick = () => {
        clearTimeout(this._timerCloseId);
        this._closeModal();
      };

      this._onDocumentKeydown = (evt) => {
        isEscapePressEvent(evt, this._closeModal.bind(this));
      };

      this._onCloseButtonClick = () => {
        this._closeModal();
      };

      this._onModalMouseLeave = () => {
        this._timerCloseId = setTimeout(() => this._closeModal(), this.closeDelay);
      };

      this._onModalMouseEnter = () => {
        clearTimeout(this._timerCloseId);
      };

      this._overlayElement.addEventListener('click', this._onOverlayClick);
      document.addEventListener('keydown', this._onDocumentKeydown);
      // if (this._closeButtonElement) {
      //   this._closeButtonElement.addEventListener('click', this._onCloseButtonClick);
      // }
      this._parentElement.addEventListener('mouseleave', this._onModalMouseLeave);
      this._parentElement.addEventListener('mouseenter', this._onModalMouseEnter);
    };


    if (this._isOpened) return;
    evt.preventDefault();
    createElements();
    addOverlay();
    configClasses();
    addHandlers();
    // scrollLock({lock: true});
    this._isOpened = true;
  }


  _closeModal() {
    const removeOverlay = () => {
      this._overlayElement.remove();
    };

    const configClasses = () => {
      this._parentElement.classList.remove(this.parentBoundSelector);
      this._modalElement.classList.add(this.closeModalClass);
    };

    const removeHandlers = () => {
      this._overlayElement.removeEventListener('click', this._onOverlayClick);
      document.removeEventListener('keydown', this._onDocumentKeydown);
      // if (this._closeButtonElement) {
      //   this._closeButtonElement.removeEventListener('click', this._onCloseButtonClick);
      // }
      this._parentElement.removeEventListener('mouseleave', this._onModalMouseLeave);
      this._parentElement.removeEventListener('mouseenter', this._onModalMouseEnter);
    };

    removeOverlay();
    configClasses();
    removeHandlers();
    // scrollLock({lock: false});
    this._isOpened = false;
  }
}



function initBoundedModals() {

  const modalContactsArgs = {
    openButtonSelector: '.header__contacts-button',
    modalSelector: '.header__contacts .modal',
    parentSelector: '.header__contacts'
  };

  const modalUserArgs = {
    openButtonSelector: '.header__user .header__link',
    modalSelector: '.header__user .modal',
    parentSelector: '.header__user'
  };

  const modalCartArgs = {
    openButtonSelector: '.header__cart .header__link',
    modalSelector: '.header__cart .modal',
    parentSelector: '.header__cart'
  };


  let modals = [
    new ModalBounded(modalContactsArgs),
    new ModalBounded(modalUserArgs),
    new ModalBounded(modalCartArgs)
  ];

  return modals;
}


export default initBoundedModals;
