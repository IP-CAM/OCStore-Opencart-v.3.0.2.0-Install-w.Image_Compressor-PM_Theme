import noUiSlider from 'nouislider';


const ELEMENT_SELECTOR = '#ocfilter';

const DataAction = {
  ADD: 'add',
  DELETE: 'delete',
  ADD_OR_MODIFY: 'addOrModify'
};



class FilterControl {

  dispatchEvent({action, optionId, optionValue, element}) {
    const filterChange = new CustomEvent('filterChange', {
      bubbles: true,
      detail: {
        action: action,
        optionId: optionId,
        optionValue: optionValue,
        targetElement: element
      }});

    this.lastChangedElement = element;
    element.dispatchEvent(filterChange);
  }

}


class FilterCheckbox extends FilterControl {
  constructor(mainElement) {
    super();

    const defaults = {
      selector: '.filter__checkbox',
      selectedClass: 'filter__checkbox--selected',
      optionIdDataAttr: 'optionId',
      optionValueIdDataAttr: 'optionValueId'
    };
    Object.assign(this, defaults);


    mainElement.addEventListener('change', (evt) => {
      // ловим на label
      let targetElement = evt.target.closest(this.selector);
      if (!targetElement) return;

      const optionId = targetElement.dataset[this.optionIdDataAttr];
      const filterParams = {
        action: evt.target.checked ? DataAction.ADD : DataAction.DELETE,
        optionId: optionId,
        optionValue: targetElement.dataset[this.optionValueIdDataAttr].slice(optionId.length),
        element: targetElement
      };

      super.dispatchEvent(filterParams);

      targetElement.classList.toggle(this.selectedClass);
    });
  }
}


class FilterRadio extends FilterControl {
  constructor(mainElement) {
    super();

    const defaults = {
      selector: '.filter__radio',
      selectedClass: 'filter__radio--selected',
      optionIdDataAttr: 'optionId',
      optionValueIdDataAttr: 'optionValueId',
      clearFilterSubstring: 'cancel-'
    };
    Object.assign(this, defaults);

    mainElement.addEventListener('change', (evt) => {
      // ловим на label
      let targetElement = evt.target.closest(this.selector);
      if (!targetElement) return;

      const optionId = targetElement.dataset[this.optionIdDataAttr];
      const initialValue = targetElement.dataset[this.optionValueIdDataAttr];
      const optionValue = (initialValue.includes(this.clearFilterSubstring)) ? null : initialValue.slice(optionId.length);

      const filterParams = {
        action: optionValue ? DataAction.ADD_OR_MODIFY : DataAction.DELETE,
        optionId: optionId,
        optionValue: optionValue,
        element: targetElement
      };

      super.dispatchEvent(filterParams);

      this._toggleSelectedClass(targetElement);


    });
  }

  _toggleSelectedClass(checkedElement) {
    const parentElement = checkedElement.parentElement.parentElement;
    const radioElements = parentElement.querySelectorAll(this.selector);
    radioElements.forEach((element) => element.classList.remove(this.selectedClass));
    checkedElement.classList.add(this.selectedClass);
  }

}


class Slider extends FilterControl {
  constructor(sliderElement) {
    super();
    const defaults = {
      optionIdDataAttr: 'optionId',
      startMinDataAttr: 'startMin',
      startMaxDataAttr: 'startMax',
      rangeMinDataAttr: 'rangeMin',
      rangeMaxDataAttr: 'rangeMax',
      valueDevider: '-'
    };
    Object.assign(this, defaults);

    this.element = sliderElement;

    const minStr = sliderElement.dataset[this.rangeMinDataAttr];
    const maxStr = sliderElement.dataset[this.rangeMaxDataAttr];
    this.startMin = parseFloat(sliderElement.dataset[this.startMinDataAttr]);
    this.startMax = parseFloat(sliderElement.dataset[this.startMaxDataAttr]);
    // предотвращение бага бэкэнда (в некоторых случаях получаем стартовые значение за пределами диапазона слайдера)
    this.min = Math.min(parseFloat(minStr), this.startMin);
    this.max = Math.max(parseFloat(maxStr), this.startMax);
    this.decimals = this._calculateMaxDecimalsNumber(minStr, maxStr);

    this._createSlider(sliderElement);
    this.element.noUiSlider.currentValues = this.element.noUiSlider.get();
    this._bindInputs();
    this._createFilterChangeEvent();

  }


