'use strict';
import { scrollLock } from './util.js';

const SHOW_TEXT_DATA_ATTR = 'showmoreShowtext';
const HIDE_TEXT_DATA_ATTR = 'showmoreHidetext';
const NODES_QUANTITY_DATA_ATTR = 'showmoreNodes';
const COLLAPSED_HEIGHT_DATA_ATTR = 'showmoreHeight';
const BUTTON_CLASS_DATA_ATTR = 'showmoreButtonClass';
const BUTTON_HTML = `<button class="showmore__button link" aria-expanded="false" type="button">
                      <svg class="showmore__button-icon" width="32" height="32">
                        <use href="img/svg/_sprite.svg#icon-arrow"></use>
                      </svg>
                    </button>`;



class ShowmoreButton {
  constructor (mainElement) {
    let defaults = {
      // buttonTextClass: 'showmore__button-text',
      showText: mainElement.dataset[SHOW_TEXT_DATA_ATTR]  || 'Показать больше',
      hideText: mainElement.dataset[HIDE_TEXT_DATA_ATTR] || 'Скрыть',
      additionalClass: mainElement.dataset[BUTTON_CLASS_DATA_ATTR]
    };
    Object.assign(this, defaults);
    this._createButton();
  }

  _createButton() {
    let buttonContainerElement = document.createElement('div');
    buttonContainerElement.innerHTML = BUTTON_HTML;
    this.element = buttonContainerElement.firstChild;

    if (this.additionalClass) {
      this._addAdditionalClasses();
    }

    this.caption = document.createElement('span');
    // this.caption.classList.add(this.buttonTextClass);
    this.caption.innerText = this.showText;
    this.element.prepend(this.caption);
  }

  _addAdditionalClasses() {
    let additionalClasses = this.additionalClass.split(' ');
    if (Array.isArray(additionalClasses)) {
      additionalClasses.forEach(elem => {
        this.element.classList.add(elem);
      });
    }
  }

  changeState({isExpanded}) {
    this.element.setAttribute('aria-expanded', isExpanded);
    (isExpanded) ? this.caption.innerText = this.hideText : this.caption.innerText = this.showText;
  }
}


class Showmore {
  constructor(element) {
    const defaults = {};
    Object.assign(this, defaults);

    this.stateIsExpanded = false;
    this.element = element;
    this.button = null;
  }

  _createButton() {
    this.button = new ShowmoreButton(this.element);
  }

  _insertButton() {
    this.element.after(this.button.element);
  }
}


class ShowmoreNodes extends Showmore {
  constructor(element) {
    super(element);
    const defaults = {
      alwaysVisibleNodeQuantity: element.dataset[NODES_QUANTITY_DATA_ATTR] || 2
    };
    Object.assign(this, defaults);


    if (this._toggleNodes({isHidden: true})) {
      super._createButton();
      super._insertButton();
      this.button.element.addEventListener('click', this._onButtonClick.bind(this));
    }
  }


  _toggleNodes({isHidden}) {
    let counter = 0;
    let itemElements = this.element.children;
    for (let i = this.alwaysVisibleNodeQuantity; i < itemElements.length; i++) {
      itemElements[i].hidden = isHidden;
      counter++;
    }
    return counter;
  }


  _onButtonClick() {
    this.stateIsExpanded ? this._hideNodes() : this._showNodes();
  }


  _showNodes() {
    this.element.addEventListener('transitionend', () => {
      scrollLock({lock: false});
      this.element.style.height = 'auto';
    }, {once: true});

    // сохраним высоту для возврата к ней после закрытия
    this.collapsedHeight = this.element.scrollHeight;
    scrollLock({lock: true});
    this.element.style.height = this.element.scrollHeight + 'px';
    this._toggleNodes({isHidden: false});
    this.element.style.height = this.element.scrollHeight + 'px';
    this.button.changeState({isExpanded: true});
    this.stateIsExpanded = true;
  }


  _hideNodes() {
    this.element.addEventListener('transitionend', () => {
      this._toggleNodes({isHidden: true});
      scrollLock({lock: false});
      this.element.style.height = 'auto';
      this.element.style.transitionDuration = '';
    }, {once: true});

    this.element.style.height = this.element.scrollHeight + 'px';
    setTimeout(() => {
      scrollLock({lock: true});
      this.element.style.transitionDuration = '75ms';
      this.element.style.height = this.collapsedHeight + 'px';
    }, 0);
    this.button.changeState({isExpanded: false});
    this.stateIsExpanded = false;
  }

}


class ShowmoreHeight extends Showmore {
  constructor(element) {
    super(element);
    const defaults = {
      collapsedHeight: element.dataset[COLLAPSED_HEIGHT_DATA_ATTR] || 226
    };
    Object.assign(this, defaults);


    if (this.element.scrollHeight > this.collapsedHeight) {
      // установливаем мин высоту
      this.element.style.height = this.collapsedHeight + 'px';

      super._createButton();
      super._insertButton();
      this.button.element.addEventListener('click', () => {
        this.stateIsExpanded ? this._collapse() : this._show();
      });
    }
  }


  _show() {
    this.element.addEventListener('transitionend', () => {
      scrollLock({lock: false});
      this.element.style.height = 'auto';
    }, {once: true});

    scrollLock({lock: true});
    this.element.style.height = this.element.scrollHeight + 'px';
    this.button.changeState({isExpanded: true});
    this.stateIsExpanded = true;
  }


  _collapse() {
    this.element.addEventListener('transitionend', () => {
      scrollLock({lock: false});
      this.element.style.transitionDuration = '';
    }, {once: true});

    this.element.style.height = this.element.scrollHeight + 'px';
    setTimeout(() => {
      scrollLock({lock: true});
      this.element.style.transitionDuration = '75ms';
      this.element.style.height = this.collapsedHeight + 'px';
    }, 0);
    this.button.changeState({isExpanded: false});
    this.stateIsExpanded = false;
  }

}






const selector = '[data-showmore]';
const actionAttr = 'showmoreAction';

const typeDataAttr = {
  NODE_TYPE: 'hideNodes',
  HEIGHT_TYPE: 'hideHeight'
};

const typeActions = {
  [typeDataAttr.NODE_TYPE]: (elem) => new ShowmoreNodes(elem),
  [typeDataAttr.HEIGHT_TYPE]: (elem) => new ShowmoreHeight(elem)
};


function initShowmores() {
  const elements = Array.from(document.querySelectorAll(selector));
  const Showmores = elements.map((elem) => {
    return typeActions[elem.dataset[actionAttr]](elem);
  });

  return Showmores;
}


export default initShowmores;
