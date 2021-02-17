<?php
// Разработчик sitecreator.ru 2019(c)
class ControllerCommonFileManagerForWmSitecreator extends Controller {
  protected function translit($text) {
    $rus = array("а","А","б","Б","в","В","г","Г","д","Д","е","Е","ё","Ё","є","Є","ж", "Ж",  "з","З","и","И","і","І","ї","Ї","й","Й","к","К","л","Л","м","М","н","Н","о","О","п","П","р","Р", "с","С","т","Т","у","У","ф","Ф","х","Х","ц","Ц","ч", "Ч", "ш", "Ш", "щ",  "Щ", "ъ","Ъ", "ы","Ы","ь","Ь","э","Э","ю", "Ю", "я","Я",'/',' ');
    $eng =array("a","A","b","B","v","V","g","G","d","D","e","E","e","E","e","E", "zh","ZH","z","Z","i","I","i","I","yi","YI","j","J","k","K","l","L","m","M","n","N","o","O", "p","P","r","R","s","S","t","T","u","U","f","F","h","H","c","C","ch","CH", "sh","SH","sch","SCH","", "", "y","Y","","","e","E","ju","JU","ja","JA",'','');
    $text = strtolower(str_replace($rus,$eng,$text));
    $disallow_symbols = array(
      ' ' => '-', '\\' => '-', '/' => '-', ':' => '-', '*' => '',
      '?' => '', ',' => '', '"' => '', '\'' => '', '<' => '', '>' => '', '|' => ''
    );
    return trim(strip_tags(str_replace(array_keys($disallow_symbols), array_values($disallow_symbols), trim(html_entity_decode($text, ENT_QUOTES, 'UTF-8')))), '-');
  }
  public function index() {
    $oc23 = (version_compare(VERSION, "2.3", ">="))? true:false;
    $oc15 = (version_compare(VERSION, "2.0", "<"))? true:false;
    $oc30 = (version_compare(VERSION, "3.0", ">="))? true:false;

    $data = [];
    $data['module_ver'] = '1.2.1';

    if($oc30) $data['user_token']  = $this->session->data['user_token'];  // opencart 3
    else $data['token']  = $this->session->data['token'];



    $tpl = '/common/filemanager_for_wm_sitecreator.tpl';
    // универсальный вывод для всех версий движка
    $output = $this->myView($tpl, $data);
    echo $output;
  }

  public function connector() {

    require_once DIR_SYSTEM. "library/sitecreator/elFinder/php/elFinderConnector.class.php";
    require_once DIR_SYSTEM. "library/sitecreator/elFinder/php/elFinder.class.php";
    require_once DIR_SYSTEM. "library/sitecreator/elFinder/php/elFinderVolumeDriver.class.php";
    require_once DIR_SYSTEM. "library/sitecreator/elFinder/php/elFinderVolumeLocalFileSystem.class.php";

    if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')))
      $domain = (defined('HTTPS_CATALOG'))? HTTPS_CATALOG: HTTPS_SERVER;
    else {$domain = (defined('HTTP_CATALOG'))? HTTP_CATALOG: HTTP_SERVER;}

    $catalog = 'catalog/';
    if(version_compare(VERSION, "2.0", "<")) $catalog = 'data/';

    $opts = array(
      'roots' => array(
        array(
          'driver' => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
          'path'   => DIR_IMAGE. $catalog,                // path to files (REQUIRED)
          'URL'    => $domain. 'image/'. $catalog,
          'tmbPath'=> DIR_IMAGE. 'elfinder_tmb',
          'tmbURL' => $domain. 'image/elfinder_tmb/',
          'tmbSize' => 100,
          'tmbCrop' => false,
          'tmbBgColor' => '#ffffff',
          'mimeDetect' => 'internal',
          'imgLib'     => 'auto',
          'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
          'uploadAllow' => array('image/jpeg', 'image/png', 'image/gif', 'image/svg+xml',
            // "особые" типы древних IE добавил на всякий случай sitecreator
            'image/pjpeg', 'image/x-png'),
          'uploadDeny' => array('all'),
          'uploadOrder' => array('allow, deny'),
        )

      )
    );


    $connector = new elFinderConnector(new elFinder($opts), true);
    $connector->run();

  }

  private function myView($template, $data = array()) {
    $file = DIR_TEMPLATE . $template;
    if (!file_exists($file)) {
      trigger_error('Error: Could not load template ' . $file . '!');
      exit();
    }
    extract($data);
    ob_start();
    require_once($file);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  }
}
