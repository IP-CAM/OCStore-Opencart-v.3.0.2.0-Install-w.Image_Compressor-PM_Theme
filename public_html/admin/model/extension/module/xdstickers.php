<?php
class ModelExtensionModuleXDStickers extends Model {
	public function addCustomXDSticker($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "xdstickers SET xdsticker_id = '" . (int)$this->db->escape($data['xdsticker_id']) . "', name = '" . $this->db->escape($data['name']) . "', text = '" . $this->db->escape(json_encode($data['text'])) . "', bg_color = '" . $this->db->escape($data['bg_color']) . "', color_color = '" . $this->db->escape($data['color_color']) . "', status = '" . (int)$data['status'] . "'");
		return $this->db->getLastId();
	}
	
	public function truncateCustomXDStickers() {
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "xdstickers");
	}
	
	public function deleteCustomXDSticker($xdsticker_id) {
		$sql = "DELETE FROM " . DB_PREFIX . "xdstickers WHERE xdsticker_id = '" . (int)$this->db->escape($xdsticker_id) . "'";
		$query = $this->db->query($sql);
		// var_dump($query);
		if ($query) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function deleteCustomXDStickerProduct($xdsticker_id) {
		$sql = "DELETE FROM " . DB_PREFIX . "xdstickers_product WHERE xdsticker_id = '" . (int)$this->db->escape($xdsticker_id) . "'";
		$query = $this->db->query($sql);
		// var_dump($query);
		if ($query) {
			return true;
		} else {
			return false;
		}		
	}	
	
	public function getCustomXDSticker($xdsticker_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "xdstickers WHERE id = '" . (int)$xdsticker_id . "'");
		return $query->row;
	}
	
	public function getCustomXDStickersProduct($product_id) {
		$query = $this->db->query("SELECT xdsticker_id FROM " . DB_PREFIX . "xdstickers_product WHERE product_id = '" . (int)$product_id . "'");
		return $query->rows;
	}
	
	public function getCustomXDStickers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "xdstickers";
		$sort_data = array(
			'name',
			'status'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY xdsticker_id";
		}
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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
		$query = $this->db->query($sql);
		if ($query) {
			return $query->rows;
		} else {
			return false;
		}
	}
	
	public function getTotalCustomXDStickers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "xdstickers");
		return $query->row['total'];
	}
	
	// Bulk
    public function getCategories() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

        $category_data = array();

        foreach ($query->rows as $row) {
            $category_data[$row['parent_id']][$row['category_id']] = $row;
        }

        return $category_data;
    }

    public function updateBulkCustomXDStickerProduct($module_categories, $module_xdsticker_id) {
		
		// var_dump($module_categories);
		// var_dump($module_manufacturers);
		
        $filter_data = array(
            'filter_category' => $module_categories
        );

        $results = $this->getProducts($filter_data);
		
		// var_dump($results);

        if ($results) {
            foreach ($results as $product_id) {
				$cur_product_id = (int)$product_id['product_id'];
				$this->db->query("DELETE FROM " . DB_PREFIX . "xdstickers_product WHERE product_id = '" . $cur_product_id . "' AND xdsticker_id = '" . (int) $module_xdsticker_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "xdstickers_product (`product_id`, `xdsticker_id`) VALUES ('" .  $this->db->escape($cur_product_id) . "','" .  $this->db->escape((int) $module_xdsticker_id) . "')");
            }
            return true;
        } else {
            return false;
        }
    }
	
    public function deleteBulkCustomXDStickerProduct($module_categories, $module_xdsticker_id) {
		
		// var_dump($module_categories);
		// var_dump($module_manufacturers);
		
        $filter_data = array(
            'filter_category' => $module_categories
        );

        $results = $this->getProducts($filter_data);
		
		// var_dump($results);

        if ($results) {
            foreach ($results as $product_id) {
				$cur_product_id = (int)$product_id['product_id'];
				$this->db->query("DELETE FROM " . DB_PREFIX . "xdstickers_product WHERE product_id = '" . $cur_product_id . "' AND xdsticker_id = '" . (int) $module_xdsticker_id . "'");
            }
            return true;
        } else {
            return false;
        }
    }	

    public function getProducts($data = array()) {

        $sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p";
		
        if ($data['filter_category'] != '0') {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p2c.category_id = '" . (int) $data['filter_category'] . "'";
        }

        $sql .= " GROUP BY p.product_id";

        $product_data = array();

        $query = $this->db->query($sql);

		/*
        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $result['product_id'];
        }
		*/

        return $query->rows;
    }	
}