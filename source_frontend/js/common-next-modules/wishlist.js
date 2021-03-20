// class Wishlist {
//   constructor() {
//     this.ajaxParams = {
//       add: {
//         url: 'index.php?route=account/wishlist/add',
//         method: 'post',
//         responseType: 'json',
//         requestHeader: {
//           headerName: 'Content-Type',
//           headerValue: 'application/x-www-form-urlencoded; charset=UTF-8'
//         },
//         onLoad: (response) => {
//           if (response['redirect']) {
//             location = response['redirect'];
//           }
//           if (response['success']) {
//             console.log('success', response);
//           }
//         }
//       }
//     };
//   }

//   add (product_id) {
//     const sendingData = 'product_id=' + product_id;
//     this.ajaxParams.add.sendingData = sendingData;
//     ajaxRequest(this.ajaxParams.add);
//   }
// }




// следим за событием click на document
// проверяем data атрибут data-wishlist на evt.target, если есть - наш клиент
// значение атрибута data-wishlist - имя запускаемой функции

class Wishlist {
  constructor() {
    this.requestAddUrl = 'index.php?route=account/wishlist/add';
    this.wishlistDataAttr = 'wishlist';
    this.wishlistSelector = `[data-${this.wishlistDataAttr}]`;
    this.productIdDataAttr = 'productId';
    this.wishlistCountDataAttr = 'data-wishlist-count';
    this.wishlistCountSelector = `[${this.wishlistCountDataAttr}]`;


    document.addEventListener('click', (evt) => {
      const targetElement = evt.target.closest(this.wishlistSelector);
      if (!targetElement) return;

      const action = targetElement.dataset[this.wishlistDataAttr];
      this[action](targetElement);
    });
  }


  add(button) {
    const formData = new FormData();
    formData.append('product_id', button.dataset[this.productIdDataAttr]);

    this._sendAddRequest(formData)
      .then(response => {
        if (response['redirect']) {
          location = response['redirect'];
        }
        this._updateHeaderWishlistCount(response.item_count);
        if (response.need_registration) {
          this._showNeedRegistrationModal(response.success, response.login_link, response.register_link);
        } else {
          this._showAddWishlistModal(response.success, response.total, response.wishlist_link);
        }
      })
      .catch(console.error);
  }


  _sendAddRequest(data) {
    return fetch(this.requestAddUrl, {
      method: 'post',
      body: data
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.json();
      })
      .then((response) => {
        if (!response['success']) {
          throw new Error(`Ошибка ответа сервера ${response}`);
        }
        return response;
      })
      .catch(console.error);
  }


  _updateHeaderWishlistCount(itemCount) {
    console.log(itemCount);
    const countElement = document.querySelector(this.wishlistCountSelector);
    countElement.setAttribute(this.wishlistCountDataAttr, itemCount);
  }


  _showAddWishlistModal(message, totalMessage, wishlistLink) {
    const html = `<h2 class="modal__header" style="display: flex; align-items: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="32" height="32" style="margin-right: 1rem" aria-hidden="true"><polyline points="2,8 6,13 14,3" fill="none" stroke="#01768b" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" stroke-width="2"/></svg>
                    Товар добавлен в избранное
                  </h2>
                  <p class="modal__p">${message}</p>
                  <p class="modal__p">${totalMessage}</p>
                  <div style="display: flex; flex-direction: column; margin-top: 2rem;">
                    <button class="button button--action-primary" style="margin-bottom: 0.5rem" data-modal-close>Продолжить покупки</button>
                    <a class="link" href=${wishlistLink} style="padding-top: 0.5rem; text-align: center;">Перейти в избранные товары</a>
                  </div>`;
    window.yulms.modal.open({content: html, focusOnOpen: false});
  }


  _showNeedRegistrationModal(message, loginLink, registerLink) {
    const html = `<h2 class="modal__header">Выполните вход, что бы сохранять товары в избранное</h2>
                  <p class="modal__p">${message}</p>
                  <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
                    <a class="button button--action-primary" href="${loginLink}" style="margin-right: 0.5rem">Войти</a>
                    <a class="button button--action-secondary" href="${registerLink}">Зарегистрироваться</a>
                  </div>`;
    window.yulms.modal.open({content: html, focusOnOpen: false});
  }

}





export default function initWishlist() {
  return new Wishlist();
}
