// WEBP detect by sitecreator (c) 2019 https://sitecreator.ru webp_detect.js ver. 2.1.1
// Code Developer Malyutin R. A. All rights reserved.
(function() {
  if(typeof (window.sitecreator_hasWebP) !== 'object') window.sitecreator_hasWebP = {val: null};

  var usA = navigator.userAgent;
  var s;
  if(usA.match(/windows|android/i) !== null) if((s = usA.match(/(Chrome|Firefox)\/(\d{2,3})\./i)) !== null) {
    // console.log(s);
    var br = s[1].toLowerCase();
    var ver = s[2];
    if((br === "chrome" &&   ver >= 32) || br === "firefox" && ver >= 65) {
      window.sitecreator_hasWebP.val = true; // сработает если еще нет куки
      console.log('webp on start= ok');
    }
  }

  var cookie_hasWebP = document.cookie.match(/\bsitecreator_hasWebP=1\b;?/);
  if(cookie_hasWebP !== null) window.sitecreator_hasWebP.val = true;

  var img = new Image();
  img.onerror = function() {
    document.cookie = "sitecreator_hasWebP=0; path=/";
    window.sitecreator_hasWebP.val = false;
    console.log('webp = bad');
  };
  // работает асинхроннно. в Хроме сработает сразу и до DOMContentLoaded, в FF - в конце (после DOMContentLoaded)
  img.onload = function() {
    if (img.width === 2 && img.height === 1) {
      document.cookie = "sitecreator_hasWebP=1; path=/";
      window.sitecreator_hasWebP.val = true;
      console.log('webp = ok');
    }};
  img.src = "data:image/webp;base64,UklGRjIAAABXRUJQVlA4ICYAAACyAgCdASoCAAEALmk0mk0iIiIiIgBoSygABc6zbAAA/v56QAAAAA==";
})();



function funWebpOrNot2(tag, n) {
  // console.log('funWebpOrNot2, document.readyState= ' + document.readyState);
  // var me = document.currentScript;  // будет null если тег <script> добвлен динамически после document.readyState === complete
  if(typeof n == "undefined" || n === null) return;
  var me = document.getElementById('scwebp' + n);
  if (me === null) return;  // null - если элемент не существует. выходим без отображения картинки

  // перестраховка, т.к. id уже уникальный в каждый отрезок времени
  // на случай динамического создания на стр. <script>. Для одного запроса по http исключено дублирование id, да и js не выполняются параллельно
  if(typeof me.removeAttribute) me.removeAttribute('id');

  if ((typeof (window.sitecreator_hasWebP) === 'undefined' || !window.sitecreator_hasWebP.val)) { // not webp
    tag = tag.replace(/\.webp(['"\s])/g, '$1');
  }

  if(document.readyState === 'loading') {
    document.write(tag);
    // удалим узел чтобы не мешал (чему, где  и когда?) удаление - лишняя операция и перестроение дерева DOM
    //  подстраховка на гипотетический случай 2-го запуска одного и того же блока <script>, что невозможно после удаления его id, который к тому же уникален
    if (typeof me.remove === 'function') me.remove(); // старые браузеры не знают
    me = null; //отправляется к сборщику мусора
  }
  else me.insertAdjacentHTML("afterend", tag);  // метод поддерживается всеми зверями

}

function funWebpOrNot22(v) {
  if(typeof v === 'object') {
    funWebpOrNot2(v[0], v[1]);
  }
}

// на случай если в ускорителе включена оптимизация JS и все скрипты перемещаются в конец страницы
function funWebpOrNot3(tag, n) {
  // console.log('funWebpOrNot2, document.readyState= ' + document.readyState);
  // var me = document.currentScript;  // будет null если тег <script> добвлен динамически после document.readyState === complete
  if(typeof n == "undefined" || n === null) return;
  var me = document.getElementById('scwebp' + n); //
  var ns = document.getElementById('nswebp' + n); // элемент <noscript>
  if (me === null || ns === null) return;  // null - если элемент не существует. выходим без отображения картинки

  // перестраховка, т.к. id уже уникальный в каждый отрезок времени
  // на случай динамического создания на стр. <script>. Для одного запроса по http исключено дублирование id, да и js не выполняются параллельно
  // if(typeof me.removeAttribute) me.removeAttribute('id');

  if ((typeof (window.sitecreator_hasWebP) === 'undefined' || !window.sitecreator_hasWebP.val)) { // not webp
    tag = tag.replace(/\.webp(['"\s])/g, '$1');
  }
  ns.insertAdjacentHTML("afterend", tag);  // метод поддерживается всеми зверями
}

function funWebpOrNot33(v) {
  if(typeof v === 'object') {
    funWebpOrNot2(v[0], v[1]);
  }
}
