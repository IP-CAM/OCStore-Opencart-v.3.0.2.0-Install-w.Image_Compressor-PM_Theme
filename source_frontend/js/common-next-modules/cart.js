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


// * CART-MODEL
class ModelCart {
  constructor() {
    this.requestUrl = {
      add: 'index.php?route=checkout/cart/add',
      set: 'index.php?route=checkout/cart/set',
      remove: 'index.php?route=checkout/cart/remove',
      info: 'index.php?route=common/cart/info'
    };
  }


  sendRequest(requestUrl, data) {
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


  getCartProductList() {
    return fetch(this.requestUrl.info)
      .then(response => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.text();
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

    this.modelCart.sendRequest(this.modelCart.requestUrl.add, new FormData(formElement))
      .then(response => {
        if (response['redirect']) {
          location = response['redirect'];
        }
        this._updateHeaderCartCount(response.items_count);
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
    this.modelCart.sendRequest(this.modelCart.requestUrl.set, formData)
      .then(response => this._updateHeaderCartCount(response.items_count))
      .then(() => this._changeLocationIfNeedeed())
      .then(() => this._updateHeaderCart())
      .finally(() => loadingIndicator.off())
      .catch(console.error);
  }


  remove(element) {
    const formData = new FormData();
    formData.append('key', element.dataset[this.productIdDataAttr]);

    const loadingIndicator = this._createLoadingIndicator(element);

    loadingIndicator.on();
    this.modelCart.sendRequest(this.modelCart.requestUrl.remove, formData)
      .then(response => this._updateHeaderCartCount(response.items_count))
      .then(() => this._changeLocationIfNeedeed())
      .then(() => this._updateHeaderCart())
      .finally(() => loadingIndicator.off())
      .catch(console.error);
  }


  _updateHeaderCartCount (countValue) {
    if (!this.headerCartCountElement) {
      this.headerCartCountElement = document.querySelector(this.countSelector);
    }
    this.headerCartCountElement.textContent = countValue;
  }


  _updateHeaderCart () {
    return new Promise((resolve, reject) => {
      this.modelCart.getCartProductList()
        .then(html => {
          const responseElement = document.createElement('div');
          responseElement.innerHTML = html;
          const responseContentElement = responseElement.querySelector(this.headerCartSelector);
          if (!this.headerCartElement) {
            this.headerCartElement = document.querySelector(this.headerCartSelector);
          }
          this.headerCartElement.innerHTML = responseContentElement.innerHTML;
          resolve();
        })
        .catch(() => reject(new Error('Ошибка получения разметки корзины с сервера')));
    });
  }


  _showAddCartModal(message, totalMessage, checkoutLink) {
    const html = `<h2 class="modal__header" style="display: flex; align-items: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="32" height="32" style="margin-right: 1rem" aria-hidden="true"><polyline points="2,8 6,13 14,3" fill="none" stroke="#01768b" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" stroke-width="2"/></svg>
                    Товар добавлен в корзину
                  </h2>
                  <p class="modal__p">${message}</p>
                  <p class="modal__p">${totalMessage}</p>
                  <div style="display: flex; flex-direction: column; margin-top: 2rem;">
                    <a class="button button--action-primary" href=${checkoutLink} style="margin-bottom: 0.5rem">Оформить заказ</a>
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


  _changeLocationIfNeedeed() {
    if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
      location = 'index.php?route=checkout/cart';
    }
  }

}


export default function initCart() {
  return new ControllerCart();
}
