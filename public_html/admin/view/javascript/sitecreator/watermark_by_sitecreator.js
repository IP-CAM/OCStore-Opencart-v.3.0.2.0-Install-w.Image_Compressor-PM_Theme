/*
sitecreator.ru (c) 2017-2018


 */

// глобальная
var CookiesStcrtr = false;
var watermarkPreviewRunning = false;

function hideBtnSaveSetting() {
  console.log('hideBtnSaveSetting');
  $('#btn_submit').hide();
  $('#btn_submit_return').hide();
}

function showBtnSaveSetting() {
  console.log('hideBtnSaveSetting');
  $('#btn_submit').show();
  $('#btn_submit_return').show();
}

function getURLVar(key) {
  var value = [];

  var query = String(document.location).split('?');

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

function change_destination(val) {
  var destination;
  if (val == 'cgi-bin') destination = 'cgi-bin';
  else destination = 'home';

  $('#mozjpeg_install').html('<i class="fa fa-magic" aria-hidden="true"></i> install MozJPEG (' + destination + ')').data('destination', destination);
  $('#optipng_install').html('<i class="fa fa-magic" aria-hidden="true"></i> install OptiPNG (' + destination + ')').data('destination', destination);
  $('#del_mozjpeg').html('<i class="fa fa-times" aria-hidden="true"></i> DELETE MozJPEG (' + destination + ')').data('destination', destination);
  $('#del_optipng').html('<i class="fa fa-times" aria-hidden="true"></i> DELETE OptiPNG (' + destination + ')').data('destination', destination);
}

function watermarkInputValidate() {
//    var watermarkImage = parseInt($('#input-image').val());
  var x = parseInt($('#input-posx').val());
  var y = parseInt($('#input-posy').val());
  var d = parseInt($('#input-degree').val());
  var w = parseInt($('#input-width').val());
  var h = parseInt($('#input-height').val());
  var o = parseInt($('#input-opacity').val());


  if (isNaN(x) || x < 0) x=0;
  if (x > 100) x=100;
  if (isNaN(y) || y < 0) y=0;
  if (y > 100) y=100;

  if (isNaN(d) || d < 0)  d=0;
  if (d > 360) d = 0;
  if (isNaN(w) || w < 0 || w > 100) w=100;


  if (isNaN(h) || h < 0 || h > 100) h=100;

  if (isNaN(o) || o < 0 || o > 100) o=100;


  $('#input-posx').val(x);
  $('#input-posy').val(y);
  $('#input-degree').val(d);
  $('#input-width').val(w);
  $('#input-height').val(h);
  $('#input-opacity').val(o);
}

function watermarkReset() {
  $('#input-posx').val(50);
  $('#input-posy').val(50);
  $('#input-degree').val(0);
  $('#input-width').val(80);
  $('#input-height').val(80);
  $('#input-opacity').val(100);
  watermarkInputValidate();
  
  watermarkPreview();
}


function wait_start(me) {
  me.prop('disabled', true);
  var wait = me.find('.wait_');
  if(!wait.length) me.append( '<span class="wait_"></span>' );
  else wait.css('display', 'block')
}
function wait_stop(me) {
  //return;
  me.prop('disabled', false);
  me.find('.wait_').css('display', 'none');
}

function wait_for_watermark_test() {
  var watermark_group = $('#watermark_group');
  watermark_group.find('button').prop('disabled', true);
  watermark_group.find('a').css('pointer-events', 'none');
  var wait = watermark_group.find('.wait_circ');
  if(!wait.length)  watermark_group.find('a').append( '<span class="wait_circ"></span>' );
  else wait.each(function () {
    $(this).css('display', 'block');
  });

  $('#watermark_test_warning, #thumb-image img').css('opacity', '0.7');
}

function error_permission(error) {
  var danger = $('.alert.alert-danger');
  if(!danger.length) $('#div_after_alert').before('<div class="alert alert-danger" style="display: none;"><i class="fa fa-exclamation-circle"></i> ' + error + '</div>');
  else danger.html('<i class="fa fa-exclamation-circle"></i> ' + error);
  $('.alert-danger').slideDown().delay(3000).slideUp();
}





function watermarkPreview() {
  if(watermarkPreviewRunning) return;

  console.log('watermarkPreview');
  wait_for_watermark_test();

  var dt = new Date();
  var ver = dt.getTime();
  var p = globalPars();
  var preview = p.preview;

  var watermarkImage = $('#input-image').val();
  var x = parseInt($('#input-posx').val());
  var y = parseInt($('#input-posy').val());
  var d = parseInt($('#input-degree').val());
  var w = parseInt($('#input-width').val());
  var h = parseInt($('#input-height').val());
  var o = parseInt($('#input-opacity').val());

  if (isNaN(x) || x < 0 || x > 100) x=0;
  if (isNaN(y) || y < 0 || y > 100) y=0;
  if (isNaN(d) || d < 0 || d > 360)  d=0;
  if (isNaN(w) || w < 0 || w > 100) w=100;
  if (isNaN(h) || h < 0 || h > 100) h=100;
  if (isNaN(o) || o < 0 || o > 100) o=100;

  var src = preview + '&image=' + watermarkImage + '&posX='
    + x + '&posY=' + y + '&degree=' + d
    + '&width=' + w + '&height=' + h + '&opacity=' + o + '&ver=' + ver;

  var src2 = preview + '&image=' + watermarkImage + '&posX='
    + x + '&posY=' + y + '&degree=' + d
    + '&width=' + w + '&height=' + h + '&opacity=' + o + '&ver=' + ver + '&big=1';


  $('#watermarkTestImg').attr('src', src);
  $('#watermark-big-img').attr('href', src2);

}


function loadTestImg() {
  $('#input-image').val('sitecreator/watermark_by_sitecreator.png');

  var dt = new Date();
  var ver = dt.getTime();
  var p = globalPars();
  var load_test_img = p.load_test_img;

  var src = load_test_img  + '&ver=' + ver;
  $('#thumb-image > img').attr('src', src);
  watermarkInputValidate();
  
  watermarkPreview();

}




$(document).ready(function() {
  document.title = 'Image Compressor & Watermark by Sitecreator';

  var input_for_watermark = $("#input-posx, #input-posy, #input-degree, #input-width, #input-height, #input-opacity");

  input_for_watermark.on('change', function (e) {
    console.log('input-change');
    console.log(e);
    watermarkInputValidate();
    
    watermarkPreview();
  });
  input_for_watermark.on('input', function (e) {
//     console.log('input-input');
//     console.log(e);
// //      watermarkInputValidate();
//
//     watermarkPreview();
  });

  $("input[id^='input-']").css('max-width', '110px');

  // выбираем целевой элемент
  var target = document.getElementById('input-image');

  // создаем экземпляр наблюдателя
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
//        console.log(mutation.type);
      
      watermarkPreview();
    });
  });

