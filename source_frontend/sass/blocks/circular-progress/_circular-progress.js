const PRIMARY_COLOR = '#01768b';

export default class CircularProgress {
  constructor(parentSelectorOrElement, {width = '24px', height = '24px', color = ''} = {}) {
    if (typeof parentSelectorOrElement === 'object') {
      this.parentElements = [];
      this.parentElements.push(parentSelectorOrElement);
    } else {
      this.parentElements = Array.from(document.querySelectorAll(parentSelectorOrElement));
    }

    this.width = width;
    this.height = height;
    this.color = (color === 'primary') ? PRIMARY_COLOR : color;

    this.savedElementHtmls = [];
    this.savedStyleAttributes = [];
  }


  on() {
    if (this.parentElements.length === 0) return;

    this.parentElements.forEach((parentElement, index) => {
      this.savedElementHtmls[index] = parentElement.innerHTML;
      this.savedStyleAttributes[index] = parentElement.getAttribute('style') || '';

      const addingStyleAttributes = `width: ${parentElement.offsetWidth}px; height: ${parentElement.offsetHeight}px; display: flex; padding: 0;`;
      parentElement.setAttribute('style', this.savedStyleAttributes[index] + addingStyleAttributes);
      this.parentElements[index].innerHTML = `<div class="circular-progress" style="width: ${this.width}; height: ${this.height}; color: ${this.color}">
                                                <svg class="circular-progress__svg" viewBox="22 22 44 44">
                                                  <circle cx="44" cy="44" r="20.2" fill="none" stroke-width="3.6"></circle>
                                                </svg>
                                              </div>`;
    });
  }


  off() {
    if (this.parentElements.length === 0) return;

    this.parentElements.forEach((parentElement, index) => {
      parentElement.setAttribute('style', this.savedStyleAttributes[index]);
      parentElement.innerHTML = this.savedElementHtmls[index];
    });
  }
}



// * Старая реализация - только для одного элемента
// export default class CircularProgress {
//   constructor(parentSelectorOrElement, {width = '24px', height = '24px', color = ''} = {}) {
//     this.parentElement = (typeof parentSelectorOrElement === 'object') ?
//       parentSelectorOrElement : document.querySelector(parentSelectorOrElement);
//     this.width = width;
//     this.height = height;
//     this.color = (color === 'primary') ? PRIMARY_COLOR : color;

//     this.savedElementHtml = undefined;
//     this.savedStyleAttributes = undefined;
//   }


//   on() {
//     if (!this.parentElement) return;

//     this.savedElementHtml = this.parentElement.innerHTML;
//     this.savedStyleAttributes = this.parentElement.getAttribute('style') || '';

//     const addingStyleAttributes = `width: ${this.parentElement.offsetWidth}px; height: ${this.parentElement.offsetHeight}px; display: flex;`;

//     this.parentElement.setAttribute('style', this.savedStyleAttributes + addingStyleAttributes);
//     this.parentElement.innerHTML = `<div class="circular-progress" style="width: ${this.width}; height: ${this.height}; color: ${this.color}">
//                           <svg class="circular-progress__svg" viewBox="22 22 44 44">
//                             <circle cx="44" cy="44" r="20.2" fill="none" stroke-width="3.6"></circle>
//                           </svg>
//                         </div>`;
//   }


//   off() {
//     if (!this.parentElement) return;

//     this.parentElement.setAttribute('style', this.savedStyleAttributes);
//     this.parentElement.innerHTML = this.savedElementHtml;
//   }
// }
