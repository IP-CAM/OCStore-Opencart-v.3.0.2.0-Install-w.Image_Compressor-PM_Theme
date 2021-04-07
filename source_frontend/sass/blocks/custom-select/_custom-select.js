import appendCustomFocusEvents from '../../../js/custom-focus-events.js';


const MAIN_SELECTOR = '.custom-select';
const LIST_SELECTOR = '.custom-select__list';
const ITEM_SELECTOR = '.custom-select__item';
const INPUT_SELECTOR = 'input';
const ITEM_TITLE_SELECTOR = '.custom-select__item-title';
const ITEM_DESCRIPTION_SELECTOR = '.custom-select__item-description';
const STATUS_HTML = '<div class="visually-hidden" aria-live="polite"></div>';
const STATUS_SELECTOR = '[aria-live="polite"]';
const FILTERED_STATUS_PREFIX = 'Доступно вариантов: ';
const FilterEntryType = {
  ANY: 'any',
  START: 'start'
};
const FILTER_ENTRY_TYPE = FilterEntryType.ANY;


class DataManager {
  constructor() {
    this.data = [];
    this.sourceUrl = undefined;
    this.sourceFieldName = {
      title: 'title', // !!! разобраться с перезаписью
      description: 'description',
      dataId: 'dataId',
    };
  }

  updateDataFromItemElements(itemElements) {
    itemElements.forEach(item => {
      this.data.push({
        title: (item.querySelector(ITEM_TITLE_SELECTOR)) ? item.querySelector(ITEM_TITLE_SELECTOR).textContent : '',
        description: (item.querySelector(ITEM_DESCRIPTION_SELECTOR)) ? item.querySelector(ITEM_DESCRIPTION_SELECTOR).textContent : '',
        dataId: item.dataset.id || ''
      });
    });
    return this.data;
  }

  setExternalSource(url, {titleFieldName, descriptionFieldName, dataIdFieldName} = {}) {
    this.sourceUrl = url;
    this._setSourceFieldNames(titleFieldName, descriptionFieldName, dataIdFieldName);
  }

  setSource(data, {titleFieldName, descriptionFieldName, dataIdFieldName} = {}) {
    this._setSourceFieldNames(titleFieldName, descriptionFieldName, dataIdFieldName);
    this.setData(data);
  }

  _setSourceFieldNames(titleFieldName, descriptionFieldName, dataIdFieldName) {
    if (titleFieldName) this.sourceFieldName.title = titleFieldName;
    if (descriptionFieldName) this.sourceFieldName.description = descriptionFieldName;
    if (dataIdFieldName) this.sourceFieldName.dataId = dataIdFieldName;
  }

  updateDataFromExternalSource(term = '') {
    return fetch(this.sourceUrl + encodeURIComponent(term))
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.json();
      })
      .then(json => {
        this.setData(json);
      })
      .catch(console.error);
  }

  setData(itemsData) {
    // itemsData - массив объектов [{},{},...]
    const {title, description, dataId} = this.sourceFieldName;
    this.data = itemsData.map(item => {
      return {
        title: item[title] || '',
        description: item[description] || '',
        dataId: item[dataId] || ''
      };
    });
  }

  getData(terms) {
    if (terms) {
      switch (FILTER_ENTRY_TYPE) {
        case FilterEntryType.ANY:
          return this.data.filter(dataItem =>
            dataItem.title.trim().toUpperCase().includes(terms.toUpperCase()));
        case FilterEntryType.START:
          return this.data.filter(dataItem =>
            dataItem.title.trim().toUpperCase().startsWith(terms.toUpperCase()));
      }
    } else {
      return this.data;
    }
  }

  clearData() {
    this.data = [];
  }
}


class Input {
  constructor(mainElement) {
    this.element = mainElement.querySelector(INPUT_SELECTOR);

    this._createCustomSelectInputEvent(mainElement); // * adding user custom events
  }

  _createCustomSelectInputEvent(mainElement) {
    this.element.addEventListener('input', (evt) => {
      mainElement.dispatchEvent(new CustomEvent('customSelectInput', {
        detail: {
          value: evt.target.value
        }
      }));
    });
  }
}


