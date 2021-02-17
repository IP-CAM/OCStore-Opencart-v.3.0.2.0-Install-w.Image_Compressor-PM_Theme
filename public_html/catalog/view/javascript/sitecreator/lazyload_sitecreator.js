
// WEBP Lazy Load by sitecreator (c) 2019-2020 https://sitecreator.ru lazyload_sitecreator.js
function LazyLoadStcrtr() {
  var config = {
    root: null,
    rootMargin: '0px',
    threshold: [0.2]
  };

  var w_or_h = 812; 
  var mobile_screen = typeof window.screen.width === "number" && (window.screen.width <= w_or_h && window.screen.height <= w_or_h);
  if(mobile_screen) console.log('mobile_screen');
  var observer;

  if (typeof window.IntersectionObserver === 'function') {
    observer = new IntersectionObserver(function(entries, self) {
      Array.prototype.forEach.call(entries, function (entry) {
        if (entry.isIntersecting) {
          // console.log(entry);
          var img = entry.target;
          self.unobserve(img);
          setSrc(img);
        }
      });
    }, config);
  }

  var busy = false;

  this.lazyReStart = function() {
    if(busy) return;
    busy = true;
    var imgs = document.querySelectorAll("img[data-src]");
    if(typeof observer === 'object') {
      // observer.disconnect(); // вредно, т.к. перестает работать config
      Array.prototype.forEach.call(imgs, function (img) {
        observer.observe(img);
      });
    } else Array.prototype.forEach.call(imgs, function (img) {
      setSrc(img);
    });
    busy = false;
  };

  function setSrc(img) {
    var src = img.getAttribute('data-src');
    var srclow = img.getAttribute('data-srclow');
    if (src) {
      if(mobile_screen && srclow) img.src = srclow;
      else img.src = src;
      img.removeAttribute('data-src');

      if(typeof lazyl_remove_w_h_stcrtr !== 'undefined' && lazyl_remove_w_h_stcrtr) {
        img.removeAttribute('width');
        img.removeAttribute('height');
      }
    }
  }

}
