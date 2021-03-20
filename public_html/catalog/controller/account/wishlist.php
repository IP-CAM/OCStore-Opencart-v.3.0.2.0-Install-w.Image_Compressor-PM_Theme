<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerAccountWishList extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/wishlist');

		$this->load->model('account/wishlist');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['remove'])) {
			// Remove Wishlist
			$this->model_account_wishlist->deleteWishlist($this->request->get['remove']);

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->response->redirect($this->url->link('account/wishlist'));
		}

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setRobots('noindex,follow');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/wishlist')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['products'] = array();

		$results = $this->model_account_wishlist->getWishlist();

		foreach ($results as $result) {
			$product_info = $this->model_catalog_product->getProduct($result['product_id']);

			if ($product_info) {
				if ($product_info['image']) {
					// $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_wishlist_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_wishlist_height'));
          $image236w = $this->model_tool_image->resize($product_info['image'], 236, 236);
          $image344w = $this->model_tool_image->resize($product_info['image'], 344, 344);
          $image444w = $this->model_tool_image->resize($product_info['image'], 444, 444);
          $image     = 'image/' . $product_info['image'];
				} else {
					$image     = false;
          $image236w = NULL;
          $image344w = NULL;
          $image444w = NULL;
          $image     = PLACEHOLDER_IMAGE;
				}

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
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

				$data['products'][] = array(
					'product_id'     => $product_info['product_id'],
					'thumb'          => $image,
					'thumb236w'      => $image236w,
					'thumb344w'      => $image344w,
					'thumb444w'      => $image444w,
					'name'           => $product_info['name'],
					'model'          => $product_info['model'],
					'stock'          => $stock,
					'price'          => $price,
					'special'        => $special,
					'href'           => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'         => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id']),
					'price_clean'    => $price_clean,
					'price_before'   => $price_before,
					'price_after'    => $price_after,
					'special_clean'  => $special_clean,
					'special_before' => $special_before,
					'special_after'  => $special_after
				);
			} else {
				$this->model_account_wishlist->deleteWishlist($result['product_id']);
			}
		}

		$data['continue'] = $this->url->link('account/account', '', true);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/wishlist', $data));
	}

	public function add() {
		$this->load->language('account/wishlist');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if ($this->customer->isLogged()) {
				// Edit customers cart
				$this->load->model('account/wishlist');

				$this->model_account_wishlist->addWishlist($this->request->post['product_id']);

				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

				$json['total'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());

        $json['item_count'] = $this->model_account_wishlist->getTotalWishlist();
        $json['wishlist_link'] = $this->url->link('account/wishlist');

			} else {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}

				$this->session->data['wishlist'][] = $this->request->post['product_id'];

				$this->session->data['wishlist'] = array_unique($this->session->data['wishlist']);

				$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

        $json['need_registration'] = true;

				$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));

        $json['item_count'] = isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0;
        $json['login_link'] = $this->url->link('account/login', '', true);
        $json['register_link'] = $this->url->link('account/register', '', true);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
