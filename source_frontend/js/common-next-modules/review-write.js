import Alert from '../../sass/blocks/alert/_alert.js';
import ReCaptcha from './recaptcha-v3.js';
import CircularProgress from '../../sass/blocks/circular-progress/_circular-progress';

class ReviewWrite {
  constructor(formElement) {
    this.formSelector = '.review-write__form';
    this.productId = formElement.dataset.productId;
    this.recaptchaAction = 'submit_product_review';
    this.url = 'index.php?route=product/product/write&product_id=' + this.productId;
    this.submitButtonSelector = `${this.formSelector} button[type="submit"]`;


    this.formElement = formElement;

    this.reCaptcha = new ReCaptcha();

    this.formElement.addEventListener('focusin', () => this.reCaptcha.loadScript(), {once: true});

    this.formElement.addEventListener('submit', (evt) => {
      evt.preventDefault();

      const loadingIndicator = new CircularProgress(this.submitButtonSelector);
      loadingIndicator.on();

      // * reCAPTCHA
      this.reCaptcha.execute(this.recaptchaAction)
        .then(() => {
          return fetch(this.url, {
            method: 'POST',
            body: new FormData (this.formElement)
          });
        })
        .then(response => {
          if (!response.ok) {
            throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
          }
          return response.json();
        })
        .then(json => {
          this._showAlert(json);
          if (json.success) this.formElement.reset();
        })
        .finally(() => loadingIndicator.off())
        .catch(console.error);
    });
  }


  _showAlert(json) {
    const alertOptions = {
      targetSelector: this.formSelector + ' .stars',
      position: 'after',
      extraCssClass: 'review-write__elem'
    };

    if (json.success) {
      alertOptions.html = json.success;
      alertOptions.type = 'success';
    } else {
      alertOptions.html = json.error;
      alertOptions.type = 'warning';
    }

    new Alert(alertOptions);
  }

}



export default function initReviewWrite() {
  const formSelector = '.review-write__form';
  const formElement = document.querySelector(formSelector);
  if (formElement) return new ReviewWrite(formElement);
}
