<?php
class CustomFieldsImagelist {
	
	public function __construct() {
		
	}
	
	public function getFields($result, $language, $languages, $ckeditor) {
		
		if(!file_exists(__DIR__.'/language/'.$language.'.php')) $language='en-gb';
		require_once('language/'.$language.'.php');
	
		$result = unserialize($result);
		
		$file = __DIR__.'/view/data.tpl';
		
		if (is_file($file)) {
			//extract($data);

			ob_start();

			require($file);

			return ob_get_clean();
		}
	}
	
	public function renderBackendView($result, $data, $language, $language_code, &$controller) {
		$result['data'] = unserialize($result['data']);
		
		extract($data);
		
		if(!file_exists(__DIR__.'/language/'.$language_code.'.php')) $language_code='en-gb';
		require('language/'.$language_code.'.php');
		
		$file = __DIR__.'/view/backend.tpl';
		
		if (is_file($file)) {
			
			
			$custom_fields_placeholder = $controller->model_tool_image->resize('no_image.png', 100, 100);
			
			$custom_fields_images = array();
			if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['imagelist'])){
				foreach($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['imagelist'] as $key=>$val){
					$custom_fields_images []=array(
						'image'	=> isset($val['image'])?$val['image']:'',
						'thumb'	=> isset($val['image'])?$controller->model_tool_image->resize($val['image'], 100, 100):$controller->model_tool_image->resize('no_image.png', 100, 100),
						'mode'	=> isset($val['mode'])?$val['mode']:0,
						'link'	=> isset($val['link'])?$val['link']:'',
						'new'	=> isset($val['new'])?$val['new']:0,
					); 
					
					
				}
			}
			ob_start();

			require($file);

			return ob_get_clean();
		}
	}
	
	public function renderFrontendView($result, $language_id, &$controller) {
		$result['data'] = unserialize($result['data']);
		//require_once('language/'.$language.'.php');
		
		$result['settings_data'] = unserialize($result['settings_data']);
		
		$file = __DIR__.'/view/frontend.tpl';
		
		if (is_file($file)) {
			//extract($data);
			
			$custom_fields_images = array();
			if(isset($result['data'][$language_id]['imagelist'])){
				foreach($result['data'][$language_id]['imagelist'] as $key=>$val){
					$custom_fields_images []=array(
						'image'	=> $val['image']?$controller->model_tool_image->resize($val['image'], $result['settings_data']['popup_width'], $result['settings_data']['popup_height']):false,
						'thumb'	=> $val['image']?$controller->model_tool_image->resize($val['image'], $result['settings_data']['preview_width'], $result['settings_data']['preview_height']):false,
						'mode'	=> $val['mode'],
						'link'	=> $val['link'],
						'new'	=> $val['new'],
					); 
					
					
				}
			}
			
			ob_start();

			require($file);

			return ob_get_clean();
		}
	}
	
	public function renderFrontendAdvanced($result, $language_id, &$controller) {
		return $this->renderFrontendView($result, $language_id, $controller);
	}
	
	public function makeArray($result, $language_id, &$controller){
		$result['data'] = unserialize($result['data']);
		$result['settings_data'] = unserialize($result['settings_data']);
		
		$custom_fields_images = array();
		if(isset($result['data'][$language_id]['imagelist'])){
			foreach($result['data'][$language_id]['imagelist'] as $key=>$val){
				$custom_fields_images []=array(
					'image'	=> $val['image']?$controller->model_tool_image->resize($val['image'], $result['settings_data']['popup_width'], $result['settings_data']['popup_height']):false,
					'thumb'	=> $val['image']?$controller->model_tool_image->resize($val['image'], $result['settings_data']['preview_width'], $result['settings_data']['preview_height']):false,
					'mode'	=> $val['mode'],
					'link'	=> $val['link'],
					'new'	=> $val['new'],
				); 
				
				
			}
		}
		
		$ret = array(
			'imagelist'	=> $custom_fields_images,
		);
		return $ret;
	}
	
	public function validate($field){
		if(!$field){
			return false;
		}
		
		return true;
	}
	
}