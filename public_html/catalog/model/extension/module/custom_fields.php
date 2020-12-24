<?php
class ModelExtensionModuleCustomFields extends Model {
	public function getCustomFields($controller, $id){
		$entity = $controller.'_id='.$id;

		$query = $this->db->query("SELECT c.*, cs.type, cs.mode, cs.advanced, cs.place, cs.placenum, cs.entity as controller, cs.data as settings_data FROM " . DB_PREFIX . "custom_fields c LEFT JOIN " . DB_PREFIX . "custom_fields_settings cs ON (c.custom_fields_id=cs.custom_fields_id) WHERE cs.status=1 AND cs.entity='".$this->db->escape($controller)."' AND c.entity='".$this->db->escape($entity)."' ORDER BY cs.sort_order");
		
		return $query->rows;
	}
}	
?>