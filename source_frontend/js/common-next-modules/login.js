// класс для работы с модальным окном авторизации, передача данных только через ajax (fetch)
// для авторизации со страницы, будет работат без этого модуля
import CircularProgress from '../../sass/blocks/circular-progress/_circular-progress';
import Alert from '../../sass/blocks/alert/_alert';



class Login {
  constructor() {
    this.endOfLoginPageHref = '?route=account/login';
    this.loginLinkSelector = `[href$="/index.php${this.endOfLoginPageHref}"]`;
    this.ajaxUrl = 'index.php?route=account/login/ajax';
    this.formSelector = '.login .login__form';
    this.submitButtonSelector = `${this.formSelector} button[type="submit"]`;


    document.addEventListener('click', (evt) => {
      const loginLinkElement = evt.target.closest(this.loginLinkSelector);
      if (!loginLinkElement) return;
      evt.preventDefault();

      this._showLoginModal();
      this._addSubmitListener();
    });
  }


  _showLoginModal() {
    const forgotHref = window.location.origin + '/index.php?route=account/forgotten';
    const registerHref = window.location.origin + '/index.php?route=account/register';

    const html = `<section class="login">
        <h2 class="modal__header">Вход</h2>
        <form class="login__form">
          <div class="textfield login__textfield">
            <label class="textfield__input-container">
              <input class="textfield__input" type="email" name="email" required>
              <span class="textfield__label">email</span>
            </label>
          </div>
          <div class="textfield login__textfield">
            <label class="textfield__input-container">
              <input class="textfield__input" type="password" name="password" required minlength="4" maxlength="20">
              <span class="textfield__label">Пароль</span>
            </label>
          </div>
          <div class="login__button-container">
            <a href="${forgotHref}" class="link">Напомнить пароль</a>
            <button class="button button--action-primary" type="submit">Войти</button>
          </div>
        </form>

        <div class="socials-login login__socials-login">
          <span>Или войти через:</span>
          <ul class="socials-login__list">
            <li>
              <a class="socials-login__link" href="#">
                <svg class="icon socials-login__icon" width="24" height="24">
                  <use href="catalog/view/theme/pm/img/svg/_sprite.svg#icon-google"></use>
                </svg>
                <span class="visually-hidden">Google</span>
              </a>
            </li>
            <li>
              <a class="socials-login__link" href="#">
                <svg class="icon socials-login__icon socials-login__icon--vk" width="24" height="24">
                  <use href="catalog/view/theme/pm/img/svg/_sprite.svg#icon-vk"></use>
                </svg>
                <span class="visually-hidden">Вконтакте</span>
              </a>
            </li>
            <li>
              <a class="socials-login__link" href="#">
                <svg class="icon socials-login__icon socials-login__icon--fb" width="24" height="24">
                  <use href="catalog/view/theme/pm/img/svg/_sprite.svg#icon-facebook"></use>
                </svg>
                <span class="visually-hidden">Фэйсбук</span>
              </a>
            </li>
            <li>
              <a class="socials-login__link" href="#">
                <svg class="icon socials-login__icon socials-login__icon--ok" width="24" height="24">
                  <use href="catalog/view/theme/pm/img/svg/_sprite.svg#icon-ok"></use>
                </svg>
                <span class="visually-hidden">Однокласники</span>
              </a>
            </li>
          </ul>
        </div>

        <p class="login__no-account">Нет аккаунта?<a class="link login__no-account-link" href="${registerHref}">Зарегистрироваться</a></p>
      </section>`;

    window.yulms.modal.open({content: html});
  }


  _addSubmitListener() {
    const formElement = document.querySelector(this.formSelector);
    formElement.addEventListener('submit', (evt) => {
      evt.preventDefault();

      this._submitForm(formElement);
    });
  }


  _submitForm(formElement) {
    const loadingIndicator = new CircularProgress(this.submitButtonSelector);
    loadingIndicator.on();

    this._sendFetchRequest(formElement)
      .then(json => this._parseResponse(json))
      .then(response => {
        if (response) window.location.reload();
      })
      .catch((err) => {
        loadingIndicator.off();
        console.error(err);
      });
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


  _parseResponse(json) {
    if (!json['success']) {
      throw new Error(`Ошибка ответа сервера ${json}`);
    }
    if (json['validation_error']) {
      const validationErrors = Object.values(json['validation_error']).join('<br>');
      new Alert({
        targetSelector: '.login__button-container',
        position: 'before',
        html: validationErrors,
        type: 'simpleWarning',
        extraCssClass: 'login__alert',
        isDissmisible: false
      });

      return false;
    }

    return json;
  }

}


export default function initLogin() {
  return new Login();
}
