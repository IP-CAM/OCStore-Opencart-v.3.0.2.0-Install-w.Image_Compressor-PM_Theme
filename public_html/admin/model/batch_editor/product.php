<?php
class ModelBatchEditorProduct extends Model {
	public function getProducts($data = array ()) {
		$sql = "SELECT " . $data['sql_fields'] . " p.product_id AS product_id, p.date_modified AS date_modified, p.date_added AS date_added FROM " . DB_PREFIX . "product p " . $data['sql_tables'] . " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id = " . (int) $data['language_id'] . ") LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p2s.store_id = " . (int) $data['store_id'] . " " . $this->getFilterSql() . " GROUP BY p.product_id ORDER BY " . $data['sort'] . " " . $data['order'] . " LIMIT " . $data['start'] . "," . $data['limit'];
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getTotalProducts($data = array ()) {
		$query = $this->db->query("SELECT COUNT(DISTINCT p.`product_id`) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id = '" . (int) $data['language_id'] . "') LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p2s.store_id = " . (int) $data['store_id'] . " " . $this->getFilterSql());
		
		return $query->row['total'];
	}
	
	public function getProductId($data = array ()) {
		$sql = "SELECT DISTINCT p.`product_id` AS product_id FROM `" . DB_PREFIX . "product` p LEFT JOIN `" . DB_PREFIX . "product_description` pd ON (p.product_id = pd.product_id AND pd.language_id = '" . (int) $data['language_id'] . "') LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p2s.store_id = " . (int) $data['store_id'] . " " . $this->getFilterSql();
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	private function getFilterSql() {
		$list = $this->model_batch_editor_setting->get('list');
		
		if (isset ($this->request->post['table']) && is_array ($this->request->post['table'])) {
			$tables = $this->request->post['table'];
		} else {
			$tables = array ();
		}
		
		if (isset ($this->request->post['filter_language_id'])) {
			$language_id = (int) $this->request->post['filter_language_id'];
		} else {
			$language_id = (int) $this->config->get('config_language_id');
		}
		
		if (isset ($this->request->post['filter_store_id'])) {
			$store_id = (int) $this->request->post['filter_store_id'];
		} else {
			$store_id = 0;
		}
		
		$variables = array ('action' => '%LIKE%', 'value' => '', 'value_min' => '', 'value_max' => '', 'is' => 'value', 'duplicate' => 0);
		
		$sql = '';
		
		foreach ($tables as $table => $fields) {
			$table_temp = $this->model_batch_editor_setting->getTableField($table);
			
			if (!$table || !is_array ($fields)) {
				continue;
			}
			
			$sql_and = array ();
			$sql_or = array ();
			
			if ($table == 'product') {
				$prefix = 'p.';
			} else if ($table == 'product_description') {
				$prefix = 'pd.';
			} else {
				$prefix = '';
			}
			
			foreach ($fields as $field => $data) {
				foreach ($variables as $variable => $default) {
					if (isset ($data[$variable])) {
						${$variable} = $data[$variable];
					} else {
						if ($variable == 'action') {
							$type = 'varchar';
							
							if (isset ($table_temp[$field]['type'])) {
								$type = $table_temp[$field]['type'];
							}
							
							if ($type == 'int' || $type == 'tinyint' || $type == 'decimal') {
								${$variable} = '=';
							} else {
								${$variable} = '%LIKE%';
							}
						} else {
							${$variable} = $default;
						}
					}
				}
				
				if (isset ($table_temp[$field])) {
					$setting = $table_temp[$field];
				} else {
					$prefix = '';
					
					if ($field == 'url_alias') {
						$field = 'keyword';
						$table = 'seo_url';
					} else if ($field == 'tag' && VERSION < '1.5.4') {
						$table = 'product_tag';
					}
				}
				
				if ($duplicate && ($field == 'keyword' || $table_temp[$field]['type'] != 'text')) {
					$sql_temp = $prefix . $field . " IN (SELECT `" . $field . "` FROM `" . DB_PREFIX . $table . "` ";
					
					if ($table == 'product_description') {
						$sql_temp .= "WHERE `language_id` = '" . $language_id . "' ";
					}
					
					$sql_temp .= "GROUP BY `" . $field . "` HAVING COUNT(*) > 1)";
					
					$sql_and[] = $sql_temp;
					
					continue;
				}
				
				if (isset ($data['not']) && $data['not'] == 'NOT') {
					$not = 'NOT';
				} else {
					$not = '';
				}
				
				$data_temp = array ('not' => $not, 'action' => $action, 'field' => $prefix . $field);
				
				if ($table == 'product' && isset ($list[$field]) && is_array ($value) && $value) {
					foreach ($value as $key => $value_temp) {
						$value[$key] = $this->db->escape($value_temp);
					}
					
					$sql_and[] = $prefix . $field . " ". $not . " IN ('" . implode ("','", $value) . "') ";
				} else {
					$data_temp['value'] = $this->db->escape(utf8_strtolower($value));
					
					if ($is == 'value') {
						$sql_and[] = $this->getSqlAction($data_temp);
					} else if ($is == 'array') {
						$array_temp = explode (' ', $data_temp['value']);
						
						foreach ($array_temp as $key => $value_temp) {
							//$array_temp[$key] = trim ($value_temp);
							
							$data_temp['value'] = trim ($value_temp);
							
							$sql_or[] = $this->getSqlAction($data_temp);
						}
						
						
						
						//$sql_and[] = $data_temp['field'] . " " . $data_temp['not'] . " IN ('" . implode ("','", $array_temp) . "')";
					} else if ($is == 'range') {
						if ($value_min || $value_min == '0') {
							$sql_and[] = $not . " " . $prefix . $field . " > '" . $this->db->escape($value_min) . "'";
						}
						
						if ($value_max || $value_max == '0') {
							$sql_and[] = $not . " " . $prefix . $field . " < '" . $this->db->escape($value_max) . "'";
						}
					}
				}
			}
			
			if ($sql_and) {
				if ($prefix) {
					$sql .= " AND " . implode (' AND ', $sql_and);
				} else {
					if ($table == 'seo_url') {
						$sql .= " AND p.`product_id` IN (SELECT REPLACE(query, 'product_id=', '') AS product_id FROM " . DB_PREFIX . $table . " WHERE " . implode (' AND ', $sql_and) . " AND language_id = '" . $language_id . "' AND store_id = '" . $store_id . "')";
					} else {
						$sql .= " AND p.`product_id` IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $table . " WHERE " . implode (' AND ', $sql_and) . " AND language_id = '" . $language_id . "' AND store_id = '" . $store_id . "')";
					}
				}
			}
			
			if ($sql_or) {
				if ($prefix) {
					$sql .= " AND (" . implode (' OR ', $sql_or) . ")";
				} else {
					if ($table == 'seo_url') {
						$sql .= " AND p.`product_id` IN (SELECT REPLACE(query, 'product_id=', '') AS product_id FROM " . DB_PREFIX . $table . " WHERE " . implode (' OR ', $sql_or) . " AND language_id = '" . $language_id . "' AND store_id = '" . $store_id . "')";
					} else {
						$sql .= " AND p.`product_id` IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $table . " WHERE " . implode (' OR ', $sql_or) . " AND language_id = '" . $language_id . "' AND store_id = '" . $store_id . "')";
					}
				}
			}
		}
		
		$links = $this->model_batch_editor_setting->get('link');
		
		unset ($links['category']);
		unset ($links['special']);
		unset ($links['discount']);
		
		foreach ($links as $link => $parameter) {
			if (isset ($this->request->post['none'][$link])) {
				$not = 'NOT';
			} else {
				$not = '';
			}
			
			if (isset ($this->request->post['has'][$link])) {
				$has = true;
			} else {
				$has = false;
			}
			if (isset ($this->request->post['count'][$link])) {
				$count = true;
			} else {
				$count = false;
			}
			
			if (isset ($this->request->post[$link])) {
				$data = $this->request->post[$link];
				
				if ($link == 'store' || $link == 'related' || $link == 'download' || $link == 'filter') {
					$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $parameter['table'] . " WHERE " . $link . "_id IN (" . implode (', ', $data) . "))";
				} else if ($link == 'layout') {
					$where = array ();
					
					foreach ($data as $store_id => $array) {
						foreach ($array as $layout_id) {
							if ($layout_id != '') {
								$where[] = "(`store_id` = " . (int) $store_id . " AND `layout_id` = " . (int) $layout_id . ")";
							}
						}
					}
					
					if ($where) {
						$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $parameter['table'] . " WHERE " . implode (' OR ', $where) . ")";
					} else {
						if ($not) {
							$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $parameter['table'] . ")";
						}
					}
				} else if ($link == 'reward') {
					$where = array ();
					
					foreach ($data as $customer_id => $array) {
						foreach ($array as $point) {
							if ($point != '') {
								$where[] = "(customer_group_id = " . (int) $customer_id . " AND points = " . (int) $point . ")";
							}
						}
					}
					
					if ($where) {
						$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $parameter['table'] . " WHERE " . implode (' OR ', $where) . ")";
					} else {
						if ($not) {
							$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $parameter['table'] . ")";
						}
					}
				} else if ($link == 'image') {
					$images = array ();
					$sort_orders = array ();
					
					foreach ($data as $array) {
						foreach ($array as $field => $value) {
							if ($field == 'image') {
								$images[] = "'" . $this->db->escape($value) . "'";
							} else {
								$sort_orders[] = (int) $value;
							}
						}
					}
					
					$sql .= " AND p.product_id " . $not . " IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $parameter['table'] . " WHERE `image` IN (" . implode (', ', $images) . ") AND sort_order IN (" . implode (', ', $sort_orders) . "))";
				} else if ($link == 'special' || $link == 'discount') {
					$fields = $this->model_batch_editor_setting->getTableField('product_' . $link);
					$sql_or = array ();
					
					foreach ($data as $array) {
						$sql_and = array ();
						
						foreach ($array as $field => $value) {
							if (isset ($fields[$field]) && $value != '') {
								$sql_and[] = $field . "='" . $this->db->escape($value) . "'";
							}
						}
						
						$sql_or[] = '(' . implode (' AND ', $sql_and) . ')';
					}
					
					if ($sql_or) {
						$sql .= " AND p.product_id " . $not . " IN (SELECT DISTINCT `product_id` FROM " . DB_PREFIX . $parameter['table'] . " WHERE " . implode (' OR ', $sql_or) . ")";
					}
				} else if ($link == 'attribute') {
					$sql_or = array ();
					
					foreach ($data as $attribute) {
						$sql_lang = array ();
						$languages = array ();
						
						if (isset ($attribute['attribute_description'])) {
							foreach ($attribute['attribute_description'] as $language_id => $value) {
								$languages[$language_id] = $language_id;
								
								if ($value['text'] != '') {
									$sql_lang[] = "(`language_id` = " . (int) $language_id . " AND LCASE(`text`) LIKE '%" . $this->db->escape($value['text']) . "%')";
								}
							}
						}
						
						
						if ($attribute['attribute_id']) {
							if ($sql_lang) {
								$sql_or[] = "(`attribute_id` = " . (int) $attribute['attribute_id'] . " AND " . implode (' OR ', $sql_lang) . ")";
							} else {
								$sql_or[] = "(`attribute_id` = " . (int) $attribute['attribute_id'] . ")";
							}
						} else {
							if ($sql_lang) {
								$sql_or[] = "(" . implode (' OR ', $sql_lang) . ")";
							}
						}
					}
					
					if ($sql_or) {
						$count_or = count ($sql_or);
						
						if ($has && $count_or > 1) {
							$sql .= " AND p.`product_id` " . $not . " IN";
							
							foreach ($sql_or as $key => $sql_temp) {
								$sql .= " (SELECT `product_id` FROM `" . DB_PREFIX . $parameter['table'] . "` WHERE `product_id` ";
								
								if ($key < ($count_or - 1)) {
									$sql .= " IN ";
								}
							}
							
							foreach ($sql_or as $sql_temp) {
								$sql .= " AND " . $sql_temp . ")";
							}
						} else {
							$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . $parameter['table'] . "` WHERE " . implode (' OR ', $sql_or) . ")";
						}
						
						if ($count) {
							$sql .= " AND p.`product_id` IN (SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . $parameter['table'] . "` GROUP BY `product_id` HAVING COUNT(*) = '" . ((isset ($languages))? ($count_or * count ($languages)) : $count_or) . "')";
						}
					}
				} else if ($link == 'option') {
					$sql_or = array ();
					
					$product_option_fields = $this->model_batch_editor_setting->getTableField('product_option');
					//$product_option_value_fields = $this->model_batch_editor_setting->getTableField('product_option_value');
					
					foreach ($data as $array) {
						$sql_and = array ();
						
						foreach ($product_option_fields as $field => $parameter) {
							if (isset ($array[$field]) && ($array[$field] != '')) {
								$sql_and[] = "`" . $field . "` = '" . $this->db->escape($array[$field]) . "'";
							}
						}
						
						/*if (isset ($array['product_option_value'])) {
							$sql_or_1 = array ();
							
							foreach ($array['product_option_value'] as $array_1) {
								$sql_and_1 = array ();
								$sql_and_1[] = "`option_id` = '" . $this->db->escape($array['option_id']) . "'";
								
								foreach ($product_option_value_fields as $field => $parameter) {
									if (isset ($array_1[$field]) && ($array_1[$field] != '')) {
										$sql_and_1[] = "`" . $field . "` = '" . $this->db->escape($array_1[$field]) . "'";
									}
								}
								
								if ($sql_and_1) {
									$sql_or_1[] = "(" . implode (' AND ', $sql_and_1) . ")";
								}
							}
							
							if ($sql_or_1) {
								$sql_and[] = "p.product_id IN (SELECT `product_id` FROM `" . DB_PREFIX . "product_option_value` WHERE " . implode (' OR ', $sql_or_1) . ")";
							}
						}*/
						
						if ($sql_and) {
							$sql_or[] = implode (' AND ', $sql_and);
						}
					}
					
					if ($sql_or) {
						$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . "product_option` WHERE " . implode (' OR ', $sql_or) . ")";
					}
				} else if ($link == 'ocfilter') {
					$sql_or = array ();
					
					foreach ($data as $option_id => $array) {
						$sql_and = array ();
						
						foreach ($array['values'] as $value_id => $value_temp) {
							$sql_and[] = "oov2p.`option_id` = " . (int) $option_id;
							
							if (isset ($value_temp['selected'])) {
								$sql_and[] = "oov2p.`value_id` = " . (int) $value_id;
								
								if (isset ($value_temp['slide_value_min']) && ($value_temp['slide_value_min'] || $value_temp['slide_value_min'] == '0')) {
									$sql_and[] = "oov2p.`slide_value_min` = " . (float) $value_temp['slide_value_min'];
								}
								
								if (isset ($value_temp['slide_value_max']) && ($value_temp['slide_value_max'] || $value_temp['slide_value_max'] == '0')) {
									$sql_and[] = "oov2p.`slide_value_max` = " . (float) $value_temp['slide_value_max'];
								}
							}
							
							foreach ($value_temp['description'] as $language_id => $text) {
								if ($text['description']) {
									$sql_and[] = "(oov2pd.`language_id` = '" . (int) $language_id . "' AND oov2pd.`description` = '" . $this->db->escape($text['description']) . "')";
								}
							}
						}
						
						if ($sql_and) {
							$sql_or[] = "(" . implode (' AND ', $sql_and) . ")";
						}
					}
					
					if ($sql_or) {
						$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT oov2p.`product_id` FROM `" . DB_PREFIX . "ocfilter_option_value_to_product` oov2p LEFT JOIN `" . DB_PREFIX . "ocfilter_option_value_to_product_description` oov2pd ON (oov2p.`product_id` = oov2pd.`product_id`) WHERE " . implode (' OR ', $sql_or) . ")";
					}
				}
			} else {
				if ($not) {
					$sql .= " AND p.product_id " . $not . " IN (SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . $parameter['table'] . "`)";
				}
			}
		}
		
		$links = $this->model_batch_editor_setting->getAdditionalLink();
		
		$links['category'] = array ('table' => 'product_to_category', 'type' => 'standart');
		$links['special'] = array ('table' => 'product_special', 'type' => 'standart');
		$links['discount'] = array ('table' => 'product_discount', 'type' => 'standart');
		
		foreach ($links as $link => $parameter) {
			if (isset ($this->request->post['none'][$link])) {
				$not = 'NOT';
			} else {
				$not = '';
			}
			
			if (isset ($this->request->post['has'][$link])) {
				$has = true;
			} else {
				$has = false;
			}
			if (isset ($this->request->post['count'][$link])) {
				$count = true;
			} else {
				$count = false;
			}
			
			$sql_or = array ();
			
			if ($link == 'category' && isset ($this->request->post['none']['main_category'])) {
				$not = 'NOT';
				$sql_or[] = "main_category = '1'";
			} else {
				if (isset ($this->request->post[$link])) {
					$data = $this->request->post[$link];
					$fields = $this->model_batch_editor_setting->getTableField($parameter['table']);
					
					if ($fields) {
						if ($parameter['type'] == 'language') {
							$this->load->model('batch_editor/list');
							$languages = $this->model_batch_editor_list->getLanguages();
							
							foreach ($languages as $language) {
								$sql_and = array ();
								
								foreach ($fields as $field => $parameter_1) {
									if ($parameter_1['key'] != 'PRI') {
										if (isset ($data[$language['language_id']][$field])) {
											$value = $data[$language['language_id']][$field];
											
											if ($value || $value == '0') {
												if ($parameter_1['type'] == 'char' || $parameter_1['type'] == 'varchar' || $parameter_1['type'] == 'text') {
													$sql_and[] = "LCASE(" . $field . ") LIKE '%" . $this->db->escape(utf8_strtolower($value)) . "%'";
												} else {
													$sql_and[] = $field . "='" . $this->db->escape($value) . "'";
												}
											}
										}
									}
								}
								
								if ($sql_and) {
									$sql_or[] = "(" . implode (' AND ', $sql_and) . ")";
								}
							}
						} else {
							foreach ($data as $array) {
								$sql_and = array ();
								
								foreach ($fields as $field => $parameter_1) {
									if ($parameter_1['extra'] != 'auto_increment') {
										if (isset ($array[$field])) {
											$value = $array[$field];
											
											if ($value || $value == '0') {
												if ($parameter_1['type'] == 'char' || $parameter_1['type'] == 'varchar' || $parameter_1['type'] == 'text') {
													$sql_and[] = "LCASE(" . $field . ") LIKE '%" . $this->db->escape(utf8_strtolower($value)) . "%'";
												} else {
													$sql_and[] = $field . "='" . $this->db->escape($value) . "'";
												}
											}
										}
									}
								}
								
								if ($sql_and) {
									$sql_or[] = "(" . implode (' AND ', $sql_and) . ")";
								}
							}
						}
					}
				}
			}
			
			if ($sql_or) {
				$count_or = count ($sql_or);
				
				if ($has && $count_or > 1) {
					$sql .= " AND p.`product_id` " . $not . " IN";
					
					foreach ($sql_or as $key => $sql_temp) {
						$sql .= " (SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . $parameter['table'] . "` WHERE `product_id` ";
						
						if ($key < ($count_or - 1)) {
							$sql .= " IN ";
						}
					}
					
					foreach ($sql_or as $sql_temp) {
						$sql .= " AND " . $sql_temp . ")";
					}
				} else {
					$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . $parameter['table'] . "` WHERE " . implode (' OR ', $sql_or) . ")";
				}
				
