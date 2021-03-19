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

      const currentStateIsOpened = buttonElement.getAttribute('aria-expanded') === 'true';
      currentStateIsOpened ? this.close(buttonElement) : this.open(buttonElement);
    });

  }


  open(buttonElementOrSelector) {
    const buttonElement = (typeof buttonElementOrSelector === 'object') ?
      buttonElementOrSelector : document.querySelector(buttonElementOrSelector);

    const wrapper = buttonElement.parentNode.nextElementSibling;
    wrapper.addEventListener('transitionend', () => {
      wrapper.style.height = 'auto';
      wrapper.style.overflow = '';
    }, {once: true});

    wrapper.style.height = 0;
    wrapper.style.overflow = 'hidden';
    wrapper.hidden = false;
    const fullHeight =  wrapper.scrollHeight;
    wrapper.style.height = fullHeight + 'px';

    buttonElement.setAttribute('aria-expanded', true);
  }


  close(buttonElementOrSelector) {
    const buttonElement = (typeof buttonElementOrSelector === 'object') ?
      buttonElementOrSelector : document.querySelector(buttonElementOrSelector);

    const wrapper = buttonElement.parentNode.nextElementSibling;
    const fullHeight =  wrapper.scrollHeight;
    wrapper.style.height = fullHeight + 'px';
    wrapper.addEventListener('transitionend', () => {
      wrapper.style.height = 'auto';
      wrapper.style.overflow = '';
      wrapper.hidden = true;
      wrapper.style.transitionDuration = '';
    }, {once: true});

    setTimeout(() => {
      wrapper.style.transitionDuration = '75ms';
      wrapper.style.overflow = 'hidden';
      wrapper.style.height = 0;
    }, 0);

    buttonElement.setAttribute('aria-expanded', false);
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
    const paddingValue = window.getComputedStyle(heading, null).getPropertyValue('padding');
    heading.style.padding = '0';
    const styleString = (paddingValue) ? `style="padding: ${paddingValue}"` : '';

    heading.innerHTML = `<button class="accordion__button" aria-expanded="${initStateIsOpened}" type="button" ${styleString}>
                            ${heading.innerHTML}
                            <svg viewBox="0 0 24 24" class="accordion__button-icon" width="32" height="32">
                              <path fill="none" vector-effect="non-scaling-stroke" d="M7 11l5 4 5-4"/>
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
