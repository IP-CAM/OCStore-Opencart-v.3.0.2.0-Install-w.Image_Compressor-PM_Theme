<?php
class CustomFieldsImage {
	
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
			
			$custom_fields_image = isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['image'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['image']:'';
			
			$custom_fields_thumb = isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['image'])?$controller->model_tool_image->resize($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['image'], 100, 100):$controller->model_tool_image->resize('no_image.png', 100, 100);

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
			
			$custom_fields_thumb = $result['data'][$language_id]['image']?$controller->model_tool_image->resize($result['data'][$language_id]['image'], $result['settings_data']['preview_width'], $result['settings_data']['preview_height']):false;
			
			$custom_fields_image = $result['data'][$language_id]['image']?$controller->model_tool_image->resize($result['data'][$language_id]['image'], $result['settings_data']['popup_width'], $result['settings_data']['popup_height']):false;

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
		
		$custom_fields_thumb = $result['data'][$language_id]['image']?$controller->model_tool_image->resize($result['data'][$language_id]['image'], $result['settings_data']['preview_width'], $result['settings_data']['preview_height']):false;
			
		$custom_fields_image = $result['data'][$language_id]['image']?$controller->model_tool_image->resize($result['data'][$language_id]['image'], $result['settings_data']['popup_width'], $result['settings_data']['popup_height']):false;
		
		$ret = array(
			'thumb'	=> $custom_fields_thumb,
			'image'	=> $custom_fields_image,
			'mode'	=> $result['data'][$language_id]['mode'],
			'link'	=> $result['data'][$language_id]['link'],
			'new'	=> $result['data'][$language_id]['new'],
		);
		return $ret;
	}
	
	public function validate($field){
		if(utf8_strlen($field['image']) < 1){
			return false;
		}
		
		return true;
	}
	
}