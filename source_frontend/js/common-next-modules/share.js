import CircularProgress from '../../sass/blocks/circular-progress/_circular-progress';


class Share {
  constructor() {
    this.shareButtonSelector = '[data-button-share]';
    this.loadUrl = 'https://yastatic.net/share2/share.js';
    this.shareElementId = 'ya-share';
    this.modalHeaderHtml = '<h2 class="modal__header">Рассказать друзьям</h2>';
    this.shareHtml = `<div id="${this.shareElementId}"></div>`;
    this.shareOptions = {
      theme: {
        services: 'viber,telegram,facebook,odnoklassniki,vkontakte,twitter',
        size: 'l',
        shape: 'round',
        direction: 'vertical'
      }
    };


    const shareButtonElements = document.querySelectorAll(this.shareButtonSelector);
    shareButtonElements.forEach(button => {
      button.addEventListener('click', this._openShareModal.bind(this, button));
    });
  }


  _openShareModal(buttonElement) {
    const loadingIndicator = new CircularProgress(buttonElement, {color: 'primary'});
    loadingIndicator.on();

    this._loadScript()
      .then(() => {
        window.yulms.modal.open({
          content: this.modalHeaderHtml + this.shareHtml,
          modalSize: 'auto'
        });
        window.Ya.share2(this.shareElementId, this.shareOptions);
      })
      .then(() => loadingIndicator.off());
  }


  _loadScript() {
    return new Promise((resolve, reject) => {
      const loadedScript = document.head.querySelector(`script[src="${this.loadUrl}"]`);

      if (loadedScript) {
        resolve(loadedScript);
      } else {
        const script = document.createElement('script');
        script.src = this.loadUrl;

        script.onload = () => resolve(script);
        script.onerror = () => reject(new Error(`Ошибка загрузки скрипта yandex share ${this.loadUrl}`));

        document.head.append(script);
      }
    });
  }

}


export default function initShare() {
  return new Share();
}
