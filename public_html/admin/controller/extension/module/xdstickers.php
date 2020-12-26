<?php
class ControllerExtensionModuleXDStickers extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/xdstickers');
		$this->document->setTitle($this->language->get('heading_name'));
		$this->document->addScript('view/javascript/jquery/colorpicker.js');
		$this->document->addStyle('view/stylesheet/css/colorpicker.css');

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('setting/setting');
		$this->load->model('extension/module/xdstickers');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_extension_module_xdstickers->truncateCustomXDStickers();
			if (isset($this->request->post['custom_xdsticker'])) {
				foreach ($this->request->post['custom_xdsticker'] as $custom_xdsticker) {
					$this->model_extension_module_xdstickers->addCustomXDSticker($custom_xdsticker);
				}
			}

			$this->model_setting_setting->editSetting('xdstickers', $this->request->post);
			$this->model_setting_setting->editSetting('module_xdstickers', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			if ($this->request->post['xdstickers_apply']) {
				$this->response->redirect($this->url->link('extension/module/xdstickers', 'user_token=' . $this->session->data['user_token'], true));
			}

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		// Heading
		$data['heading_title'] = $this->language->get('heading_title');
		$data['heading_name'] = $this->language->get('heading_name');

		// Text
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_topleft'] = $this->language->get('text_topleft');
		$data['text_topright'] = $this->language->get('text_topright');

		//Buttons
		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_custom_xdsticker_add'] = $this->language->get('button_custom_xdsticker_add');

		// Styles
		$data['entry_xdstickers_styles'] = $this->language->get('entry_xdstickers_styles');
		$data['xdstickers_styles_help'] = $this->language->get('xdstickers_styles_help');
		$data['default_styles'] = '.xdstickers_wrapper {position:absolute; z-index:999; color:#fff; text-transform:uppercase; font-weight:bold; line-height:1.75;}
.xdstickers_wrapper.position_upleft {top:5px; left:15px; right:auto;}
.xdstickers_wrapper.position_upright {top:5px; right:15px; left:auto;}
.xdstickers {padding:0 10px; margin-bottom:5px;}
		';

		// Tab headers
		$data['text_tab_settings'] = $this->language->get('text_tab_settings');
		$data['text_tab_settings_title'] = $this->language->get('text_tab_settings_title');
		$data['text_tab_auto_stickers'] = $this->language->get('text_tab_auto_stickers');
		$data['text_tab_stock_stickers'] = $this->language->get('text_tab_stock_stickers');

		$data['text_tab_sold_title'] = $this->language->get('text_tab_sold_title');
		$data['text_tab_sale_title'] = $this->language->get('text_tab_sale_title');
		$data['text_tab_bestseller_title'] = $this->language->get('text_tab_bestseller_title');
		$data['text_tab_novelty_title'] = $this->language->get('text_tab_novelty_title');
		$data['text_tab_last_title'] = $this->language->get('text_tab_last_title');
		$data['text_tab_freeshipping_title'] = $this->language->get('text_tab_freeshipping_title');

		$data['text_tab_custom'] = $this->language->get('text_tab_custom');
		$data['text_tab_custom_title'] = $this->language->get('text_tab_custom_title');
		$data['text_tab_bulk_custom'] = $this->language->get('text_tab_bulk_custom');
		$data['text_tab_bulk_custom_title'] = $this->language->get('text_tab_bulk_custom_title');

		$data['text_tab_help'] = $this->language->get('text_tab_help');
		$data['text_tab_help_title'] = $this->language->get('text_tab_help_title');
		$data['text_help'] = $this->language->get('text_help');			

		// Entry
		$data['entry_xdstickers_status'] = $this->language->get('entry_xdstickers_status');
		$data['entry_xdstickers_position'] = $this->language->get('entry_xdstickers_position');

		$data['entry_sticker_title'] = $this->language->get('entry_sticker_title');
		$data['entry_sticker_text'] = $this->language->get('entry_sticker_text');
		$data['entry_sticker_color'] = $this->language->get('entry_sticker_color');
		$data['entry_sticker_bg'] = $this->language->get('entry_sticker_bg');
		$data['entry_sticker_property'] = $this->language->get('entry_sticker_property');
		$data['entry_sticker_status'] = $this->language->get('entry_sticker_status');

		$data['entry_sticker_sale_property'] = $this->language->get('entry_sticker_sale_property');
		$data['entry_sticker_bestseller_property'] = $this->language->get('entry_sticker_bestseller_property');
		$data['entry_sticker_novelty_property'] = $this->language->get('entry_sticker_novelty_property');
		$data['entry_sticker_last_property'] = $this->language->get('entry_sticker_last_property');
		$data['entry_sticker_freeshipping_property'] = $this->language->get('entry_sticker_freeshipping_property');

		// Ajax
		$data['text_delete_xdsticker_success'] = $this->language->get('text_delete_xdsticker_success');
		$data['text_delete_xdsticker_error'] = $this->language->get('text_delete_xdsticker_error');
		$data['text_error_ajax'] = $this->language->get('text_error_ajax');

		// BULK
		$data['entry_bulk_categories'] = $this->language->get('entry_bulk_categories');
		$data['text_all_categories'] = $this->language->get('text_all_categories');
		// $data['entry_bulk_manufacturers'] = $this->language->get('entry_bulk_manufacturers');
		// $data['text_all_manufacturers'] = $this->language->get('text_all_manufacturers');
		$data['entry_bulk_custom_xdstickers'] = $this->language->get('entry_bulk_custom_xdstickers');
		$data['entry_bulk_warning'] = $this->language->get('entry_bulk_warning');
		$data['button_custom_xdstickers_bulk_delete'] = $this->language->get('button_custom_xdstickers_bulk_delete');
		$data['button_custom_xdstickers_bulk'] = $this->language->get('button_custom_xdstickers_bulk');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'text' => $this->language->get('heading_name'),
			'href' => $this->url->link('extension/module/xdstickers', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/xdstickers', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		// Languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		// Main settings
		if (isset($this->request->post['xdstickers'])) {
			$data['xdstickers'] = $this->request->post['xdstickers'];
		} else {
			$data['xdstickers'] = $this->config->get('xdstickers');
		}

		// Get main settings
		$xdstickers = $data['xdstickers'];

		if ($xdstickers['position']) {
			$data['xdstickers']['position'] = $xdstickers['position'];
		} else {
			$data['xdstickers']['position'] = 0;
		}

		/*
		if ($xdstickers['status']) {
			$data['xdstickers']['status'] = $xdstickers['status'];
		} else {
			$data['xdstickers']['status'] = 0;
		}
		*/

		if (isset($xdstickers['inline_styles']) && $xdstickers['inline_styles'] != '') {
			$data['xdstickers']['inline_styles'] = trim($xdstickers['inline_styles']);
		} else {
			$data['xdstickers']['inline_styles'] = trim($data['default_styles']);
		}
		
		if (isset($this->request->post['module_xdstickers_status'])) {
			$data['module_xdstickers_status'] = $this->request->post['module_xdstickers_status'];
		} else {
			$data['module_xdstickers_status'] = $this->config->get('module_xdstickers_status');
		}		

		// Stock status stickers
		$sort = 'name';
		$order = 'ASC';
		$page = 1;

		$data['stock_statuses'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => 0,
			'limit' => 100
		);

		$this->load->model('localisation/stock_status');

		$stock_status_total = $this->model_localisation_stock_status->getTotalStockStatuses();

		$results = $this->model_localisation_stock_status->getStockStatuses($filter_data);

		foreach ($results as $result) {
			$data['stock_statuses'][] = array(
				'stock_status_id' => $result['stock_status_id'],
				'name'            => $result['name'],
				'name_stock_status' => $this->model_localisation_stock_status->getStockStatusDescriptions($result['stock_status_id'])
			);
		}

		// CUSTOM stickers
		$data['custom_xdstickers'] = array();
		$custom_xdstickers = $this->model_extension_module_xdstickers->getCustomXDStickers();
		if (empty($custom_xdstickers)) {
			$custom_xdstickers = array();
		} else {
			foreach ($custom_xdstickers as $custom_xdsticker) {
				$data['custom_xdstickers'][] = array(
					'xdsticker_id'	=> $custom_xdsticker['xdsticker_id'],
					'name'			=> $custom_xdsticker['name'],
					'text' 			=> json_decode($custom_xdsticker['text'], true),
					'bg_color'		=> $custom_xdsticker['bg_color'],
					'color_color'	=> $custom_xdsticker['color_color'],
					'status'		=> $custom_xdsticker['status'],
				);
			}
		}

		// var_dump($data['xdstickers']);

		// BULK Stickers
        $categories = $this->model_extension_module_xdstickers->getCategories();
		// $data['bulk_manufacturers'] = $this->model_extension_module_xdstickers->getManufacturers();
		$data['bulk_custom_xdstickers'] = $this->model_extension_module_xdstickers->getCustomXDStickers();
        $data['bulk_categories'] = $this->getAllCategories($categories);


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/xdstickers', $data));
	}

	public function install() {
		$sql = "SHOW TABLES LIKE '" . DB_PREFIX . "xdstickers'";
		if (count($this->db->query($sql)->rows) == 0) { // if not installed
			$sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xdstickers` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`xdsticker_id` int(11),
				`name` char(100) DEFAULT NULL,
				`text` varchar(255),
				`bg_color` char(100) DEFAULT NULL,
				`color_color` char(100) DEFAULT NULL,
				`status` tinyint(1) DEFAULT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			$this->db->query($sql);

			$sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xdstickers_product` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`product_id` int(11) NOT NULL,
				`xdsticker_id` int(11) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			$this->db->query($sql);
		}
	}
	
	public function uninstall() {
		$sql = "SHOW TABLES LIKE '" . DB_PREFIX . "xdstickers'";
		if (count($this->db->query($sql)->rows) != 0) { // if not installed
			$sql = "DROP TABLE IF EXISTS `" . DB_PREFIX . "xdstickers`";
			$this->db->query($sql);

			$sql = "DROP TABLE IF EXISTS `" . DB_PREFIX . "xdstickers_product`";
			$this->db->query($sql);
		}
	}

    public function delete_xdsticker() {
        $json = array();
		$this->load->language('extension/module/xdstickers');
        if (!$this->user->hasPermission('modify', 'extension/module/xdstickers')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->request['xdsticker_id'])) {
                $this->load->model('extension/module/xdstickers');
				$status = $this->model_extension_module_xdstickers->deleteCustomXDSticker($this->request->request['xdsticker_id']);
                if ($status) {
					$status = $this->model_extension_module_xdstickers->deleteCustomXDStickerProduct($this->request->request['xdsticker_id']);
					if ($status) {
						$json['success'] = $this->language->get('text_delete_xdsticker_success');
					} else {
						$json['error'] = $this->language->get('text_delete_xdstickers_error');
					}
                } else {
                    $json['error'] = $this->language->get('text_delete_xdstickers_error');
                }
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function getAllCategories($categories, $parent_id = 0, $parent_name = '') {
        $output = array();

        if (array_key_exists($parent_id, $categories)) {
            if ($parent_name != '') {
                $parent_name .= ' &gt; ';
            }

            foreach ($categories[$parent_id] as $category) {
                $output[$category['category_id']] = array(
                    'category_id' => $category['category_id'],
                    'name' => $parent_name . $category['name']
                );

                $output += $this->getAllCategories($categories, $category['category_id'], $parent_name . $category['name']);
            }
        }

        uasort($output, array(
            $this,
            'sortByName'
        ));

        return $output;
    }

    public function bulkAddCustomXDStickers() {
        $json = array();
		// var_dump($this->request->request);
		$this->load->language('extension/module/xdstickers');

        if (!$this->user->hasPermission('modify', 'extension/module/xdstickers')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
			// var_dump($json);
            if (isset($this->request->request['module_bulk_categories']) && empty($json)) {

                $this->load->model('extension/module/xdstickers');
                $this->load->language('extension/module/xdstickers');

                $status = $this->model_extension_module_xdstickers->updateBulkCustomXDStickerProduct($this->request->request['module_bulk_categories'], $this->request->request['module_bulk_custom_xdstickers']);
				// var_dump($status);
                if ($status) {
                    $json['success'] = $this->language->get('text_bulk_xdstickers_success');
                } else {
                    $json['error'] = $this->language->get('text_bulk_xdstickers_error');
                }
            } else {
                $json['error'] = $this->language->get('text_bulk_xdstickers_error');
            }
        }
		// var_dump($this->response);
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function bulkDeleteCustomXDStickers() {
        $json = array();
		// var_dump($this->request->request);
		$this->load->language('extension/module/xdstickers');

        if (!$this->user->hasPermission('modify', 'extension/module/xdstickers')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->request['module_bulk_categories']) && empty($json)) {

                $this->load->model('extension/module/xdstickers');
                $this->load->language('extension/module/xdstickers');

                $status = $this->model_extension_module_xdstickers->deleteBulkCustomXDStickerProduct($this->request->request['module_bulk_categories'], $this->request->request['module_bulk_custom_xdstickers']);
				// var_dump($status);
                if ($status) {
                    $json['success'] = $this->language->get('text_bulk_delete_xdstickers_success');
                } else {
                    $json['error'] = $this->language->get('text_bulk_delete_xdstickers_error');
                }
            } else {
                $json['error'] = $this->language->get('text_bulk_xdstickers_error');
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    function sortByName($a, $b) {
        return strcmp($a['name'], $b['name']);
    }

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/xdstickers')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}