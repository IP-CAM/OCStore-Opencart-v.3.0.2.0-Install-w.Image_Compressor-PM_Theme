<?php

class ControllerExtensionModuleMatrositeLooked extends Controller {
	public function index() {

		$this->load->model('setting/setting');
		$this->load->language('extension/module/matrosite/looked');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');


		$setting = $this->model_setting_setting->getSetting('module_matrosite_looked');

		if ( !isset($setting['module_matrosite_looked_limit']) ) {
			$setting['module_matrosite_looked_limit'] = 4;
		}

		if ( (int)$setting['module_matrosite_looked_status'] == 1 ) {

			$data['heading_title'] = $this->language->get('matrosite_looked_title');

			if (isset($this->session->data['matrosite']['looked'])) {
				$products = $this->session->data['matrosite']['looked'];
			} else {
				$products = array();
			}

			if (isset($this->request->get['product_id'])) {

				$isset = false; // Флаг присутствия текущего товара в списке

				foreach($products as $key => $product_id){
					if ($product_id == $this->request->get['product_id']) {
						$isset = true;
						unset($products[$key]);
					}
				}

				if (!$isset) {
					$this->session->data['matrosite']['looked'][] = $this->request->get['product_id'];
				}

				// Удаляем излишки
				if (count($this->session->data['matrosite']['looked']) > (int)$setting['module_matrosite_looked_limit']) {
					$iteration = count($this->session->data['matrosite']['looked']) - (int)$setting['module_matrosite_looked_limit'];
					for ($i=0; $i<$iteration; $i++){
						array_shift($this->session->data['matrosite']['looked']);
					}
				}

			}

			$data['products'] = array();
			foreach(array_reverse($products) as $key => $product_id){
				$product_info = $this->model_catalog_product->getProduct($product_id);
				if ($product_info) {
					if ($product_info['image']) {
						// $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
            $image236w = $this->model_tool_image->resize($product_info['image'], 236, 236);
						$image344w = $this->model_tool_image->resize($product_info['image'], 344, 344);
						$image444w = $this->model_tool_image->resize($product_info['image'], 444, 444);
            $image = 'image/' . $product_info['image'];
					} else {
						// $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
            $image236w = NULL;
            $image344w = NULL;
            $image444w = NULL;
						$image = PLACEHOLDER_IMAGE;
					}

          $this->registry->set('custom_price', new CustomPrice($this->registry));

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            $price_integer = $this->custom_price->getPriceInteger($product_info['price']);
            $price_decimal = $this->custom_price->getPriceDecimal($product_info['price']);
					} else {
						$price = false;
            $price_integer = false;
            $price_decimal = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            $special_integer = $this->custom_price->getPriceInteger($product_info['special']);
            $special_decimal = $this->custom_price->getPriceDecimal($product_info['special']);
					} else {
						$special = false;
            $special_integer = false;
            $special_decimal = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					$data['products'][] = array(
						'product_id'     => $product_info['product_id'],
						'thumb'          => $image,
						'thumb236w'      => $image236w,
						'thumb344w'      => $image344w,
						'thumb444w'      => $image444w,
						'name'           => $product_info['name'],
						'description'    => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'          => $price,
						'special'        => $special,
						'tax'            => $tax,
						'rating'         => $rating,
						'rating_percent' => (100 * $rating / 5) .'%',
						'reviews'        => $product_info['reviews'],
						'href'           => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
						'manufacturer'   => $product_info['manufacturer'],
						'price_integer'   => $price_integer,
						'price_decimal'    => $price_decimal,
						'special_integer' => $special_integer,
						'special_decimal'  => $special_decimal
					);
				}
			}

      $data['price_currency_symbol'] = $this->currency->getSymbolRight($this->session->data['currency']);

			$data['count'] = count($data['products']);

			if ($data['products']) {
				return $this->load->view('extension/module/matrosite_looked', $data);
			}

		}
	}
}
