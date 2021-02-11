// Copyright © Malyutin Roman aka sitecreator, sitecreator.pro 2020 ckeditorinit.js v. 1.0.2
if(typeof window.stcrtr_ckeditorInit != 'function') {
  function stcrtr_ckeditorInit(node, token) {

    CKEDITOR.replace(node);
    CKEDITOR.config.defaultLanguage = 'en';
    var lang = $('html').attr('lang');
    if(lang !== undefined && lang !== null) {
      CKEDITOR.config.language = lang;
    }

    CKEDITOR.on('dialogDefinition', function (ev) {
      for (i = 0; i < ev.data.definition.contents.length; i++) {
        var button = ev.data.definition.contents[i].get('browse');
        if (button !== null) {
          button.hidden = false;
          button.onClick = function() {
            $('#modal-image').remove();
            $.ajax({
              url: 'index.php?route=common/filemanager&cke=' + this.filebrowser.target + '&user_token=' + token,
              dataType: 'html',
              success: function(html) {
                $('body').append('<div class="modal ckeditor" id="modal-image">' + html + '</div>');
                $('#modal-image').modal('show').css('z-index', 9999999);
              }
            });
          }
        }
      }
    });
  }
}

if(typeof window.stcrtr_getURLVar != 'function') {
  function stcrtr_getURLVar(key) {
    var value = [];

    var query = document.location.search.split('?');

    if (query[1]) {
      var part = query[1].split('&');

      for (i = 0; i < part.length; i++) {
        var data = part[i].split('=');

        if (data[0] && data[1]) {
          value[data[0]] = data[1];
        }
      }

      if (value[key]) {
        return value[key];
      } else {
        return '';
      }
    }
  }
}
