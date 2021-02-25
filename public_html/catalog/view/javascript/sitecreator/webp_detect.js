(function() {
  if(typeof (window.sitecreator_hasWebP) !== 'object') window.sitecreator_hasWebP = {val: null};

  var usA = navigator.userAgent;
  var s;
  if(usA.match(/windows|android/i) !== null) if((s = usA.match(/(Chrome|Firefox)\/(\d{2,3})\./i)) !== null) {
    var br = s[1].toLowerCase();
    var ver = s[2];
    if((br === "chrome" &&   ver >= 32) || br === "firefox" && ver >= 65) {
      window.sitecreator_hasWebP.val = true;
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
  img.onload = function() {
    if (img.width === 2 && img.height === 1) {
      document.cookie = "sitecreator_hasWebP=1; path=/";
      window.sitecreator_hasWebP.val = true;
      console.log('webp = ok');
    }};
  img.src = "data:image/webp;base64,UklGRjIAAABXRUJQVlA4ICYAAACyAgCdASoCAAEALmk0mk0iIiIiIgBoSygABc6zbAAA/v56QAAAAA==";
})();



function funWebpOrNot2(tag, n) {
  if(typeof n == "undefined" || n === null) return;
  var me = document.getElementById('scwebp' + n);
  if (me === null) return;

  if(typeof me.removeAttribute) me.removeAttribute('id');

  if ((typeof (window.sitecreator_hasWebP) === 'undefined' || !window.sitecreator_hasWebP.val)) {
    tag = tag.replace(/\.webp(['"\s])/g, '$1');
  }

  if(document.readyState === 'loading') {
    document.write(tag);
    if (typeof me.remove === 'function') me.remove();
    me = null;
  }
  else me.insertAdjacentHTML("afterend", tag);
}

function funWebpOrNot22(v) {
  if(typeof v === 'object') {
    funWebpOrNot2(v[0], v[1]);
  }
}

function funWebpOrNot3(tag, n) {
  if(typeof n == "undefined" || n === null) return;
  var me = document.getElementById('scwebp' + n);
  var ns = document.getElementById('nswebp' + n);
  if (me === null || ns === null) return;

  if ((typeof (window.sitecreator_hasWebP) === 'undefined' || !window.sitecreator_hasWebP.val)) {
    tag = tag.replace(/\.webp(['"\s])/g, '$1');
  }
  ns.insertAdjacentHTML("afterend", tag);
}

function funWebpOrNot33(v) {
  if(typeof v === 'object') {
    funWebpOrNot2(v[0], v[1]);
  }
}
