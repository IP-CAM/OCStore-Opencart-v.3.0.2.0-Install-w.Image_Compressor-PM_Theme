import initLazyload from './lazyload.js';
import initScrollOnLoad from './scrollonload.js';
import initSwitchView from '../sass/blocks/switch-view/_switch-view.js';
import initMainNav from '../sass/blocks/main-nav/_main-nav.js';
import initBoundedModals from '../sass/blocks/modal/_modal--bounded.js';
import initModal from '../sass/blocks/modal/_modal.js';
import initQuantityInput from '../sass/blocks/quantity-input/_quantity-input.js';
import initTooltips from '../sass/blocks/tooltip/_tooltip.js';
import initTextfields from '../sass/blocks/textfield/_textfield.js';
import initCustomSelects from '../sass/blocks/custom-select/_custom-select.js';
import initRipple from '../sass/blocks/ripple/_ripple.js';
import initAccordion from '../sass/blocks/accordion/_accordion.js';
import initSliders from '../sass/blocks/slider/_slider.js';
import initShowmores from '../sass/blocks/showmore/_showmore.js';
import initStars from '../sass/blocks/stars/_stars.js';
import initRadios from '../sass/blocks/radiocheck/_radio.js';
import initPickup from '../sass/blocks/pickup/_pickup.js';
import './common-next.js';
import Filter from './yulms-ocfilter.js';


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
  pickup: initPickup(),
  filter: new Filter()
};

console.log(projectObjects);

window.projectObjects = projectObjects;
