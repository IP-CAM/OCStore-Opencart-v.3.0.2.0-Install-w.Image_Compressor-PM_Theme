<?php
/*
@author  nikifalex
@skype   logoffice1
@email    nikifalex@yandex.ru
*/

class ControllerExtensionModuleNkfSimilarProducts extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/nkf_similar_products');

		$this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('nkf_similar_products', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'].'&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_select_all'] = $this->language->get('text_select_all');
        $data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_status'] = $this->language->get('entry_status');
        $data['entry_use_category'] = $this->language->get('entry_use_category');
        $data['entry_delimiter'] = $this->language->get('entry_delimiter');
        $data['entry_price_percent'] = $this->language->get('entry_price_percent');
        $data['entry_delimiter_help'] = $this->language->get('entry_delimiter_help');
        $data['entry_use_price'] = $this->language->get('entry_use_price');
        $data['entry_use_cache'] = $this->language->get('entry_use_cache');
        $data['entry_use_quantity'] = $this->language->get('entry_use_quantity');
        $data['entry_use_manufacturer'] = $this->language->get('entry_use_manufacturer');
        $data['entry_add_diff_attributes'] = $this->language->get('entry_add_diff_attributes');
        $data['entry_use_featured_template'] = $this->language->get('entry_use_featured_template');
        $data['entry_excluded_attributes'] = $this->language->get('entry_excluded_attributes');
        $data['entry_cnt_diff'] = $this->language->get('entry_cnt_diff');
        $data['entry_included_categories'] = $this->language->get('entry_included_categories');
        $data['help_included_categories'] = $this->language->get('help_included_categories');
        $data['help_use_category'] = $this->language->get('help_use_category');
        $data['entry_category'] = $this->language->get('entry_category');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_run'] = $this->language->get('button_run');
        $data['user_token'] = $this->session->data['user_token'];


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

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
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

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/nkf_similar_products', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/nkf_similar_products', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/nkf_similar_products', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/nkf_similar_products', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->get['module_id']))
		    $data['module_id']=$this->request->get['module_id'];
		else
            $data['module_id']=0;

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info) && isset($module_info['name'])) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($module_info) && isset($module_info['title'])) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = '';
		}

        $data['run']='';
        if (!empty($module_info) && isset($module_info['use_cache']) && $module_info['use_cache'])
            $data['run'] = $this->url->link('extension/module/nkf_similar_products/run', 'module_id='.$this->request->get['module_id'].'&user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info) && isset($module_info['limit'])) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}

        if (isset($this->request->post['use_category'])) {
            $data['use_category'] = $this->request->post['use_category'];
        } elseif (!empty($module_info) && isset($module_info['use_category'])) {
            $data['use_category'] = $module_info['use_category'];
        } else {
            $data['use_category'] = 0;
        }

        if (isset($this->request->post['delimiter'])) {
            $data['delimiter'] = $this->request->post['delimiter'];
        } elseif (!empty($module_info) && isset($module_info['delimiter'])) {
            $data['delimiter'] = $module_info['delimiter'];
        } else {
            $data['delimiter'] = ',';
        }

        if (isset($this->request->post['price_percent'])) {
            $data['price_percent'] = $this->request->post['price_percent'];
        } elseif (!empty($module_info) && isset($module_info['price_percent'])) {
            $data['price_percent'] = $module_info['price_percent'];
        } else {
            $data['price_percent'] = '';
        }

        if (isset($this->request->post['use_price'])) {
            $data['use_price'] = $this->request->post['use_price'];
        } elseif (!empty($module_info) && isset($module_info['use_price'])) {
            $data['use_price'] = $module_info['use_price'];
        } else {
            $data['use_price'] = 1;
        }
        if (isset($this->request->post['use_cache'])) {
            $data['use_cache'] = $this->request->post['use_cache'];
        } elseif (!empty($module_info) && isset($module_info['use_cache'])) {
            $data['use_cache'] = $module_info['use_cache'];
        } else {
            $data['use_cache'] = 1;
        }
        if (isset($this->request->post['use_quantity'])) {
            $data['use_quantity'] = $this->request->post['use_quantity'];
        } elseif (!empty($module_info) && isset($module_info['use_quantity'])) {
            $data['use_quantity'] = $module_info['use_quantity'];
        } else {
            $data['use_quantity'] = 1;
        }


        if (isset($this->request->post['use_manufacturer'])) {
            $data['use_manufacturer'] = $this->request->post['use_manufacturer'];
        } elseif (!empty($module_info) && isset($module_info['use_manufacturer'])) {
            $data['use_manufacturer'] = $module_info['use_manufacturer'];
        } else {
            $data['use_manufacturer'] = 0;
        }
        if (isset($this->request->post['add_diff_attributes'])) {
            $data['add_diff_attributes'] = $this->request->post['add_diff_attributes'];
        } elseif (!empty($module_info) && isset($module_info['add_diff_attributes'])) {
            $data['add_diff_attributes'] = $module_info['add_diff_attributes'];
        } else {
            $data['add_diff_attributes'] = 1;
        }

        if (isset($this->request->post['use_featured_template'])) {
            $data['use_featured_template'] = $this->request->post['use_featured_template'];
        } elseif (!empty($module_info) && isset($module_info['use_featured_template'])) {
            $data['use_featured_template'] = $module_info['use_featured_template'];
        } else {
            $data['use_featured_template'] = 0;
        }

        // Categories
        $this->load->model('catalog/category');

        if (isset($this->request->post['included_categories'])) {
            $categories = $this->request->post['included_categories'];
        } elseif (!empty($module_info) && isset($module_info['included_categories'])) {
            $categories = $module_info['included_categories'];
        } else {
            $categories = array();
        }

        $data['included_categories'] = array();

        foreach ($categories as $category_id) {
            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
                $data['included_categories'][] = array(
                    'category_id' => $category_info['category_id'],
                    'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
                );
            }
        }


        if (isset($this->request->post['cnt_diff'])) {
            $data['cnt_diff'] = $this->request->post['cnt_diff'];
        } elseif (!empty($module_info) && isset($module_info['cnt_diff'])) {
            $data['cnt_diff'] = $module_info['cnt_diff'];
        } else {
            $data['cnt_diff'] = 3;
        }

        if (isset($this->request->post['excluded_attributes'])) {
            $data['excluded_attributes'] = $this->request->post['excluded_attributes'];
        } elseif (!empty($module_info) && isset($module_info['excluded_attributes'])) {
            $data['excluded_attributes'] = $module_info['excluded_attributes'];
        } else {
            $data['excluded_attributes'] = array();
        }


        $this->load->model('catalog/attribute');

        $data['attributes'] = $this->model_catalog_attribute->getAttributes();


		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info) && isset($module_info['width'])) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 200;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info) && isset($module_info['height'])) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 200;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info) && isset($module_info['status'])) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/nkf_similar_products', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/nkf_similar_products')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}

		return !$this->error;
	}

    public function install()
    {
        $this->load->model('extension/module/nkf_similar_products');
        $this->model_extension_module_nkf_similar_products->checkTables();
    }

    public function run() {
        $this->load->model('extension/module/nkf_similar_products');
        $this->model_extension_module_nkf_similar_products->checkTables();

        $this->load->language('extension/module/nkf_similar_products');
        if ($this->validateRun()) {
            $this->load->model('extension/module/nkf_similar_products');
            $this->model_extension_module_nkf_similar_products->run();
            $this->session->data['success'] = $this->language->get('text_success_run');
        }
        $this->response->redirect($this->url->link('extension/module/nkf_similar_products', 'module_id='.$this->request->get['module_id'].'&user_token=' . $this->session->data['user_token'], 'SSL'));
    }

    protected function validateRun() {
        if (!$this->user->hasPermission('modify', 'extension/module/nkf_similar_products')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }


    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "nkf_similar_product`");
    }


}