  _createSlider(sliderElement) {
    noUiSlider.create(sliderElement, {
      range: {
        'min': this.min,
        'max': this.max
      },
      start: [this.startMin, this.startMax],
      margin: 0, // минимальная разница
      connect: true, //цветной центр
      format:
        {
          from: (value) => value,
          to: (value) => +value.toFixed(this.decimals)
        }
    });
  }


  _bindInputs() {
    // инпуты - первых два у родителя слайдера
    const parentElement = this.element.parentElement;
    const inputElements = Array.from(parentElement.querySelectorAll('input'));
    const [leftInputElement, rightInputElement] = inputElements;

    this.element.noUiSlider.on('update', (values, handle) => {
      inputElements[handle].value = values[handle];
    });
    leftInputElement.addEventListener('change', () => {
      this.element.noUiSlider.set([leftInputElement.value, null]);
    });
    rightInputElement.addEventListener('change', () => {
      this.element.noUiSlider.set([null, rightInputElement.value]);
    });
  }


  _createFilterChangeEvent() {

    this.element.noUiSlider.on('set', (values) => {

      const valueIsChanges = ([leftValue, rightValue]) => {
        let [leftCurrentValue, rightCurrentValue] = this.element.noUiSlider.currentValues;
        return (leftCurrentValue !== leftValue || rightCurrentValue !== rightValue) ? true : false;
      };
      if (!valueIsChanges(values)) return;


      const updateCurrentValues = ([leftValue, rightValue]) =>  {
        this.element.noUiSlider.currentValues[0] = leftValue;
        this.element.noUiSlider.currentValues[1] = rightValue;
      };
      updateCurrentValues(values);


      const action = (this.min !== values[0] || this.max !== values[1]) ? DataAction.ADD_OR_MODIFY : DataAction.DELETE;
      const optionId = this.element.dataset[this.optionIdDataAttr];
      const optionValue = values.join(this.valueDevider);
      const element = this.element;

      const filterParams = {
        action: action,
        optionId: optionId,
        optionValue: optionValue,
        element: element
      };

      super.dispatchEvent(filterParams);
    });

  }


  _calculateMaxDecimalsNumber(...arr) {
    const DOT = '.';
    return arr.reduce((maxDecimal, current) => {
      let currentDecimal = (current.includes(DOT)) ? current.length - current.indexOf(DOT) - 1 : 0;
      return Math.max(maxDecimal, currentDecimal);
    }, 0);
  }

}


class Sliders {
  constructor(mainElement) {
    this.sliderSelector = '.nouislider';
    const sliderElements = Array.from(mainElement.querySelectorAll(this.sliderSelector));
    this.sliders = sliderElements.map((sliderElement) => new Slider(sliderElement));
  }
}


class FilterControlUpdater {
  // constructor(mainElement, serverData, showCounter, dataManager) {
  constructor(mainElement) {
    const defaults = {
      radiocheck: {
        radiocheckSelector:  '.radiocheck[data-option-value-id]',
        optionValueIdDataAttr: 'optionValueId',
        radiocheckInputSelector: '.radiocheck__input',
        countSelector: '.filter__product-count'
      },
      slider: {
        sliderSelector: '.nouislider[data-option-id]',
        optionIdDataAttr: 'optionId'
      },
      productTotal: {
        totalCountSelector: '[data-filter-count]',
        totalCountPrefix: 'Найдено: '
      }

    };
    Object.assign(this, defaults);
    this.mainElement = mainElement;
    this.sliderElements = this.mainElement.querySelectorAll(this.slider.sliderSelector);
    this.radiocheckElements = this.mainElement.querySelectorAll(this.radiocheck.radiocheckSelector);
    this.totalCountElement = this.mainElement.querySelector(this.productTotal.totalCountSelector);
  }


