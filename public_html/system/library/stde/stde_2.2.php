<?php

/**
 * @category OpenCart
 * @package StdE
 * @description Standard Library for creating of Extensions
 * @version 1.0.0
 * @copyright © Serge Tkach, 2019, http://sergetkach.com/
 */

/*
 * Использование библиотеки - изначально задумалось для уменьшения рутины при работе с контроллерами
 * Целеособразность применения в модели - пока что не рассматривалась
 */

class StdE {
	private $extension_code;
	private $module_info = array();
	// only modules monolithic has $module_info
	private $extension_type;
	private $setting = array();
	private $languages_array = array();

	public function __construct($registry) {
		$this->request	 = $registry->get('request');
		$this->config		 = $registry->get('config');
		$this->load			 = $registry->get('load');
		$this->session	 = $registry->get('session');
		$this->url			 = $registry->get('url');
		$this->language	 = $registry->get('language');
		$this->load	     = $registry->get('load');
	}
	
	// test
	public function getCode() {
		return $this->extension_code;
	}

	
	
	### SETTERS
	public function setCode($extension_code) {
		$this->extension_code = $extension_code;
	}
	
	/*
	 * module_with_blocks - can create blocks in catalog & instances in admin with module_id - save settings in table `module`
	 * extension_monolithic - can't create blocks in catalog - save settings in table `setting` or create new table
	 * ?? if I want add payment method ??
	 */

	public function setType($extension_type) {
		$this->extension_type = $extension_type;
	}

	public function setModuleInfo($module_info) {
		$this->module_info = $module_info;
	}

	
	
	### FIELDS
	public function field($key, $default_value = '') {
		switch ($this->extension_type) {
			case 'module_with_blocks':
				return $this->fieldModuleWithBlocks($key, $default_value);
				break;
			case 'extension_monolithic':
				return $this->fieldExtensionMonolithic($key, $default_value);
				break;
			default:
				break;
		}

		return false;
	}

	private function fieldModuleWithBlocks($key, $default_value) {
		if (!$key) {
			return false;
		}

		if (isset($this->request->post[$key])) {
			return $this->request->post[$key];
		} elseif ($this->module_info[$key]) {
			return $this->module_info[$key];
		} else {
			return $default_value;
		}

		return false;
	}

	public function fieldExtensionMonolithic($key, $default_value) {
		if (!$key) {
			return false;
		}

		// Magic for extension code in fields . Begin
		$key2 = $key;

		if (false === strpos($key2, $this->extension_code . '_')) {
			$key2 = $this->extension_code . '_' . $key2;
		}
		// Magic for extension code in fields . End

		if (isset($this->request->post[$key])) {
			return $this->request->post[$key];
		} elseif ($this->config->get($key2)) { // Magic for extension code in fields
			return $this->config->get($key2); // Magic for extension code in fields
		} else {
			return $default_value;
		}

		return false;
	}

	
	
	### SETTING
	public function settingSet($setting = array()) {
		$this->setting = $setting;
	}
	
	public function settingUnset() {
		$this->setting = array();
	}
	
	public function languages4Setting($languages = array()) {
		$this->languages_array = $languages;
	}
	
	/*
	 * Используется лишь в настройках модуля как аналог field
	 * Особенностью является то, что можно задать значение по умолчанию
	 * А это нужно лишь при обновлении настроек модуля, когда в базе текущей настройки еще не существует??
	 * Нет особого смысла использовать этот метод при получении настроек в каком-либо другом контроллере
	 */

	public function fieldSetting($key, $default_value = false) {
		if (!$key) {
			return false;
		}
		
		if (!is_array($this->setting)) {
			return '<b>setting is not array!</b>';
		}

		// Magic for extension code in fields . Begin
		$key2 = $key;

		if (false === strpos($key2, $this->extension_code . '_')) {
			$key2 = $this->extension_code . '_' . $key2;
		}
		// Magic for extension code in fields . End
		
		if (isset($this->setting[$key2])) {
			if (count($this->languages_array) > 0) {
				$return_value = array();
				
				$setting_value = $this->setting[$key2];
				
				foreach ($this->languages_array as $language_id => $item) {
					$return_value[$language_id] = $setting_value[$language_id];
				}
				
				return $return_value;
			} else {
				return $setting_value; // Magic for extension code in fields
			}	
		} else {	
			if (is_array($this->languages_array)) {
				$return_value = array();
				
				foreach ($this->languages_array as $language_id => $item) {
					$return_value[$language_id] = $default_value;
				}
				
				return $return_value;
			} else {
				return $default_value;
			}	
		}
		
		return false;
	}
	
	
	
	### BREADCRUMBPS
	public function breadcrumbs() {
		switch ($this->extension_type) {
			case 'module_with_blocks':
				return $this->breadcrumbsModuleWithBlocks();
				break;
			case 'extension_monolithic':
				return $this->breadcrumbsExtensionMonolithic();
				break;
			default:
				break;
		}

		return false;
	}

	public function breadcrumbsModuleWithBlocks() {
		$breadcrumbs = array();

		$breadcrumbs[] = array(
			'text'=>$this->language->get('text_home'),
			'href'=>$this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$breadcrumbs[] = array(
			'text'=>$this->language->get('text_extension'),
			'href'=>$this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
		);

		if (!isset($this->request->get['module_id'])) {
			$breadcrumbs[] = array(
				'text'=>$this->language->get('heading_title'),
				'href'=>$this->url->link('extension/module/' . $this->extension_code, 'token=' . $this->session->data['token'], true)
			);
		} else {
			$breadcrumbs[] = array(
				'text'=>$this->language->get('heading_title'),
				'href'=>$this->url->link('extension/module/' . $this->extension_code, 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		return $breadcrumbs;
	}

	public function breadcrumbsExtensionMonolithic() {
		$breadcrumbs = array();

		$breadcrumbs[] = array(
			'text'=>$this->language->get('text_home'),
			'href'=>$this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$breadcrumbs[] = array(
			'text'=>$this->language->get('text_extension'),
			'href'=>$this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
		);

		$breadcrumbs[] = array(
			'text'=>$this->language->get('heading_title'),
			'href'=>$this->url->link('extension/module/' . $this->extension_code, 'token=' . $this->session->data['token'], true)
		);

		return $breadcrumbs;
	}
	

	
	### LINKS
	// added in version 0.2.0
	public function link($target) {
		if (!$target)
			return false;

		if ('index' == $target) {
			return $this->url->link('extension/module/' . $this->extension_code, 'token=' . $this->session->data['token'], true);
		} elseif ('action' == $target) {
			return $this->url->link('extension/module/' . $this->extension_code, 'token=' . $this->session->data['token'], true);
		} elseif ('cancel' == $target) {
			return $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		} elseif (false !== strpos($target, 'part')) {
			return $this->url->link('extension/module/' . $this->extension_code . '/' . $target, 'token=' . $this->session->data['token'], true);
		}

		return false;
	}
	
	public function view($template, $data = array()) {
		return $this->load->view($template, $data);
	}
	

	
	### LANGUAGES
	public function languages($languages) {
		foreach ($languages as $key=> $language) {
			$languages[$key]['src'] = 'language/' . $language['code'] . '/' . $language['code'] . '.png';
		}

		return $languages;
	}

}
