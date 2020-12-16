import appendCustomFocusEvents from './custom-focus-events.js';



class Textfield {
  constructor(element, overrides) {

    const defaults = {
      inputSelector : '.textfield__input'
    };

    Object.assign(this, defaults, overrides);

    this.element = element;
    this.inputElement = this.element.querySelector(this.inputSelector);
  }
}


class TextfieldOutlined extends Textfield {
  constructor(element, overrides) {

    super(element);

    const defaults = {
      labelSelector : '.textfield__label',
      textfieldActiveClass : 'textfield--active',
      labelOnTopClass : 'textfield__label--top'
    };

    Object.assign(this, defaults, overrides);

    this.labelElement = this.element.querySelector(this.labelSelector);

    if (this.inputElement.value !== '') {
      this.labelElement.classList.add(this.labelOnTopClass);
    }

    appendCustomFocusEvents(this.element);
    this.element.addEventListener('focusEnter', this._onTextfieldFocusEnter.bind(this));
    this.element.addEventListener('focusLeave', this._onTextfieldFocusLeave.bind(this));
  }


  _onTextfieldFocusEnter() {
    this._activateTextfield();
  }


  _onTextfieldFocusLeave() {
    this._deactivateTextfield();
  }


  _activateTextfield() {
    this.element.classList.add(this.textfieldActiveClass);
    this.labelElement.classList.add(this.labelOnTopClass);
  }


  _deactivateTextfield() {
    this.element.classList.remove(this.textfieldActiveClass);
    if (!this.inputElement.value) {
      this.labelElement.classList.remove(this.labelOnTopClass);
    }
  }
}




const textfieldSelector = '.textfield';

function initTextfields() {
  const textfieldElements = document.querySelectorAll(textfieldSelector);
  const textfields = [].map.call(textfieldElements, (elem) => new TextfieldOutlined(elem));
  return textfields;
}


export default initTextfields;




// * Material design
// Вызов для одного элемента на странице
// const foo = new MDCFoo(document.querySelector('.mdc-foo'));

// Вызов для всех элементов на странице
// const foos = [].map.call(document.querySelectorAll('.mdc-foo'), function(el) {
//   return new MDCFoo(el);
// });
