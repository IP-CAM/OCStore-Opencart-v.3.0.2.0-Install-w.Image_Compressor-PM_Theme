<?php
class CustomFieldsFile {
	
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
			
			$custom_fields_file = isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['file'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['file']:'';
			
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
			
			$custom_fields_file = $result['data'][$language_id]['file']?str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/', HTTP_SERVER, DIR_UPLOAD).$result['data'][$language_id]['file']:false;

			ob_start();

			require($file);

			return ob_get_clean();
		}
	}
	
	public function renderFrontendAdvanced($result, $language_id, &$controller) {
		$result['data'] = unserialize($result['data']);
		$custom_fields_file = $result['data'][$language_id]['file']?str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/', HTTP_SERVER, DIR_UPLOAD).$result['data'][$language_id]['file']:false;
		return '<a href="'.$custom_fields_file.'">'.$result['data'][$language_id]['name'].'</a>';
	}
	
	public function makeArray($result, $language_id, &$controller){
		$result['data'] = unserialize($result['data']);
		$result['settings_data'] = unserialize($result['settings_data']);
		
		$custom_fields_file = $result['data'][$language_id]['file']?str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/', HTTP_SERVER, DIR_UPLOAD).$result['data'][$language_id]['file']:false;
		
		$ret = array(
			'name'	=> $result['data'][$language_id]['name'],
			'file'	=> $custom_fields_file
		);
		return $ret;
	}
	
	public function validate($field){
		if(utf8_strlen($field['file']) < 1){
			return false;
		}
		
		return true;
	}
	
}