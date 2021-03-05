import Alert from '../../sass/blocks/alert/_alert.js';


class WriteReview {
  constructor(formElement) {
    this.formSelector = '.review-write__form';
    this.productId = formElement.dataset.productId;
    this.url = 'index.php?route=product/product/write&product_id=' + this.productId;


    this.formElement = document.querySelector(this.formSelector);
    this.formElement.addEventListener('submit', (evt) => {
      evt.preventDefault();

      const formData = new FormData (this.formElement);
      this._sendRequest(formData)
        .then(parsedData => {
          const alertOptions = {
            targetSelector: this.formSelector + ' .stars',
            position: 'after',
            extraCssClass: 'review-write__elem'
          };

          if (parsedData.success) {
            alertOptions.html = parsedData.success;
            alertOptions.type = 'success';
            this.formElement.reset();
          } else {
            alertOptions.html = parsedData.error;
            alertOptions.type = 'warning';
          }

          new Alert(alertOptions);
        });
    });
  }


  _sendRequest(formData) {
    return fetch(this.url, {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw Error(`${response.status} ${response.statusText}`);
        }
        return response.json();
      });
  }

}


const formSelector = '.review-write__form';
const formElement = document.querySelector(formSelector);
if (formElement) new WriteReview(formElement);



// TODO
// 1. Встроить рекапчу
// 2. Добавить пагинацию
