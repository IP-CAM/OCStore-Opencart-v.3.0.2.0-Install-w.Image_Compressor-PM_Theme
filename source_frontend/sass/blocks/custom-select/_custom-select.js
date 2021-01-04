import appendCustomFocusEvents from './custom-focus-events.js';
import { generateId } from './util.js';


class CustomSelect {
  constructor(element, overrides) {

    const defaults = {
      mainSelector : '.custom-select',
      inputSelector : 'input',
      listSelector : '.custom-select__list',
      listCloseClass : 'custom-select__list--closed',
      itemSelector : '.custom-select__item',
      statusSelector : '[aria-live="polite"]',
      itemTitleSelector : '.custom-select__item-title',
      filteredStatusPrefix : 'Доступно вариантов : '
    };

    Object.assign(this, defaults, overrides);


    this.element = element;
    this.inputElement = this.element.querySelector(this.inputSelector);
    this.state = {
      isOpened: false
    };
    this.listElement = this.element.querySelector(this.listSelector);
    this.itemElements = this.element.querySelectorAll(this.itemSelector);
    this.items = Array.from(this.itemElements);
    this.statusElement = this.element.querySelector(this.statusSelector);

    // generate ID for list
    let listId = generateId();
    this.listElement.id = listId;

    // * setting Aria attributes
    this.element.setAttribute('role', 'combobox');
    this.element.setAttribute('aria-haspopup', 'listbox');
    this.element.setAttribute('aria-owns', this.listElement.id);
    this.element.setAttribute('aria-expanded', 'false');
    this.inputElement.setAttribute('aria-controls', this.listElement.id);
    this.inputElement.setAttribute('aria-autocomplete', 'both');
    this.listElement.setAttribute('role', 'listbox');
    this.itemElements.forEach(function(item) {
      item.setAttribute('role', 'option');
      item.setAttribute('tabindex', '-1');
    });


    // * Adding handlers
    this.inputElement.addEventListener('click', () => {
      this._toggleList();
    });


    this.listElement.addEventListener('click', () => {
      const focusedElement = document.activeElement;
      if (focusedElement.tagName === 'LI') {
        this._makeChoice(focusedElement);
        this._toggleList();
      }
    });


    this.element.addEventListener('keyup', (evt) => {
      this._doKeyAction(evt.key);
    });


    appendCustomFocusEvents(this.element);
    this.element.addEventListener('focusLeave', () => {
      if (this.state.isOpened) {
        this._toggleList('shut');
      }
    });


    document.addEventListener('click', (evt) => {
      if (!evt.target.closest(this.mainSelector) && this.state.isOpened) {
        this._toggleList('shut');
      }
    });
  }


  _toggleList(action = 'toggle') {

    let _openList  = () => {
      this.listElement.classList.remove(this.listCloseClass);
      this.element.setAttribute('aria-expanded', 'true');
      this.state.isOpened = true;
    };

    let _closeList  = () => {
      this.listElement.classList.add(this.listCloseClass);
      this.element.setAttribute('aria-expanded', 'false');
      this.state.isOpened = false;
    };


    switch (action) {
      case 'toggle':
        if (this.state.isOpened) {
          _closeList();
        } else {
          _openList();
        }
        break;

      case 'open':
        _openList();
        break;

      case 'shut':
        _closeList();
        break;
    }
  }


  _makeChoice(focusedItem) {
    const itemTitle = focusedItem.querySelector(this.itemTitleSelector);
    this.inputElement.value = itemTitle.textContent;
    this.inputElement.focus();
  }


  _moveFocus({moveDirection}) {

    const visibleItems = this.items.filter((item) => (item.style.display === ''));
    const currentFocus = document.activeElement;
    let currentIndex;

    let _moveFocusUp = () => {
      switch (true) {

        case (currentFocus === this.inputElement):
          visibleItems[visibleItems.length - 1].focus();
          break;

        case (currentFocus.tagName === 'LI'):
          currentIndex = visibleItems.indexOf(currentFocus);
          if (currentIndex === 0) {
            this.inputElement.focus();
          } else {
            visibleItems[currentIndex - 1].focus();
          }
          break;
      }
    };

    let _moveFocusDown = () => {
      switch (true) {

        case (currentFocus === this.inputElement):
          visibleItems[0].focus();
          break;

        case (currentFocus.tagName === 'LI'):
          currentIndex = visibleItems.indexOf(currentFocus);
          if (currentIndex !== visibleItems.length - 1) {
            visibleItems[currentIndex + 1].focus();
          } else {
            visibleItems[0].focus();
          }
          break;
      }
    };


    if (visibleItems.length === 0) return;
    if (moveDirection === 'up') {
      _moveFocusUp();
    } else {
      _moveFocusDown();
    }
  }


  _doKeyAction(key) {
    const currentFocus = document.activeElement;

    switch(key) {

      case 'Enter':
        if (this.state.isOpened && currentFocus.tagName === 'LI') {
          this._makeChoice(currentFocus);
        }
        this._toggleList();
        break;

      case 'Escape':
        if (this.state.isOpened) {
          this._toggleList();
        }
        break;

      case 'ArrowDown':
        if (!this.state.isOpened) {
          this._toggleList();
        }
        this._moveFocus({moveDirection: 'down'});
        break;

      case 'ArrowUp':
        if (!this.state.isOpened) {
          this._toggleList();
        }
        this._moveFocus({moveDirection: 'up'});
        break;

      default:
        if (!this.state.isOpened) {
          this._toggleList();
        }
        this._doFilter();
        break;
    }

  }


  _doFilter() {
    const terms = this.inputElement.value;

    this.itemElements.forEach((item) => item.style.display = 'none');

    const filteredItems = this.items.filter((item) =>
      item.innerText.toUpperCase().startsWith(terms.toUpperCase()));

    filteredItems.forEach((item) => item.style.display = '');

    this._updateStatus(filteredItems.length);
  }


  _updateStatus(itemsQuantity) {
    this.statusElement.textContent = this.filteredStatusPrefix + itemsQuantity;
  }

}




const mainSelector = '.custom-select';

function initCustomSelects() {
  const customSelectElements = document.querySelectorAll(mainSelector);
  const customSelects = [].map.call(customSelectElements, (elem) => new CustomSelect(elem));
  return customSelects;
}

export default initCustomSelects;
