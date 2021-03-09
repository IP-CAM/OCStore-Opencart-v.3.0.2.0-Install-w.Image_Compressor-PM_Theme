export default class CircularProgress {
  constructor(parentSelector, {width = '24px', height = '24px'} = {}) {
    this.parentElement = document.querySelector(parentSelector);
    this.width = width;
    this.height = height;

    this.savedElementHtml = undefined;
  }


  on() {
    this.savedElementHtml = this.parentElement.innerHTML;
    this.parentElement.style.width = this.parentElement.offsetWidth + 'px';
    this.parentElement.style.height = this.parentElement.offsetHeight + 'px';
    this.parentElement.innerHTML = `<span class="circular-progress" style="width: ${this.width}; height: ${this.height};">
                          <svg class="circular-progress__svg" viewBox="22 22 44 44">
                            <circle cx="44" cy="44" r="20.2" fill="none" stroke-width="3.6"></circle>
                          </svg>
                        </span>`;
  }


  off() {
    this.parentElement.style.width = '';
    this.parentElement.style.height = '';
    this.parentElement.innerHTML = this.savedElementHtml;
  }
}
