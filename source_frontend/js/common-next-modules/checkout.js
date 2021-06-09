import { getURLVar } from './util.js';
// import CircularProgress from '../../sass/blocks/circular-progress/_circular-progress';


const CHECKOUT_FORM_SELECTOR = '[data-checkout-form]';
const requestUrl = {
  validateCustomerData: 'index.php?route=checkout/checkout/submit'
};


class Checkout {
  constructor() {
    this.formElement = document.querySelector(CHECKOUT_FORM_SELECTOR);

    this.formElement.addEventListener('submit', (evt) => {
      evt.preventDefault();
      console.log('submit order');


      this._validateCustomerData(new FormData(evt.target));
    });
  }


  _validateCustomerData(formData) {
    return fetch(requestUrl.validateCustomerData, {
      method: 'post',
      body: formData
    }).then(response => {
      console.log(response);
      if (!response.ok) {
        throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
      }
      return response.json();
    })
      .then(response => {
      // if (!response['success']) {
      //   throw new Error(`Ошибка ответа сервера ${response}`);
      // }
        return response;
      })
      .catch(console.error);
  }

}


export default function initCheckout() {
  if (getURLVar('route') === 'checkout/checkout') {
    return new Checkout();
  }
}
