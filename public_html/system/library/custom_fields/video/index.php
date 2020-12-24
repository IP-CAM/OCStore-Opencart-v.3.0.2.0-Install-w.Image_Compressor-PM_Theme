<?php
class CustomFieldsVideo {
	
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
		//require('language/'.$language.'.php');
		
		$file = __DIR__.'/view/frontend.tpl';
		
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
		$ret = array(
			'link'	=> $result['data'][$language_id]['link'],
			'title'	=> $result['data'][$language_id]['title'],
			'vid'	=> $result['data'][$language_id]['vid'],
			'width'	=> $result['data'][$language_id]['width'],
			'height'	=> $result['data'][$language_id]['height'],
			'thumb'	=> $result['data'][$language_id]['thumb'],
			'html'	=> $result['data'][$language_id]['html'],
		);
		return $ret;
	}
	
	public function validate($field){
		if(utf8_strlen($field['link']) < 1){
			return false;
		}
		
		return true;
	}
	
}