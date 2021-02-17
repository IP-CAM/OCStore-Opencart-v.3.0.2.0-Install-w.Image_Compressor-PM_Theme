<?php
$php_v = substr(phpversion(),0,3);
if(extension_loaded('ionCube Loader')) {
  $v = ioncube_loader_iversion();
  if($v < 100000) {
    echo "Версия ionCube Loader должна быть не ниже 10. The ionCube Loader version must be at least 10.<br>\n";
    exit();
  }
  else {
    if($php_v == '5.6' || $php_v == '7.0') {
      $file = DIR_SYSTEM.'library/sitecreator/image_lib56.php';
      if(is_file($file)) require_once($file);
      else {
        echo "Нет файла $file. No file $file.<br>\n";
        exit();
      }
    }
    elseif($php_v == '7.1' || $php_v == '7.2' || $php_v == '7.3' || $php_v == '7.4') {
      $file = DIR_SYSTEM.'library/sitecreator/image_lib71.php';
      if(is_file($file)) require_once($file);
      else {
        echo "Нет файла $file. No file $file.<br>\n";
        exit();
      }

    }
    else {
      echo "Ваша версия php равна $php_v. Версия php должна быть не ниже 5.6. Your version of php is $php_v. The php version must be at least 5.6.<br>\n";
      exit();
    }
  }

}
else {
  echo "Отсутствует ionCube Loader. Missing ionCube Loader.<br>\n";
  exit();
}

?>