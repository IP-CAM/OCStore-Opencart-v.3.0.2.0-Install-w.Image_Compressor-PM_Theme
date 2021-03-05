'use strict';


import { ajaxRequest } from '../util.js';
import { getURLVar } from './util.js';


// * CART
class Cart {

  constructor () {
    this.headerCartSelector = '.header__cart-modal';
    this.countSelectors = '.js-cart-count';
    this.totalSumSelector = '.header__cart-summary-number';

    this.headerCartElement = document.querySelector(this.headerCartSelector);
    this.headerCartCountElement = undefined;
    this.headerCartSumElement = undefined;
    this.headerCartSumElement = undefined;

    this.ajaxParams = {

      add: {
        url: 'index.php?route=checkout/cart/add',
        method: 'post',
        responseType: 'json',
        requestHeader: {
          headerName: 'Content-Type',
          headerValue: 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        beforeSend: () => {
          this.headerCartElement.setAttribute('style', 'opacity: 0.9; filter: grayscale(100%); transition: 100ms linear; cursor: wait');
        },
        onLoad: (response) => {
          if (response['redirect']) {
            location = response['redirect'];
          }
          if (response['success']) {
            const removeWait = () => {
              this.headerCartElement.setAttribute('style', 'opacity: 1; filter: unset; transition: 100ms linear, cursor: auto');
            };
            this._updateHeaderCartCount(response.items_count);
            this._updateHeaderCartItemsList(removeWait);
          }
        },
        onError: () => {
          this.headerCartElement.removeAttribute('style');
        }
      },

      remove: {
        url: 'index.php?route=checkout/cart/remove',
        method: 'post',
        responseType: 'json',
        requestHeader: {
          headerName: 'Content-Type',
          headerValue: 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        onLoad: (response) => {
          if (getURLVar('route') === 'checkout/cart' || getURLVar('route') === 'checkout/checkout') {
            document.location = 'index.php?route=checkout/cart';
          } else {
            this._updateHeaderCartCount(response.items_count);
            this._updateHeaderCartItemsList();
          }
        }
      },

      info: {
        url: 'index.php?route=common/cart/info',
        method: 'get',
        responseType: 'text'
      }
    };
  }


  change (product_id, oldCount, newCount) {
    if (Number.isInteger(+newCount)) {
      this.add(product_id, newCount - oldCount);
    }
  }


  add (product_id, quantity = 1) {
    const sendingData = 'product_id=' + product_id + '&quantity=' + quantity;
    this.ajaxParams.add.sendingData = sendingData;
    ajaxRequest(this.ajaxParams.add);
    // добавить появление модального окна по определенным условиям (data атрибут или дополнительный параметр в html)
  }


  remove (key) {
    const sendingData = 'key=' + key;
    this.ajaxParams.remove.sendingData = sendingData;
    ajaxRequest(this.ajaxParams.remove);
  }


  _updateHeaderCartItemsList (onLoad) {
    this.ajaxParams.info.onLoad = (response) => {
      const responseElement = document.createElement('div');
      responseElement.innerHTML = response;
      const responseContentElement = responseElement.querySelector(this.headerCartSelector);
      this.headerCartElement.innerHTML = responseContentElement.innerHTML;
      onLoad();
    };

    ajaxRequest(this.ajaxParams.info);
  }


  _updateHeaderCartCount (countValue) {
    if (!this.headerCartCountElement) {
      this.headerCartCountElement = document.querySelector(this.countSelectors);
    }
    this.headerCartCountElement.textContent = countValue;
  }
}

window.cart = new Cart();
