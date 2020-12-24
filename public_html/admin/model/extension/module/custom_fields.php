<?php
class ModelExtensionModuleCustomFields extends Model {
	public function addCustomField($data) {
		
		if(!isset($data['custom_field']))$data['custom_field']=array();
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "custom_fields_settings SET name='" . $this->db->escape($data['name']) . "', description='" . $this->db->escape($data['description']) . "', entity='" . $this->db->escape($data['entity']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', mode = '" . (int)$data['mode'] . "', showeditor = '" . (int)$data['showeditor'] . "', advanced = '" . $this->db->escape(serialize($data['advanced'])) . "', type='" . $this->db->escape($data['type']) . "', place='" . $this->db->escape($data['place']) . "', placenum='" . (int)$data['placenum'] . "', tab='" . $this->db->escape($data['tab']) . "', required='" . (int)$data['required'] . "', texterror='" . $this->db->escape($data['texterror']) . "', data='".$this->db->escape(serialize($data['custom_field']))."'");

		$custom_fields_id = $this->db->getLastId();

		//$this->cache->delete('custom_fields');

		return $custom_fields_id;
	}

	public function editCustomField($custom_fields_id, $data) {
		
		if(!isset($data['custom_field']))$data['custom_field']=array();
		
		$this->db->query("UPDATE " . DB_PREFIX . "custom_fields_settings SET name='" . $this->db->escape($data['name']) . "', description='" . $this->db->escape($data['description']) . "', entity='" . $this->db->escape($data['entity']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', mode = '" . (int)$data['mode'] . "', showeditor = '" . (int)$data['showeditor'] . "', advanced = '" . $this->db->escape(serialize($data['advanced'])) . "', type='" . $this->db->escape($data['type']) . "', place='" . $this->db->escape($data['place']) . "', placenum='" . (int)$data['placenum'] . "', tab='" . $this->db->escape($data['tab']) . "', required='" . (int)$data['required'] . "', texterror='" . $this->db->escape($data['texterror']) . "', data='".$this->db->escape(serialize($data['custom_field']))."' WHERE custom_fields_id = '" . (int)$custom_fields_id . "'");

		

		//$this->cache->delete('custom_fields');
	}

	public function deleteCustomField($custom_fields_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "custom_fields_settings WHERE custom_fields_id = '" . (int)$custom_fields_id . "'");

		//$this->cache->delete('custom_fields');
	}
	
	public function getCustomField($custom_fields_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "custom_fields_settings WHERE custom_fields_id='".(int)$custom_fields_id."'");
		return $query->row;
	}
	
	public function getCustomFields($data){
		$sql = "SELECT * FROM " . DB_PREFIX . "custom_fields_settings c WHERE 1";
		
		$sort_data = array(
			'c.name',
			'c.entity',
			'c.sort_order',
			'c.status',
		);
		
		if (!empty($data['filter_entity'])) {
			$sql .= " AND c.entity='".$this->db->escape($data['filter_entity'])."'";
		}
		
		if (!empty($data['filter_status'])) {
			$sql .= " AND c.status='".(int)$data['filter_status']."'";
		}

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c.name";
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
		
		return $query->rows;
	}
	
	
	
	public function getCustomFieldStores($custom_fields_id) {
		$custom_fields_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "custom_fields_settings_to_store WHERE custom_fields_id = '" . (int)$custom_fields_id . "'");

		foreach ($query->rows as $result) {
			$custom_fields_store_data[] = $result['store_id'];
		}

		return $custom_fields_store_data;
	}
	
	public function getTotalCustomFields(){
		$query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "custom_fields_settings");
		return $query->row['total'];
	}
	
	public function getCustomFieldsByEntity($controller, $id){
		$entity = $controller.'_id='.$id;
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "custom_fields WHERE entity='".$this->db->escape($entity)."'");
		
		$data = array();
		foreach ($query->rows as $row){
			$data[$row['custom_fields_id']]=unserialize($row['data']);
		}
		
		return $data;

	}
	
}
