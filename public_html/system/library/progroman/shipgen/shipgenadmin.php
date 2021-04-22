<?php

namespace progroman\ShipGen;

if (file_exists(__DIR__ . '/admin.php')) {
    require_once 'admin.php';
} elseif (version_compare(phpversion(), '5.6', '<')) {
    require_once 'admin-encoded-php54.php';
} elseif (version_compare(phpversion(), '7.1', '<')) {
    require_once 'admin-encoded-php56.php';
} elseif (version_compare(phpversion(), '7.2', '<')) {
    require_once 'admin-encoded-php71.php';
} else {
    require_once 'admin-encoded-php72.php';
}

class ShipGenAdmin extends Admin {

    const VERSION = '1.2';

    /** @var array */
    static private $shipping;

    /** @var \Registry */
    private $registry;

    /** @var \ModelProgromanShipgen */
    private $model_shipgen;

    public function __construct($registry) {
        if (VERSION >= 3) {
            // fix для OC 3
            $config = $registry->get('config');
            $config->set('progroman_shipgen_license', $config->get('shipping_progroman_shipgen_license'));
        }

        parent::__construct($registry);
        $this->registry = $registry;
        $registry->get('load')->model('progroman/shipgen');
        $this->model_shipgen = $registry->get('model_progroman_shipgen');
    }

    public function loadLangFile($shipping_id) {
        /** @var \Language $language */
        $language = $this->registry->get('language');
        $shipping = $this->getShipping($shipping_id);

        if (VERSION < 3) {
            $language->set('heading_title', $shipping['title']);
        } else {
            $language->get('extension')->set('heading_title', $shipping['title']);
        }

        return $language->all();
    }

    public function getShipping($shipping_id) {
        if (is_null(self::$shipping)) {
            foreach ($this->model_shipgen->getAllShipping() as $shipping) {
                self::$shipping[$shipping['shipping_id']] = $shipping;
            }
        }

        return isset(self::$shipping[$shipping_id]) ? self::$shipping[$shipping_id] : false;
    }
}