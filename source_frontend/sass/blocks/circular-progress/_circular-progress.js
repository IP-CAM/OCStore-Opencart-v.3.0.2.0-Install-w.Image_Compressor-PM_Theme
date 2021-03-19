const PRIMARY_COLOR = '#01768b';

export default class CircularProgress {
  constructor(parentSelector, {width = '24px', height = '24px', color = ''} = {}) {
    this.parentElement = document.querySelector(parentSelector);
    this.width = width;
    this.height = height;
    this.color = (color === 'primary') ? PRIMARY_COLOR : color;

    this.savedElementHtml = undefined;
  }


  on() {
    if (!this.parentElement) return;

    this.savedElementHtml = this.parentElement.innerHTML;
    this.parentElement.setAttribute('style', `width: ${this.parentElement.offsetWidth}px; height: ${this.parentElement.offsetHeight}px; display: flex;`);
    this.parentElement.innerHTML = `<div class="circular-progress" style="width: ${this.width}; height: ${this.height}; color: ${this.color}">
                          <svg class="circular-progress__svg" viewBox="22 22 44 44">
                            <circle cx="44" cy="44" r="20.2" fill="none" stroke-width="3.6"></circle>
                          </svg>
                        </div>`;
  }


  off() {
    if (!this.parentElement) return;

    this.parentElement.setAttribute('style', '');
    this.parentElement.innerHTML = this.savedElementHtml;
  }
}
