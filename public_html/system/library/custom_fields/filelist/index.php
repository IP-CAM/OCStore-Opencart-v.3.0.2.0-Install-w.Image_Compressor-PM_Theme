<?php
class CustomFieldsFilelist {
	
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
			
			$custom_fields_files = array();
			if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['filelist'])){
				foreach($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['filelist'] as $key=>$val){
					$custom_fields_files []=$val;										
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
			if(isset($result['data'][$language_id]['filelist'])){
				foreach($result['data'][$language_id]['filelist'] as $key=>$val){
					$custom_fields_files []=array(
						'name'	=> $val['name'],
						'file'	=> $val['file']?str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/', HTTP_SERVER, DIR_UPLOAD).$val['file']:false
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
		
		$custom_fields_files = array();
		if(isset($result['data'][$language_id]['filelist'])){
			foreach($result['data'][$language_id]['filelist'] as $key=>$val){ 
				$custom_fields_files []=array(
					'name'	=> $val['name'],
					'file'	=> $val['file']?str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/', HTTP_SERVER, DIR_UPLOAD).$val['file']:false
				); 
				
				
			}
		}
		
		$ret = array(
			'filelist'	=> $custom_fields_files,
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