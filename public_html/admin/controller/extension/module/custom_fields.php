<?php

class ControllerExtensionModuleCustomFields extends Controller {
	private $error = array();

	//private $types = array('text', 'integer', 'float', 'textarea', 'html', 'date', 'time', 'datetime', 'select', 'checkbox', 'image', 'imagelist', 'file', 'filelist', 'video', 'geolocation', 'dummy');
	
	public function index() {
		$this->load->language('extension/module/custom_fields');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { 
			$this->model_setting_setting->editSetting('module_custom_fields', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		
		$this->getList();
	}
	
	public function add() {
		$this->load->language('extension/module/custom_fields');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/custom_fields');
		
		$data['success'] = '';
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$custom_fields_id = $this->model_extension_module_custom_fields->addCustomField($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			

			$this->response->redirect($this->url->link('extension/module/custom_fields/edit', 'user_token=' . $this->session->data['user_token'] . '&custom_fields_id='. $custom_fields_id .'&type=module', true));
		}

		$this->getForm($data);
	}

	public function edit() {
		$this->load->language('extension/module/custom_fields');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/custom_fields');
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_module_custom_fields->editCustomField($this->request->get['custom_fields_id'], $this->request->post);

			//$this->session->data['success'] = $this->language->get('text_success');
			$data['success'] = $this->language->get('text_success');
			//$this->response->redirect($this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			
		}

		$this->getForm($data);
	}
	
	public function delete() {
		$this->load->language('extension/module/custom_fields');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/custom_fields');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $custom_field_id) {
				$this->model_extension_module_custom_fields->deleteCustomField($custom_field_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$this->getList();
	}
	
	
	public function getList(){
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'c.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		
		$data['add'] = $this->url->link('extension/module/custom_fields/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/custom_fields/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);
		
		$data['custom_fields'] = array();
		
		$this->load->model('extension/module/custom_fields');
		
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$custom_fields_total = $this->model_extension_module_custom_fields->getTotalCustomFields();
		
		$results = $this->model_extension_module_custom_fields->getCustomFields($filter_data);

		foreach($results as $result){
			$data['custom_fields'][] = array(
				'custom_fields_id'	=> $result['custom_fields_id'],
				'entity'			=> $result['entity'],
				'name'				=> $result['name'],
				'sort_order'		=> $result['sort_order'],
				'status'			=> $result['status'],
				'edit'				=> $this->url->link('extension/module/custom_fields/edit', 'user_token=' . $this->session->data['user_token'] . '&custom_fields_id=' . $result['custom_fields_id'] . $url, true)
			);
		}

		$data['action'] = $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['entry_status'] = $this->language->get('entry_status');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_entity'] = $this->language->get('column_entity');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		if (isset($this->request->post['module_custom_fields_status'])) {
			$data['module_custom_fields_status'] = $this->request->post['module_custom_fields_status'];
		} else {
			$data['module_custom_fields_status'] = $this->config->get('module_custom_fields_status');
		}
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . '&sort=c.name' . $url, true);
		$data['sort_entity'] = $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . '&sort=c.entity' . $url, true);
		$data['sort_sort_order'] = $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . '&sort=c.sort_order' . $url, true);
		$data['sort_status'] = $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . '&sort=c.status' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $custom_fields_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($custom_fields_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($custom_fields_total - $this->config->get('config_limit_admin'))) ? $custom_fields_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $custom_fields_total, ceil($custom_fields_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/custom_fields/list', $data));
	}
	
	
	protected function getForm($data) {
		
		$data['entities'] = array('category', 'manufacturer', 'product', 'information');
		$data['modes'] = array(
			1=>	array(
				'name'=> $this->language->get('text_modes_normal'),
				'description'=> $this->language->get('text_modes_normal_description'),
			),
			2=>	array(
				'name'=> $this->language->get('text_modes_advanced'),
				'description'=> sprintf($this->language->get('text_modes_advanced_description'), $this->language->get('text_dummy')),
			),
			3=>	array(
				'name'=> $this->language->get('text_modes_expert'),
				'description'=> $this->language->get('text_modes_expert_description'),
			),
		);
		
		//CKEditor
		if ($this->config->get('config_editor_default')) {
			$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
			$this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
		} else {
			$this->document->addScript('view/javascript/summernote/summernote.js');
			$this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
			$this->document->addScript('view/javascript/summernote/opencart.js');
			$this->document->addStyle('view/javascript/summernote/summernote.css');
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['custom_fields_id']) ? $this->language->get('text_fields_add') : $this->language->get('text_fields_edit');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_fields_title'] = $this->language->get('entry_fields_title');
		$data['entry_fields_description'] = $this->language->get('entry_fields_description');
		
		$data['entry_fields_sort_order'] = $this->language->get('entry_fields_sort_order');
		$data['entry_fields_status'] = $this->language->get('entry_fields_status');
		$data['entry_fields_entity'] = $this->language->get('entry_fields_entity');
		$data['entry_fields_type'] = $this->language->get('entry_fields_type');
		$data['entry_fields_tab'] = $this->language->get('entry_fields_tab');
		$data['entry_fields_required'] = $this->language->get('entry_fields_required');
		$data['entry_fields_error'] = $this->language->get('entry_fields_error');
		$data['entry_fields_mode'] = $this->language->get('entry_fields_mode');
		$data['entry_fields_showeditor'] = $this->language->get('entry_fields_showeditor');
		$data['entry_fields_showeditor_help'] = $this->language->get('entry_fields_showeditor_help');
		$data['entry_fields_place'] = $this->language->get('entry_fields_place');
		$data['entry_fields_place_help'] = $this->language->get('entry_fields_place_help');
		$data['entry_fields_placenum'] = $this->language->get('entry_fields_placenum');
		$data['entry_fields_placenum_help'] = $this->language->get('entry_fields_placenum_help');
		
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_frontend'] = $this->language->get('tab_frontend');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		
		if (isset($this->error['tab'])) {
			$data['error_tab'] = $this->error['tab'];
		} else {
			$data['error_tab'] = '';
		}
		
		if (isset($this->error['place'])) {
			$data['error_place'] = $this->error['place'];
		} else {
			$data['error_place'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['custom_fields_id'])) {
			$data['action'] = $this->url->link('extension/module/custom_fields/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/custom_fields/edit', 'user_token=' . $this->session->data['user_token'] . '&custom_fields_id=' . $this->request->get['custom_fields_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/custom_fields', 'user_token=' . $this->session->data['user_token'] . $url, true);
		
		$data['custom_fields_id']='';
		
		if (isset($this->request->get['custom_fields_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$custom_fields_info = $this->model_extension_module_custom_fields->getCustomField($this->request->get['custom_fields_id']);
			
			$data['custom_fields_id']=$custom_fields_info?$custom_fields_info['custom_fields_id']:'';
		}
		
		$data['user_token'] = $this->session->data['user_token'];
		$data['ckeditor'] = $this->config->get('config_editor_default');

		$this->load->model('localisation/language');

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($custom_fields_info)) {
			$data['name'] = $custom_fields_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} elseif (!empty($custom_fields_info)) {
			$data['description'] = $custom_fields_info['description'];
		} else {
			$data['description'] = '';
		}
		

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($custom_fields_info)) {
			$data['status'] = $custom_fields_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($custom_fields_info)) {
			$data['sort_order'] = $custom_fields_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}
		
		if (isset($this->request->post['entity'])) {
			$data['entity'] = $this->request->post['entity'];
		} elseif (!empty($custom_fields_info)) {
			$data['entity'] = $custom_fields_info['entity'];
		} else {
			$data['entity'] = '';
		}
		
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($custom_fields_info)) {
			$data['type'] = $custom_fields_info['type'];
		} else {
			$data['type'] = '';
		}
		
		if (isset($this->request->post['tab'])) {
			$data['tab'] = $this->request->post['tab'];
		} elseif (!empty($custom_fields_info)) {
			$data['tab'] = $custom_fields_info['tab'];
		} else {
			$data['tab'] = '';
		}
		
		if (isset($this->request->post['place'])) {
			$data['place'] = $this->request->post['place'];
		} elseif (!empty($custom_fields_info)) {
			$data['place'] = $custom_fields_info['place'];
		} else {
			$data['place'] = '';
		}
		
		if (isset($this->request->post['placenum'])) {
			$data['placenum'] = $this->request->post['placenum'];
		} elseif (!empty($custom_fields_info)) {
			$data['placenum'] = $custom_fields_info['placenum'];
		} else {
			$data['placenum'] = 0;
		}
		
		if (isset($this->request->post['required'])) {
			$data['required'] = $this->request->post['required'];
		} elseif (!empty($custom_fields_info)) {
			$data['required'] = $custom_fields_info['required'];
		} else {
			$data['required'] = 0;
		}
		
		if (isset($this->request->post['texterror'])) {
			$data['texterror'] = $this->request->post['texterror'];
		} elseif (!empty($custom_fields_info)) {
			$data['texterror'] = $custom_fields_info['texterror'];
		} else {
			$data['texterror'] = '';
		}
		
		if (isset($this->request->post['mode'])) {
			$data['mode'] = $this->request->post['mode'];
		} elseif (!empty($custom_fields_info)) {
			$data['mode'] = $custom_fields_info['mode'];
		} else {
			$data['mode'] = 1;
		}
		
		if (isset($this->request->post['showeditor'])) {
			$data['showeditor'] = $this->request->post['showeditor'];
		} elseif (!empty($custom_fields_info)) {
			$data['showeditor'] = $custom_fields_info['showeditor'];
		} else {
			$data['showeditor'] = 1;
		}
		
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['lang'] = $this->language->get('lang');
		
		$empty_advanced=array();
		foreach($data['languages'] as $language){
			$empty_advanced[$language['language_id']]['text']=$this->language->get('text_dummy');
		}

		if (isset($this->request->post['advanced'])) {
			$data['advanced'] = $this->request->post['advanced'];
		} elseif (isset($this->request->get['custom_fields_id'])) {
			$data['advanced'] = unserialize(isset($custom_fields_info['advanced'])?$custom_fields_info['advanced']:'');
		} else {
			$data['advanced'] = array();
		}
		
		require_once(DIR_SYSTEM . 'library/custom_fields.php');
		$custom_fields = new CustomFields();
		
		$data['types'] = $custom_fields->getTypes();
		
		
		
		$data['user_token'] = $this->session->data['user_token'];
		$data['custom_fields_id'] = isset($this->request->get['custom_fields_id'])?$this->request->get['custom_fields_id']:0;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/custom_fields/form', $data));
	}
	
	
	public function getFieldAjax(){
		$json = array();
		
		if (isset($this->request->post['type']) && isset($this->request->post['custom_fields_id'])) {
			$type = $this->request->post['type'];
			//if (in_array($type, $this->types)){
				if(file_exists(DIR_SYSTEM . 'library/custom_fields/'.$type.'/index.php')){
					$this->load->model('localisation/language');
					$languages = $this->model_localisation_language->getLanguages();
					
					require_once(DIR_SYSTEM . 'library/custom_fields/'.$type.'/index.php');
					$class='CustomFields'.$type;
					
					$cl = new $class();
					
					if($this->request->post['custom_fields_id']){
						$this->load->model('extension/module/custom_fields');

						$custom_field = $this->model_extension_module_custom_fields->getCustomField($this->request->post['custom_fields_id']);
						if(isset($custom_field['data'])){	
							$fields = $cl->getFields($custom_field['data'], $this->config->get('config_admin_language'), $languages, $this->config->get('config_editor_default'));
						}else{
							$fields = $cl->getFields('', $this->config->get('config_admin_language'), $languages, $this->config->get('config_editor_default'));
						}
					}else{
						$fields = $cl->getFields('', $this->config->get('config_admin_language'), $languages, $this->config->get('config_editor_default'));
					}
					$json['success'] = $fields;
				}
			//}
		}
		$this->response->setOutput(json_encode($json));
	}
	
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/custom_fields')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
			
		if ((utf8_strlen($this->request->post['tab']) < 3) || (utf8_strlen($this->request->post['tab']) > 255)) {
			$this->error['tab'] = $this->language->get('error_tab');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/custom_fields')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/custom_fields')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function install() {
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "custom_fields_settings'");
		if(!$query->num_rows){
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "custom_fields_settings` (`custom_fields_id` int(11) NOT NULL, `name` varchar(255) NOT NULL, `description` varchar(255) NOT NULL, `entity` varchar(255) NOT NULL, `type` varchar(255) NOT NULL, `tab` varchar(255) NOT NULL, `required` tinyint(1) NOT NULL, `texterror` varchar(255) NOT NULL, `data` text NOT NULL, `status` tinyint(1) NOT NULL, `mode` tinyint(1) NOT NULL, `showeditor` tinyint(1) NOT NULL DEFAULT '1', `advanced` longtext NOT NULL, `place` varchar(64) NOT NULL, `placenum` int(3) NOT NULL, `sort_order` int(3) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "custom_fields_settings` ADD PRIMARY KEY (`custom_fields_id`);");
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "custom_fields_settings` MODIFY `custom_fields_id` int(11) NOT NULL AUTO_INCREMENT;");
		}
		
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "custom_fields'");
		if(!$query->num_rows){				
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "custom_fields` (`custom_fields_id` int(11) NOT NULL, `entity` varchar(255) NOT NULL, `data` text NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "custom_fields` ADD PRIMARY KEY (`custom_fields_id`,`entity`);");
		}
	   
		$this->load->model('setting/event');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'admin/view/catalog/category_form/before', 'extension/module/custom_fields/processData');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'admin/view/catalog/category_form/after', 'extension/module/custom_fields/processOutput');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'admin/view/catalog/manufacturer_form/before', 'extension/module/custom_fields/processData');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'admin/view/catalog/manufacturer_form/after', 'extension/module/custom_fields/processOutput');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'admin/view/catalog/product_form/before', 'extension/module/custom_fields/processData');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'admin/view/catalog/product_form/after', 'extension/module/custom_fields/processOutput');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'admin/view/catalog/information_form/before', 'extension/module/custom_fields/processData');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'admin/view/catalog/information_form/after', 'extension/module/custom_fields/processOutput');

		$this->model_setting_event->addEvent('kur1977_custom_fields', 'catalog/view/product/category/before', 'extension/module/custom_fields/processData');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'catalog/view/product/category/after', 'extension/module/custom_fields/processOutput');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'catalog/view/product/manufacturer_info/before', 'extension/module/custom_fields/processData');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'catalog/view/product/manufacturer_info/after', 'extension/module/custom_fields/processOutput');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'catalog/view/product/product/before', 'extension/module/custom_fields/processData');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'catalog/view/product/product/after', 'extension/module/custom_fields/processOutput');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'catalog/view/information/information/before', 'extension/module/custom_fields/processData');
		$this->model_setting_event->addEvent('kur1977_custom_fields', 'catalog/view/information/information/after', 'extension/module/custom_fields/processOutput');
   }

   public function uninstall() {
       $this->load->model('setting/event');
       $this->model_setting_event->deleteEventByCode('kur1977_custom_fields');
   }
   
	public function processData($route, &$data){
		
		if(!$this->config->get('module_custom_fields_status'))return;
		
		$controller = str_replace(array('catalog/', '_form'), '', $route);
		if(!$controller) return;
	
		
		$this->load->model('extension/module/custom_fields');
		$filter_data = array(
			'filter_entity'	=> $controller,
			'filter_status'=>1,
			'sort'  => 'c.sort_order',
			'order' => 'ASC',
			'start' => 0,
			'limit' => 1000
		);
		$results = $this->model_extension_module_custom_fields->getCustomFields($filter_data);
				
		$data['custom_fields'] = array();
		
		$data['tabs'] = array();
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach($results as $result){
			if(file_exists(DIR_SYSTEM . 'library/custom_fields/'.$result['type'].'/index.php')){
			
			require_once(DIR_SYSTEM . 'library/custom_fields/'.$result['type'].'/index.php');
			$class='CustomFields'.$result['type'];
			$cl = new $class();	
				if(!in_array($result['tab'], $data['tabs'])){
					$data['tabs'][] = $result['tab'];
				}
					
				foreach ($languages as $language) {				
					$field_view = $cl->renderBackendView($result, $data, $language, $this->config->get('config_admin_language'), $this);
					$data['custom_fields'][$result['tab']][$language['language_id']][] = $field_view;
				}				
								
			}
		}		
	}
	
	public function processOutput($route, $data, &$output){
		
		
		
		if(!$this->config->get('module_custom_fields_status'))return;
		require_once(DIR_SYSTEM . 'library/simple_html_dom.php');
		
		$html = str_get_html($output, true, true, DEFAULT_TARGET_CHARSET, false);
		$ul = $html->find('ul.nav-tabs', 0);
		
		$content = $html->find('div.tab-content', 0);
		$head = $html->find('head',0);
		$new_tab_pane_text='';
		
		
		
		require_once(DIR_SYSTEM . 'library/custom_fields.php');
		$cl = new CustomFields();
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		if($data['tabs']){
			$head->innertext .= '<script src="view/javascript/custom_fields/custom_fields.js" type="text/javascript"></script>';
			//$head->innertext .= '<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>';
		}
		
		foreach($data['tabs'] as $tab){
			$ul->innertext .= '<li><a href="#tab-'.$this->translit($tab).'" data-toggle="tab">'.$tab.'</a></li>';
			$new_tab_pane_text .='<div class="tab-pane" id="tab-'.$this->translit($tab).'">';
			
			$new_tab_pane_text .= $cl->renderLangTabs($languages, $this->translit($tab));
			
			foreach ($languages as $language) {
				$new_tab_pane_text .= $cl->renderLangBegin($language, $this->translit($tab));
				foreach($data['custom_fields'][$tab][$language['language_id']] as $field){
					$new_tab_pane_text .= $field;
				}
				$new_tab_pane_text .= $cl->renderLangEnd($this->translit($tab));
			}
			
			$new_tab_pane_text .= $cl->renderScript($this->translit($tab));
			$new_tab_pane_text .='</div>';
		}
		
		$content->innertext = $new_tab_pane_text.$content->innertext;
		
		$html->save();
		
		$output = $html;
		
	}
	

	private function translit($insert){ 
		//$insert = mb_strtolower($insert);    // Если работаем с юникодными строками
		$insert = utf8_strtolower($insert); 
		$replase = array(
		// Буквы
		'а'=>'a',
		'б'=>'b',
		'в'=>'v',
		'г'=>'g',
		'д'=>'d',
		'е'=>'e',
		'ё'=>'yo',
		'ж'=>'zh',
		'з'=>'z',
		'и'=>'i',
		'й'=>'j',
		'к'=>'k',
		'л'=>'l',
		'м'=>'m',
		'н'=>'n',
		'о'=>'o',
		'п'=>'p',
		'р'=>'r',
		'с'=>'s',
		'т'=>'t',
		'у'=>'u',
		'ф'=>'f',
		'х'=>'h',
		'ц'=>'c',
		'ч'=>'ch',
		'ш'=>'sh',
		'щ'=>'shh',
		'ъ'=>'j',
		'ы'=>'y',
		'ь'=>'',
		'э'=>'e',
		'ю'=>'yu',
		'я'=>'ya',
		// Всякие знаки препинания и пробелы
		' '=>'-',
		' - '=>'-',
		'_'=>'-',
		//Удаляем
		'.'=>'',
		':'=>'',
		';'=>'',
		','=>'',
		'!'=>'',
		'?'=>'',
		'>'=>'',
		'<'=>'',
		'&'=>'',
		'*'=>'',
		'%'=>'',
		'$'=>'',
		'"'=>'',
		'\''=>'',
		'('=>'',
		')'=>'',
		'`'=>'',
		'+'=>'',
		'/'=>'',
		'\\'=>'',
		);
		$insert=preg_replace("/\s+/"," ",$insert); // Удаляем лишние пробелы
		$insert = strtr($insert,$replase);
		return $insert;
	}
}