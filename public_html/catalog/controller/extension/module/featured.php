<?php
class ControllerExtensionModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/featured');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						// $image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
						$image244w = $this->model_tool_image->resize($product_info['image'], 244, 244);
						$image344w = $this->model_tool_image->resize($product_info['image'], 344, 344);
						$image444w = $this->model_tool_image->resize($product_info['image'], 444, 444);
            $image = 'image/' . $product_info['image'];
					} else {
            $image244w = NULL;
            $image344w = NULL;
            $image444w = NULL;
						$image = PLACEHOLDER_IMAGE;
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            $price_clean = $this->currency->format($product_info['price'], $this->session->data['currency'], '', true, true);
            $price_before = floor($price_clean);
            $price_after = explode('.', $price_clean)[1];
					} else {
            $price = false;
            $price_clean = false;
            $price_before = false;
            $price_after = false;
					}

					if ((float)$product_info['special']) {
            $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            $special_clean = $this->currency->format($product_info['special'], $this->session->data['currency'], '', true, true);
            $special_before = floor($special_clean);
            $special_after = explode('.', $special_clean)[1];
					} else {
            $special = false;
            $special_clean = false;
            $special_before = false;
            $special_after = false;
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
						'product_id'        => $product_info['product_id'],
						'thumb'             => $image,
						'thumb244w'         => $image244w,
						'thumb344w'         => $image344w,
						'thumb444w'         => $image444w,
						'name'              => $product_info['name'],
						'description'       => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'             => $price,
						'special'           => $special,
						'tax'               => $tax,
						'rating'            => $rating,
						'rating_percent'    => (100 * $rating / 5) .'%',
						'reviews'           => $product_info['reviews'],
						'href'              => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
						'manufacturer'      => $product_info['manufacturer'],
						'price_clean'       => $price_clean,
						'price_before'      => $price_before,
						'price_after'       => $price_after,
						'special_clean'     => $special_clean,
						'special_before'    => $special_before,
						'special_after'     => $special_after
					);
				}
			}
		}

		if ($data['products']) {
			return $this->load->view('extension/module/featured', $data);
		}
	}
}