  updateSliders({sliders: slidersResponseData}, dataManager) {

    this.sliderElements.forEach((elem) => {

      const optionId = elem.dataset[this.slider.optionIdDataAttr];

      if (slidersResponseData[optionId]) {

        const SliderOptions = function({currentRangeMin, currentRangeMax, responsedRangeMin, responsedRangeMax, optionWasSetted}) {
          const setRange = (property, value) => {
            if (!this.range) this.range = {};
            this.range[property] = value;
          };

          if (responsedRangeMin === responsedRangeMax) return;

          if (optionWasSetted) {
            if (responsedRangeMin < currentRangeMin) setRange('min', responsedRangeMin);
            if (responsedRangeMax > currentRangeMax) setRange('max', responsedRangeMax);
          } else {
            setRange('min', responsedRangeMin);
            setRange('max', responsedRangeMax);
            this.start = [responsedRangeMin, responsedRangeMax];
          }
        };

        const params = {
          currentRangeMin: elem.noUiSlider.options.range.min,
          currentRangeMax: elem.noUiSlider.options.range.max,
          responsedRangeMin: slidersResponseData[optionId].min,
          responsedRangeMax: slidersResponseData[optionId].max,
          optionWasSetted: dataManager.hasOption(optionId)
        };

        let newOptions = new SliderOptions(params);
        if (Object.keys(newOptions).length !== 0) {
          try {
            elem.noUiSlider.updateOptions(
              newOptions,
              false // Boolean 'fireSetEvent'
            );
          } catch(err) {
            console.log('slider error', err);
          }
        }

        elem.noUiSlider.currentValues = elem.noUiSlider.get();
      }
    });

  }


  updateRadiochecks({values}, showCounter) {

    this.radiocheckElements.forEach((element) => {
      const elementHash = element.dataset[this.radiocheck.optionValueIdDataAttr];
      const inputElement = element.querySelector(this.radiocheck.radiocheckInputSelector);

      let countCaptionElement;
      if (showCounter) {
        countCaptionElement = element.querySelector(this.radiocheck.countSelector);
      }

      if (values[elementHash]) {
        inputElement.disabled = false;

        if (countCaptionElement) {
          countCaptionElement.textContent = values[elementHash].t;
        }
      } else {
        inputElement.disabled = true;
        if (countCaptionElement) {
          countCaptionElement.textContent = '0';
        }
      }
    });
  }


  updateCountCaption({text_total}) {
    this.totalCountElement.textContent = this.productTotal.totalCountPrefix + text_total;
  }

}


class FilterButton {
  constructor(mainElement) {
    const defaults = {
      tooltipMinVw: 1280,
      filterFooterSelector: '.filter__footer',
      filterFooterHiddenClass: 'filter__footer--hidden',
      buttonSelector: '.filter__button-submit',
      tooltipClass: 'filter__button-tooltip',
      tooltipPositionerSelector: '.filter__tooltip-positioner'
    };
    Object.assign(this, defaults);


    this.footerElement = mainElement.querySelector(this.filterFooterSelector);
    this.buttonElement = this.footerElement.querySelector(this.buttonSelector);

    // футер появляется при работе с фильром (filterChange event)

  }


  update(serverData, targetElement) {
    this.footerElement.classList.remove(this.filterFooterHiddenClass);

    this._updateCurrentButton(serverData);
    if (document.documentElement.clientWidth >= this.tooltipMinVw) {
      this._createTooltipButton(serverData, targetElement);
    }
  }


  _updateCurrentButton({text_total, href}) {
    this.buttonElement.setAttribute('onclick', `location = '${href}'`);
    this.buttonElement.textContent = 'Показать ' + text_total;
  }


  _createTooltipButton({text_total, href}, targetElement) {
    const positionerElement = targetElement.closest(this.tooltipPositionerSelector);
    if (!positionerElement) return;

    const tooltipElement = document.createElement('div');
    tooltipElement.classList.add(this.tooltipClass);
    tooltipElement.innerHTML = this._getButtonSubmitHtml(text_total, href);
    positionerElement.append(tooltipElement);


    const removeTooltip = () => {
      tooltipElement.remove();
      document.removeEventListener('mousedown', onFilterTooltipMousedown);
      document.removeEventListener('keydown', onFilterTooltipKeydown);
    };

    const onFilterTooltipMousedown = (evt) => {
      // если клик за пределами tooltip - убираем его
      const target = evt.target.closest('.' + this.tooltipClass);
      if (!target && evt.which === 1) {
        removeTooltip();
      }
    };

    const onFilterTooltipKeydown = (evt) => {
      // если клик за пределами tooltip - убираем его
      if (evt.code === 'Escape') {
        removeTooltip();
      }
    };
    // ловим на фазе захвата, т.к. nouislider блокирует всплытие
    document.addEventListener('mousedown', onFilterTooltipMousedown, true);
    document.addEventListener('keydown', onFilterTooltipKeydown);
  }


