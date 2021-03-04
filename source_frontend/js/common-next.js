'use strict';

import { ajaxRequest } from './util.js';

// * SEARCH URL PARAMETER VALUE
function getURLVar(key) {
  const currentURL = String(document.location);
  const urlAddress = new URL(currentURL);
  const result = urlAddress.searchParams.get(key);
  return (result) ? result : '';
}


// * BASE HREF
let baseHref;
function getBaseHref() {
  if (baseHref !== undefined)  return baseHref;
  baseHref = document.querySelector('base').href;
  return baseHref;
}


// * SEARCH FIELD
function initSearch() {
  const FORM_SELECTOR = '.search-form';
  const INPUT_SELECTOR = '.search-form__input';

  const formElement = document.querySelectorAll(FORM_SELECTOR);
  formElement.forEach((elem) => {
    elem.addEventListener('submit', (evt) => {
      evt.preventDefault();

      let url = getBaseHref() + 'index.php?route=product/search';
      let searchValue = elem.querySelector(INPUT_SELECTOR).value;
      if (searchValue) {
        url += '&search=' + encodeURIComponent(searchValue);
      }
      window.location = url;
    });
  });
}

initSearch();



// * CART
class Newcart {

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

window.newcart = new Newcart();




// * WISHLIST

class Wishlist {
  constructor() {
    this.ajaxParams = {
      add: {
        url: 'index.php?route=account/wishlist/add',
        method: 'post',
        responseType: 'json',
        requestHeader: {
          headerName: 'Content-Type',
          headerValue: 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        onLoad: (response) => {
          if (response['redirect']) {
            location = response['redirect'];
          }
          if (response['success']) {
            console.log('success', response);
          }
        }
      }
    };
  }

  add (product_id) {
    const sendingData = 'product_id=' + product_id;
    this.ajaxParams.add.sendingData = sendingData;
    ajaxRequest(this.ajaxParams.add);
  }
}

window.newwishlist = new Wishlist();




// * REVIEW LIKE
class ReviewLike {
  constructor() {
    this.selector = '[data-review-like]';
    this.dataAttrReviewId = 'reviewId';
    this.reviewIdSelector = '[data-review-id]';
    this.likedClass = 'reviews__vote-button--liked';
    this.voteCountSelector = '.reviews__vote-count';
    this.localStoragePropertyLike = 'liked-reviews';
    this.requestUrl = 'index.php?route=product/product/votereview';
    this.voteType = {
      LIKE: 'like',
      UNLIKE: 'unlike'
    };
    this.requestIsRunning = false;

    this.checkVotedButtons();

    document.addEventListener('click', (evt) => {
      const buttonElement = evt.target.closest(this.selector);
      if (!buttonElement) return;

      if (this.requestIsRunning) {
        return; // предыдущий запрос не выполнен
      } else {
        this.requestIsRunning = true;
      }

      const reviewId = +buttonElement.dataset[this.dataAttrReviewId];
      const voteType = buttonElement.classList.contains(this.likedClass) ? this.voteType.UNLIKE : this.voteType.LIKE;

      this._vote(reviewId, buttonElement, voteType)
        .then(() => this.requestIsRunning = false);
    });
  }


  checkVotedButtons() {
    const buttonElements = document.querySelectorAll(this.reviewIdSelector);
    buttonElements.forEach(button => {
      const reviewId = +button.dataset[this.dataAttrReviewId];

      if (this._isAlreadyVoted(reviewId)) {
        button.classList.add(this.likedClass);
      }
    });
  }


  _isAlreadyVoted(reviewId) {
    if (!localStorage[this.localStoragePropertyLike]) return;

    const propValue = localStorage.getItem([this.localStoragePropertyLike]);

    if (propValue) {
      const propValueArray = JSON.parse(propValue);
      return propValueArray.includes(reviewId);
    }
  }


  _vote(reviewId, buttonElement, voteType) {
    if (!reviewId) return;

    const countElement = buttonElement.querySelector(this.voteCountSelector);
    if (voteType === this.voteType.LIKE) {
      buttonElement.classList.add(this.likedClass);
      countElement.textContent++;
    } else {
      buttonElement.classList.remove(this.likedClass);
      countElement.textContent--;
    }

    const sendingData = new FormData;
    sendingData.append('review_id', reviewId);
    sendingData.append('vote', voteType);

    return fetch(this.requestUrl, {
      method: 'POST',
      headers: {'X-Requested-With': 'XMLHttpRequest'},
      body: sendingData
    })
      .then(response => {
        if (!response.ok) {
          throw Error(`${response.status} ${response.statusText}`);
        }
        return response.json();
      })
      .then(parsedData => {
        if (!parsedData.success) {
          throw Error('Ошибка сервера');
        } else {
          this._updateLocalStorage(reviewId, voteType);
        }
      });
  }


  _updateLocalStorage(reviewId, voteType) {
    const propName = this.localStoragePropertyLike;
    if (!localStorage[propName]) {
      localStorage.setItem(propName, '');
    }
    const currentValues = localStorage.getItem(propName);
    const currentValuesArr = (currentValues) ? JSON.parse(currentValues) : [];

    if (voteType === this.voteType.LIKE) {
      currentValuesArr.push(reviewId);
    } else {
      const reviewIdIndex = currentValuesArr.indexOf(reviewId);
      if (reviewIdIndex !== -1) {
        currentValuesArr.splice(reviewIdIndex, 1);
      }
    }

    localStorage.setItem(propName, JSON.stringify(currentValuesArr));
  }
}

new ReviewLike;
