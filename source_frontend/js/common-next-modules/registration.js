import ReCaptcha from './recaptcha-v3.js';
import CircularProgress from '../../sass/blocks/circular-progress/_circular-progress';
import Alert from '../../sass/blocks/alert/_alert';


class Registration {
  constructor() {
    this.endOfRegisterPageHref = '?route=account/register';
    this.registerLinkSelector = `[href$="/index.php${this.endOfRegisterPageHref}"]`;
    this.formSelector = '[data-registration-form]';
    this.subscribeFormSelector = '[data-register-for-subscribe]'; // подписка на новости открывает окно регистрации
    this.ajaxUrl = 'index.php?route=account/register/ajax';
    this.submitButtonSelector = `${this.formSelector} button[type="submit"]`;
    this.recaptchaAction = 'submit_registration';


    this.reCaptcha = new ReCaptcha();

    document.addEventListener('click', (evt) => {
      const targetElement = evt.target.closest(this.registerLinkSelector);
      if (!targetElement) return;

      evt.preventDefault();
      this._showRegistrationModal();
    });

    document.addEventListener('submit', (evt) => {
      const subscribeFormElement = evt.target.closest(this.subscribeFormSelector);
      if (!subscribeFormElement) return;

      evt.preventDefault();

      const formData = new FormData(subscribeFormElement);
      const emailValue = formData.get('email');
      const initiatedBySubscribe = true;
      this._showRegistrationModal(initiatedBySubscribe, emailValue);
    });


    this._waitFocusOnForm(this.formSelector)
      .then(() => this._addSubmitListener(this.formSelector))
      .then(() => this._loadCaptcha());
  }


  _showRegistrationModal(initiatedBySubscribe, emailValue = '') {
    const loginHref = window.location.origin + '/index.php?route=account/login';
    const recapthaInputId = this.reCaptcha.getResponseInpudId();
    const recapthaInputName = this.reCaptcha.getResponseInpudName();

    let subscribeHtml = '';
    if (initiatedBySubscribe) {
      subscribeHtml = `<label class="radiocheck registration__subscribe-check">
                        <input class="radiocheck__input visually-hidden" type="checkbox" name="newsletter" value="1" checked>
                        <span class="radiocheck__box radiocheck__box--check"></span>
                        <span class="radiocheck__caption">Подписаться на рассылку</span>
                      </label>`;
    }


    const html = `<section class="registration">
      <h2 class="modal__header">Регистрация</h2>
      <form data-registration-form>
        <div class="textfield registration__textfield">
          <label class="textfield__input-container">
            <input class="textfield__input" type="email" name="email" value="${emailValue}" autocomplete="off" required>
            <span class="textfield__label">e-mail</span>
          </label>
        </div>
        <div class="textfield registration__textfield">
          <label class="textfield__input-container">
            <input class="textfield__input" type="password" name="password" autocomplete="off" required minlength="4" maxlength="20">
            <span class="textfield__label">Пароль</span>
          </label>
          <div class="textfield__help">от 4 до 20 символов</div>
        </div>
        ${subscribeHtml}
        <input type="hidden" name="firstname" value="">
        <input type="hidden" name="lastname" value="">
        <input type="hidden" name="telephone" value="">
        <input type="hidden" id="${recapthaInputId}" name="${recapthaInputName}">
        <button class="button button--action-primary registration__button" type="submit">Продолжить</button>
      </form>
      <p class="registration__already-text">
        Уже есть аккаунт?
        <a class="link" href="${loginHref}" style="margin-left: 1rem">Войти</a>
      </p>
    </section>`;

    window.yulms.modal.open({content: html});
  }


  _waitFocusOnForm(formSelector) {
    return new Promise(resolve => {
      const onFocusIn = (evt) => {
        const formElement = evt.target.closest(formSelector);
        if (!formElement) return;

        document.removeEventListener('focusin', onFocusIn);
        resolve();
      };

      document.addEventListener('focusin', onFocusIn);
    });
  }


  _addSubmitListener(formSelector) {
    document.addEventListener('submit', (evt) => {
      const formElement = evt.target.closest(formSelector);
      if (!formElement) return;

      evt.preventDefault();
      this._submitForm(formElement);
    });
  }


  _loadCaptcha() {
    return new Promise(resolve => {
      if (!this.captchaWasLoaded) {
        this.reCaptcha.loadScript()
          .then(() => {
            this.captchaWasLoaded = true;
            resolve();
          });
      } else {
        resolve();
      }
    });
  }


  _submitForm(formElement) {
    const loadingIndicator = new CircularProgress(this.submitButtonSelector);
    loadingIndicator.on();

    this.reCaptcha.execute(this.recaptchaAction)
      .then(() => this._sendFetchRequest(formElement))
      .then(json => this._parseResponse(json))
      .then(response => {
        if (response) {
          // для любой текущей страницы, кроме register - перезагружаем
          const endOfCurrentPageHref = window.location.search;
          (endOfCurrentPageHref === this.endOfRegisterPageHref) ?
            window.location = response.redirect : window.location.reload();
        }
      })
      .finally(() => loadingIndicator.off())
      .catch(console.error);
  }


  _parseResponse(json) {
    if (!json['success']) {
      throw new Error(`Ошибка ответа сервера ${json}`);
    }
    if (json['validation_error']) {
      const validationErrors = Object.values(json['validation_error']).join('<br>');
      new Alert({
        targetSelector: '.registration__button',
        position: 'before',
        html: validationErrors,
        type: 'simpleWarning',
        extraCssClass: 'registration__alert',
        isDissmisible: false
      });

      return false;
    }

    return json;
  }


  _sendFetchRequest(formElement) {
    return fetch(this.ajaxUrl, {method: 'POST', body: new FormData (formElement)})
      .then(response => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.json();
      });
  }

}


export default function initRegistration() {
  return new Registration();
}
