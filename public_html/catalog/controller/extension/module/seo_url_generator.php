<?php

/**
 * @category   OpenCart
 * @package    SEO URL Generator PRO
 * @copyright  © Serge Tkach, 2018-2021, http://sergetkach.com/
 */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// for different PHP versions...
if (version_compare(PHP_VERSION, '7.2') >= 0) {
	$php_v = '72_73';
} elseif (version_compare(PHP_VERSION, '7.1') >= 0) {
	$php_v = '71';
} elseif (version_compare(PHP_VERSION, '5.6.0') >= 0) {
	$php_v = '56_70';
} elseif (version_compare(PHP_VERSION, '5.4.0') >= 0) {
	$php_v = '54_56';
} else {
	echo "Sorry! Version for PHP 5.3 Not Supported!<br>Please contact to author!";
	exit;
}

$file = DIR_SYSTEM . 'library/seo_url_generator/cron/seo_url_generator_' . $php_v . '.php';

if (is_file($file)) {
	include $file;
} else {
	echo "No file '$file'<br>";
	exit;
}