class List {
  constructor(mainElement) {
    this.listElement = mainElement.querySelector(LIST_SELECTOR);
    this.itemElements = undefined;
    this.itemElementsIsUpdated = undefined;
    this.itemsCount = this.listElement.children.length;
  }

  getCurrentItems() {
    if (!this.itemElementsIsUpdated) {
      this.itemElements = this.listElement.querySelectorAll(ITEM_SELECTOR);
      this.itemElementsIsUpdated = true;
    }
    return this.itemElements;
  }

  render(itemsData) {
    const itemElements = itemsData.map(item =>
      `<li class="custom-select__item" ${(item.dataId) ? `data-id="${item.dataId}"` : ''} role="option" tabindex="-1">
        <strong class="custom-select__item-title">${item.title}</strong>
        ${(item.description) ? `<span class="custom-select__item-description">${item.description}</span>` : ''}
      </li>`);
    this.listElement.innerHTML =  itemElements.join('');
    this.itemsCount = itemsData.length;
    this.itemElementsIsUpdated = false;
  }

  open() {
    if (this.itemsCount) {
      this.listElement.hidden = false;
      return true;
    }
  }

  close() {
    this.listElement.hidden = true;
  }

  clear() {
    while(this.listElement.firstChild) {
      this.listElement.removeChild(this.listElement.firstChild);
    }
  }

  focus(direction) {
    const itemElements = Array.from(this.getCurrentItems());
    if (itemElements.length === 0) return;

    let currentIndex;

    switch (direction) {
      case 'first':
        itemElements[0].focus();
        break;
      case 'last':
        itemElements[itemElements.length - 1].focus();
        break;
      case 'next':
        currentIndex = this.getCurrentFocusItemIndex();
        if (currentIndex !== itemElements.length - 1) {
          itemElements[currentIndex + 1].focus();
        } else {
          itemElements[0].focus();
        }
        break;
      case 'previous':
        currentIndex = this.getCurrentFocusItemIndex();
        itemElements[currentIndex - 1].focus();
        break;
    }
  }

  getCurrentFocusItemIndex() {
    const itemElements = Array.from(this.getCurrentItems());
    return itemElements.indexOf(document.activeElement);
  }

}


class Status {
  constructor(mainElement) {
    mainElement.insertAdjacentHTML('afterbegin', STATUS_HTML);
    this.element = mainElement.querySelector(STATUS_SELECTOR);
  }

  update(itemsQuantity) {
    this.element.textContent = (Number.isInteger(itemsQuantity)) ? FILTERED_STATUS_PREFIX + itemsQuantity : '';
  }
}


class CustomSelect {
  constructor(element) {
    this.element = element;
    this.dataManager = new DataManager();
    this.input = new Input(element);
    this.list = new List(element);
    this.status = new Status(element);
    this.state = {
      isOpened: false,
      useExternalData: false,
      requestInputValueLength: undefined,
      requestWasSend: false
    };


    this._setAreaAttributes();
    this.dataManager.updateDataFromItemElements(this.list.getCurrentItems());

    this.element.addEventListener('customSelectInput', this._onInput.bind(this));
    this.element.addEventListener('click', this._onClick.bind(this));
    this.element.addEventListener('keydown', this._onKeyDown.bind(this));
    appendCustomFocusEvents(this.element);
    this.element.addEventListener('focusLeave', this._closeList.bind(this));

    element.setExternalSource = this.setExternalSource.bind(this);
    element.setSource = this.setSource.bind(this);
  }

  _setAreaAttributes() {
    this.element.setAttribute('role', 'combobox');
    this.element.setAttribute('aria-haspopup', 'listbox');
    this.element.setAttribute('aria-expanded', 'false');
    this.input.element.setAttribute('aria-autocomplete', 'both');
    this.list.listElement.setAttribute('role', 'listbox');
  }

