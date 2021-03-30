<?php
/*
@author  nikifalex
@skype   logoffice1
@email    nikifalex@yandex.ru
@link https://opencartforum.com/files/file/4617-pohozhie-tovary/
*/

class ModelExtensionModuleNkfSimilarProducts extends Model {

    private function getProductAttributes($product_id,$ea) {
        $attributes=array();
        $sql1="
          SELECT *
          FROM " . DB_PREFIX . "product_attribute pa
          JOIN " . DB_PREFIX . "product p on p.product_id=pa.product_id
          WHERE p.product_id = '" . (int)$product_id . "'
          AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' 
          ".$ea."
        ";
        $a=$this->db->query($sql1);
        foreach ($a->rows as $b) {
            $attributes[$b['attribute_id']]=$b['text'];
        }

        return $attributes;
    }

    private function getAttributeName($attribute_id) {
        $sql1="
          SELECT *
          FROM " . DB_PREFIX . "attribute_description ad
          WHERE ad.attribute_id = '" . (int)$attribute_id . "'
          AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        ";
        $a=$this->db->query($sql1);
        if ($a->num_rows>0)
            return $a->row['name'];
        else
            return false;
    }


    public function run() {
        $this->load->model('setting/module');
        $modules = $this->model_setting_module->getModulesByCode('nkf_similar_products');

        foreach ($modules as $module) {
            $module_id = $module['module_id'];
            $module_info = $this->model_setting_module->getModule($module_id);

            if (!isset($module_info['use_cache']) || !$module_info['use_cache'])
                continue;

            $this->load->model('catalog/product');
            $ea = '';
            if (isset($module_info['excluded_attributes']) && count($module_info['excluded_attributes']) > 0) {
                $ea = " AND pa.attribute_id not in (" . implode(',', $module_info['excluded_attributes']) . ")";
            }
            $this->db->query("DELETE FROM `" . DB_PREFIX . "nkf_similar_product` WHERE `module_id`='" . $module_id . "'");
            $products = $this->db->query("select product_id,price from " . DB_PREFIX . "product");
            foreach ($products->rows as $product) {
                $product_id = $product['product_id'];
                $price= $product['price'];
                $sql2 = array();
                $product_attributes = $this->getProductAttributes((int)$product_id, $ea);
                foreach ($product_attributes as $i => $b) {
                    if ($module_info['delimiter'] != '') {
                        $b1 = explode($module_info['delimiter'], $b);
                        $t = array();
                        foreach ($b1 as $b2) {
                            $b2 = trim($b2);
                            $t[] = "pa.text LIKE '" . $this->db->escape($b2) . $module_info['delimiter'] . "%'";
                            $t[] = "pa.text LIKE '%" . $module_info['delimiter'] . $this->db->escape($b2) . "'";
                            $t[] = "pa.text LIKE '%" . $module_info['delimiter'] . $this->db->escape($b2) . $module_info['delimiter'] . "%'";
                            $t[] = "pa.text = '" . $this->db->escape($b2) . "'";
                        }
                        $t = implode(' OR ', $t);
                        $sql2[] = " (pa.attribute_id='" . $i . "' AND (" . $t . ")) ";
                    } else {
                        $sql2[] = " (pa.attribute_id='" . $i . "' AND pa.text='" . $this->db->escape($b) . "') ";
                    }
                }
                $categories = array();
                if ($module_info['use_category']) {
                    $sql1 = "
                  SELECT *
                  FROM " . DB_PREFIX . "product_to_category p2c
                  JOIN " . DB_PREFIX . "product p on p.product_id=p2c.product_id
                  WHERE p.product_id = '" . (int)$product_id . "'
                  AND main_category=1
            ";
                    $a = $this->db->query($sql1);
                    foreach ($a->rows as $b) {
                        $categories[] = $b['category_id'];
                    }
                } else {
                    if (isset($module_info['included_categories']) && is_array($module_info['included_categories']))
                        $categories=$module_info['included_categories'];
                }
                $manufacturer = '';
                if ($module_info['use_manufacturer']) {
                    $sql1 = "
                  SELECT *
                  FROM " . DB_PREFIX . "product p
                  WHERE p.product_id = '" . (int)$product_id . "'
            ";
                    $a = $this->db->query($sql1);
                    if ($a->num_rows > 0 && $a->row['manufacturer_id'] > 0)
                        $manufacturer = $a->row['manufacturer_id'];
                }
                $j1 = '';
                $w1 = '';
                if (count($categories) > 0) {
                    $j1 = "JOIN " . DB_PREFIX . "product_to_category p2c on p.product_id=p2c.product_id";
                    $w1 = "AND main_category=1 AND p2c.category_id in (" . implode(',', $categories) . ")";
                }
                $w2 = '';
                if ($manufacturer != '') {
                    $w2 = "AND p.manufacturer_id = " . (int)$manufacturer . "";
                }
                $u1 = '';
                if ($module_info['use_price']) {
                    $u1 = " AND price>0 ";
                }
                $u2 = '';
                if ($module_info['use_quantity']) {
                    $u2 = " AND quantity>0 ";
                }

                $u3 = '';
                if ($module_info['price_percent']!='') {
                    $pp=$module_info['price_percent'];
                    $pp=(float)str_replace('%','',$pp);
                    $u3 = " AND price>=".$price*(1-$pp/100)." AND price<=".$price*(1+$pp/100);
                }

                if (count($sql2) > 0) {
                    $sql2 = implode(' OR ', $sql2);
                    $sql3 = "
                  SELECT p.product_id
                  FROM " . DB_PREFIX . "product_attribute pa
                  JOIN " . DB_PREFIX . "product p on p.product_id=pa.product_id
                  " . $j1 . "
                  WHERE  p.product_id <> '" . (int)$product_id . "'
                  AND p.status = '1'
                  AND p.date_available <= NOW()
                  " . $u1 . "
                  " . $u2 . "
                  " . $u3 . "
                  AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "'
                  AND (" . $sql2 . ")
                  " . $w1 . "
                  " . $w2 . "
                  " . $ea . "
                  group by product_id
                  order by count(*) DESC, p.price, p.product_id
                ";
                    $query = $this->db->query($sql3);
                    $cnt_products = 0;
                    foreach ($query->rows as $result) {
                        $diff['attributes'] = array();
                        $product_attrubutes_p = $this->getProductAttributes($result['product_id'], $ea);
                        $cnt_diff = 0;
                        foreach ($product_attrubutes_p as $i => $p) {
                            if (isset($product_attributes[$i]) && ($product_attributes[$i] != $p)) {
                                $diff['attributes'][] = $this->getAttributeName($i) . ': ' . $p;
                                $cnt_diff++;
                            }
                        }
                        $cnt_products++;
                        if ($cnt_diff > $module_info['cnt_diff'] || $cnt_products > $module_info['limit'])
                            break;
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "nkf_similar_product` SET
                        `product_id` = '" . $product_id . "',
                        `similar_id`= '" . $result['product_id'] . "',
                        `module_id`='" . $module_id . "',
                        `diff` ='" . $this->db->escape(json_encode($diff['attributes'])) . "'
                    ");
                    }
                }
            }
        }
    }

    public function checkTables() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "nkf_similar_product` (
            `nkf_similar_product_id` int(11) NOT NULL AUTO_INCREMENT,
            `product_id` int(11) NOT NULL,
            `similar_id` int(11) NOT NULL,
            `module_id` int(11) NOT NULL,
            `diff` TEXT,
            PRIMARY KEY (`nkf_similar_product_id`),
            KEY `module_id` (`module_id`),
            KEY `similar_id` (`similar_id`),
            KEY `product_id` (`product_id`)
          ) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;");
    }


}
