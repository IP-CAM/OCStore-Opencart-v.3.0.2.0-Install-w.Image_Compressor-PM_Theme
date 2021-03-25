class Subscribe {
  constructor() {
    this.subscribeFormSelector = '[data-subscribe-form]';
    this.subscribeUrl = 'index.php?route=account/newsletter';
    this.subscribeField = 'newsletter';
    this.valueToSubscribe = 1;


    document.addEventListener('submit', (evt) => {
      const subscribeForm = evt.target.closest(this.subscribeFormSelector);
      if (!subscribeForm) return;

      evt.preventDefault();

      const formData = new FormData();
      formData.append(this.subscribeField, this.valueToSubscribe);
      fetch(this.subscribeUrl, {method: 'POST', body: formData})
        .then(response => {
          if (!response.ok) {
            throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
          }
        })
        .then(() => this._showConfirmationModal())
        .catch(console.error);
    });

  }


  _showConfirmationModal() {
    const confirmHtml = `<h2 class="modal__header">Подписка оформлена!</h2>
    <p class="modal__p">Теперь вы будете уведомлены о последних новинках, скидках и акциях нашего магазина.</p>`;
    window.yulms.modal.open({content: confirmHtml});
  }

}


export default function initSubscribe() {
  return new Subscribe();
}
