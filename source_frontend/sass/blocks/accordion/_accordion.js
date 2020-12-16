'use strict';



class Accordion {
  constructor(overrides) {
    const defaults = {
      accordionClassName: 'accordion',
      buttonSelector: '.accordion__button',
      contentWrapperClassName: 'accordion__content-wrapper',
      initStateDataAttribute: 'accordionOpen',
      additionalClassDataAttribute: 'accordionClass'
    };

    Object.assign(this, defaults, overrides);


    this._headingElements = Array.from(document.querySelectorAll('.' + this.accordionClassName));

    this._headingElements.forEach((heading) => {
      let initStateIsOpened = this._getInitState(heading);

      this._addButton(heading, initStateIsOpened);
      let contents = this._getContent(heading);

      // Create a wrapper element for `contents` and hide it
      let wrapper = document.createElement('div');
      wrapper.classList.add(this.contentWrapperClassName);

      if (!initStateIsOpened) {
        wrapper.hidden = true;
      }

      // adding additional classes
      let additionalClass = heading.dataset[this.additionalClassDataAttribute];
      if (additionalClass) {
        let additionalClasses = additionalClass.split(' ');
        additionalClasses.forEach((className) => {
          wrapper.classList.add(className);
        });
      }


      // Add each element of `contents` to `wrapper`
      contents.forEach(node => {
        wrapper.appendChild(node);
      });

      // Add the wrapped content back into the DOM
      // after the heading
      heading.parentNode.insertBefore(wrapper, heading.nextElementSibling);
    });


    document.addEventListener('click', (evt) => {
      let buttonElement = evt.target.closest(this.buttonSelector);
      if (!buttonElement) return;

      let isExpanded = buttonElement.getAttribute('aria-expanded') === 'true' || false;
      buttonElement.setAttribute('aria-expanded', !isExpanded);

      // let parent = buttonElement.parentNode;
      let wrapper = buttonElement.parentNode.nextElementSibling;

      let targetStateIsOpen = !isExpanded;

      if (targetStateIsOpen) {
      // поведение при открытии
        wrapper.style.height = 0;
        wrapper.hidden = false;
        let fullHeight =  wrapper.scrollHeight;
        wrapper.style.height = fullHeight + 'px';
      } else {
        // закрытие
        let fullHeight =  wrapper.scrollHeight;
        wrapper.style.height = fullHeight + 'px';
        wrapper.addEventListener('transitionend', () => {
          wrapper.style.height = 'auto';
          wrapper.hidden = true;
          wrapper.style.transitionDuration = '';
        }, {once: true});

        setTimeout(() => {
          wrapper.style.transitionDuration = '75ms';
          wrapper.style.height = 0;
        }, 0);
      }
    });

  }

  _getInitState(heading) {
    let initStateIsOpened;
    let widthOpened = heading.dataset[this.initStateDataAttribute];

    switch (widthOpened) {
      case undefined:
        initStateIsOpened = false;
        break;

      case (''):
        initStateIsOpened = true;
        break;

      default:
        initStateIsOpened = (window.innerWidth >= widthOpened);
    }

    return initStateIsOpened;
  }


  _addButton(heading, initStateIsOpened) {
    heading.innerHTML = `<button class="accordion__button" aria-expanded="${initStateIsOpened}" type="button">
                            ${heading.textContent}
                            <svg class="accordion__button-icon" width="32" height="32">
                              <use href="img/svg/_sprite.svg#icon-arrow"></use>
                            </svg>
                          </button>`;
  }


  _getContent(elem) {
    // Function to create a node list
    // of the content between this <h2> and the next
    let elems = [];
    while (elem.nextElementSibling && !elem.nextElementSibling.classList.contains(this.accordionClassName)) {
      elems.push(elem.nextElementSibling);
      elem = elem.nextElementSibling;
    }

    // Delete the old versions of the content nodes
    elems.forEach((node) => {
      node.parentNode.removeChild(node);
    });

    return elems;
  }


}



function initAccordion() {
  return new Accordion();
}

export default initAccordion;
