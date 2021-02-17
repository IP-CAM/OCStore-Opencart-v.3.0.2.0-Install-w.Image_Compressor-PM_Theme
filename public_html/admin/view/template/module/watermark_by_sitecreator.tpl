<!DOCTYPE html>
<html dir="ltr" lang="ru">
<head>
  <meta charset="UTF-8" />
  <title>Image COMPRESSOR & Watermark & WebP & Lazy Load etc.</title>
  <base href="<?php echo $base; ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <script type="text/javascript" src="view/javascript/sitecreator/jquery-3.4.1.min.js"></script>

  <script type="text/javascript" src="view/javascript/sitecreator/bootstrap-3.3.7/js/bootstrap.min.js"></script>

  <link href="view/javascript/sitecreator/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <link href="view/javascript/sitecreator/font-awesome-4/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

<!--  <script src="view/javascript/sitecreator/moment.js-2.24.0/moment.min.js" type="text/javascript"></script>-->
<!--  <script src="view/javascript/sitecreator/moment.js-2.24.0/locale/ru.js" type="text/javascript"></script>-->
<!---->
<!--  <script src="view/javascript/sitecreator/datetimepicker-4.17.47/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>-->
<!--  <link href="view/javascript/sitecreator/datetimepicker-4.17.47/css/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />-->



  <script type="text/javascript" src="view/javascript/sitecreator/magnific/jquery.magnific-popup.min.js"></script>
  <link type="text/css" href="view/javascript/sitecreator/magnific/magnific-popup.css" rel="stylesheet" media="screen" />
  <script type="text/javascript" src="view/javascript/sitecreator/watermark_by_sitecreator.js?v=<?php echo time(). mt_rand(1,9999); ?>"></script>
  <link type="text/css" href="view/stylesheet/watermark_by_sitecreator.css?v=<?php echo time(). mt_rand(1,9999); ?>" rel="stylesheet" media="screen" />

  <link rel="stylesheet" type="text/css" href="view/javascript/sitecreator/jquery-ui-1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" type="text/css" href="view/javascript/sitecreator/elfinder/css/elfinder.min.css">
  <link rel="stylesheet" type="text/css" href="view/javascript/sitecreator/elfinder/css/theme.css">

  <script type="text/javascript" src="view/javascript/sitecreator/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="view/javascript/sitecreator/elfinder/js/elfinder.min.js"></script>
  <script type="text/javascript" src="view/javascript/sitecreator/elfinder/js/i18n/elfinder.ru.js"></script>
  <script type="text/javascript" src="view/javascript/sitecreator/elfinder/js/i18n/elfinder.uk.js"></script>

</head>
<body>
<div id="supertop" class="supertop">
  <header id="header">
    <div class="page-header">
      <div class="container-fluid">
        <div class="pull-right btns-group" style="text-align: right;">
          <button id="btn_submit" type="submit" form="form-watermark_by_sitecreator" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
          <button id="btn_submit_return" style="border: solid 1px #c0c0c0" type="submit" onclick="$('input#noclose').val(1);" form="form-watermark_by_sitecreator" data-toggle="tooltip" title="<?php echo $button_save_and_noclose; ?>" class="btn"><i class="fa fa-save"></i></button>

          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
          <br><br><?php echo $text_version; ?>
        </div>
        <h2><?php echo $heading_title; ?></h2>
        <ul class="breadcrumb">
          <?php
          //if(empty($fast_f) || strlen($fast_f) < 256) echo '<script>document.getElementById("content").style.display = "none";</script>'
          foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
          <?php } ?>
        </ul>

      </div>
      <div class="container-fluid">
        <?php if ($error_warning) { ?>
          <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php } ?>
        <div id="div_after_alert"></div>
      </div>
<!--      <div class="panel-heading">-->
<!--        <h3 class="panel-title"><i class="fa fa-pencil"></i> --><?php //echo $text_edit; ?><!--</h3>-->
<!--      </div>-->
      <ul class="nav  scr-module">
        <li onclick="showBtnSaveSetting();" class="active"><a href="#tab-main" data-toggle="tab"><?php echo $text_tab_main; ?></a></li>
        <li onclick="hideBtnSaveSetting();" class=""><a href="#tab-service" data-toggle="tab"><?php echo $text_tab_service; ?></a></li>
        <li onclick="hideBtnSaveSetting();" class=""><a href="#tab-theme" data-toggle="tab"><?php echo $text_tab_theme; ?></a></li>
        <li onclick="hideBtnSaveSetting();" class=""><a href="#tab-cron" data-toggle="tab"><?php echo $text_tab_cron; ?></a></li>
        <li onclick="hideBtnSaveSetting();" class=""><a href="#tab-webp_stat" data-toggle="tab"><?php echo $text_tab_webp_stat; ?></a></li>
        <!--          <li class=""><a href="#tab-http_cwebp" data-toggle="tab">--><?php //echo $text_tab_http_cwebp; ?><!--</a></li>-->
        <li class=""><a href="#tab-help" data-toggle="tab"><?php echo $text_tab_help; ?></a></li>
      </ul>
    </div>

  </header>
</div>
<div id="container">