  _getButtonSubmitHtml(text_total, href) {
    return `<button class="button button--options-primary filter__button-submit" type="button" onclick="location = '${href}'">
              Показать ${text_total}
            </button>`;
  }
}


class DataManager {
  constructor({params: initialFilterParams, index: filterIndex, path}) {
    this.initialFilterParams = initialFilterParams;
    this.filterParamsMap = new Map(this._decode(initialFilterParams));
    this.filterParamsString = '';
    this.filterIndex = filterIndex;
    this.path = path;
    this.lastChangedOptionId = undefined;
    this.requestUrl = 'index.php?route=extension/module/ocfilter/callback';
    this.serverData = {};
  }


  processChangedParams({action, optionId, optionValue}) {
    const filterParamsMap = this.filterParamsMap;

    switch (action) {
      case DataAction.ADD:
        if (filterParamsMap.has(optionId)) {
          filterParamsMap.get(optionId).push(optionValue);
        } else {
          filterParamsMap.set(optionId, [optionValue]);
        }
        break;

      case DataAction.DELETE:
        if (filterParamsMap.get(optionId).length === 1) {
          filterParamsMap.delete(optionId);
        } else {
          const index = filterParamsMap.get(optionId).indexOf(optionValue);
          filterParamsMap.get(optionId).splice(index, 1);
        }
        break;

      case DataAction.ADD_OR_MODIFY:
        filterParamsMap.set(optionId, [optionValue]);
        break;
    }

    this.lastChangedOptionId = optionId;
    this.filterParamsString = this._encode(filterParamsMap);

    return this;
  }


  requestServerData() {
    const createFilterParamsUrl = () => {
      const pathUrl = `&path=${encodeURIComponent(this.path)}`;
      const optionIdUrl = `&option_id=${encodeURIComponent(this.lastChangedOptionId)}`;
      let paramsUrl = pathUrl + optionIdUrl;
      if (this.filterParamsString) {
        paramsUrl += `&${this.filterIndex}=${encodeURIComponent(this.filterParamsString)}`;
      }
      return paramsUrl;
    };

    return fetch(this.requestUrl + createFilterParamsUrl(), {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(response => {
        if (!response.ok) {
          throw Error(`${response.status} ${response.statusText}`);
        }
        return response.json();
      })
      .then(parsedData => this.serverData = parsedData);
  }


  getParams() {
    return this.filterParamsMap;
  }


  hasOption(optionId) {
    return this.filterParamsMap.has(optionId);
  }


  _decode(str) {
    // * преобразование строки параметров в объект Map
    // "m:7,8,9;5:39,40" => { 5: ["39", "40"], m: ["7", "8", "9"] }
    if (!str) return;

    let result = new Map;
    str.split(';').forEach((elem) => {
      const [optionId, optionValues] = elem.split(':');
      if (optionValues) {
        result.set(optionId, optionValues.split(','));
      }
    });
    return result;
  }


  _encode(map) {
    // * преобразование объекта параметров в строку
    // { 5: ["39", "40"], m: ["7", "8", "9"] } => "m:7,8,9;5:39,40"
    if (!map) return;

    let result = [];
    for (let [key, value] of map.entries()) {
      result.push(`${key}:${value.join(',')}`);
    }
    return result.join(';');
  }

}


class Filter {

  init(options) {
    this.options = options;
    this.element = document.querySelector(ELEMENT_SELECTOR);

    this._dataManager = new DataManager(options.php);
    this._checkbox = new FilterCheckbox(this.element);
    this._radio = new FilterRadio(this.element);
    this._slider = new Sliders(this.element);
    this._controlUpdater = undefined;
    this._filterButton = new FilterButton(this.element);

    this.element.addEventListener('filterChange', (evt) => {
      const changedParams = evt.detail;
      const promise = this._dataManager.processChangedParams(changedParams).requestServerData();
      promise
        .then((serverData) => {
          if (this.options.php.searchButton) {
            if (!this._controlUpdater) {
              this._controlUpdater = new FilterControlUpdater(this.element);
            }
            this._controlUpdater.updateRadiochecks(serverData, this.options.php.showCounter);
            this._controlUpdater.updateSliders(serverData, this._dataManager);
            this._controlUpdater.updateCountCaption(serverData);
            this._filterButton.update(serverData, evt.detail.targetElement);
          } else {
            window.location = serverData.href;
          }
        })
        .catch(err => console.log('Ошибка скрипта фильтра', err));
    });

  }


}

window.yulmsOcfilter = new Filter();
