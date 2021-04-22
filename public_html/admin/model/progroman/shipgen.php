<?php

class ModelProgromanShipgen extends Model {

    public function getAllShipping($data = []) {

        $sql = "SELECT * FROM prmn_sg_shipping";

        $sort_data = ['title'];

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        return $this->db->query($sql)->rows;
    }

    public function getTotalShipping() {
        return $this->db->query("SELECT COUNT(*) total FROM prmn_sg_shipping")->row['total'];
    }

    public function getShipping($shipping_id) {
        return $this->db->query("SELECT * FROM prmn_sg_shipping WHERE shipping_id = " . (int)$shipping_id)->row;
    }

    public function addShipping($data) {
        $this->db->query(
            "INSERT INTO prmn_sg_shipping SET title = '" . $this->db->escape($data['title'])
            . "', image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "'");

        $shipping_id = $this->db->getLastId();
        $code = 'shipping_progroman_shipgen' . $shipping_id;

        unset($data['title']);
        unset($data['image']);

        // Записывем в extension
        $this->load->model('setting/extension');
        $this->model_setting_extension->install('shipping', 'progroman_shipgen' . $shipping_id);

        // Записываем в setting
        $settings = [];
        foreach ($data as $key => $value) {
            $settings[$code . '_' . $key] = $value;
        }

        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting($code, $settings);

        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/shipping/progroman_shipgen' . $shipping_id);
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/shipping/progroman_shipgen' . $shipping_id);

        return $shipping_id;
    }

    public function editShipping($shipping_id, $data) {
        $this->db->query(
            "UPDATE prmn_sg_shipping SET title = '" . $this->db->escape($data['title'])
            . "', image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8'))
            . "' WHERE shipping_id = " . (int)$shipping_id);

        $code = 'shipping_progroman_shipgen' . $shipping_id;
        unset($data['title']);
        unset($data['image']);

        // Записываем в setting
        $settings = [];

        foreach ($data as $key => $value) {
            $settings[$code . '_' . $key] = $value;
        }

        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting($code, $settings);
    }

    public function removeShipping($shipping_id) {
        // Удалить из prmn_sg_shipping
        $this->db->query("DELETE FROM prmn_sg_shipping WHERE shipping_id = " . (int)$shipping_id);
        $code = 'progroman_shipgen' . $shipping_id;

        // Удалить из extension
        $this->load->model('setting/extension');
        $this->model_setting_extension->uninstall('shipping', $code);

        // Удалить из setting
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting($code);

        // Удалить виды доставки
        $this->db->query("DELETE FROM prmn_sg_quote WHERE shipping_id = " . (int)$shipping_id);
        $this->db->query("DELETE FROM prmn_sg_quote_geozone WHERE quote_id NOT IN (SELECT quote_id FROM prmn_sg_quote)");
        $this->db->query("DELETE FROM prmn_sg_quote_zone WHERE quote_id NOT IN (SELECT quote_id FROM prmn_sg_quote)");

        return true;
    }

    public function removeQuote($quote_id) {
        $this->db->query("DELETE FROM prmn_sg_quote WHERE quote_id = " . (int)$quote_id);
        $this->db->query("DELETE FROM prmn_sg_quote_geozone WHERE quote_id = " . (int)$quote_id);
        $this->db->query("DELETE FROM prmn_sg_quote_zone WHERE quote_id = " . (int)$quote_id);
    }

    public function getQuote($quote_id) {
        return $this->db->query("SELECT * FROM prmn_sg_quote WHERE quote_id = " . (int)$quote_id)->row;
    }

    public function getQuotes($shipping_id) {
        return $this->db->query("SELECT * FROM prmn_sg_quote WHERE shipping_id = " . (int)$shipping_id)->rows;
    }

    public function getQuotesGeoZones($quote_id) {
        return $this->db->query("SELECT * FROM prmn_sg_quote_geozone WHERE quote_id = " . (int)$quote_id)->rows;
    }

    public function getQuotesZones($quote_id) {
        return $this->db->query("SELECT * FROM prmn_sg_quote_zone WHERE quote_id = " . (int)$quote_id)->rows;
    }

    public function editQuote($quote_id, $data) {
        $this->db->query(
            "UPDATE prmn_sg_quote SET title = '" . $this->db->escape($data['title']) . "', shipping_id = '" . (int)$data['shipping_id']
            . "', description = '" . $this->db->escape($data['description'])
            . "', image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "', status = '" . (int)$data['status']
            . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE quote_id = " . (int)$quote_id);
        $this->db->query("DELETE FROM prmn_sg_quote_geozone WHERE quote_id = " . (int)$quote_id);

        if (!empty($data['quotes_geo_zones'])) {
            $this->addQuotesGeoZones($quote_id, $data['quotes_geo_zones']);
        }

        $this->db->query("DELETE FROM prmn_sg_quote_zone WHERE quote_id = " . (int)$quote_id);

        if (!empty($data['quotes_zones'])) {
            $this->addQuotesZones($quote_id, $data['quotes_zones']);
        }
    }

    public function addQuote($data) {
        $this->db->query(
            "INSERT INTO prmn_sg_quote SET title = '" . $this->db->escape($data['title']) . "', shipping_id = '" . (int)$data['shipping_id']
            . "', description = '" . $this->db->escape($data['description'])
            . "', image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "', status = '" . (int)$data['status']
            . "', sort_order = '" . (int)$data['sort_order'] . "'");
        $quote_id = $this->db->getLastId();

        if (!empty($data['quotes_geo_zones'])) {
            $this->addQuotesGeoZones($quote_id, $data['quotes_geo_zones']);
        }

        if (!empty($data['quotes_zones'])) {
            $this->addQuotesZones($quote_id, $data['quotes_zones']);
        }

        return $quote_id;
    }

    public function copyQuote($quote_id) {
        $quote = $this->getQuote($quote_id);
        $quote['title'] .= ' (Copy)';
        $quote['quotes_geo_zones'] = $this->getQuotesGeoZones($quote_id);
        $quote['quotes_zones'] = $this->getQuotesZones($quote_id);

        $this->addQuote($quote);
    }

    private function addQuotesGeoZones($quote_id, $quotes_geo_zones) {
        foreach ($quotes_geo_zones as $quote) {
            $this->db->query("INSERT INTO prmn_sg_quote_geozone SET quote_id = '" . $quote_id . "', "
                             . "geo_zone_id = '" . (int)$quote['geo_zone_id'] . "', "
                             . "rate = '" . $this->db->escape(trim($quote['rate'])) . "', "
                             . "discount = '" . $this->db->escape($quote['discount']) . "', "
                             . "description = '" . $this->db->escape($quote['description']) . "', "
                             . "min_price = " . ((int)$quote['min_price'] > 0 ? (int)$quote['min_price'] : 'NULL') . ", "
                             . "max_price = " . ((int)$quote['max_price'] > 0 ? (int)$quote['max_price'] : 'NULL'));
        }
    }

    private function addQuotesZones($quote_id, $quotes_zones) {
        foreach ($quotes_zones as $quote) {
            $this->db->query("INSERT INTO prmn_sg_quote_zone SET quote_id = '" . $quote_id . "', "
                             . "country_id = '" . (int)$quote['country_id'] . "', "
                             . "zone_id = '" . (int)$quote['zone_id'] . "', "
                             . "rate = '" . $this->db->escape(trim($quote['rate'])) . "', "
                             . "discount = '" . $this->db->escape($quote['discount']) . "', "
                             . "description = '" . $this->db->escape($quote['description']) . "', "
                             . "enabled_cities = '" . $this->db->escape(trim($quote['enabled_cities'])) . "', "
                             . "disabled_cities = '" . $this->db->escape(trim($quote['disabled_cities'])) . "', "
                             . "min_price = " . ((int)$quote['min_price'] > 0 ? (int)$quote['min_price'] : 'NULL') . ", "
                             . "max_price = " . ((int)$quote['max_price'] > 0 ? (int)$quote['max_price'] : 'NULL'));
        }
    }

    public function install() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `prmn_sg_quote` (
              `quote_id` int(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL,
              `shipping_id` int(11) NOT NULL, 
              `description` varchar(255) DEFAULT NULL, 
              `image` varchar(255) DEFAULT NULL, 
              `status` tinyint(1) NOT NULL DEFAULT '0', 
              `sort_order` int(11) DEFAULT NULL, 
              PRIMARY KEY (`quote_id`))");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `prmn_sg_quote_geozone` (
              `quote_geozone_id` int(11) NOT NULL AUTO_INCREMENT, 
              `quote_id` int(11) NOT NULL, 
              `geo_zone_id` int(11) NOT NULL, 
              `rate` text NOT NULL, 
              `discount` text, 
              `description` varchar(255) DEFAULT NULL, 
              `min_price` int(11) DEFAULT NULL, 
              `max_price` int(11) DEFAULT NULL, 
              PRIMARY KEY (`quote_geozone_id`))");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `prmn_sg_quote_zone` (
              `quote_zone_id` int(11) NOT NULL AUTO_INCREMENT, 
              `quote_id` int(11) NOT NULL, 
              `country_id` int(11) NOT NULL, 
              `zone_id` int(11) NOT NULL, 
              `rate` text NOT NULL, 
              `discount` text, 
              `description` varchar(255) DEFAULT NULL, 
              `enabled_cities` text, 
              `disabled_cities` text, 
              `min_price` int(11) DEFAULT NULL, 
              `max_price` int(11) DEFAULT NULL, 
              PRIMARY KEY (`quote_zone_id`), 
              KEY `quote_country_zone` (`quote_id`,`country_id`,`zone_id`))");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `prmn_sg_shipping` (
              `shipping_id` int(11) NOT NULL AUTO_INCREMENT, 
              `title` varchar(255) NOT NULL, 
              `image` varchar(255) DEFAULT NULL, 
              PRIMARY KEY (`shipping_id`))");
    }
}