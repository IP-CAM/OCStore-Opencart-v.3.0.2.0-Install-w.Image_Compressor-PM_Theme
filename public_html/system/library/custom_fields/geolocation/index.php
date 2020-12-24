<?php
class CustomFieldsGeolocation {
	
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
		
		if(!file_exists(__DIR__.'/language/'.$language_code.'.php')) $language_code='en-gb';
		require('language/'.$language_code.'.php');
		
		$file = __DIR__.'/view/backend_'.$result['data']['type'].'.tpl';
		
		if (is_file($file)) {
			extract($data);

			ob_start();

			require($file);

			return ob_get_clean();
		}
	}
	
	public function renderFrontendView($result, $language_id, &$controller) {
		$result['data'] = unserialize($result['data']);
		$result['settings_data'] = unserialize($result['settings_data']);
		//require('language/'.$language.'.php');
		
		$file = __DIR__.'/view/frontend_'.$result['settings_data']['type'].'.tpl';
		
		if (is_file($file)) {
			//extract($data);

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
		$ret = array(
			'custom_fields_id'	=> $result['custom_fields_id'],
			'type'	=> $result['settings_data']['type'],
			'name'	=> $result['data'][$language_id]['name'],
			'description'	=> $result['data'][$language_id]['description'],
			'lat'	=> $result['data'][$language_id]['lat'],
			'lng'	=> $result['data'][$language_id]['lng'],
			'zoom'	=> $result['data'][$language_id]['zoom'],
			'width'	=> $result['data'][$language_id]['width']?($result['data'][$language_id]['width'].'px'):'100%',
			'height'	=> $result['data'][$language_id]['height']?($result['data'][$language_id]['height'].'px'):'400px',
		);
		return $ret;
	}
	
	public function validate($field){
		if(utf8_strlen($field['lat']) < 1 || utf8_strlen($field['lng'])<1){
			return false;
		}
		
		return true;
	}
	
}