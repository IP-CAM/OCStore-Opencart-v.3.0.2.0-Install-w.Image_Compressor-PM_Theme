<?php
/*
@author  nikifalex
@skype   logoffice1
@email    nikifalex@yandex.ru
@link https://opencartforum.com/files/file/4617-pohozhie-tovary/
*/

class ModelExtensionModuleNkfSimilarProducts extends Model {

    private function getProductAttributes($product_id, $ea) {
        $attributes = array();
        $sql1 = "
          SELECT *
          FROM " . DB_PREFIX . "product_attribute pa
          JOIN " . DB_PREFIX . "product p on p.product_id=pa.product_id
          WHERE p.product_id = '" . (int)$product_id . "'
          AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' 
          " . $ea . "
        ";
        $a = $this->db->query($sql1);
        foreach ($a->rows as $b) {
            $attributes[$b['attribute_id']] = $b['text'];
        }
        return $attributes;
    }

    private function getAttributeName($attribute_id) {
        $sql1 = "
          SELECT *
          FROM " . DB_PREFIX . "attribute_description ad
          WHERE ad.attribute_id = '" . (int)$attribute_id . "'
          AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        ";
        $a = $this->db->query($sql1);
        if ($a->num_rows > 0)
            return $a->row['name'];
        else
            return false;
    }


    public function getProductSimilar($data) {
        if ($data['use_cache'] && $data['module_id'] > 0) {
            $this->load->model('catalog/product');
            $product_data = array();
            $products = $this->db->query("select * from " . DB_PREFIX . "nkf_similar_product WHERE product_id='" . (int)$data['product_id'] . "' AND module_id='" . (int)$data['module_id'] . "'");
            foreach ($products->rows as $result) {
                if ($data['only_id']) {
                    $product_data[] = $result['similar_id'];
                } else {
                    $p = $this->model_catalog_product->getProduct($result['similar_id']);
                    if ($p) {
                        $p['diff']['attributes'] = json_decode($result['diff'], true);
                        $product_data[$result['similar_id']] = $p;
                    }
                }
            }
        } else {
            $mc = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_to_category` LIKE 'main_category'");
            if ($mc->num_rows) {
                $m = "AND main_category=1";
            } else {
                $m = "";
            }
            $this->load->model('catalog/product');
            $ea = '';
            if (isset($data['excluded_attributes']) && count($data['excluded_attributes']) > 0) {
                $ea = " AND pa.attribute_id not in (" . implode(',', $data['excluded_attributes']) . ")";
            }
            $product_data = array();
            $sql2 = array();
            $product=$this->db->query("select price from ".DB_PREFIX."product WHERE product_id='".(int)$data['product_id']."'");
            $price=$product->row['price'];
            $product_attributes = $this->getProductAttributes((int)$data['product_id'], $ea);
            foreach ($product_attributes as $i => $b) {
                if ($data['delimiter'] != '') {
                    $b1 = explode($data['delimiter'], $b);
                    $t = array();
                    foreach ($b1 as $b2) {
                        $b2 = trim($b2);
                        $t[] = "pa.text LIKE '" . $this->db->escape($b2) . $data['delimiter'] . "%'";
                        $t[] = "pa.text LIKE '%" . $data['delimiter'] . $this->db->escape($b2) . "'";
                        $t[] = "pa.text LIKE '%" . $data['delimiter'] . $this->db->escape($b2) . $data['delimiter'] . "%'";
                        $t[] = "pa.text = '" . $this->db->escape($b2) . "'";
                    }
                    $t = implode(' OR ', $t);
                    $sql2[] = " (pa.attribute_id='" . $i . "' AND (" . $t . ")) ";
                } else {
                    $sql2[] = " (pa.attribute_id='" . $i . "' AND pa.text='" . $this->db->escape($b) . "') ";
                }
            }
            $categories = array();
            if ($data['use_category']) {
                $sql1 = "
                  SELECT *
                  FROM " . DB_PREFIX . "product_to_category p2c
                  JOIN " . DB_PREFIX . "product p on p.product_id=p2c.product_id
                  WHERE p.product_id = '" . (int)$data['product_id'] . "'
                  " . $m . "
            ";
                $a = $this->db->query($sql1);
                foreach ($a->rows as $b) {
                    $categories[] = $b['category_id'];
                }
            } else {
                if (isset($data['included_categories']) && is_array($data['included_categories']))
                    $categories = $data['included_categories'];
            }
            $manufacturer = '';
            if ($data['use_manufacturer']) {
                $sql1 = "
                  SELECT *
                  FROM " . DB_PREFIX . "product p
                  WHERE p.product_id = '" . (int)$data['product_id'] . "'
            ";
                $a = $this->db->query($sql1);
                if ($a->num_rows > 0 && $a->row['manufacturer_id'] > 0)
                    $manufacturer = $a->row['manufacturer_id'];
            }
            $j1 = '';
            $w1 = '';
            if (count($categories) > 0) {
                $j1 = "JOIN " . DB_PREFIX . "product_to_category p2c on p.product_id=p2c.product_id";
                $w1 = " " . $m . " AND p2c.category_id in (" . implode(',', $categories) . ")";
            }
            $w2 = '';
            if ($manufacturer != '') {
                $w2 = "AND p.manufacturer_id = " . (int)$manufacturer . "";
            }
            $u1 = '';
            if ($data['use_price']) {
                $u1 = " AND price>0 ";
            }
            $u2 = '';
            if ($data['use_quantity']) {
                $u2 = " AND quantity>0 ";
            }

            $u3 = '';
            if ($data['price_percent']!='') {
                $pp=$data['price_percent'];
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
                  WHERE  p.product_id <> '" . (int)$data['product_id'] . "'
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
                    if ($cnt_diff > $data['cnt_diff'] || $cnt_products > $data['limit'])
                        break;
                    if ($data['only_id']) {
                        $product_data[] = $result['product_id'];
                    } else {
                        $p = $this->model_catalog_product->getProduct($result['product_id']);
                        if ($p) {
                            $product_data[$result['product_id']] = $p;
                            $product_data[$result['product_id']]['diff'] = $diff;
                        }
                    }
                }
            }
        }
        return $product_data;
    }
}