// настраиваем наблюдатель
  var config = { attributes: true, childList: false, characterData: false };

// передаем элемент и настройки в наблюдатель
  observer.observe(target, config);

  
  watermarkPreview();





  // добавить кнопки
  $('#input-posx, #input-posy, #input-degree, #input-width, #input-height, #input-opacity').after('<button type="button" class="btn minus">-</button><button type="button" class="btn plus">+</button>');
//    $("input[id^='input-'][id!='input-image'][id!='input-quality'][id!='input-min_width'][id!='input-max_width'][id!='input-dirs'][id!='input-test_compressing'][id!='input-webp_enable_jpeg'][id!='input-webp_enable_png']").after('<button type="button" class="btn minus">-</button><button type="button" class="btn plus">+</button>');

  $('.btn.minus').on('click', function () {
    var input = $(this).siblings('input');
    // 


    watermarkInputValidate();
    input.val(parseInt(input.val()) - 5);
    watermarkInputValidate();
    
    watermarkPreview();

  });
  $('.btn.plus').on('click', function () {
    var input = $(this).siblings('input');
    // 


    watermarkInputValidate();
    input.val(parseInt(input.val()) + 5);
    watermarkInputValidate();
    
    watermarkPreview();

  });


  $('#watermark-big-img').magnificPopup({
    type: 'image'
    // other options
  });


  $('#info_memcache').on('click', function() {
    var me = $(this);
    var get_info_os_extra = globalPars().get_info_os_extra;

      $.ajax({
      url: get_info_os_extra + '&type=' + $(this).data('type'),
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  $('#on_off_module, #on_off_webp_output, #on_off_adminbar, #on_off_ocmod_market1, #on_off_ocmod_market2').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var get_info_os_extra = p.get_info_os_extra;
    var text_clear_ocmod_success = p.text_clear_ocmod_success;


    $.ajax({
      url: p.on_off_module + '&type=' + $(this).data('type'),
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
          if(json['btn_content'] && json['btn_id']) {
            var btn = $('#' + json['btn_id']);
            btn.html(json['btn_content']);
            if(json['btn_css']) {
              if(json['btn_css'] == 'on') btn.removeClass().addClass('btn  stcrtr_btn btn-type4');
              if(json['btn_css'] == 'off') btn.removeClass().addClass('btn btn-danger  stcrtr_btn btn-type2');
            }
          }
        }


        console.log('start clear_ocmod'); // не убирать этот код. он важен для правильной последовательности

        $.ajax({
          url: p.clear_ocmod,
          dataType: 'html',
          beforeSend: function() {
            wait_start(me);
            wait_start($('#clear_ocmod'));
          },
          success: function(content) {
            if (content) {


              var permission_error = p.modification_refresh_permission;
              if(permission_error != '') { //error
                var danger = $('.alert.alert-danger');
                if(!danger.length) $('#div_after_alert').before('<div class="alert alert-danger" style="display: none;"><i class="fa fa-exclamation-circle"></i> ' + p.error_permission + '</div>');
                else danger.html('<i class="fa fa-exclamation-circle"></i> ' + p.error_permission);
                $('.alert-danger').slideDown().delay(3000).slideUp();
              } else {
                var service_result = $('#service_result');
                service_result.text(service_result.text() + '\n' + text_clear_ocmod_success);
                service_result.scrollTop(service_result.prop('scrollHeight'));
              }
            }
            wait_stop(me);
            wait_stop($('#clear_ocmod'));
          },
          error: function(content) {
            var service_result = $('#service_result');
            service_result.text(service_result.text() + '\n' + text_clear_ocmod_success);
            service_result.scrollTop(service_result.prop('scrollHeight'));
            wait_stop(me);
            wait_stop($('#clear_ocmod'));
          }
        });
        return false;
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });


  });


  $('#clear_ocmod').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var get_info_os_extra = p.get_info_os_extra;
    var text_clear_ocmod_success = p.text_clear_ocmod_success;

    $.ajax({
      url: p.clear_ocmod,
      dataType: 'html',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(content) {
        if (content) {


          var permission_error = p.modification_refresh_permission;
          if(permission_error != '') { //error
            var danger = $('.alert.alert-danger');
            if(!danger.length) $('#div_after_alert').before('<div class="alert alert-danger" style="display: none;"><i class="fa fa-exclamation-circle"></i> ' + p.error_permission + '</div>');
            else danger.html('<i class="fa fa-exclamation-circle"></i> ' + p.error_permission);
            $('.alert-danger').slideDown().delay(3000).slideUp();
          } else {
            var service_result = $('#service_result');
            service_result.text(service_result.text() + '\n' + text_clear_ocmod_success);
            service_result.scrollTop(service_result.prop('scrollHeight'));
          }
        }
        wait_stop(me);
      },
      error: function(content) {
        var service_result = $('#service_result');
        service_result.text(service_result.text() + '\n' + text_clear_ocmod_success);
        service_result.scrollTop(service_result.prop('scrollHeight'));
        wait_stop(me);
      }
    });
    return false;
  });


  $('#clear_img_cache, #clear_img_webp, #clear_img_market_cache, #clear_img_no_mozjpeg_cache, #clear_system_cache, #clear_memcache, #clear_all_memcache, #clear_turbocache').on('click', function() {
    var me = $(this);
    var type = $(this).data('type');
    var p = globalPars();
    var text_confirm_clear_all_memcache = p.text_confirm_clear_all_memcache;
    var text_confirm_clear_all_memcache = p.text_confirm_clear_all_memcache;
    if( type == 'all_memcache') {
      if(!confirm(text_confirm_clear_all_memcache)) return;
    }
    $.ajax({
      url: p.clear_cache + '&type=' + type,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
        }
        wait_stop($(me));
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop($(me));
      }
    });
  });


  $('#start_soft_test, #del_mozjpeg, #del_optipng, #del_cwebp').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var info_type = me.data('type');
    var destination = me.data('destination');
    var soft_info = $('#soft_info');

    var webp_mode = $('#webp_mode').val();
    if(webp_mode === undefined) webp_mode = 'cwebp';

    var webp_m_control = $('#webp_m_control').val();
    if(webp_m_control === undefined) webp_m_control = 4;

    var webp_q_for_test = $('#webp_q_for_test').val();
    if(webp_q_for_test === undefined) webp_q_for_test = 80;

    if(info_type == 'del_mozjpeg' || info_type == 'del_optipng' || info_type == 'del_cwebp') {
      if(!confirm("Are you sure? \n Вы уверены?")) return;
    }

    $.ajax({
      url: p.start_soft_test + '&type=' + info_type + '&destination=' + destination + '&webp_mode=' + webp_mode + '&webp_m_control=' + webp_m_control + '&webp_q_for_test=' + webp_q_for_test,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) {
          error_permission(json['error']);
        }
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));


        }
        if (json['info']) {

//            soft_info.css('backgroundColor', '#fff');
          soft_info.html(json['info']);
          soft_info.css('backgroundColor', '#f9f8c1');
          setTimeout (function(){
            $('#soft_info').css('backgroundColor', '#fff');
          }, 500);
          // позволим выбрать только движки webp, успешно прошедшие тест
          input_webp_mode_exist();
        }
        wait_stop(me);
      },

      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });

  $('#soft_link_del, #mozjpeg_install, #optipng_install, #webp_install').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var info_type = me.data('type');
    var destination = me.data('destination');
    var linux_core = '';
    var soft_info = $('#soft_info');

    var ini_alert = p.ini_alert.replace(/<\/?[^>]+>/g,'');

    if(info_type == 'webp_install') {
      linux_core = $('#cwebp_build').val();
    }

    if(ini_alert != '' && (info_type == 'mozjpeg_install' || info_type == 'optipng_install')) {
      alert(ini_alert);
      var service_result = $('#service_result');
      {
        service_result.text(service_result.text() + '\n' + ini_alert);
        service_result.scrollTop(service_result.prop('scrollHeight'));
      }
      return;
    }


    // $.ajax({
    //   url: p.activated_test,
    //   type: 'post',
    //   dataType: 'json',
    //   success: function(json) {
    //     if (json['error']) {
    //       error_permission(json['error']);
    //       return;
    //     }
    //     if (json['success']) {
    //
    //     }
    //   },
    //   error: function(xhr, ajaxOptions, thrownError) {
    //     alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    //   }
    // });

    $.ajax({
      url: p.soft_extra + '&type=' + info_type + '&linux_core=' + linux_core + '&destination=' + destination,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
        }
        if (json['info']) {
//            soft_info.css('backgroundColor', '#fff');
          soft_info.html(json['info']);
          soft_info.css('backgroundColor', '#f9f8c1');
          setTimeout (function(){
            $('#soft_info').css('backgroundColor', '#fff');
          }, 500);
          // позволим выбрать только движки webp, успешно прошедшие тест
          input_webp_mode_exist();
        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });



  $('#lic_activate').on('click', function() {
    var me = $(this);
    var p = globalPars();

    var ini_alert = p.ini_alert.replace(/<\/?[^>]+>/g,'');
    if(ini_alert != '') {
      alert(ini_alert);
      var service_result = $('#service_result');
      {
        service_result.text(service_result.text() + '\n' + ini_alert);
        service_result.scrollTop(service_result.prop('scrollHeight'));
      }

      return;
    }






    $.ajax({
      url: p.lic_activate_test + '&type=' + 'true',
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['alert']) {
          alert(json['alert']);
        }
        if (json['success']) {
          var service_result = $('#service_result');
           {
            service_result.text(service_result.text() + '\n' + json['success']);
            service_result.scrollTop(service_result.prop('scrollHeight'));
          }

        }
        wait_stop(me);
        if(json['lic'] === 'ok') {
          me.text('License is active.');
          me.prop('disabled', true);
          $('input#noclose').val(1);
          $('#form-watermark_by_sitecreator').submit();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert("*** ОШИБКА!  ***  ERROR! ***\n\n" +
          "Установите  ПРАВА (\"разрешить просмотр\" и \"разрешить редактирование\") пользователю (\"группе пользователей\") для дополнений:\n" +
          "" +
          "Edit User Group. Edit 'Access Permission' and 'Modify Permission' for this Extensions:\n\n\n" +
          "extension/module/watermark_by_sitecreator \n" +
          "module/watermark_by_sitecreator \n\n" +
          "-------------------------------------------\n" +
          "Смотрите подробнее об ошибке в console.log. (Это в браузере в панели разработчика: Ctrl+Shift+K)\n" +
          "See more about the error in the console.log. (Ctrl+Shift+K)");
        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });

  $('#watermarkTestImg').on('load', function () {
    console.log('load');
    var watermark_group = $('#watermark_group');
    watermark_group.find('button').prop('disabled', false);
    watermark_group.find('a').css('pointer-events', '');
    watermark_group.find('.wait_circ').css('display', 'none');
    $('#watermark_test_warning, #thumb-image img').css('opacity', '1');
    watermarkPreviewRunning = false;
  });


  $('#default_setting').on('click', function() {
    if(!confirm("Are you sure you want to reset the settings and deactivate the license? \nВы уверены, что желаете сбросить настройки и ДЕЗАКТИВИРОВАТЬ лицензию?")) return;
    var me = $(this);
    var info_type = $(this).data('type');
    var p = globalPars();

    $.ajax({
      url: p.default_setting + '&type=' + info_type,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {



        }
        wait_stop(me);
         window.location.assign(window.location);  // переход без повторной отправки данных
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });


  });

  $('#phpinfo, #info_os, #site_path, #info_ocmod, #soft_link').on('click', function() {
    var me = $(this);
    var info_type = $(this).data('type');
    var p = globalPars();
      //console.log(p.get_phpinfo + '&type=' + info_type);

    $.ajax({
      url: p.get_phpinfo + '&type=' + info_type,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          if(info_type == 'phpinfo') {
            var pattern = /<td class="e">System <\/td><td class="v">(.+?)<\/td>/;
            var info_part = json['success'].match(pattern);
            if (info_part.length >= 2){
              var system = '# phpinfo: ' + info_part[1];
              service_result.text(service_result.text() + '\n' + system);
              service_result.scrollTop(service_result.prop('scrollHeight'));
            }

            var win_phpinfo = window.open('about:blank', 'win_phpinfo', '', false);
            if (win_phpinfo) {
              win_phpinfo.close();
              win_phpinfo = window.open('about:blank', 'win_phpinfo', '', false);
              win_phpinfo.document.write(json['success']);
              win_phpinfo.document.close();
              win_phpinfo.focus();
            } else {  // если браузер блокирует создание окна/вкладки
              if (!$('iframe').is('#phpinfo_frame')) {
                $('#service_result').after('<iframe id="phpinfo_frame" name="phpinfo_frame"  width="100%" height="600" align="left">===</iframe>');
              }

              window.frames.phpinfo_frame.document.write(json['success']);
              window.frames.phpinfo_frame.document.close();
              window.location.hash = '#phpinfo_frame';

            }



          } else if(info_type == 'info_os' || info_type == 'site_path'  || info_type == 'info_ocmod' || info_type == 'soft_link') {
            service_result.text(service_result.text() + '\n' + json['success']);
            service_result.scrollTop(service_result.prop('scrollHeight'));
          }

        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });

  });



  $('#del_copies_of_images').on('click', function() {
    var me = $(this);
    var p = globalPars();

    $.ajax({
      url: p.del_copies_of_images,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');

      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  function cron_test_webp() {
    var me = $('#btn_cron_webp_test');
    var p = globalPars();
    var url = p.cron_test_webp;

    var div_ouput = $('#cron_test_output_imgs');


    $.ajax({
      url: url,
      type: 'post',
      dataType: 'html',
      beforeSend: function() {
        div_ouput.addClass('warning');
        wait_start(me);
      } ,
      success: function(html) {
        div_ouput.html(html);
        console.log('ok cron_test_webp');
        wait_stop($(me));
        setTimeout(function() {
          div_ouput.removeClass('warning');
        }, 500);

      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop($(me));
        setTimeout(function() {
          div_ouput.removeClass('warning');
        }, 500);
      }
    });
  }

  $('#btn_cron_webp_test').on('click', function() {

    cron_test_webp();

  });

  $('#btn_cron_webp_test_clear_imgs').on('click', function() {
    var me = $(this);
    var p = globalPars();

    $.ajax({
      url: p.cron_webp_test_clear_imgs,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          cron_test_webp();
        }
        wait_stop($(me));
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop($(me));
      }
    });
  });

  $('#create_secret_val_for_http_cwebp').on('click', function() {
    var me = $(this);
    var p = globalPars();

    $.ajax({
      url: p.create_secret_val_for_http_cwebp,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['secret_filenane']) {
          // имя секретного файла http_cwebp.cgi
          $('#secret_val_for_http_cwebp').val(json['secret_filenane']);
        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });



  $('#compress_logo').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var theme_jpeg_quality = parseInt($('#theme_jpeg_quality').val());
    if (isNaN(theme_jpeg_quality) || theme_jpeg_quality < 1 || theme_jpeg_quality > 100) {
      alert("проверьте значение качества JPEG!\nРазрешено: 0...100");
      $('#theme_jpeg_quality').val(80);
      return;
    }
    $.ajax({
      url: p.compress_logo + '&theme_jpeg_quality=' + theme_jpeg_quality,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });





  $('#undu_compress_theme').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var dir_for_compress = $('#dir_for_compress').val();
    $.ajax({
      url: p.undu_compress_theme + '&dir=' + dir_for_compress,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });

  $('#undu_compress_logo').on('click', function() {
    var me = $(this);
    var p = globalPars();

    $.ajax({
      url: p.undu_compress_logo,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  $('#compress_theme').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var theme_jpeg_quality = parseInt($('#theme_jpeg_quality').val());
    if (isNaN(theme_jpeg_quality) || theme_jpeg_quality < 1 || theme_jpeg_quality > 100) {
      alert("проверьте значение качества JPEG!\nРазрешено: 0...100");
      $('#theme_jpeg_quality').val(80);
      return;
    }
    var theme_optipng_level = parseInt($('#theme_optipng_level').val());
    var dir_for_compress = $('#dir_for_compress').val();
    $.ajax({
      url: p.compress_theme + '&theme_jpeg_quality=' + theme_jpeg_quality + '&theme_optipng_level=' + theme_optipng_level + '&dir=' + dir_for_compress,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });

  // Кнопки "показать/скрыть"
  // У кнопки должен id="market_group_click"  для соответствующего блока id="market_group"
  // можут быть также блок id="market_group_before"

  $('.toggle_block').on('click', function () {
    console.log("развернуть/свернуть");
    var id = this.id.replace('_click', '');
    toggle_and_cookies('#' + id);
    return false; // не позволить переход по ссылке
  });


  // переключить элемент и сохранить состояние в куки
  function toggle_and_cookies(id) {
    // CookiesStcrtr - глобальная
    if (CookiesStcrtr !== undefined && CookiesStcrtr !== false ) {  // если есть куки-функционал
      if ($(id).is(':visible')) {
        CookiesStcrtr.set('sitecreator.compressor.' + id + '.disp', 'off', { expires: 30 });
      }
      else {
        CookiesStcrtr.set('sitecreator.compressor.' + id + '.disp', 'on', { expires: 30 });
      }
    }
    $(id + '_before').toggleClass('half_hidden half_hidden_false');
    $(id).toggle("slow", function() {
    });
  }

  // Получить куки для id элнмента, если нет кук, то установить в off (не показывать). И в соответствии с куками показать или нет.
  // id
  function get_cookies_disp(id) {
    var cookies = 'sitecreator.compressor.' + id + '.disp'; // имя куки
    var disp = CookiesStcrtr.get(cookies);  // значение куки on/off
    console.log(id);

    // первое открытие страницы
    // if (disp  === undefined && id != '#mozjpeg_group') {
    if (disp  === undefined) {
      CookiesStcrtr.set(cookies, 'off', { expires: 30 });// по умолчанию свернуто
      $(id).hide();
      $(id + '_before').removeClass('half_hidden_false').addClass('half_hidden');
    }
    // else if (disp  === undefined) {
    //   CookiesStcrtr.set(cookies, 'on', { expires: 30 });// по умолчанию свернуто
    //   $(id).show();
    //   $(id + '_before').removeClass('half_hidden').addClass('half_hidden_false');
    // }
    else if (disp == 'on') {
      $(id + '_before').removeClass('half_hidden').addClass('half_hidden_false');
      $(id).fadeIn("slow");
    }
    else if (disp == 'off') {
      $(id).fadeOut("slow");
      $(id + '_before').removeClass('half_hidden_false').addClass('half_hidden');
    }
  }

  // получить куки для всех нужных элементов и применить действия к элементам согласно кукишам
  function get_cookies_disp_array() {
    // глобальная
    CookiesStcrtr = Cookies.noConflict(); // глобальная
    get_cookies_disp('#watermark_group');
    get_cookies_disp('#background_group');
    get_cookies_disp('#market_group');
    get_cookies_disp('#mozjpeg_group');
  }

  // загружаем скрипт кукишей если еще не загружен
  if (typeof(Cookies) == 'undefined') {
    console.log("не загружен скрипт кукишей");
    $.getScript('../../../admin/view/javascript/sitecreator/js.cookie.js', function(){
      console.log('js.cookie.js loaded');
      // получить куки для всех нужных элементов и применить действия к элементам согласно кукишам
      get_cookies_disp_array();
    });
  }
  else {
    console.log("уже загружен скрипт кукишей");
    // получить куки для всех нужных элементов и применить действия к элементам согласно кукишам
    get_cookies_disp_array();
  }


  var text_plugin_limitation = "Ограничено. Необходимо приобрести лицензионный ключ для плагина";
  $('.plugin_disable input').attr('title', text_plugin_limitation);
  // маркет
  $("div.market_lite input[id!='input-market_quality'][id!='input-market_watermark_enable']").prop('disabled', true).attr('title', text_plugin_limitation);



  function webp_mode_change() {
    var webp_mode = $('#webp_mode').val();
    if(webp_mode !== undefined && webp_mode != 'cwebp' && webp_mode != 'http_cwebp') {
      $('#webp_m_control').prop('disabled',true);
    }
    else $('#webp_m_control').prop('disabled',false);
  }

  $('#webp_mode').on('change', webp_mode_change);
  webp_mode_change();

  // составляем разрешенный список движков webp
  function input_webp_mode_exist() {
    //stcrtr_webp_mod_exist массив составляется в контроллере при каждом запуске тестирования софта
    console.log(window.stcrtr_webp_mod_exist);
    console.log($('#input-webp_mode').val());

    var selected_val = $('#input-webp_mode').val();
    var selected_none = true;

    $('#input-webp_mode option').prop('disabled',true).hide();


    if(window.stcrtr_webp_mod_exist) {
      stcrtr_webp_mod_exist.forEach(function (item, i, arr) {
        // если для выбранной опции тест движка был успешный
        if(item == selected_val) selected_none = false;
        // позволим выбрать только движки webp, успешно прошедшие тест
        $('#input-webp_mode option[value="'+ item +'"]').prop('disabled',false).show();

      });
    }


    // если ранее выбранный (сохраненный в настройках) движок не может быть выбран, т.к. тест не пройден
    if(selected_none) {
      $('#input-webp_mode option:selected').prop('selected',false); // отменим selected
      // и выберем первый доступный
      $('#input-webp_mode option:first-child').prop('selected',true);
    }





  }
  input_webp_mode_exist();

  $("#input-mozjpeg_readme").on('change', function (e) {
    if($(this).is(':checked')) {
      $("#input-mozjpeg_enable").prop('disabled', false);
      $("#input-optipng_enable").prop('disabled', false);
      $("#input-test_compressing").prop('disabled', false);
      $('.mozjpeg_enable').css('opacity', 1);
    }
    else {
      $("#input-mozjpeg_enable").prop('disabled', true);
      $("#input-optipng_enable").prop('disabled', true);
      $("#input-test_compressing").prop('disabled', true);
      $('.mozjpeg_enable').css('opacity', 0.4);
    }
  });

  // Color Picker ввод цвета для фона и полей картинок вместо стандартного белого
  $("#input-ColorPickerStcrtr").on('change', function(e) {
    var color = $(this).val();
    $("#input-ColorPickerText").val(color.replace('#', ''));
    console.log('color=' + color);
  });

  $("#input-ColorPickerText").on('input', function(e) {
    var color = $(this).val();
    var test = color.match(/^[\dabcdef]{6}$/i);
    if(test !== null) {
      $("#input-ColorPickerStcrtr").val('#' + color);
      console.log('color=' + color);
    }

  });


  var cron_test_time = 60;
  $('#cron_test_time').html(cron_test_time + ' sec / сек');

  setInterval(function () {
    if(cron_test_time === 0) {
      cron_test_webp();
      cron_test_time = 60;
    }
    else cron_test_time--;
    $('#cron_test_time').html(cron_test_time + ' sec / сек');
  }, 1000);

  // setInterval(function () {
  //   cron_test_webp();
  // }, 60000);





  $('#cron_test_webp_on_off').on('change', function(ev) {
    var me = $(this);
    var p = globalPars();

    var type = ev.target.value;


    $.ajax({
      url: p.cron_test_webp_on_off + '&type=' + type,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success'] === 'on') {
          $('#cron_test_webp_on').attr("checked","checked");
          $('#cron_test_webp_off').removeAttr("checked");
        }
        else {  // off
          $('#cron_test_webp_off').attr("checked","checked");
          $('#cron_test_webp_on').removeAttr("checked");
        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  $('#btn_cron_test_secret_key').on('click', function ()  {
    var me = $(this);
    var p = globalPars();

    $.ajax({
      url: p.cron_test_secret_key,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          cron_webp_command_for_site[2] = json['success'];
          $('#cron_test_secret_key').val(json['success']);
          create_cron_webp_command();
        }

        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });

  });

  function create_cron_webp_command() {
    var cmd = cron_webp_command_for_site;
    if(cmd.length === 4) {
      $('#cron_test_command_for_site').val('"' + cmd[0] + '" "' + cmd[1] + '" "' + cmd[2] + '" ' + cmd[3]);
    }



  }

  $('#btn_php_cli_path').on('click', function () {
    var me = $(this);
    var p = globalPars();
    var php_cli_path = $('#php_cli_path').val();

    $.ajax({
      url: p.php_cli_path + '&php_cli_path=' + php_cli_path,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          console.log(json['php_cli_path']);
          if(json['php_cli_path'] !== false) {
            // путь до php cli
            cron_webp_command_for_site[0] = json['php_cli_path'];
              $('#php_cli_path').val(cron_webp_command_for_site[0]);
          }
          else {

          }
          cron_webp_command_for_site[2] = $('#cron_test_secret_key').val();
          create_cron_webp_command();
        }

        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });


  });

  $('#input-cron_webp_mode').on('change', function () {
    var me = $(this);
    var mode = me.val();
    var p = globalPars();
    var url = p.cron_webp_mode_change + '&mode=' + mode;

    $.ajax({
      url: url,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {

        }

        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });

  });

  $('#btn_php_cli_cmd').on('click', function () {
    var me = $(this);
    var cmd = $('#input-php_cli_cmd').val();
    var p = globalPars();
    var url = p.php_cli_cmd + '&cmd=' + cmd;
    // console.log(url);

    $.ajax({
      url: url,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          $('#php_cli_cmd_out').val(json['success']);
        }

        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  $('#btn_webp_stat_refresh').on('click', function() {
    var me = $(this);
    var p = globalPars();

    $.ajax({
      url: p.webp_stat_refresh,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['text_stat']) {
          // имя секретного файла http_cwebp.cgi
          $('#text_stat').html(json['text_stat']);
        }
        if (json['graphic_stat']) {
          // имя секретного файла http_cwebp.cgi
          $('#graphic_stat').html(json['graphic_stat']);
        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  // Image Manager
  $(document).on('click', 'a[data-toggle=\'image\']', function(e) {
    var $element = $(this);
    var $popover = $element.data('bs.popover'); // element has bs popover?

    e.preventDefault();

    // destroy all image popovers
    $('a[data-toggle="image"]').popover('destroy');

    // remove flickering (do not re-add popover when clicking for removal)
    if ($popover) {
      return;
    }

    $element.popover({
      html: true,
      placement: 'right',
      trigger: 'manual',
      content: function() {
        return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
      }
    });

    $element.popover('show');

    $('#button-image').on('click', function() {
      var $button = $(this);
      var $icon   = $button.find('> i');

      $('#modal-image').remove();

      var token_for_url = '';
      var token = '', user_token = '';
      token = getURLVar('token');
      user_token = getURLVar('user_token');
      if(token.length) token_for_url = 'token=' + token;
      if(user_token.length) token_for_url = 'user_token=' + user_token;

      $.ajax({
        url: 'index.php?route=common/filemanager_for_wm_sitecreator&' + token_for_url + '&target=' + $element.parent().find('input').attr('id') + '&thumb=' + $element.attr('id'),
        dataType: 'html',
        beforeSend: function() {
          $button.prop('disabled', true);
          if ($icon.length) {
            $icon.attr('class', 'fa fa-circle-o-notch fa-spin');
          }
        },
        complete: function() {
          $button.prop('disabled', false);
          if ($icon.length) {
            $icon.attr('class', 'fa fa-pencil');
          }
        },
        success: function(html) {
          var regexp = /<!DOCTYPE html>/i;
          var regexp2 = /<head/i;
          var regexp3 = /<body/i;
          // если целиком страница, что гворит о передаче страницы "доступ зпрещен"
          if(regexp.test(html) || regexp2.test(html) || regexp3.test(html)) {
            console.log(html);
            var text = "Access is denied! Доступ запрещен!\n" +
              "Add permission to view and edit common / filemanager_for_wm_sitecreator.\n" +
              "Добавьте (путем редактирования прав пользователей) разрешение просматривать  и редактировать common/filemanager_for_wm_sitecreator.";
            alert(text);
            html = '';
            return;
          }


          $('body').append('<div id="modal-image" class="modal">' + html + '</div>');
          $('#modal-image').modal('show');
        },
        error: function () {
          console.log("ERROR");
          alert("ERROR");
        }
      });

      $element.popover('destroy');
    });

    $('#button-clear').on('click', function() {
      $element.find('img').attr('src', $element.find('img').attr('data-placeholder'));

      $element.parent().find('input').val('');

      $element.popover('destroy');
    });
  });

  // Tooltip remove fixed
  $(document).on('click', '[data-toggle=\'tooltip\']', function(e) {
    $('body > .tooltip').remove();
  });

  // tooltips on hover
  $('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

  // Makes tooltips work on ajax generated content
  $(document).ajaxStop(function() {
    $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
  });

  // https://github.com/opencart/opencart/issues/2595
  $.event.special.remove = {
    remove: function(o) {
      if (o.handler) {
        o.handler.apply(this, arguments);
      }
    }
  };

  $('[data-toggle=\'tooltip\']').on('remove', function() {
    $(this).tooltip('destroy');
  });

//Form Submit for IE Browser
  $('button[type=\'submit\']').on('click', function() {
    $("form[id*='form-']").submit();
  });

  // Highlight any found errors
  $('.text-danger').each(function() {
    var element = $(this).parent().parent();

    if (element.hasClass('form-group')) {
      element.addClass('has-error');
    }
  });

  function supertopResize() {
    var supertop_h = $('#supertop').outerHeight();
    $('#container').css('marginTop',  supertop_h + 'px');
  }
  supertopResize();
  $(window).resize(supertopResize);



});
