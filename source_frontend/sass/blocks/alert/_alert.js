export default class Alert {
  constructor({targetSelector, position, html, type = 'info', extraCssClass = '', isDissmisible = true, deletePrevious = true}) {
    const defaults = {
      alertCssClass: 'alert',
      typeToCssClass: {
        info: 'alert--info',
        success: 'alert--success',
        warning: 'alert--warning',
        danger: 'alert--danger'
      },
      closeButtonHtml: `<button class="button alert__close-button" type="button">
                          <span class="visually-hidden">Закрыть</span>
                          <svg class="button__close-icon" width="40" height="40" viewBox="0 0 24 24" aria-hidden="true"
                            fill="none" stroke-linecap="round"><path vector-effect="non-scaling-stroke" d="M7 7l10 10M7 17L17 7"/>
                          </svg>
                        </button>`,
      dissmisibleModClass: 'alert--dissmisible'
    };

    Object.assign(this, defaults);

    const alertElement = this._createAlertElement(html, type, extraCssClass, isDissmisible);
    const targetElement = document.querySelector(targetSelector);

    // удаляем предыдущий alert, если найдется
    if (deletePrevious) this._deletePreviousAlert(targetElement, position);

    targetElement[position](alertElement);

    alertElement.scrollIntoView({behavior: 'smooth'});
  }


  _createAlertElement(html, type, extraCssClass, isDissmisible) {
    const alertElement = document.createElement('div');
    alertElement.className = `${this.alertCssClass} ${this.typeToCssClass[type]} ${extraCssClass}`;
    alertElement.innerHTML = html;

    if (isDissmisible) {
      alertElement.classList.add(this.dissmisibleModClass);
      alertElement.insertAdjacentHTML('beforeEnd', this.closeButtonHtml);
      alertElement.querySelector('button').addEventListener('click', () => alertElement.remove());
    }

    return alertElement;
  }


  _deletePreviousAlert(targetElement, position) {
    let previousAlertElement;

    switch (position) {
      case 'append':
        previousAlertElement = targetElement.lastElementChild;
        break;

      case 'prepend':
        previousAlertElement = targetElement.firstElementChild;
        break;

      case 'before':
        previousAlertElement = targetElement.previousElementSibling;
        break;

      case 'after':
        previousAlertElement = targetElement.nextElementSibling;
        break;
    }

    if (previousAlertElement && previousAlertElement.classList.contains(this.alertCssClass)) {
      previousAlertElement.remove();
    }
  }

}
