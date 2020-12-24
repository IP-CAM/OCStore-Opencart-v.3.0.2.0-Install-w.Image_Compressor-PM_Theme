<?php
class CustomFieldsDummy {
	
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
		
		$file = __DIR__.'/view/backend.tpl';
		
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
		$result['data'][$language_id]['value'] = html_entity_decode($result['settings_data'][$language_id]['text'], ENT_QUOTES, 'UTF-8');
		
		
		//require_once('language/'.$language.'.php');
		
		$file = __DIR__.'/view/frontend.tpl';
		
		if (is_file($file)) {
			//extract($data);

			ob_start();

			require($file);

			return ob_get_clean();
		}
	}
	
	public function renderFrontendAdvanced($result, $language_id, &$controller) {
		$result['data'] = unserialize($result['data']);
		$result['settings_data'] = unserialize($result['settings_data']);
		$result['data'][$language_id]['value'] = $result['settings_data'][$language_id]['text'];
		
		return html_entity_decode($result['data'][$language_id]['value'], ENT_QUOTES, 'UTF-8');
	}
	
	public function makeArray($result, $language_id, &$controller){
		$result['data'] = unserialize($result['data']);
		$result['settings_data'] = unserialize($result['settings_data']);
		
		$ret = array(
			'data'	=> html_entity_decode($result['settings_data'][$language_id]['text'], ENT_QUOTES, 'UTF-8'),
		);
		return $ret;
	}
	
	public function validate($field){
		/*
		if(utf8_strlen($field['text']) < 1){
			return false;
		}
		*/
		return true;
	}
	
}