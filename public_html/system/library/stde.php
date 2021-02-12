<?php

/**
 * @category OpenCart
 * @package StdE
 * @description Standard Library for creating of Extensions
 * @version 1.0.0
 * @copyright © Serge Tkach, 2019, http://sergetkach.com/
 */

// Different OpenCart Versions
if (version_compare(VERSION, '3.0') >= 0) {
	$oc_v = '3.0';
} elseif(version_compare(VERSION, '2.3') >= 0) {
	$oc_v = '2.3';
} elseif (version_compare(VERSION, '2.2') >= 0) {
	$oc_v = '2.2';
} elseif (version_compare(VERSION, '2.1') >= 0) {
	$oc_v = '2.1';
} elseif (version_compare(VERSION, '1.5.6') >= 0) {
	$oc_v = '1.5.6';
} else {
	echo "Sorry! <b>VERSION " . VERSION . "</b> is not supported!";
	exit;
}

if (is_file(DIR_SYSTEM . 'library/stde/stde_' . $oc_v . '.php')) {
	require_once DIR_SYSTEM . 'library/stde/stde_' . $oc_v . '.php';
} else {
	echo DIR_SYSTEM . 'library/stde/stde_' . $oc_v . '.php is not a file!';
	exit;
}