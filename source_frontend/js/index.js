import initLazyload from './lazyload.js';
import initScrollOnLoad from './scrollonload.js';  // переработать в связи с существованием scrollIntoView()
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

import initSearch from './common-next-modules/search-field.js';
import initFilter from './common-next-modules/yulms-ocfilter.js';
import initCart from './common-next-modules/cart.js';
import initWishlist from './common-next-modules/wishlist.js'; // допилить
import initReviewVote from  './common-next-modules/review-vote.js';
import initReviewWrite from './common-next-modules/review-write.js';
import initReviewPagination from './common-next-modules/review-pagination.js';
import initRegistration from './common-next-modules/registration.js';
import initLogin from './common-next-modules/login.js';
import initSubscribe from './common-next-modules/subscribe.js';
import initShare from './common-next-modules/share.js';
import initCityManager from './common-next-modules/citymanager';


const projectObjects = {
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
  search: initSearch(),
  ocFilter: initFilter(),
  cart: initCart(),
  wishList: initWishlist(),
  reviewVote: initReviewVote(),
  reviewWrite: initReviewWrite(),
  reviewPagination: initReviewPagination(),
  registration: initRegistration(),
  login: initLogin(),
  subscribe: initSubscribe(),
  share: initShare(),
  cityManager: initCityManager()
};

window.yulms = projectObjects;

console.log(window.yulms);