  _onInput(evt) {
    const needNewRequest = Boolean(this.state.useExternalData
      && evt.detail.value.length >= this.state.requestInputValueLength
      && !this.state.requestWasSend);
    const needToClearOldRequest = Boolean(this.state.useExternalData
      && evt.detail.value.length < this.state.requestInputValueLength
      && this.state.requestWasSend);

    if (needNewRequest) {
      this.dataManager.updateDataFromExternalSource(evt.detail.value)
        .then(() => {
          const currentData = this.dataManager.getData();
          this.list.render(currentData);
          this.status.update(currentData.length);
          this._openList();
          this.state.requestWasSend = true;
        });

    } else if (needToClearOldRequest) {
      this.dataManager.clearData();
      this.list.clear();
      this.status.update();
      this._closeList();
      this.state.requestWasSend = false;

    } else {
      const filteredItems = this.dataManager.getData(evt.detail.value);
      this.list.render(filteredItems);
      (filteredItems.length > 0) ? this._openList() : this._closeList();
      this.status.update(filteredItems.length);
    }
  }

  _onClick() {
    const focusedElement = document.activeElement;
    if (focusedElement.tagName === 'LI') {
      this._makeChoice(focusedElement);
    } else if (focusedElement === this.input.element) {
      (this.state.isOpened) ? this._closeList() : this._openList();
    }
  }

  _onKeyDown(evt) {
    const currentFocus = document.activeElement;

    switch(evt.key) {
      case 'Enter':
        (this.state.isOpened && currentFocus.tagName === 'LI') ? this._makeChoice(currentFocus) : this._openList();
        break;
      case 'Escape':
        if (this.state.isOpened) {
          this._closeList();
          evt.stopPropagation();
        }
        break;
      case 'ArrowDown':
        this._openList();
        this._moveFocus({moveDirection: 'down'});
        break;
      case 'ArrowUp':
        this._openList();
        this._moveFocus({moveDirection: 'up'});
        break;
    }
  }

  setExternalSource({url, requestValueLength = 2, fieldMap}) {
    this.dataManager.setExternalSource(url, fieldMap);
    this.state.useExternalData = true;
    this.state.requestInputValueLength = requestValueLength;
  }

  setSource(data, fieldMap) {
    this.dataManager.setSource(data, fieldMap);
    this.state.useExternalData = false;
  }

  _openList() {
    if (this.state.isOpened) return;

    const result = this.list.open();
    if (result) {
      this.element.setAttribute('aria-expanded', 'true');
      this.state.isOpened = true;
    }
  }

  _closeList() {
    if (!this.state.isOpened) return;

    this.list.close();
    this.element.setAttribute('aria-expanded', 'false');
    this.state.isOpened = false;
  }

  _makeChoice(focusedItem) {
    const itemTitle = focusedItem.querySelector(ITEM_TITLE_SELECTOR).textContent;
    const itemId = focusedItem.dataset.id;

    this.input.element.value = itemTitle;
    this.input.element.focus();
    this._closeList();

    this.element.dispatchEvent(new CustomEvent('customSelectChoice', {
      detail: {
        choiceId: itemId,
        choiceValue: itemTitle
      }
    }));
  }

  _moveFocus({moveDirection}) {
    const currentFocus = document.activeElement;

    const _moveFocusUp = () => {
      switch (true) {
        case (currentFocus === this.input.element):
          this.list.focus('last');
          break;
        case (currentFocus.tagName === 'LI'):
          (this.list.getCurrentFocusItemIndex() === 0) ? this.input.element.focus() : this.list.focus('previous');
          break;
      }
    };

    const _moveFocusDown = () => {
      switch (true) {
        case (currentFocus === this.input.element):
          this.list.focus('first');
          break;
        case (currentFocus.tagName === 'LI'):
          this.list.focus('next');
          break;
      }
    };

    (moveDirection === 'up') ? _moveFocusUp() : _moveFocusDown();
  }

}


export default function initCustomSelects() {
  // добавить тип изменение типа вхождения при фильтрации (data-attr)
  const customSelectElements = document.querySelectorAll(MAIN_SELECTOR);
  return Array.from(customSelectElements).map(elem => new CustomSelect(elem));
}
