<?php
class ControllerExtensionModuleCustomFields extends Controller {
	
	public function processData(&$route, &$data){
		if(!$this->config->get('module_custom_fields_status'))return;
		
		$controller = preg_replace('/.*\//', '', $route);
		if(!$controller) return;
		
		
		switch ($controller){
			case 'category':
				$parts = explode('_', (string)$this->request->get['path']);
				$id = (int)array_pop($parts);
				break;
			case 'manufacturer_info':
				$controller = 'manufacturer';
				$id = (int)$this->request->get['manufacturer_id'];
				break;
			case 'product':
				$id = (int)$this->request->get['product_id'];
				break;
			case 'information':
				$id = (int)$this->request->get['information_id'];
				break;
		}

		$this->load->model('extension/module/custom_fields');
		
		$results = $this->model_extension_module_custom_fields->getCustomFields($controller, $id);
	
		$data['custom_fields'] = array();		
	
		foreach($results as $result){
			$field_view='';
			if($result['mode']!=3){
				if(file_exists(DIR_SYSTEM . 'library/custom_fields/'.$result['type'].'/index.php')){
					require_once(DIR_SYSTEM . 'library/custom_fields/'.$result['type'].'/index.php');
					$class='CustomFields'.$result['type'];
					$cl = new $class();
					
					$field_view = $cl->renderFrontendView($result, $this->config->get('config_language_id'), $this);
					if($result['mode']==2){
						$advanced = unserialize($result['advanced']);
						$advanced = html_entity_decode($advanced[$this->config->get('config_language_id')]['text'], ENT_QUOTES, 'UTF-8');
						$field_view = $cl->renderFrontendAdvanced($result, $this->config->get('config_language_id'), $this);
						
						$field_view = str_replace('{#custom_field#}', $field_view, $advanced);
						
					}
					$data['custom_fields'][] = array(
						'place'			=> $result['place'],
						'placenum'		=> $result['placenum'],
						'field_view'	=>$field_view,
					);
				}
			}else{
				if(file_exists(DIR_SYSTEM . 'library/custom_fields/'.$result['type'].'/index.php')){
					require_once(DIR_SYSTEM . 'library/custom_fields/'.$result['type'].'/index.php');
					$class='CustomFields'.$result['type'];
					$cl = new $class();
					$data['custom_field_'.$result['custom_fields_id']] = $cl->makeArray($result, $this->config->get('config_language_id'), $this);
				}
				//print_r($data['custom_field_'.$result['custom_fields_id']]);
			}
		}
		
		
	}
	
	public function processOutput($route, $data, &$output){
		
		if(!$this->config->get('module_custom_fields_status'))return;
		
		require_once(DIR_SYSTEM . 'library/simple_html_dom.php');
		
		$html = str_get_html($output, true, true, DEFAULT_TARGET_CHARSET, false);
		
		$head = $html->find('head',0);
		
		
		if($data['custom_fields'])$head->innertext .= '<link href="catalog/view/theme/default/stylesheet/custom_fields.css" rel="stylesheet">';
		
		
		foreach($data['custom_fields'] as $field){
			$content = $html->find($field['place'], $field['placenum']);
			
			
			if($content){
				$content->innertext .= $field['field_view'];
			}
		}
		
		
		$html->save();
		
		$output = $html;
		
	}
}
?>