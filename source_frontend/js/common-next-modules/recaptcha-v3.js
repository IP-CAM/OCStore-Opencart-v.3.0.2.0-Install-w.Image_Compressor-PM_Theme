export default class ReCaptcha {
  constructor() {
    this.siteKey = '6LfoznEaAAAAAEXkXA91WMS5ZglCtuIWNnms8auO';
    this.loadUrl = 'https://www.google.com/recaptcha/api.js?render=' + this.siteKey;
    this.responseInputSelector = '#g-recaptcha-response';
  }


  loadScript() {
    return new Promise((resolve, reject) => {
      const loadedScript = document.head.querySelector(`script[src="${this.loadUrl}"]`);

      if (loadedScript) {
        resolve(loadedScript);
      } else {
        const script = document.createElement('script');
        script.src = this.loadUrl;

        script.onload = () => resolve(script);
        script.onerror = () => reject(new Error(`Ошибка загрузки скрипта reCaptcha ${this.loadUrl}`));

        document.head.append(script);
      }
    });
  }


  execute(action) {
    return new Promise((resolve, reject) => {
      window.grecaptcha.ready(() => {
        window.grecaptcha.execute(this.siteKey, {action: action})
          .then(token => {
            document.querySelector(this.responseInputSelector).value = token;
            resolve();
          })
          .catch(() => reject(new Error('Ошибка метода grecaptcha.execute'))
          );
      });
    });
  }

}