				if ($count) {
					$sql .= " AND p.`product_id` IN (SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . $parameter['table'] . "` GROUP BY `product_id` HAVING COUNT(*) = '" . $count_or . "')";
				}
			} else {
				if ($not) {
					$sql .= " AND p.`product_id` " . $not . " IN (SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . $parameter['table'] . "`)";
				}
			}
		}
		
		//echo $sql . "<br />";
		
		return $sql;
	}
	
	private function getSqlAction($data) {
		if ($data['action'] == '=') {
			
			$sql = $data['not'] . " " . $data['field'] . "='" . $data['value'] . "'";
			
		} else if ($data['action'] == 'LIKE%') {
			
			$sql = "LCASE(" . $data['field'] . ") " . $data['not'] . " LIKE '" . $data['value'] . "%'";
			
		} else if ($data['action'] == '%LIKE') {
			
			$sql = "LCASE(" . $data['field'] . ") " . $data['not'] . " LIKE '%" . $data['value'] . "'";
			
		} else if ($data['action'] == '%LIKE%') {
			
			$sql = "LCASE(" . $data['field'] . ") " . $data['not'] . " LIKE '%" . $data['value'] . "%'";
			
		} else if ($data['action'] == '%LIKE%LIKE%') {
			
			$sql = "LCASE(" . $data['field'] . ") " . $data['not'] . " LIKE '%" . str_replace (' ', '%', $data['value']) . "%'";
			
		} else {
			
			$sql = $data['not'] . " " . $data['field'] . "='" . $data['value'] . "'";
			
		}
		
		return $sql;
	}
}
?>