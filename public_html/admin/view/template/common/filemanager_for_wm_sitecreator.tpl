<?php
// File Manager for watermark module
// Версия 1.0
// Разработчик sitecreator.ru 2019(c)



?>
<div id="filemanager" class="modal-dialog" style="  width:auto; display: table;">
  <div class="modal-header" style="display:table-header-group;">
    <div style="background: #fbfbfb; padding: 10px 10px 10px 15px; border-radius: 2px 2px 0 0;">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">True File Manager <a style="text-decoration: underline;" target="_blank" href="https://sitecreator.ru/modules-for-opencart/true_file_manager">(Full version)</a> <span style="font-size: 12px; color: #b0b0b0; font-weight: normal;">by Sitecreator.ru <br><a style="text-decoration: underline;" target="_blank" href="https://sitecreator.ru/modules-for-opencart/true_file_manager">Полная версия менеджера и редактора изображений.</a>
          </span></h4>
    </div>
  </div>
  <div class="" style="display: table-row;">

    <div class="" style="display: table-cell;"><a id="elfinder_a_click" class="thumbnail" href="" style="display: none;"></a>
      <div id="elfinder"></div>
    </div>
  </div>
</div>
<?php if(!empty($token) || !empty($user_token)) {
  $token_for_url = '';
 if(!empty($token)) $token_for_url = "token=$token";
 if(!empty($user_token)) $token_for_url = "user_token=$user_token";
  ?>
<script>

        (function() {

          var url = 'index.php?route=common/filemanager_for_wm_sitecreator/connector&' + '<?php echo $token_for_url; ?>';
          var options = {
            url  : url,
            lang : 'en',
            ui: ['toolbar', 'places', 'tree', 'path', 'stat'],
            height: 600,
            resizable: true,
            commandsOptions : {
              getfile : {
                multiple : false,
                oncomplete : 'close'
              }
            },
            getFileCallback: function(files, fm){
              console.log('files:');
              console.log(files);

              $('#thumb-image').find('img').attr('src', files.tmb);

              var path = files.path;
              // for windows
              path = path.replace(/\\\\/g,'/');
              path = path.replace(/\\/g,'/');
              $('#input-image').attr('value', path);

              $('#elfinder_a_click').attr('href', files.url).trigger('click');

              $('#modal-image').modal('hide');
              $('#modal-image').remove();
            }
          };
          $('#elfinder').elfinder(options);

        })();


</script>
<?php } ?>