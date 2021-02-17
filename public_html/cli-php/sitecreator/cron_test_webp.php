<?php
// программа для работы в PHP(cli) версии 5.6-7.3 и ioncube loader 10+
// Тест создания WEBP + рабочий (нормальный) режим работы создания WEBP через CRON
// Входит в состав модуля "Image COMPRESSOR & Watermark & WebP & Lazy Load etc. by Sitecreator"

/*
 *  LICENSE
 *  for Opencart
 *  cron_test_webp.php  for OpenCart 2.*
 *  Copyright (c) 2017-2019 sitecreator.ru
 *  version 1.17.3+ (sitecreator.ru)
 *  Исключительные права на данный файл (и модуль, в сотав которого входит данный файл) принадлежат разработчику - sitecreator.ru (Малютину Р.А.)
 *  Разработчик может выступать как под своим именем (Малютин Р.А.) так и использовать свой ник, совпадающий с названием одного из сайтов разработчика -
 *  sitecreator.ru или sitecreator.pro, а также более короткий ник  - sitecreator (SiteCreator).
 *  Упоминание любого из этих ников (сайтов) в контексте защиты авторских прав и интеллектуальной собственности однозначно следует связывать с защитой
 *  исключительных прав на интеллектуальную собственность  разработчика Малютина Р.А.
 *  В таком контексте любой из указанных выше ников следует рассматривать как синоним "разработчик Малютин Р.А.".
 *
 *  Копирование и распространение без согласия разработчика (sitecreator.ru) не допускается.
 */

$time_start = microtime(true);

$sapi_type = php_sapi_name();
echo "sapi type = '$sapi_type' \n";
if($sapi_type !== 'cli') {
  echo "PHP должен быть запущен в командной строке (cli). Not cli. Abort.\n";
  exit();
}
echo "== cron (TEST or NORMAL mode) for WEBP by SiteCreator Start ==\n";

$php_v = substr(phpversion(),0,3);
echo "PHP version: $php_v\n";

$php_v = (int)((float)$php_v * 10);
if($php_v < 56) {
  echo "Версия php должна быть не ниже 5.6. The php version should be at least 5.6.\n";
  exit();
}

if(!function_exists('ioncube_loader_iversion')) {
  echo "Расширение  php ionCube Loader 10+ должно быть установлено. The php ionCube Loader 10+ extension must be installed.\n";
  exit();
}
$v = ioncube_loader_iversion();
if($v < 100000) {
  echo "Версия ionCube Loader должна быть не ниже 10. The ionCube Loader version must be at least 10.\n";
  exit();
}

if(!function_exists('proc_open')) {
  echo "Функция php proc_open не должна быть отключена. The php proc_open function should not be disable.\n";
  exit();
}

$file = __FILE__;
$file = str_replace("\\", "/", $file);
$config_dir = dirname(dirname(dirname($file)));
$config_file = $config_dir. '/config.php';


if(!is_file($config_file)) {
  echo "Error: File config.php ($config_file) not found.\n";
  exit();
}
require_once $config_file;


$dir = DIR_IMAGE. 'sitecreator/wm_setting/';
$status_file = $dir. '.cron_test_webp_status';
if(!is_file($status_file)) {
  exit("stop & exit (status=off)\n");
}


if(empty($argv[1])) {
  exit("secret key not found\n");
}
else {
  $key = $argv[1];
  $key_hash_file = $dir.  '.cron_test_webp_key_hash';
  $key_hash = file_get_contents($key_hash_file);
  if($key_hash !== false) {
    $key_hash2 = strtolower(md5($key));
    if($key_hash !== $key_hash2) {
      exit("secret key is not valid\n");
    }
  }

}

$image_lib_file = DIR_SYSTEM. 'library/image_sitecreator0.php';
if(!is_file($image_lib_file)) {
  echo "Нет файла 'system/library/image_sitecreator0.php'. There is no file 'system/library/image_sitecreator0.php'.\n";
  exit();
}
require_once $image_lib_file;

$webpImage_lib_file = DIR_SYSTEM. 'library/webpimage.php';
if(!is_file($webpImage_lib_file)) {
  echo "Нет файла 'system/library/webpimage.php'. There is no file 'system/library/webpimage.php'.\n";
  exit();
}
require_once $webpImage_lib_file;


if(!function_exists('stcrtr_cron_test_webp')) {
  echo "Нет функции для теста WEBP. No function to test WEBP.\n";
  exit();
}

//=======================================================
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++


require_once(DIR_SYSTEM . 'library/db/mysqli.php');
require_once(DIR_SYSTEM . 'library/db.php');

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);


// Settings
$setting = stcrtr_get_settings();

//-------------------------------------------------------
//=======================================================

$cron_webp_mode = $setting['watermark_by_sitecreator_cron_webp_mode'];


if($cron_webp_mode == 'test') {
  $test_out_dir = DIR_IMAGE. 'cache/sitecreator/cron_test_webp/';
  if(!is_dir($test_out_dir)) {
    mkdir($test_out_dir, 0777, true);
    chmod(dirname(dirname($test_out_dir)), 0777);
    chmod(dirname($test_out_dir), 0777);
    chmod($test_out_dir, 0777);
  }

  $txt_file = $test_out_dir. 'cron_test_webp.svg'; // будет создан stcrtr_cron_test_webp()
  if(is_file($txt_file)) @unlink($txt_file);

// функция ТЕСТ WEBP
  $out = stcrtr_cron_test_webp();

// $txt_file закрыт от чтения извне файлом .htaccess
// ценной информации в нем нет даже если он будет доступен.
// в случае наличия паранойи можно раскомментировать нижеследующую строку чтобы он всегда удалялся, но тогда не увидим полезную инфу в админке.
//
//unlink($txt_file);


  $htaccess = $test_out_dir. '.htaccess';
  $htaccess_content = "Order allow,deny
<Files cron_test_webp.svg>
  Deny from all
</Files>";

  file_put_contents($htaccess, $htaccess_content);

  $out .= "== stop test ==\n";
  echo $out;  // вывод версии или ошибок
  exit();
}

// нормальный (РАБОЧИЙ) режим создания WEBP
echo "** webp mode = NORMAL **\n";

//$db->query('SET AUTOCOMMIT = 0;');
//$db->query('START TRANSACTION;');
sitecreatorCreateWebpStart($db);
//$db->query('COMMIT;');

$time = number_format (microtime(true) - $time_start, 4);
echo "time = $time\n";
echo "== end of task (NORMAL mode) ==\n";
?>