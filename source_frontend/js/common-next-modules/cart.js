// * Корзина
// Модуль реагирует на запросы пользователя по операциям с корзиной.


// * Описание работы
// Модуль отслеживает события click, submit, change на document.
// Если элемент на котором произошло событие, определен в константах класса, выполняется функция из data атрибута cart-action.


// * Обязательные атрибуты
// Соответствие элемента определяется по наличию data-атрибута:
// data-cart-event="submit, click, change" - событие, на котором необходимо проверять элемент
// data-cart-action="add, set, remove" - функция, которая будет выполнена при наступлении события


// * Общие атрибуты:
// data-product-id -id товара
// data-cart-loading-selector - селектор элемента, внутри которого будет отображаться индикатор загрузки (не обязательный)
// data-cart-loading-color - цвет индикатора или строка 'primary', в противном случае у индикатору будет текущий color (не обязательный)


// * Атрибуты для data-cart-action="set"
// data-cart-setting-count - количество товара. Если значение = value, js интерпретирует это как input.value


import CircularProgress from '../../sass/blocks/circular-progress/_circular-progress';
import { getURLVar } from './util.js';
import Alert from '../../sass/blocks/alert/_alert.js';


// * CART-MODEL
class ModelCart {
  constructor() {
    this.requestUrl = {
      add: 'index.php?route=checkout/cart/add',
      set: 'index.php?route=checkout/cart/set',
      remove: 'index.php?route=checkout/cart/remove',
      headerHtml: 'index.php?route=common/cart/info',
      checkoutCartHtml: 'index.php?route=checkout/checkout__cart/getCart',
      applyCoupon: 'index.php?route=extension/total/coupon/coupon'
    };
  }


  _sendChangeCartRequest(requestUrl, data) {
    return fetch(requestUrl, {
      method: 'POST',
      body: data
    })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.json();
      })
      .then(response => {
        if (!response['success']) {
          throw new Error(`Ошибка ответа сервера ${response}`);
        }
        return response;
      })
      .catch(console.error);
  }

  add(data) {
    return this._sendChangeCartRequest(this.requestUrl.add, data);
  }

  set(data) {
    return this._sendChangeCartRequest(this.requestUrl.set, data);
  }

  remove(data) {
    return this._sendChangeCartRequest(this.requestUrl.remove, data);
  }

  getHeaderCart() {
    return fetch(this.requestUrl.headerHtml)
      .then(response => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.text();
      })
      .catch(console.error);
  }

  getCheckoutCart() {
    return fetch(this.requestUrl.checkoutCartHtml)
      .then(response => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.text();
      })
      .catch(console.error);
  }

  applyCoupon(data) {
    return fetch(this.requestUrl.applyCoupon, {
      method: 'POST',
      body: data
    })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.json();
      })
      .catch(console.error);
  }

}





// * CART-CONTROLLER
class ControllerCart {

  constructor () {
    this.observedEventTypes = ['click','change','submit'];
    this.eventDataAttr = 'data-cart-event';
    this.actionDataAttr = 'cartAction';
    this.loadingSelectorDataAttr = 'cartLoadingSelector';
    this.loadingColorDataAttr = 'cartLoadingColor';
    this.productIdDataAttr = 'productId';
    this.settingCountDataAttr = 'cartSettingCount';
    this.countSelector = '[data-cart-count]';
    this.headerCartSelector = '.header__cart-modal';
    this.checkoutCartSelector = '[data-checkout-cart]';

    this.headerCartElement = undefined;
    this.headerCartCountElement = undefined;



    this.modelCart = new ModelCart();

    this.observedEventTypes.forEach(evtType => {
      document.addEventListener(evtType, (evt) => {
        const targetElement = evt.target.closest(`[${this.eventDataAttr}="${evtType}"]`);
        if (!targetElement) return;
        evt.preventDefault();

        const action = targetElement.dataset[this.actionDataAttr];
        this[action](targetElement);
      });
    });

  }


  add(formElement) {
    const loadingIndicator = this._createLoadingIndicator(formElement);
    loadingIndicator.on();

    this.modelCart.add(new FormData(formElement))
      .then(response => {
        if (response['redirect']) {
          location = response['redirect'];
        }
        this._updateHeaderCartCount(response.item_count);
        this._showAddCartModal(response.success, response.total, response.checkout_link);
      })
      .then(() => this._updateHeaderCart())
      .finally(() => loadingIndicator.off())
      .catch(console.error);
  }


  set(element) {
    const formData = new FormData();
    const dataCount = element.dataset[this.settingCountDataAttr];
    const settingCount = (dataCount === 'value') ? element.value : dataCount;
    formData.append('key', element.dataset[this.productIdDataAttr]);
    formData.append('quantity', settingCount);

    const loadingIndicator = this._createLoadingIndicator(element);

    loadingIndicator.on();
    this.modelCart.set(formData)
      .then(response => this._updateHeaderCartCount(response.item_count))
      .then(() => {
        return Promise.all([
          this._updateCheckoutPageCart(),
          this._updateHeaderCart()
        ]);
      })
      .finally(() => loadingIndicator.off())
      .catch(console.error);
  }


