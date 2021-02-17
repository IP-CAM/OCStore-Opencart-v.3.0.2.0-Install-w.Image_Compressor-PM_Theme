
// WEBP Lazy Load by sitecreator (c) 2019 https://sitecreator.ru lazyload_start.js
/*
Некоторые анимационные баннеры и слайдеры требуют чтобы их изображения были загружены и отображены сразу, иначе они рискуют быть вовсе не показаны.
Сделайте правки подобно коду, который закомментирован ниже.
В данном случае все изображения <img> из блока с классом '#slideshow0'  будут сразу загружены
Редактируйте свой собственный файл lazyload_start_alt.js как альтернативу данному файлу
В настройках модуля Компрессор включите "Использовать альтернативный JS lazyload_start_alt.js"
Данный файл (lazyload_start.js) не рекомендуется редактировать, т.к. при обновлении модуля он будет переписан, т.е. затерт.

Не пытайтесь найти где данный файл подключается как ссыдка в HTML, ссылки нет. Его содержимое вставляется в страницу HTML
Комментарии не попадут в результирующий HTML из этого файла если они будут сделаны таким же образом как здесь
*/
/*
document.addEventListener("DOMContentLoaded", function() {
  var imgs = document.querySelectorAll('#slideshow0 img');
  Array.prototype.forEach.call(imgs, function (img) {
    var src = img.getAttribute('data-src');
    if(src) img.src = src;
  });
});
*/
(function() {
  var lazy = new LazyLoadStcrtr();
  var lazyReStart = lazy.lazyReStart;
  document.addEventListener("DOMContentLoaded", lazyReStart);
  setInterval(lazyReStart, 100);
})();
