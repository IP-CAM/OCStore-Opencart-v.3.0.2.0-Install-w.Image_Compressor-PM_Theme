import initLazyload from './lazyload.js';
import initScrollOnLoad from './scrollonload.js';
import initSwitchView from './_switch-view.js';
import initMainNav from './_main-nav.js';
import initBoundedModals from './_modal--bounded.js';
import initModal from './_modal.js';
import initQuantityInput from './_quantity-input.js';
import initTooltips from './_tooltip.js';
import initTextfields from './_textfield.js';
import initCustomSelects from './_custom-select.js';
import initRipple from './_ripple.js';
import initAccordion from './_accordion.js';
import initSliders from './_slider.js';
import initShowmores from './_showmore.js';
import initStars from './_stars.js';
import initRadios from './_radio.js';
import initPickup from './_pickup.js';

const projectObjects = { // eslint-disable-line
  lazyLoad: initLazyload(),
  scrollOnLoad: initScrollOnLoad(),
  switchView: initSwitchView(),
  mainNav: initMainNav(),
  modalsBounded: initBoundedModals(),
  modal: initModal(),
  quantityInput: initQuantityInput(),
  toolTips: initTooltips(),
  textfields: initTextfields(),
  customSelects: initCustomSelects(),
  ripple: initRipple(),
  accordion: initAccordion(),
  sliders: initSliders(),
  showMores: initShowmores(),
  stars: initStars(),
  radios: initRadios(),
  pickup: initPickup()
};

console.log(projectObjects);


window.projectObjects = projectObjects;