<div id="content">

    <div class="container-fluid">

      <div class="panel panel-default">


        <div class="panel-body tab-content">
          <div id="tab-main" class="tab-pane active">
            <form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-watermark_by_sitecreator" name="form-watermark_by_sitecreator" class="form-horizontal">


              <div class="form-group" style="display: none">
                <label  class="col-sm-4 control-label"><?php echo $text_imagick_disable; ?></label>
                <div class="col-sm-8">
                  <input disabled="disabled" type="checkbox" id="input-imagick_disable"  class="form-control"  name="watermark_by_sitecreator_imagick_disable" <?php if(!empty($imagick_disable)) echo 'checked'; ?>>
                </div>
              </div>
              <div class="form-group" style="">
                <div  class="col-sm-4 header_stcrtr">СЖАТИЕ включить</div><div class="col-sm-8 header2_stcrtr"><a class="toggle_block warning" style="" id="mozjpeg_group_click" href="#" onclick="return false;"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Показать / скрыть  ПРЕДУПРЕЖДЕНИЕ! <i class="fa fa-eye-slash" aria-hidden="true"></i></a></div>
              <div style="height:15px; clear: both;"></div>
                <div class="warning_stcrtr">
                <div id="mozjpeg_group_before" style="padding: 5px 20px;  color: #000;"><?php echo $text_mozjpeg_warning_before; ?></div>
                <div id="mozjpeg_group" style="display:none; padding: 5px 20px;  color: #000;"><?php echo $text_mozjpeg_warning; ?></div>
                </div>
                <div style="height:15px; clear: both;"></div>

                <label  class="col-sm-4 control-label"><?php echo $text_mozjpeg_readme; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-mozjpeg_readme"  class="form-control"  name="watermark_by_sitecreator_mozjpeg_readme" <?php if(!empty($mozjpeg_readme)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <div class="mozjpeg_enable"  style="<?php if(empty($mozjpeg_readme)) echo 'opacity:0.4;';?>">
              <label  class="col-sm-4 control-label"><?php echo $text_mozjpeg_enable; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($mozjpeg_readme)) echo ' disabled="disabled" title="заблокировано пока вы не прочитаете ПРЕДУПРЕЖДЕНИЕ и не согласитесь с ним." '; ?> type="checkbox" id="input-mozjpeg_enable"  class="form-control"  name="watermark_by_sitecreator_mozjpeg_enable" <?php if(!empty($mozjpeg_enable)) echo 'checked'; ?>>
              </div>
                </div>
          </div>
              <div class="mozjpeg_enable"  style="<?php if(empty($mozjpeg_readme)) echo 'opacity:0.4;';?>">
          <div class="form-group" style="">
            <label  class="col-sm-4 control-label"><?php echo $text_optipng_enable; ?></label><br>
            <div class="col-sm-8">
              <input <?php if(empty($mozjpeg_readme)) echo ' disabled="disabled" title="заблокировано пока вы не прочитаете ПРЕДУПРЕЖДЕНИЕ и не согласитесь с ним." '; ?> type="checkbox" id="input-optipng_enable"  class="form-control"  name="watermark_by_sitecreator_optipng_enable" <?php if(!empty($optipng_enable)) echo 'checked'; ?>>

            </div>
            <div style="height:15px; clear: both;"></div>
            <label  class="col-sm-4 control-label"><?php echo $text_optipng_level; ?></label>
            <div class="col-sm-8">
              <select id="input-optipng_level"  class="form-control"  name="watermark_by_sitecreator_optipng_level">
                <option value=1 <?php if(empty($optipng_level) || $optipng_level == 1) echo 'selected';  ?>>1</option>
                <option value=2 <?php if($optipng_level == 2) echo 'selected';  ?>>2 нормально</option>
                <option value=3 <?php if($optipng_level == 3) echo 'selected';  ?>>3 медленно</option>
              </select>
            </div>

          </div>
          <div class="form-group" style="display:none;">
            <label  class="col-sm-4 control-label"><?php echo $text_test_compressing; ?></label>
            <div class="col-sm-8">
              <input <?php if(empty($mozjpeg_readme)) echo ' disabled="disabled" title="заблокировано пока вы не прочитаете ПРЕДУПРЕЖДЕНИЕ и не согласитесь с ним." '; ?>  type="checkbox" id="input-test_compressing"  class="form-control"  name="watermark_by_sitecreator_test_compressing" <?php if(!empty($test_compressing)) echo 'checked'; ?>>
            </div>
          </div>
          </div>

              <div class="form-group">
                <div  class="col-sm-4 header_stcrtr header_color2">КАЧЕСТВО для ВСЕХ изображений</div><div class="col-sm-8 header2_stcrtr"></div>
              <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_img_quality; ?></label>
                <div class="col-sm-8">
                  <input style="border: 1px solid #0c942c; background: #e1f8e3; color: #000" type="text" id="input-quality" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_quality" value="<?php echo $quality; ?>">
                  <br></div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_webp_quality; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-webp_quality" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_webp_quality" value="<?php echo $webp_quality; ?>">
                </div>
              </div>

              <div class="form-group" style="display:none;">
                <div  class="col-sm-4 header_stcrtr header_color2">КАЧЕСТВО для МАЛЕНЬКИХ изображений</div><div class="col-sm-8 header2_stcrtr"></div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_img_mini_quality; ?></label>
                <div class="col-sm-8">
                  <input disabled style="border: 1px solid #0c942c; background: #e1f8e3; color: #000" type="text" id="input-mini_quality" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_mini_quality" value="<?php echo $mini_quality; ?>">
                  <br></div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_img_mini_w_and_h; ?></label>
                <div class="col-sm-8">
                  <input disabled type="text" id="input-img_mini_w" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_img_mini_w" value="<?php echo $img_mini_w; ?>">
                  <input disabled type="text" id="input-img_mini_h" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_img_mini_h" value="<?php echo $img_mini_h; ?>">
                </div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_img_mini_if_and; ?></label>
          <div class="col-sm-8">
            <input disabled type="checkbox" id="input-img_mini_if_and"  class="form-control"  name="watermark_by_sitecreator_img_mini_if_and" <?php if(!empty($img_mini_if_and)) echo 'checked'; ?>>
          </div>
        </div>
          <div class="form-group" style="display:none;">
            <div  class="col-sm-4 header_stcrtr header_color2">КАЧЕСТВО для БОЛЬШИХ изображений</div><div class="col-sm-8 header2_stcrtr"></div>
          <div style="height:15px; clear: both;"></div>
          <label class="col-sm-4 control-label"><?php echo $text_img_maxi_quality; ?></label>
          <div class="col-sm-8">
            <input disabled style="border: 1px solid #0c942c; background: #e1f8e3; color: #000" type="text" id="input-maxi_quality" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_maxi_quality" value="<?php echo $maxi_quality; ?>">
            <br></div>
          <div style="height:15px; clear: both;"></div>
          <label class="col-sm-4 control-label"><?php echo $text_img_maxi_w_and_h; ?></label>
          <div class="col-sm-8">
            <input disabled type="text" id="input-img_maxi_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_img_maxi_w" value="<?php echo $img_maxi_w; ?>">
            <input disabled type="text" id="input-img_maxi_h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_img_maxi_h" value="<?php echo $img_maxi_h; ?>">
          </div>
        <div style="height:15px; clear: both;"></div>
        <label  class="col-sm-4 control-label"><?php echo $text_img_maxi_if_and; ?></label>
        <div class="col-sm-8">
          <input disabled type="checkbox" id="input-img_maxi_if_and"  class="form-control"  name="watermark_by_sitecreator_img_maxi_if_and" <?php if(!empty($img_maxi_if_and)) echo 'checked'; ?>>
        </div>
        <div style="height:15px; clear: both;"></div>
        <label  class="col-sm-4 control-label"><?php echo $text_img_maxi_no_compress; ?></label>
        <div class="col-sm-8">
          <input disabled type="checkbox" id="input-img_maxi_no_compress"  class="form-control"  name="watermark_by_sitecreator_img_maxi_no_compress" <?php if(!empty($img_maxi_no_compress)) echo 'checked'; ?>>
        </div>
        </div>
      
              <div class="form-group">
                <div  class="col-sm-4 header_stcrtr">WebP</div><div class="col-sm-8 header2_stcrtr"></div>
                <div style="height:15px; clear: both;"></div>
                <label style="text-align:left;"  class="col-sm-4 control-label"><?php echo $text_webp_warning; ?></label>
                <div style="height:10px; clear: both;"></div>

                <label  class="col-sm-4 control-label"><?php echo $text_webp_enable_jpeg; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_enable_jpeg"  class="form-control"  name="watermark_by_sitecreator_webp_enable_jpeg" <?php if(!empty($webp_enable_jpeg)) echo 'checked'; ?>>
                </div>
              </div>
              <div class="form-group">

                <label  class="col-sm-4 control-label"><?php echo $text_webp_enable_png; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_enable_png"  class="form-control"  name="watermark_by_sitecreator_webp_enable_png" <?php if(!empty($webp_enable_png)) echo 'checked'; ?>><br><br>
                </div>
                <div style="height:5px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_png_lossless; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_png_lossless"  class="form-control"  name="watermark_by_sitecreator_webp_png_lossless" <?php if(!empty($webp_png_lossless)) echo 'checked'; ?>><br><br>
                </div>
                <div style="height:5px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_webp_white_png_gd; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_white_png_gd"  class="form-control"  name="watermark_by_sitecreator_webp_white_png_gd" <?php if(!empty($webp_white_png_gd)) echo 'checked'; ?>><br><br>
                </div>
              </div>
              <div class="form-group" style="display: none;">
                <label  class="col-sm-4 control-label"><?php echo $text_webp_create_only; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_create_only"  class="form-control"  name="watermark_by_sitecreator_webp_create_only" <?php if(!empty($webp_create_only)) echo 'checked'; ?>><br><br>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_webp_for_tag_a; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_for_tag_a"  class="form-control"  name="watermark_by_sitecreator_webp_for_tag_a" <?php if(!empty($webp_for_tag_a)) echo 'checked'; ?>><br><br>
                </div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_for_data_attr; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_for_data_attr"  class="form-control"  name="watermark_by_sitecreator_webp_for_data_attr" <?php if(!empty($webp_for_data_attr)) echo 'checked'; ?>><br><br>
                </div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_for_js; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_for_js"  class="form-control"  name="watermark_by_sitecreator_webp_for_js" <?php if(!empty($webp_for_js)) echo 'checked'; ?>><br><br>
                </div>
              </div>
              <div class="form-group" style="" title="">

                <?php
                if(!empty($nitro)) {?>
                  <div class="col-sm-4" style="border: 1px solid green; padding: 8px 12px; margin-left: 15px;">
                    <?php echo $text_nitro;
                  if (!empty($nitroModSitecreator)) echo $text_nitroModSitecreatorON;
                  else echo $text_nitroModSitecreatorOFF;?>
                 </div>
                <?php }?>



                <div style="height:5px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_if_universal_cache; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-if_universal_cache"  class="form-control"  name="watermark_by_sitecreator_if_universal_cache" <?php if(!empty($if_universal_cache)) echo 'checked'; ?>><br><br>
                </div>
                <div style="height:5px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_if_js_optimized; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-if_js_optimized"  class="form-control"  name="watermark_by_sitecreator_if_js_optimized" <?php if(!empty($if_js_optimized)) echo 'checked'; ?>><br><br>
                </div>

              </div>
              <div class="form-group">

                <label  class="col-sm-4 control-label"><?php echo $text_img_output_google_compatibility; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-img_output_google_compatibility"  class="form-control"  name="watermark_by_sitecreator_img_output_google_compatibility" <?php if(!empty($img_output_google_compatibility)) echo 'checked'; ?>><br><br>
                </div>

              </div>
              <div class="form-group">

                <label  class="col-sm-4 control-label"><?php echo $text_webp_additional; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_additional"  class="form-control"  name="watermark_by_sitecreator_webp_additional" <?php if(!empty($webp_additional)) echo 'checked'; ?>><br><br>
                </div>

              </div>
              <div class="form-group">

                <label  class="col-sm-4 control-label"><?php echo $text_webp_recreate_input_file; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_recreate_input_file"  class="form-control"  name="watermark_by_sitecreator_webp_recreate_input_file" <?php if(!empty($webp_recreate_input_file)) echo 'checked'; ?>><br><br>
                </div>
                <div style="height:5px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_recreate_input_file_force; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_recreate_input_file_force"  class="form-control"  name="watermark_by_sitecreator_webp_recreate_input_file_force" <?php if(!empty($webp_recreate_input_file_force)) echo 'checked'; ?>><br><br>
                </div>

              </div>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_webp_fly_mode; ?></label>
                <div class="col-sm-8">
                  <select id="input-webp_fly_mode"  class="form-control"  name="watermark_by_sitecreator_webp_fly_mode">
                    <option value="0" <?php if(empty($webp_fly_mode) || $webp_fly_mode == "0") echo 'selected';  ?>>Не создавать</option>
                    <option value="1" <?php if(!empty($webp_fly_mode) && ($webp_fly_mode == "1" || $webp_fly_mode == '2')) echo 'selected';  ?> title="Универсальный режим, для  кеширующих ускорителей желательна очистка кеша перед стартом создания webp.">Форсированный НА ЛЕТУ</option>
                    <option style="" title=""  value="3" <?php if(!empty($webp_fly_mode) && $webp_fly_mode == "3") echo 'selected';  ?>>По расписанию (CRON)</option>
                  </select>
                </div>
                <div style="height:10px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_start_max; ?></label>
                <div class="col-sm-8">
                  <select id="input-webp_start_max"  class="form-control"  name="watermark_by_sitecreator_webp_start_max">
                    <option title="" value="15" <?php if(isset($webp_start_max) && $webp_start_max == "15") echo 'selected';  ?>>15</option>
                    <option title="" value="30" <?php if(!empty($webp_start_max) && $webp_start_max == "30") echo 'selected';  ?>>30</option>
                    <option title="" value='50' <?php if(!empty($webp_start_max) && $webp_start_max == '50') echo 'selected';  ?>>50</option>
                    <option title="" value="75" <?php if(!empty($webp_start_max) && $webp_start_max == "75") echo 'selected';  ?>>75</option>
                    <option title="Значение по умолчанию" value="100" <?php if(!isset($webp_start_max) || $webp_start_max == "100") echo 'selected';  ?>>100</option>
                    <option title="" value="150" <?php if(!empty($webp_start_max) && $webp_start_max == "150") echo 'selected';  ?>>150</option>
                    <option title="" value="250" <?php if(!empty($webp_start_max) && $webp_start_max == "250") echo 'selected';  ?>>250</option>
                    <option title="" value="500" <?php if(!empty($webp_start_max) && $webp_start_max == "500") echo 'selected';  ?>>500</option>
                  </select>
                </div>

                <div style="height:10px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_start_max_cron; ?></label>
                <div class="col-sm-8">
                  <select id="input-webp_start_max_cron"  class="form-control"  name="watermark_by_sitecreator_webp_start_max_cron">
                    <option title="" value="100" <?php if(isset($webp_start_max_cron) && $webp_start_max_cron == "100") echo 'selected';  ?>>100</option>
                    <option title="Значение по умолчанию" value="500" <?php if(!isset($webp_start_max_cron) || $webp_start_max_cron == "500") echo 'selected';  ?>>500</option>
                    <option title="" value='1000' <?php if(!empty($webp_start_max_cron) && $webp_start_max_cron == '1000') echo 'selected';  ?>>1000</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
              <label  class="col-sm-4 control-label"><?php echo $text_webp_mode; ?></label>
                <div class="col-sm-8">
                  <select id="input-webp_mode"  class="form-control"  name="watermark_by_sitecreator_webp_mode">
                    <option value="cwebp" <?php if(empty($webp_mode) || $webp_mode == "cwebp") echo 'selected';  ?>>cwebp ПРЕДПОЧТИТЕЛЬНО</option>
                    <option value="imagick" <?php if(!empty($webp_mode) && $webp_mode == "imagick") echo 'selected';  ?>>imagick</option>
                    <option title="Осторожно! GD может некорректно создавать webp.  Все зависит от версии GD. Проверяйте визуально!" style="color:red;" value='gd' <?php if(!empty($webp_mode) && $webp_mode == 'gd') echo 'selected';  ?>>gd !!! Осторожно!!!</option>
                    <option value="http_cwebp" <?php if(!empty($webp_mode) && $webp_mode == "http_cwebp") echo 'selected';  ?>>http_cwebp</option>
                  </select>
                </div>
                <div style="height:10px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_m_level; ?></label>
                <div class="col-sm-8">
                  <select id="input-webp_m_level"  class="form-control"  name="watermark_by_sitecreator_webp_m_level">
                    <option title="самый быстрый режим, но большой файл на выходе" value="0" <?php if(isset($webp_m_level) && $webp_m_level == "0") echo 'selected';  ?>>0 самый быстрый</option>
                    <option title="" value="1" <?php if(!empty($webp_m_level) && $webp_m_level == "1") echo 'selected';  ?>>1 быстрый</option>
                    <option title="" value='2' <?php if(!empty($webp_m_level) && $webp_m_level == '2') echo 'selected';  ?>>2 быстрый</option>
                    <option title="" value="3" <?php if(!empty($webp_m_level) && $webp_m_level == "3") echo 'selected';  ?>>3 средний</option>
                    <option style="color:#06a816;" title="баланс между скоростью работы и оптимальным весом выходного файла" value="4" <?php if(!isset($webp_m_level) || $webp_m_level == "4") echo 'selected';  ?>>4 ОПТИМАЛЬНЫЙ</option>
                    <option title="" value="5" <?php if(!empty($webp_m_level) && $webp_m_level == "5") echo 'selected';  ?>>5 средний</option>
                    <option title="очень медленный режим, но самый малый файл на выходе" value="6" <?php if(!empty($webp_m_level) && $webp_m_level == "6") echo 'selected';  ?>>6 медленный</option>
                  </select>
                </div>

              </div>
              <?php if(!empty($config_compression_warning)) { ?>
              <div class="form-group" style="padding: 15px;">
              <?php  echo $config_compression_warning;   ?>
              </div>
              <?php }?>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_no_check_htaccess; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-no_check_htaccess"  class="form-control"  name="watermark_by_sitecreator_no_check_htaccess" <?php if(!empty($no_check_htaccess)) echo 'checked'; ?>>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_webp_exception; ?></label>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_for_only_full_html5; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_for_only_full_html5"  class="form-control"  name="watermark_by_sitecreator_webp_for_only_full_html5" <?php if(!empty($webp_for_only_full_html5)) echo 'checked'; ?>>
                </div>
              </div>

              <div class="form-group">
                <div  class="col-sm-4 header_stcrtr">Lazy Load (отложенная загрузка изображений)</div><div class="col-sm-8 header2_stcrtr"></div>
                <div style="height:15px; clear: both;"></div>
                <label style="text-align:left;"  class="col-sm-4 control-label"><?php echo $text_lazy_load_pro; ?></label>
                <div style="height:10px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_lazy_load; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-lazy_load"  class="form-control"  name="watermark_by_sitecreator_lazy_load" <?php if(!empty($lazy_load)) echo 'checked'; ?>>
                </div>
                <div style="height:10px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_lazyload_type; ?></label>
                <div class="col-sm-8">
                  <select id="input-lazyload_type"  class="form-control"  name="watermark_by_sitecreator_lazyload_type">
                    <option title="Нативный. Потенциально устойчивый к багам во взаимодействии  с другим JavaScript"
                            value="loadingLazy" <?php if(!isset($lazyload_type) || $lazyload_type == "loadingLazy") echo 'selected';  ?>>loading="lazy" decoding="async"</option>
                    <option title="работает в любом браузере. При возникновении визуального конфликта выбирайте другой способ."
                            value="JSonly" <?php if(!empty($lazyload_type) && $lazyload_type == "JSonly") echo 'selected';  ?>>JavaScript</option>
                    </select>
                </div>
                <div style="height:10px; clear: both;"></div>
                  <label  class="col-sm-4 control-label"><?php echo $text_lazy_load_alt_js; ?></label>
                  <div class="col-sm-8">
                    <input type="checkbox" id="input-lazy_load_alt_js"  class="form-control"  name="watermark_by_sitecreator_lazy_load_alt_js" <?php if(!empty($lazy_load_alt_js)) echo 'checked'; ?>>
                  </div>
                <div style="height:10px; clear: both;"></div>
                <div style="">
                  <label style="display:none;" class="col-sm-4 control-label"><?php echo $text_lazy_wait_img; ?></label>
                  <div style="display:none;" class="col-sm-8">
                    <input disabled="" style="margin-top: 5px;" type="checkbox" id="input-lazy_wait_img"  class="form-control"  name="watermark_by_sitecreator_lazy_wait_img" <?php if(!empty($lazy_wait_img)) echo 'checked'; ?>>
                  </div>
                  <div style="height:10px; clear: both;"></div>
                  <label  class="col-sm-4 control-label"><?php echo $text_lazyload_wait_img_type; ?></label>
                  <div class="col-sm-8">
                    <select id="input-lazyload_wait_img_type"  class="form-control"  name="watermark_by_sitecreator_lazyload_wait_img_type">
                      <option title="Наиболее универсальный способ, гарантирующий отсутствие искажений размеров, но не всегда самый быстрый. Атрибуты width, height не выставляются."
                              value="svg" <?php if(!isset($lazyload_wait_img_type) || $lazyload_wait_img_type == "svg") echo 'selected';  ?>>SVG внутри HTML</option>
                      <option title="width, height выставляются для точного и быстрого рендеринга страницы. ПРЕДПОЧТИТЕЛЬНЫЙ способ, но если нет визуальных искажений размеров."
                              value="png" <?php if(!empty($lazyload_wait_img_type) && $lazyload_wait_img_type == "png") echo 'selected';  ?>>PNG с атрибутами width, height</option>
                      <option title="width, height выставляются, но после загрузки основного изображения  удаляются.
