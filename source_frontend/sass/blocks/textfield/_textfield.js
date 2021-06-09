class Textfield {
  constructor() {

    const defaults = {
      textfieldSelector: '.textfield',
      inputSelector : '.textfield__input'
    };

    Object.assign(this, defaults);

    // this.elements = elements;
  }
}


class TextfieldOutlined extends Textfield {
  constructor() {
    super();
    const defaults = {
      labelSelector : '.textfield__label',
      textfieldActiveClass : 'textfield--active',
      labelOnTopClass : 'textfield__label--top'
    };

    Object.assign(this, defaults);
    this.lastFocusedElement = undefined;


    this._setLabelPositions();
    document.addEventListener('focusin', this._focusInHandler.bind(this));
    document.addEventListener('focusout', this._focusOutHandler.bind(this));

    document.addEventListener('change', (evt) => {
      const targetElement = evt.target.closest(this.textfieldSelector);
      if (!targetElement) return;

      this._setLabelPosition(targetElement);
    });
  }


  _focusInHandler(evt) {
    const targetElement = evt.target.closest(this.textfieldSelector);
    if (!targetElement) return;

    if (targetElement === this.lastFocusedElement) return;

    this._activateTextfield(targetElement);
    this.lastFocusedElement = targetElement;
  }


  _focusOutHandler(evt) {
    const targetElement = evt.target.closest(this.textfieldSelector);
    if (!targetElement) return;

    if (this.lastFocusedElement.contains(evt.relatedTarget)) return;

    this._deactivateTextfield(this.lastFocusedElement);
    this.lastFocusedElement = null;
  }


  _setLabelPositions() {
    const textfields = document.querySelectorAll(this.textfieldSelector);
    textfields.forEach(textfield => this._setLabelPosition(textfield));
  }


  _setLabelPosition(textfield) {
    const inputElement = textfield.querySelector(this.inputSelector);
    const labelElement = textfield.querySelector(this.labelSelector);

    if (inputElement.value === '') {
      labelElement.classList.remove(this.labelOnTopClass);
    } else {
      labelElement.classList.add(this.labelOnTopClass);
    }
  }


  _activateTextfield(textfieldElement) {
    textfieldElement.classList.add(this.textfieldActiveClass);
    const labelElement = textfieldElement.querySelector(this.labelSelector);
    labelElement.classList.add(this.labelOnTopClass);
  }


  _deactivateTextfield(textfieldElement) {
    textfieldElement.classList.remove(this.textfieldActiveClass);
    const inputElement = textfieldElement.querySelector(this.inputSelector);
    if (!inputElement.value) {
      const labelElement = textfieldElement.querySelector(this.labelSelector);
      labelElement.classList.remove(this.labelOnTopClass);
    }
  }
}




export default function initTextfields() {
  return  new TextfieldOutlined();
}




// import appendCustomFocusEvents from '../../../js/custom-focus-events.js';

// class Textfield {
//   constructor(element, overrides) {

//     const defaults = {
//       inputSelector : '.textfield__input'
//     };

//     Object.assign(this, defaults, overrides);

//     this.element = element;
//     this.inputElement = this.element.querySelector(this.inputSelector);
//   }
// }


// class TextfieldOutlined extends Textfield {
//   constructor(element, overrides) {

//     super(element);

//     const defaults = {
//       labelSelector : '.textfield__label',
//       textfieldActiveClass : 'textfield--active',
//       labelOnTopClass : 'textfield__label--top'
//     };

//     Object.assign(this, defaults, overrides);

//     this.labelElement = this.element.querySelector(this.labelSelector);

//     if (this.inputElement.value === '') {
//       this.labelElement.classList.remove(this.labelOnTopClass);
//     }

//     appendCustomFocusEvents(this.element);
//     this.element.addEventListener('focusEnter', this._onTextfieldFocusEnter.bind(this));
//     this.element.addEventListener('focusLeave', this._onTextfieldFocusLeave.bind(this));
//   }


//   _onTextfieldFocusEnter() {
//     this._activateTextfield();
//   }


//   _onTextfieldFocusLeave() {
//     this._deactivateTextfield();
//   }


//   _activateTextfield() {
//     this.element.classList.add(this.textfieldActiveClass);
//     this.labelElement.classList.add(this.labelOnTopClass);
//   }


//   _deactivateTextfield() {
//     this.element.classList.remove(this.textfieldActiveClass);
//     if (!this.inputElement.value) {
//       this.labelElement.classList.remove(this.labelOnTopClass);
//     }
//   }
// }




// const textfieldSelector = '.textfield';

// function initTextfields() {
//   const textfieldElements = document.querySelectorAll(textfieldSelector);
//   const textfields = [].map.call(textfieldElements, (elem) => new TextfieldOutlined(elem));
//   return textfields;
// }


// export default initTextfields;




// * Material design
// Вызов для одного элемента на странице
// const foo = new MDCFoo(document.querySelector('.mdc-foo'));

// Вызов для всех элементов на странице
// const foos = [].map.call(document.querySelectorAll('.mdc-foo'), function(el) {
//   return new MDCFoo(el);
// });