  remove(element) {
    const formData = new FormData();
    formData.append('key', element.dataset[this.productIdDataAttr]);

    const loadingIndicator = this._createLoadingIndicator(element);

    loadingIndicator.on();
    this.modelCart.remove(formData)
      .then(response => this._updateHeaderCartCount(response.item_count))
      .then(() => this._updateHeaderCart())
      .finally(() => loadingIndicator.off())
      .catch(console.error);
  }

  applyCoupon(formElement) {
    const loadingIndicator = this._createLoadingIndicator(formElement);
    const _showAlert = (json) => {
      const alertOptions = {
        targetSelector: '.preview__footer',
        position: 'prepend',
        extraCssClass: 'preview__footer-alert'
      };

      if (json.success) {
        alertOptions.html = json.success;
        alertOptions.type = 'success';
      } else {
        alertOptions.html = json.error;
        alertOptions.type = 'simpleWarning';
      }

      new Alert(alertOptions);
    };

    loadingIndicator.on();
    this.modelCart.applyCoupon(new FormData(formElement))
      .then(json => {
        if (json.error) {
          _showAlert(json);
        } else {
          return this._updateCheckoutPageCart();
        }
      })
      .finally(() => loadingIndicator.off());
  }

  _updateHeaderCartCount (countValue) {
    if (!this.headerCartCountElement) {
      this.headerCartCountElement = document.querySelector(this.countSelector);
    }
    this.headerCartCountElement.textContent = countValue;
  }

  async _updateCheckoutPageCart() {
    if (getURLVar('route') !== 'checkout/checkout') return;

    const checkoutCartElement = document.querySelector(this.checkoutCartSelector);
    return this.modelCart.getCheckoutCart()
      .then(html => {
        if (html) {
          checkoutCartElement.innerHTML = html;
        } else {
          window.location = '/';
        }
      });
  }
  // _updateCheckoutPageCart() {
  //   if (getURLVar('route') !== 'checkout/checkout') return;

  //   return new Promise(resolve => {
  //     const checkoutCartElement = document.querySelector(this.checkoutCartSelector);
  //     this.modelCart.getCheckoutCart()
  //       .then(html => {
  //         if (html) {
  //           checkoutCartElement.innerHTML = html;
  //           resolve();
  //         } else {
  //           window.location = '/';
  //         }
  //       });
  //   });
  // }

  async _updateHeaderCart () {
    return this.modelCart.getHeaderCart()
      .then(html => {
        const responseElement = document.createElement('div');
        responseElement.innerHTML = html;
        const responseContentElement = responseElement.querySelector(this.headerCartSelector);
        if (!this.headerCartElement) {
          this.headerCartElement = document.querySelector(this.headerCartSelector);
        }
        this.headerCartElement.innerHTML = responseContentElement.innerHTML;
      })
      .catch(() => new Error('Ошибка получения разметки корзины с сервера'));
  }
  // _updateHeaderCart () {
  //   return new Promise((resolve, reject) => {
  //     this.modelCart.getHeaderCart()
  //       .then(html => {
  //         const responseElement = document.createElement('div');
  //         responseElement.innerHTML = html;
  //         const responseContentElement = responseElement.querySelector(this.headerCartSelector);
  //         if (!this.headerCartElement) {
  //           this.headerCartElement = document.querySelector(this.headerCartSelector);
  //         }
  //         this.headerCartElement.innerHTML = responseContentElement.innerHTML;
  //         resolve();
  //       })
  //       .catch(() => reject(new Error('Ошибка получения разметки корзины с сервера')));
  //   });
  // }


  _showAddCartModal(message, totalMessage, checkoutLink) {
    const html = `<h2 class="modal__header" style="display: flex; align-items: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="32" height="32" style="margin-right: 1rem" aria-hidden="true"><polyline points="2,8 6,13 14,3" fill="none" stroke="#01768b" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" stroke-width="2"/></svg>
                    Товар добавлен в корзину
                  </h2>
                  <p class="modal__p">${message}</p>
                  <p class="modal__p">${totalMessage}</p>
                  <div style="display: flex; flex-direction: column; margin-top: 2rem;">
                    <a class="button button--action-primary" href="${checkoutLink}" style="margin-bottom: 0.5rem">Оформить заказ</a>
                    <button class="link" style="margin-bottom: 0.5rem; padding-top: 0.5rem;">Купить в 1 клик</button>
                    <button class="link" style="padding-top: 0.5rem" data-modal-close>Продолжить покупки</button>
                  </div>`;
    window.yulms.modal.open({content: html, focusOnOpen: false});
  }


  _createLoadingIndicator(element) {
    const loadingSelector = element.dataset[this.loadingSelectorDataAttr];
    const loadingColor = element.dataset[this.loadingColorDataAttr];
    return new CircularProgress(loadingSelector, {color: loadingColor});
  }


  // _changeLocationIfNeedeed() {
  //   if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
  //     location = 'index.php?route=checkout/cart';
  //   }
  // }

}


export default function initCart() {
  return new ControllerCart();
}
