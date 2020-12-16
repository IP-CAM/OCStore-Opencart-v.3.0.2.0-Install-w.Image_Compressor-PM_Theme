export function isEscapePressEvent(evt, callback) {
  if (evt.code === 'Escape') {
    callback();
  }
}

export function isEnterPressEvent(evt, callback) {
  if (evt.code === 'Enter') {
    callback();
  }
}

export function isLeftButtonMouseDown(evt, callback) {
  if (evt.which === 1) {
    callback();
  }
}


// функция, отключающая нежелательные эффекты при position: fixed
let scrollPosition;
export function scrollLock({lock = true} = {}) {
  const html = document.documentElement;
  const htmlStyle = html.style;
  let marginSize;

  if (lock) {
    scrollPosition = window.pageYOffset;
    marginSize = window.innerWidth - html.clientWidth;
    htmlStyle.position = 'fixed';
    htmlStyle.top = -scrollPosition + 'px';
    htmlStyle.right = '0';
    htmlStyle.left = '0';
    htmlStyle.overflow = 'hidden';
    if (marginSize) {
      // при position: fixed пропадает полоса прокрутки,
      // в результате контент под окном занимает его место.
      // Для блокирования этого эффекта используем margin
      htmlStyle.marginRight = marginSize + 'px';
    }
  } else {
    htmlStyle.top = '';
    htmlStyle.position = '';
    htmlStyle.right = '';
    htmlStyle.left = '';
    htmlStyle.overflow = '';
    htmlStyle.marginRight = '';
    window.scrollTo(0, scrollPosition);
  }
}



//  Функция
//  Добавляет класс анимации на элемент.
//  Класс должнен иметь свойство с описанием анимации в CSS
//  Ожидает выполнения анимации, после чего выполняет колбэк и подчищает за собой

export function executeAfterAnimationEnd({element, animationClass, animationName, callback}) {
  function execute(evt) {
    if (evt.animationName === animationName) {
      element.classList.remove(animationClass);
      callback();
      // if (element) {
      //   element.removeEventListener('animationend', execute);
      // }
    }
  }
  element.addEventListener('animationend', execute, {once: true});
  element.classList.add(animationClass);
}


let isTouchSupport;
export function isTouchDevice() {
  if (isTouchSupport !== undefined) return isTouchSupport;

  isTouchSupport = true;
  try {
    document.createEvent('TouchEvent');
  }
  catch (err) {
    isTouchSupport = false;
  }
  return isTouchSupport;
}


let id = 0;
export function generateId() {
  return 'generatedId-' + ++id;
}