Это бывает полезно если верстка страницы сделана неидеально и есть конфликт с CSS, конфликт определяется  визуально в виде искажения размеров."
                              value='png_without_w_h' <?php if(!empty($lazyload_wait_img_type) && $lazyload_wait_img_type == 'png_without_w_h') echo 'selected';  ?>>PNG с атр. width, height с удалением</option>
                    </select>
                  </div>
                  <div style="height:10px; clear: both;"></div>
                  <label  class="col-sm-4 control-label"><?php echo $text_owl2_not_optimize; ?></label>
                  <div class="col-sm-8">
                    <input type="checkbox" id="input-owl2_not_optimize"  class="form-control"  name="watermark_by_sitecreator_owl2_not_optimize" <?php if(!empty($owl2_not_optimize)) echo 'checked'; ?>>
                  </div>
                </div>


              </div>



              <div class="form-group <?php if(empty($licExt1)) echo 'plugin_disable';  ?>"  <?php if(empty($licExt1)) echo 'style="background: #eaeaea;"';  ?> >
                <div  class="col-sm-4 header_stcrtr header_color3">Работа с фоном ИСХОДНИКА.<br>экспериментально ("как есть").<br>(нужен imagick)
                </div>
                <div class="col-sm-8 header2_stcrtr">
                  <a class="toggle_block" id="background_group_click" href="#" onclick="return false;">
                    <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Показать / скрыть параметры &nbsp;<i class="fa fa-eye-slash" aria-hidden="true"></i></a></div>
  <div style="height:10px; clear: both;"></div>
                <div class="lic_alert"><?php if(empty($licExt1)) echo 'Плагин <b>НЕАКТИВЕН</b>. Для активации функций необходим ключ, приобретается отдельно.';
                  else echo 'Плагин АКТИВЕН (лицензия подтверждена)'; ?></div>

              <label  class="col-sm-4 control-label"><?php echo $text_enable_trim; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?> type="checkbox" id="input-enable_trim"  class="form-control"  name="watermark_by_sitecreator_enable_trim" <?php if(!empty($enable_trim) && !empty($licExt1)) echo 'checked'; ?>>
              </div>

              <div style="height:15px; clear: both;"></div>

              <div style="padding: 0 15px;">
              <div id="background_group_before" class="form-group half_hidden">
              <label class="col-sm-4 control-label"><?php echo $text_fuzz; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  style="" type="text" id="input-fuzz" pattern="^[0-9]{1,6}$" class="form-control" name="watermark_by_sitecreator_fuzz" value="<?php echo $fuzz; ?>">
                <br></div>
                <div style="height:15px; clear: both;"></div>
              </div>
              </div>
                <div style="display:none;" id="background_group">
    <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_trim_cache; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-trim_cache"  class="form-control"  name="watermark_by_sitecreator_trim_cache" <?php if(!empty($trim_cache)) echo 'checked'; ?>>
                </div>


                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_enable_multitrim; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-enable_multitrim"  class="form-control"  name="watermark_by_sitecreator_enable_multitrim" <?php if(!empty($enable_multitrim)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label class="col-sm-4 control-label"><?php echo $text_trim_border; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  style="" type="text" id="input-trim_border" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_trim_border" value="<?php echo $trim_border; ?>">
                <br></div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_border_after_trim1; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-border_after_trim1"  class="form-control"  name="watermark_by_sitecreator_border_after_trim1" <?php if(!empty($border_after_trim1)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_enable_color_for_fill; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-enable_color_for_fill"  class="form-control"  name="watermark_by_sitecreator_enable_color_for_fill" <?php if(!empty($enable_color_for_fill)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_enable_border_fill; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-enable_border_fill"  class="form-control"  name="watermark_by_sitecreator_enable_border_fill" <?php if(!empty($enable_border_fill)) echo 'checked'; ?>>
              </div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_trim_maxi_w_and_h; ?></label>

                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="text" id="input-trim_maxi_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_trim_maxi_w" value="<?php echo $trim_maxi_w; ?>">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="text" id="input-trim_maxi_h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_trim_maxi_h" value="<?php echo $trim_maxi_h; ?>">
                </div>

                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_trim_mini_w_and_h; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="text" id="input-trim_mini_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_trim_mini_w" value="<?php echo $trim_mini_w; ?>">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="text" id="input-trim_mini_h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_trim_mini_h" value="<?php echo $trim_mini_h; ?>">
                </div>

    </div>
  <div class="form-group"  <?php if(empty($licExt1)) echo 'style="background: #eaeaea;"';  ?> >

    <div class="col-sm-4 control-label"><?php echo $text_dirs_noTrim; ?></div>
    <div class="col-sm-8">
                  <textarea class="form-control dirs" name="watermark_by_sitecreator_dirs_noTrim" id="input-dirs_noTrim" <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?> ><?php
                    //echo implode("\n",$dirs_noTrim);
                    echo $dirs_noTrim_implode;
                    ?></textarea>
    </div>
  </div>
  <div class="form-group" <?php if (empty($dirs_error_noTrim) || empty($licExt1)) echo 'style="display: none;"'; ?>>
    <label class="col-sm-4 control-label"><?php echo $text_dirs_error_noTrim; ?></label>
    <div class="col-sm-8">
      <textarea disabled="disabled" class="form-control dirs dirs_error"  id="dirs_error_noTrim"><?php echo $dirs_error_noTrim_implode; ?></textarea>
    </div>
  </div>
</div>
              </div>
              <div class="form-group">
                <div style="background: #7a7a7a;"  class="col-sm-4 header_stcrtr">Разное</div><div class="col-sm-8 header2_stcrtr"></div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_disable_admin_bar; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-disable_admin_bar"  class="form-control"  name="watermark_by_sitecreator_disable_admin_bar" <?php if(!empty($disable_admin_bar)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_white_back; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-white_back"  class="form-control"  name="watermark_by_sitecreator_white_back" <?php if(!empty($white_back)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_no_image; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-no_image"  class="form-control"  name="watermark_by_sitecreator_no_image" <?php if(!empty($no_image)) echo 'checked'; ?>>
              </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_crop_by_theme; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-crop_by_theme"  class="form-control"  name="watermark_by_sitecreator_crop_by_theme" <?php if(!empty($crop_by_theme)) echo 'checked'; ?>>
              </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_secretpath; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-secretpath"  class="form-control"  name="watermark_by_sitecreator_secretpath" <?php if(!empty($secretpath)) echo 'checked'; ?>>
              </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_remove_trash_disable; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-remove_trash_disable"  class="form-control"  name="watermark_by_sitecreator_remove_trash_disable" <?php if(!empty($remove_trash_disable)) echo 'checked'; ?>>
                </div>

              </div>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_enable_market; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-enable_market"  class="form-control"  name="watermark_by_sitecreator_enable_market" <?php if(!empty($enable_market)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_market_w_and_h; ?></label>
                <div class="col-sm-8">
                  <input   type="text" id="input-market_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_market_w" value="<?php echo $market_w; ?>">
                  <input   type="text" id="input-market_h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_market_h" value="<?php echo $market_h; ?>">
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_crop; ?></label>
                <div class="col-sm-8">
                  <select id="input-crop"  class="form-control"  name="watermark_by_sitecreator_crop_type">
                    <option value="" <?php if(empty($crop_type) || $crop_type == 'none') echo 'selected';  ?>>none - нет</option>
                    <option value="w" <?php if($crop_type == 'w') echo 'selected';  ?>>w - уместить по ширине (обрезать по высоте)</option>
                    <option value="h" <?php if($crop_type == 'h') echo 'selected';  ?>>h - уместить по высоте (обрезать по ширине)</option>
                    <option value="auto" <?php if($crop_type == 'auto') echo 'selected';  ?>>auto - автоматически выбрать сторону обрезки</option>
                    <option value="nocrop" <?php if($crop_type == 'nocrop') echo 'selected';  ?>>no crop - НЕ обрезать, БЕЗ полей (уместить по ширине, высота не ограничена)</option>
                  </select>

                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_img_custom_background_color; ?></label>
                <div class="col-sm-8">
                  <input  title="" id="input-ColorPickerText" maxlength="6" style="vertical-align:top;"  type="text" pattern="^[\dabcdefABCDEF]{6}$" class="form-control"  name="watermark_by_sitecreator_img_custom_background_color" value="<?php echo $img_custom_background_color; ?>">
                  <input  title="" id="input-ColorPickerStcrtr" type="color" style="height: 35px; width: 110px; padding: 0; border: 1px solid #d7d7d7; box-sizing: border-box; vertical-align:top;" value="#<?php echo $img_custom_background_color; ?>">
                </div>
              </div>

              <div class="form-group">
                <div style="background: #cc423d;" class="col-sm-4 header_stcrtr">Отладка (DeBugging)</div><div class="col-sm-8 header2_stcrtr"></div>
                <div style="height:15px; clear: both;"></div>
                <div class="warning_stcrtr"><?php echo $text_debug_warning; ?></div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_show_webpimage_time; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-show_webpimage_time"  class="form-control"  name="watermark_by_sitecreator_show_webpimage_time" <?php if(!empty($show_webpimage_time)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_image_error_output; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-image_error_output"  class="form-control"  name="watermark_by_sitecreator_image_error_output" <?php if(!empty($image_error_output)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_debug_enable; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-debug_enable"  class="form-control"  name="watermark_by_sitecreator_debug_enable" <?php if(!empty($debug_enable)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_debug_echo_in_public; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-debug_echo_in_public"  class="form-control"  name="watermark_by_sitecreator_debug_echo_in_public" <?php if(!empty($debug_echo_in_public)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
              </div>



              <div class="form-group" style="background-color: #defdff;">
                <div  class="col-sm-4 header_stcrtr">Для изображения в СПИСКЕ ТОВАРОВ</div><div class="col-sm-8 header2_stcrtr"><?php echo "(<span style='font-size: 12px;'>theme size/ задано в шаблоне:</span> $image_product_width x ". $image_product_height.')'; ?></div>
                <div style="height:15px; clear: both;"></div>
                <div class="warning_stcrtr"><?php echo $text_warning_for_product_img; ?></div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_for_product_img_noborder; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_product_img_noborder"  class="form-control"  name="watermark_by_sitecreator_for_product_img_noborder" <?php if(!empty($for_product_img_noborder)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_for_product_img_fit_to_width_nocrop; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_product_img_fit_to_width_nocrop"  class="form-control"  name="watermark_by_sitecreator_for_product_img_fit_to_width_nocrop" <?php if(!empty($for_product_img_fit_to_width_nocrop)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_for_product_img_no_max_fit; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_product_img_no_max_fit"  class="form-control"  name="watermark_by_sitecreator_for_product_img_no_max_fit" <?php if(!empty($for_product_img_no_max_fit)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_for_product_img_white_back; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_product_img_white_back"  class="form-control"  name="watermark_by_sitecreator_for_product_img_white_back" <?php if(!empty($for_product_img_white_back)) echo 'checked'; ?>>
                </div>
              </div>

              <div class="form-group" style="background-color: #edf6ff;">
               <div  class="col-sm-4 header_stcrtr">Для ВСПЛЫВАЮЩЕГО изображения</div><div class="col-sm-8 header2_stcrtr"><?php echo "(<span style='font-size: 12px;'>theme size/ задано в шаблоне:</span> $image_popup_width x ". $image_popup_height.')'; ?></div>
              <div style="height:15px; clear: both;"></div>

              <label  class="col-sm-4 control-label"><?php echo $text_for_popup_img_noborder; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_popup_img_noborder"  class="form-control"  name="watermark_by_sitecreator_for_popup_img_noborder" <?php if(!empty($for_popup_img_noborder)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_for_popup_img_fit_to_width_nocrop; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_popup_img_fit_to_width_nocrop"  class="form-control"  name="watermark_by_sitecreator_for_popup_img_fit_to_width_nocrop" <?php if(!empty($for_popup_img_fit_to_width_nocrop)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_for_popup_img_no_max_fit; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_popup_img_no_max_fit"  class="form-control"  name="watermark_by_sitecreator_for_popup_img_no_max_fit" <?php if(!empty($for_popup_img_no_max_fit)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_for_popup_img_white_back; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-for_popup_img_white_back"  class="form-control"  name="watermark_by_sitecreator_for_popup_img_white_back" <?php if(!empty($for_popup_img_white_back)) echo 'checked'; ?>>
              </div>
              </div>
          <div class="form-group" style="background-color: #defdff;">
            <div  class="col-sm-4 header_stcrtr">Для THUMBNAIL изображения</div><div class="col-sm-8 header2_stcrtr"><?php echo "(<span style='font-size: 12px;'>theme size/ задано в шаблоне:</span> $image_thumb_width x ". $image_thumb_height.')'; ?></div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_for_thumb_img_noborder; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-for_thumb_img_noborder"  class="form-control"  name="watermark_by_sitecreator_for_thumb_img_noborder" <?php if(!empty($for_thumb_img_noborder)) echo 'checked'; ?>>
          </div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_for_thumb_img_fit_to_width_nocrop; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-for_thumb_img_fit_to_width_nocrop"  class="form-control"  name="watermark_by_sitecreator_for_thumb_img_fit_to_width_nocrop" <?php if(!empty($for_thumb_img_fit_to_width_nocrop)) echo 'checked'; ?>>
          </div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_for_thumb_img_no_max_fit; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-for_thumb_img_no_max_fit"  class="form-control"  name="watermark_by_sitecreator_for_thumb_img_no_max_fit" <?php if(!empty($for_thumb_img_no_max_fit)) echo 'checked'; ?>>
          </div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_for_thumb_img_white_back; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-for_thumb_img_white_back"  class="form-control"  name="watermark_by_sitecreator_for_thumb_img_white_back" <?php if(!empty($for_thumb_img_white_back)) echo 'checked'; ?>>
          </div>
        </div>


        <div class="form-group">
          <div  class="col-sm-4 header_stcrtr">WATERMARK: настройки</div>
          <div class="col-sm-8 header2_stcrtr"><a class="toggle_block" id="watermark_group_click" href="#" onclick="return false;">
              <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Показать / скрыть параметры &nbsp;<i class="fa fa-eye-slash" aria-hidden="true"></i></a></div>
        <div style="height:15px; clear: both;"></div>

        <label class="col-sm-4 control-label" for="input-status"><?php echo $entry_status; ?></label>
        <div class="col-sm-8">
          <input type="checkbox" id="input-status"  class="form-control"  name="watermark_by_sitecreator_status" <?php if(!empty($status)) echo 'checked'; ?>>
          <input value="0" hidden name="noclose" id="noclose">
        </div>
      </div>
      <div style="height:15px; clear: both;"></div>

              <div id="watermark_group_before" class="form-group half_hidden">
                <label class="col-sm-4 control-label"><?php echo $text_img_min_width_nowatermark; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-min_width" pattern="^[0-9]{1,6}$" class="form-control"  name="watermark_by_sitecreator_min_width" value="<?php echo $min_width; ?>">
                </div>
              </div>
        <div style="display: none;" id="watermark_group">
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_img_max_width_nowatermark; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-max_width" pattern="^[0-9]{1,6}$" class="form-control"  name="watermark_by_sitecreator_max_width" value="<?php echo $max_width; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_img; ?></label>
                <div class="col-sm-8" id="div-input-image"><a style="position:relative;" href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="watermark_by_sitecreator_image" value="<?php echo $image; ?>" id="input-image" />
                  <br><button onclick=" loadTestImg();" title="Загрузить тестовое изображение для водяного знака" type="button" class="btn stcrtr_btn">load test-watermark</button>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_posx; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_posx" value="<?php echo $posx; ?>" id="input-posx" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_posy; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_posy" value="<?php echo $posy; ?>" id="input-posy" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_degree; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_degree" value="<?php echo $degree; ?>" id="input-degree" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_width; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_width" value="<?php echo $width; ?>" id="input-width" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_height; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_height" value="<?php echo $height; ?>" id="input-height" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_opacity; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_opacity" value="<?php echo $opacity; ?>" id="input-opacity" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_test; ?></label>
                <div class="col-sm-8">
                  <div id="watermark_test_warning" style="width:252px; height:252px; position:relative; padding: 10px;"><?php echo $text_watermark_test_error; ?><a  title="Кликните для увеличения" href="" style="position: absolute; top:0; left:0;" class="watermark-big-img" id="watermark-big-img"><img src="" style="width: 250px; height: 250px; border: solid 1px #eeeeee; padding: 1px" id="watermarkTestImg"></a></div><br>
                  <button title="Если при изменении параметров не обновилась картинка, то кликните" type="button" onclick=" watermarkPreview(); return false;" class="btn btn-test" >Test</button>
                  <button type="button" title="Сброс настроек WATERMARK в оптимальное состояние" onclick=" watermarkReset(); return false;" class="btn btn-test" >Reset WATERMARK settings</button>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 control-label"><?php echo $text_watermark_dirs; ?></div>
                <div class="col-sm-8">
                  <textarea class="form-control dirs" name="watermark_by_sitecreator_dirs" id="input-dirs"><?php
                    echo $dirs_implode;
                    ?></textarea>
                </div>
              </div>
              <div class="form-group" <?php if (empty($dirs_error)) echo 'style="display: none;"'; ?>>
                <label class="col-sm-4 control-label"><?php echo $text_watermark_dirs_error; ?></label>
                <div class="col-sm-8">
                  <textarea disabled="disabled" class="form-control dirs dirs_error"  id="dirs_error"><?php echo $dirs_error_implode; ?></textarea>
                </div>
              </div>
            </div>
              <div class="form-group <?php if(empty($lic_market)) echo 'market_lite'; else echo 'market_full' ?>">
                <div  class="col-sm-4 header_stcrtr header_color4">Параметры для экспорта в Яндекс-Маркет и т.п.</div><div class="col-sm-8 header2_stcrtr">
                  <a class="toggle_block" id="market_group_click" href="#" onclick="return false;">
                    <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Показать / скрыть параметры &nbsp;<i class="fa fa-eye-slash" aria-hidden="true"></i></a></div>
                <div style="height:5px; clear: both;"></div>
                <div class="lic_alert"><?php if(empty($lic_market)) echo 'Плагин работает в режиме <b style="color: red">"Lite"</b>.<b> Возможности ограничены.</b> Для активации ВСЕХ функций необходим ключ, приобретается отдельно.';
                  else echo 'Плагин АКТИВЕН (лицензия подтверждена)'; ?></div>
                <label  class="col-sm-4 control-label market_lite"><?php echo $text_market_img_quality; ?></label>
                <div class="col-sm-8">
                  <input style="border: 1px solid #0c942c; background: #e1f8e3; color: #000" type="text" id="input-market_quality" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_market_quality" value="<?php echo $market_quality; ?>">
                  <br></div>
                <div style="height:0px; clear: both;"></div>
                <div id="market_group_before" class="my-form-group">
                <label  class="col-sm-4 control-label market_lite"><?php echo $text_market_watermark_enable; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-market_watermark_enable"  class="form-control"  name="watermark_by_sitecreator_market_watermark_enable" <?php if(!empty($market_watermark_enable)) echo 'checked'; ?>>
                </div>
                </div>
                <div id="market_group">
                  <div class="form-group my-form-group">
                    <label  class="col-sm-4 control-label"><?php echo $text_market_override_image_size; ?></label>
                    <div class="col-sm-8">
                      <input type="checkbox" id="input-market_override_image_size"  class="form-control"  name="watermark_by_sitecreator_market_override_image_size" <?php if(!empty($market_override_image_size)) echo 'checked'; ?>>
                    </div>
                    <div style="height:15px; clear: both;"></div>
                    <label class="col-sm-4 control-label"><?php echo $text_market_set_image_size; ?></label>
                    <div class="col-sm-8">
                      <input   type="text" id="input-market_image_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_market_image_w" value="<?php echo $market_image_w; ?>">
                      <input   type="text" id="input-market_image__h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_market_image_h" value="<?php echo $market_image_h; ?>">
                    </div>
                  </div>
                  <div class="form-group my-form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_market_image_generate_disable; ?></label>
                <div class="col-sm-8">
                  <input title="ЗАРЕЗЕРВИРОВАНО ДЛЯ СЛЕДУЮЩЕЙ ВЕРСИИ" disabled="disabled" type="checkbox" id="input-market_image_generate_disable"  class="form-control"  name="watermark_by_sitecreator_market_image_generate_disable" <?php if(!empty($market_image_generate_disable)) echo 'checked'; ?>>
                </div>
                  </div>
                  <div class="form-group my-form-group" style="border-bottom:0;">
                    <label  class="col-sm-4 control-label"><?php echo $text_market_stickers_enable; ?></label>
                    <div class="col-sm-8">
                      <input type="checkbox" id="input-market_stickers_enable"  class="form-control"  name="watermark_by_sitecreator_market_stickers_enable" <?php if(!empty($market_stickers_enable)) echo 'checked'; ?>>
                    </div>
                  </div>
                  <div class="form-group my-form-group">
                    <label  class="col-sm-4 control-label"><?php echo $text_market_stickers_source_text; ?></label>
                    <div class="col-sm-8">
                      <select id="input-ind_for_market_text"  class="form-control"  name="watermark_by_sitecreator_ind_for_market_text">
                        <option value='upc' <?php if(empty($ind_for_market_text) || $ind_for_market_text == 'upc') echo 'selected';  ?>>upc</option>
                        <option value='ean' <?php if(!empty($ind_for_market_text) && $ind_for_market_text == 'ean') echo 'selected';  ?>>ean</option>
                        <option value='jan' <?php if(!empty($ind_for_market_text) && $ind_for_market_text == 'jan') echo 'selected';  ?>>jan</option>
                        <option value='isbn' <?php if(!empty($ind_for_market_text) && $ind_for_market_text == 'isbn') echo 'selected';  ?>>isbn</option>
                        <option value='mpn' <?php if(!empty($ind_for_market_text) && $ind_for_market_text == 'mpn') echo 'selected';  ?>>mpn</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group my-form-group  my_last"><div class="col-sm-12"><div class="ya_market_desc"><?php echo $text_ya_market_desc; ?></div>
                    </div>
                  </div>
              </div>
              </div>
            </form>
            <div class="infoplus">
              <?php echo $text_warning; ?>
            </div>
          </div>
          <div class="panel-body tab-pane" id="tab-service">
            <div class="form-group">
              <label class="col-sm-12 control-label"><?php echo $text_img_info; ?><br><br>
              </label>
              <div id="soft_info" class="col-sm-12" style="min-height: 230px; border: 1px solid #ebebeb; padding: 10px 15px;">
                <?php echo $soft_info; ?>
              </div>
            </div>
            <div style="clear:both;  padding-bottom:15px;"></div>
            <div id="browser_info" class="col-sm-12" style=" border: 1px solid #ebebeb; padding: 10px 15px;"></div>
            <div style="clear:both; border-bottom:1px solid #e8e8e8; padding-bottom:15px; margin-bottom:15px;"></div>

            <div class="col-sm-4" style="min-width: 270px; padding-left:0;"><br>
              <label class="control-label"><?php echo $text_lic_info; ?></label>
              <div class="">
                <button id="lic_activate" type="button" class="btn  stcrtr_btn btn-typeLic" data-type="lic_activate" title="Активировать лицензию / Activate license">Активировать лиц. / Activate license</button><br>
                <button id="default_setting" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="default_setting" title="Привести настройки в исходное состояние (как до установки модуля). Лицензию нужно будет активировать заново.">Сбросить все настройки!</button><br>
              </div><br>
                <label class="control-label"><?php echo $text_info_os_extra; ?></label>
                <div class="">
                <button id="site_path" type="button" class="btn  stcrtr_btn btn-type2" data-type="site_path"> UNIX home dir &nbsp;&nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true" style="margin-right: 3px;"></i> name</button><br>
                <button id="phpinfo" type="button" class="btn  stcrtr_btn btn-type2" data-type="phpinfo"><i class="fa fa-info" aria-hidden="true"></i> php info</button><br>

                <button id="info_os" type="button" class="btn  stcrtr_btn btn-type2" data-type="info_os"><i class="fa fa-linux" aria-hidden="true"></i> <?php echo $text_info_os; ?></button><br>
                <button id="info_memcache" type="button" class="btn  stcrtr_btn btn-type2" data-type="info_memcache"><i class="fa fa-key" aria-hidden="true"></i> <?php echo $text_info_memcache; ?></button><br>
                <button id="info_ocmod" type="button" class="btn  stcrtr_btn btn-type2" data-type="info_ocmod" title="Модифицирет ли OCMOD файлы модуля? Перечислены модифицированные файлы."><i class="fa fa-file-code-o" aria-hidden="true"></i> <?php echo $text_info_ocmod; ?></button><br>
              </div>
              <br>
              <?php if(empty($oc15)) { ?>
              <label class="control-label"><?php echo $text_block_on_off_module; ?></label>
              <div class="">
                <button title="создание и вывод webp работает независимо" id="on_off_module" type="button" class="<?php echo $btn_onoff_css; ?>" data-type="on_off_module" title=""><?php echo $btn_onoff_content; ?></button><br>
                <button title="создание и вывод webp работает независимо от основного модуля" id="on_off_webp_output" type="button" class="<?php echo $btn_onoff_webp_output_css; ?>" data-type="on_off_webp_output" title=""><?php echo $btn_onoff_webp_output_content; ?></button><br>

                <button title="админБар больше не поддерживается. Должен быть отключен если был соответствующий ocmod." id="on_off_adminbar" type="button" class="<?php echo $btn_onoff_adminbar_css; ?>" data-type="on_off_adminbar" title=""><?php echo $btn_onoff_adminbar_content; ?></button><br>

              </div>
              <br>
              <label class="control-label"><?php echo $text_block_on_off_ocmod_market; ?></label>
              <div class="">
                <button id="on_off_ocmod_market1" type="button" class="<?php echo $btn_onoff_ocmod_market1_css; ?>" data-type="on_off_ocmod_market1" title=""><?php echo $btn_on_off_ocmod_market1_content; ?></button><br>
                <button id="on_off_ocmod_market2" type="button" class="<?php echo $btn_onoff_ocmod_market2_css; ?>" data-type="on_off_ocmod_market2" title=""><?php echo $btn_on_off_ocmod_market2_content; ?></button><br>

              </div>
              <?php } ?>

    </div>
            <div class="col-sm-4" style="min-width: 270px; padding-left:0;"><br>
              <label class="control-label"><?php echo $text_clear_cache; ?></label>
              <div class="">
                <?php if(empty($oc15)) { ?>
                <button id="clear_ocmod" type="button" class="btn  stcrtr_btn btn-type2" data-type="ocmod" title="Обновить кеш модификаторов (кеш ocmod)"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $text_clear_ocmod; ?></button>
                <?php } ?>
                <button style="display:none;" disabled id="clear_img_no_mozjpeg_cache" type="button" class="btn  stcrtr_btn btn-type2" data-type="no_mozjpeg_image" title="Удалить файлы для тестирования: _no_mozjpeg_, _no_optipng_"><i class="fa fa-file-image-o"></i> <?php echo $text_clear_img_no_mozjpeg_cache; ?></button><br>
                <button id="clear_img_cache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="image" title="Удалить ВСЕ изображения из кеша КРОМЕ для маркета">
                  <i class="fa fa-file-image-o"></i> <?php echo $text_clear_img_cache; ?></button><br>
                <button id="clear_img_webp" type="button" class="btn btn-danger stcrtr_btn btn-type3" data-type="webp" title="Удалить ВСЕ WebP изображения из кеша">
                  <i class="fa fa-file-image-o"></i> WEBP</button><br>
                <button id="clear_img_market_cache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="market_image" title="Удалить только изображения для Яндекс-Маркета (из отдельной папки кеша DIR_IMAGE.'market_cache')">
                  <i class="fa fa-file-image-o"></i> <?php echo $text_clear_img_market_cache; ?></button><br>

                <button id="clear_system_cache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="system"><i class="fa fa-code"></i> <?php echo $text_clear_system_cache; ?></button><br>
                <button id="clear_turbocache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="turbo"><i class="fa fa-code"></i> <?php echo $text_clear_turbocache; ?></button><br>


                <button id="clear_memcache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="memcache"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $text_clear_memcache; ?></button><br>
                <button id="clear_all_memcache" type="button" class="btn btn-danger stcrtr_btn btn-type3" data-type="all_memcache"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $text_clear_all_memcache; ?></button><br><br>

              </div>
            </div>
            <div class="col-sm-4" style="min-width: 270px; padding-left:0;"><br>

              <div style="padding-bottom: 25px;" class="">
                <label class="control-label"><?php echo $text_webp_mode_test; ?></label><br>
                <select  id="webp_mode" class="form-control" style="max-width: 250px;" onchange="" title="WebP soft. Выбор  движка для создания WebP. Т.е. какая граф. библиотека или программа будет создавать WebP">
                  <option title="" value="gd">gd</option>
                  <option title="" value="imagick">imagick</option>
                  <option title="" selected="selected" value="cwebp">cwebp</option>
                  <option title="" value="http_cwebp">http_cwebp</option>
                </select><br>
                <select  id="webp_m_control" class="form-control" style="max-width: 250px;" onchange="" title="Актуально только для движка cwebp или http_cwebp. Быстро - большой файл. Медленно -маленький файл.">
                  <option title="Очень быстрый режим" value="0">0</option>
                  <option title="Очень быстрый режим" value="1">1</option>
                  <option title="Очень быстрый режим" value="2">2</option>
                  <option title="Быстрый режим" value="3">3</option>
                  <option title="Оптимальный режим" selected="selected" value="4">4</option>
                  <option title="Медленный режим." value="5">5</option>
                  <option title="Самый медленный режим." value="6">6</option>
                </select>
                <br>
                <select  id="webp_q_for_test" class="form-control" style="max-width: 250px;" onchange="" title="Качество WebP для тестов. В настройки магазина не записывается.  Используется исключительно для проведения теста.">
                  <option title="" value="70">70</option>
                  <option title="" value="75">75</option>
                  <option title="" selected="selected" value="80">80</option>
                  <option title="" value="85">85</option>
                  <option title="" value="90">90</option>

                </select>
                <button id="start_soft_test" type="button" class="btn  stcrtr_btn btn-type2" data-type="start_soft_test" title="Test"><i class="fa fa-plug" aria-hidden="true"></i> Soft Test & Info</button><br><br>
                <label class="control-label"><?php echo $text_extra_soft; ?></label><br>
                <button id="soft_link" type="button" class="btn  stcrtr_btn btn-type2" data-type="soft_link"><i class="fa fa-link" aria-hidden="true"></i> INFO: soft config & links</button><br>
                <button id="soft_link_del" type="button" class="btn btn-danger  stcrtr_btn btn-type2" data-type="soft_link_del" title="Удалить символьные ссылки на mozjpeg, optipng."><i class="fa fa-chain-broken" aria-hidden="true"></i> DELETE soft links</button><br><br>
                <label class="control-label"><?php echo $text_extra_soft_install; ?></label>
                <select disabled="disabled" id="soft_destination" class="form-control" style="display: none; visibility:hidden; max-width: 250px;" onchange="change_destination(this.value);" title="destination: cgi-bin OR Unix User Home Dir">
                  <option selected="selected" value="cgi-bin">cgi-bin</option>

                </select><br>
                <button id="mozjpeg_install" type="button" class="btn  stcrtr_btn btn-type4" data-type="mozjpeg_install" data-destination="cgi-bin" title="Установить софт в директорию"><i class="fa fa-magic" aria-hidden="true"></i> install MozJPEG (cgi-bin)</button><br>
                <button id="optipng_install" type="button" class="btn  stcrtr_btn btn-type4" data-type="optipng_install" data-destination="cgi-bin" title="Установить софт в директорию"><i class="fa fa-magic" aria-hidden="true"></i> install OptiPNG (cgi-bin)</button><br><br>
                <label class="control-label"><?php echo $text_cwebp_soft; ?></label>
                <select  id="cwebp_build" class="form-control" style="max-width: 250px;" onchange="" title="cWebP soft.  На верхней строчке самый производительный. На нижней - самый универсальный. Для Windows не имеет значения.">
                  <option title="Производительный вариант. Не работает на старых Linux." selected="selected" value="linux_3.10">cWebP soft for Linux core 3.10+</option>
                  <option selected title="Самый универсальный вариант. Работает на старых и новых Linux. Но наименее производительный." value="linux_2.6">cWebP soft for Linux core 2.6+</option>
                </select>
                <button id="webp_install" type="button" class="btn  stcrtr_btn btn-type4" data-type="webp_install" data-destination="cgi-bin" title="Установить софт в директорию"><i class="fa fa-magic" aria-hidden="true"></i> install cWebP soft (cgi-bin)</button><br>
<!--                <button id="http_webp_install" type="button" class="btn  stcrtr_btn btn-type4" data-type="http_webp_install" data-destination="cgi-bin" title="Установить софт в директорию"><i class="fa fa-magic" aria-hidden="true"></i> install HTTP_WebP soft (cgi-bin)</button><br><br>-->
                <br>

                <button id="del_mozjpeg" type="button" class="btn btn-danger  stcrtr_btn btn-type2" data-type="del_mozjpeg" data-destination="cgi-bin" title="Удалить MozJPEG."><i class="fa fa-times" aria-hidden="true"></i> DELETE MozJPEG (cgi-bin)</button><br>
                <button id="del_optipng" type="button" class="btn btn-danger  stcrtr_btn btn-type2" data-type="del_optipng" data-destination="cgi-bin" title="Удалить OptiPNG."><i class="fa fa-times" aria-hidden="true"></i> DELETE OptiPNG (cgi-bin)</button><br>
                <button id="del_cwebp" type="button" class="btn btn-danger  stcrtr_btn btn-type2" data-type="del_cwebp" data-destination="cgi-bin" title="Удалить WebP soft."><i class="fa fa-times" aria-hidden="true"></i> DELETE cWebP soft (cgi-bin)</button><br><br>

              </div>

            </div>
            <div style="clear:both;">
              <button onclick="$('#service_result').text('');" id="clear_textarea" type="button" class="btn  stcrtr_btn btn-type2" data-type="clear_textarea" title="Очистить окно вывода" style="min-width: 30px; text-align:center;"><i class="fa fa-eraser" aria-hidden="true"></i></button><br>

              <textarea style="height: 500px;" class="form-control dirs" id="service_result" readonly="readonly">info out</textarea>
              <button onclick="$('#service_result').text('');" id="clear_textarea" type="button" class="btn  stcrtr_btn btn-type2" data-type="clear_textarea" title="Очистить окно вывода" style="min-width: 30px; text-align:center;"><i class="fa fa-eraser" aria-hidden="true"></i></button><br>

            </div>
            <div style="clear:both;"><?php echo $text_warning; ?></div>
          </div>
          <div class="panel-body tab-pane" id="tab-theme">
            <label class="control-label" style="padding-right:25px;"><?php echo $text_compress_theme_jpeg_quality; ?></label><br>
            <input pattern="^[0-9]{1,3}$" class="form-control" type="text" name="theme_jpeg_quality" id="theme_jpeg_quality" value="80" style="max-width: 110px;"><br><br>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_compress_theme_optipng_level; ?></label><br>

              <select id="theme_optipng_level"  class="form-control"  name="theme_optipng_level">
                <option value=1 <?php if(empty($optipng_level) || $optipng_level == 1) echo 'selected';  ?>>1</option>
                <option value=2 <?php if($optipng_level == 2) echo 'selected';  ?>>2</option>
                <option value=3 <?php if($optipng_level == 3) echo 'selected';  ?>>3</option>
                <option value=4 <?php if($optipng_level == 4) echo 'selected';  ?>>4</option>
                <option value=5 <?php if($optipng_level == 5) echo 'selected';  ?>>5</option>
              </select>

            <div style="height:15px; clear: both;"></div>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_dir_for_compress; ?></label><br>
            <select class="form-control" id="dir_for_compress" name="dir_for_compress">
              <option value="theme" selected="selected">catalog/view/theme</option>
              <option value="javascript">catalog/view/javascript</option>
            </select><br><br>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_compress_theme; ?></label><br>
            <button style="margin-top:0;" id="compress_theme" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Compress</button><br>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_compress_logo; ?></label><br>
            <button style="margin-top:0;" id="compress_logo" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Compress LOGO</button><br><br>


            <label class="control-label" style=" padding-right:25px;"><?php echo $text_undu_compress_theme; ?></label><br>
            <button style="margin-top:0;" id="undu_compress_theme" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Undo</button><br>
            <label class="control-label" style=" padding-right:25px;"><?php echo $text_undu_compress_logo; ?></label><br>
            <button style="margin-top:0;" id="undu_compress_logo" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Undo 'Compress LOGO'</button><br><br>

            <label class="control-label" style="padding-right:25px;"><?php echo $text_del_copies_of_images; ?></label><br>
            <button style="margin-top:0;" id="del_copies_of_images" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="del_copies_of_images">DELETE copies of images</button><br>
            <div id="compress_theme_info"></div>

          </div>
          <div class="panel-body tab-pane" id="tab-cron">

            <?php echo $text_tab_cron_head; ?>


            <div class="cron_test_webp_on_off">
            <label class="control-label" style="max-width: 600px;"><?php if(!empty($text_cron_test_on_off)) echo  $text_cron_test_on_off; ?></label>
            <div>
              <fieldset style="display: inline-block; position:relative;" id="cron_test_webp_on_off">
              <input type="radio" id="cron_test_webp_on"
                     name="cron_test_webp_status" value="on" <?php if(!empty($cron_test_webp_on)) echo "checked"; ?>>
                <label for="cron_test_webp_on"><span style="color: #08911c;">On (Включено)</span></label>
              <br>
              <input type="radio" id="cron_test_webp_off"
                     name="cron_test_webp_status" value="off" <?php if(empty($cron_test_webp_on)) echo "checked"; ?>>
              <label for="cron_test_webp_off"><span style="color: #d61f00;">Off (Выключено)</span></label>
              </fieldset>
            </div>
            </div>
            <div class="cron_webplogo"><?php echo $text_webplogo; ?></div>
            <div style="height:10px; clear: both;"></div>
            <label  class="control-label"><?php echo $text_cron_webp_mode; ?></label>
            <div>
              <select id="input-cron_webp_mode"  class="form-control"  name="watermark_by_sitecreator_cron_webp_mode" form="form-watermark_by_sitecreator">
                <option value="test" <?php if(empty($cron_webp_mode) || $cron_webp_mode == "test") echo 'selected';  ?>>Тестовый</option>
                <option value="normal" <?php if(!empty($cron_webp_mode) && $cron_webp_mode == "normal") echo 'selected';  ?> title="Нормальный режим">Рабочий</option>
              </select>
            </div><br><br>


            <div style="max-width: 1000px;"><?php if(!empty($text_cron_test_input_img)) echo  $text_cron_test_input_img; ?></div>
            <div id="cron_test_input_imgs">
            <?php
            if(!empty($cron_test_input_img1)) {
              echo $cron_test_input_img1;
            }
            if(!empty($cron_test_input_img2)) {
              echo $cron_test_input_img2;
            }
            ?>
            </div>
            <button style="margin-top:0;" id="btn_cron_webp_test" type="button" class="btn  stcrtr_btn btn-type2" data-type="">cron WEBP test</button><br>
            <div style="max-width: 800px;"><?php if(!empty($text_cron_test_output_img)) echo  $text_cron_test_output_img; ?></div>
            <div id="cron_test_time"></div>
            <div style="min-height: 190px" id="cron_test_output_imgs"><br><span class="temp_txt">Здесь будет вывод созданных WEBP и вывод информации об ошибках.</span><br><?php echo $text_webplogo; ?></div>
            <button style="margin-top:0;" id="btn_cron_webp_test_clear_imgs" type="button" class="btn  stcrtr_btn btn-type2" data-type=""
                    title="<?php if(!empty($text_btn_cron_webp_test_clear_imgs_help)) echo  $text_btn_cron_webp_test_clear_imgs_help; ?>">УДАЛИТЬ результат теста</button><br>
            <div><?php if(!empty($text_btn_cron_webp_test_clear_imgs_help)) echo  $text_btn_cron_webp_test_clear_imgs_help; ?></div>
            <div id="text_cron_test_command"><?php if(!empty($text_cron_test_command)) echo  $text_cron_test_command; ?></div>

            <div class="cron_cmd_warning">
            <div class="cron_test_secret_key">
              <label class="control-label" style="max-width: 600px;"><?php if(!empty($text_cron_test_secret_key)) echo  $text_cron_test_secret_key; ?></label>
              <div>
                <input form="form-watermark_by_sitecreator" value="<?php if(!empty($cron_test_secret_key_value)) echo $cron_test_secret_key_value; ?>"  name="watermark_by_sitecreator_cron_test_secret_key_value" type="text" class="form-control" id="cron_test_secret_key" readonly></input>
                <button style="margin-top:0;" id="btn_cron_test_secret_key" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Create secret key</button>
              </div>
            </div>

            <div class="php_cli_path">
              <label class="control-label" style="max-width: 600px;"><?php if(!empty($text_php_cli_path)) echo  $text_php_cli_path; ?></label>
              <div>
                <input form="form-watermark_by_sitecreator" value="<?php if(!empty($php_cli_path_value)) echo $php_cli_path_value; ?>"  name="watermark_by_sitecreator_php_cli_path_value" type="text" class="form-control" id="php_cli_path"></input>
                <br><button style="margin-top:0;" id="btn_php_cli_path" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Создать команду cron</button>
              </div>
            </div>

            <div class="cron_test_command_for_site">
              <label class="control-label" style=""><?php if(!empty($text_cron_test_command_for_site)) echo  $text_cron_test_command_for_site; ?></label>
              <input id="cron_test_command_for_site" readonly  type="text" class="form-control" value='<?php if(!empty($cron_test_command_for_site)) echo  $cron_test_command_for_site; ?>'></div>
            <div class="text_cron_test_2"><?php if(!empty($text_cron_test_2)) echo  $text_cron_test_2; ?></div>
            </div>

              <div class="php_cli_test">
              <?php if(!empty($text_php_cli_test)) echo  $text_php_cli_test; ?>

                <label class="control-label"><?php if(!empty($text_php_cli_cmd)) echo  $text_php_cli_cmd; ?></label><br>
                <select id="input-php_cli_cmd"  class="form-control">

                  <option value="1">php -v</option>
                  <option value="2">php56 -v</option>
                  <option value="3">php70 -v</option>
                  <option value="4">php71 -v</option>
                  <option value="5">php72 -v</option>
                  <option value="6">/opt/php71/bin/php -v</option>
                  <option value="7">/usr/bin/php71 -v</option>
                  <option value="8" title="Выведет пути к различным версиям PHP">whereis php</option>

                  <option title="запуск скрипта для WEBP без ключа"
                          value="9">php ".../cli-php/sitecreator/cron_test_webp.php"</option>
                  <option title="запуск скрипта для WEBP с ключом"
                          value="10">php ".../cli-php/sitecreator/cron_test_webp.php" "key"</option>

                  <option title="запуск скрипта для WEBP без ключа"
                          value="11">/opt/php71/bin/php ".../cli-php/sitecreator/cron_test_webp.php"</option>
                  <option title="запуск скрипта для WEBP с ключом"
                          value="12">/opt/php71/bin/php ".../cli-php/sitecreator/cron_test_webp.php" "key"</option>
                </select>
                <button style="margin-top:0px;" id="btn_php_cli_cmd" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Выполнить</button><br>
                <textarea id="php_cli_cmd_out" readonly placeholder="<?php echo  $text_php_cli_cmd_out_placeholder; ?>"></textarea>

              </div>



          </div>
          <div class="panel-body tab-pane" id="tab-webp_stat">
            <?php echo $text_tab_webp_stat_head; ?>
            <button style="margin-top:0;" id="btn_webp_stat_refresh" type="button" class="btn  stcrtr_btn btn-type2" data-type="" title="Обновить данные">refresh</button><br>
            <div id="text_stat"><?php if(!empty($webp_text_stat)) echo $webp_text_stat; ?></div>
            <div id="graphic_stat"><?php if(!empty($webp_graphic_stat)) echo $webp_graphic_stat; ?></div>
            <div style="height:15px; clear: both;"></div>

          </div>
          <div class="panel-body tab-pane" id="tab-http_cwebp" style="display: none;">
            <input form="form-watermark_by_sitecreator"  class="form-control" type="text" name="watermark_by_sitecreator_secret_val_for_http_cwebp" id="secret_val_for_http_cwebp" value="<?php echo $secret_val_for_http_cwebp; ?>" style="max-width: 450px;" readonly><br><br>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_create_secret_val_for_http_cwebp; ?></label><br>
            <button style="margin-top:0;" id="create_secret_val_for_http_cwebp" type="button" class="btn  stcrtr_btn btn-type2" data-type="">create secret value</button><br>
          </div>
          <div class="panel-body tab-pane" id="tab-help"><?php echo $text_watermark_infoplus; ?></div>

        </div>
        <div class="scr_opyright"><?php echo $text_module_copyright; ?></div>

      </div>
    </div>
  </div>

<script>

  var cron_webp_command_for_site = [<?php if(!empty($cron_test_command_for_site_array)) echo $cron_test_command_for_site_array; ?>];

  function globalPars() {
    var p = {<?php echo $globalParsFor_JS;  ?>};
    // можно добавить если в контроллере зне добавили
    // p.ini_alert = '<#?php echo $ini_alert; ?#>';
    return p;
  }




  $(document).ready(function() {
    var lic_activated = <?php echo $lic_activated; ?>;
    var info = '<?php echo $lic_info; ?>';
    info += '<?php echo $ini_alert; ?>';
    if (!lic_activated) {
      $('#form-watermark_by_sitecreator').css('display', 'none');
      if(info != '') $('#tab-main').prepend(info);
      $("button[id!='lic_activate'][id!='default_setting'][type!='submit']").prop('disabled', true);

    }
    else {
      $('#lic_activate').prop('disabled', true).text('Лицензия АКТИВИРОВАНА');
    }

    // тест браузера на webp
    (function() {
      var hasWebP = false;
      var img = new Image();
      img.onload = function() {
//        hasWebP = !!(img.height > 0 && img.width > 0);
        if (img.height > 0 && img.width > 0) hasWebP = true;
        if(hasWebP) {
          $("#browser_info").html("<div class=\"ok\"><span>Ваш браузер поддерживает WebP. </span> Your browser supports WebP.</div>");
        }
      };
      img.onerror = function() {
        hasWebP = false;
        var text = "<div class=\"notice\">Ваш браузер, вероятно, НЕ поддерживает WebP.  Your browser probably does NOT support WebP.</div>";
        text += "Но без изображения не останется ни один браузер! / But without the image there will be no browser!";
        $("#browser_info").html(text);
      };
      img.src = "data:image/webp;base64,UklGRo4AAABXRUJQVlA4IIIAAADwAwCdASoUABQAPlEijUSjoiEYDAQAOAUEsoAAFzxHy8dzl714CKfwAP7+" +
        "2A9p/6ap3t7PF9R+ChO5JI6wc+BAYqPqf2pU9o1v/BSpsSPe++BIN2d4Zo8JaPWiX8U6r4z9l+Z9kDbl/6S7GfCR1F54o05F+GSpeivOJzP0NXIUAAAA";
    })();

  });


</script>
  <footer id="footer"><?php echo $text_version; ?></footer></div>
</body></html>