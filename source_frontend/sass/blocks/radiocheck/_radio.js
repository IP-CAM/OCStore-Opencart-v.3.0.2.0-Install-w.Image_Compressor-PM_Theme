// модуль устанавливает значение атрибуту data-checked  родителю input (в моем случае элементу label)
// в зависимости от состояния checked у внутреннего input

//  <label class="radiocheck" data-checked="true" || "false">
//    <input class="radiocheck__input visually-hidden" type="radio" data-parent-checked name="radio-pickup" value="1" checked>
//    <span class="radiocheck__box radiocheck__box--radio"></span>
//    <span span class="radiocheck__caption">Самовывоз - метро Спортивная</span>
//  </label>

// Это может быть полезно для стилизации следующих за radiocheck элементов
// например:
// .delivery__pickup-radio[data-checked="false"] + .delivery__pickup-info {
//   display: none;
// }

// Активация по наличию атрибута data-parent-check у input(radio)
// ! Устанавливать data-атрибут только одному элементу в группе!


const DATA_ATTR_NAME = 'data-checked';

class Radio  {
  constructor(radioInputName) {
    const radioInputSelector  = `input[name="${radioInputName}"]`;
    this.inputElements = Array.from(document.querySelectorAll(radioInputSelector));
    this._updateCheckedAttributes();
    this.inputElements.forEach(inputElement => {
      inputElement.addEventListener('change', () => {
        this._updateCheckedAttributes();
      });
    });
  }

  _updateCheckedAttributes() {
    this.inputElements.forEach(elem => {
      elem.parentElement.setAttribute(DATA_ATTR_NAME, elem.checked);
    });
  }
}



const DATA_ATTR_SELECTOR = '[data-parent-check]';

function initRadios() {
  const radioInputs = Array.from(document.querySelectorAll(DATA_ATTR_SELECTOR));
  const radios = radioInputs.map((elem) => new Radio(elem.name));
  return radios;
}

export default initRadios;
