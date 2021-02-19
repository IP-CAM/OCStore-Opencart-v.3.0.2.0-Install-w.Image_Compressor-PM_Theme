<?php
class ControllerExtensionModuleFeaturedCategory extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/featuredcategory');

		$this->load->model('catalog/category');

		$this->load->model('tool/image');

		$data['categories'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if (!empty($setting['categoriesadded'])) {

      $data['box_title'] = $setting['name'];
      $data['view_type'] = $setting['view_type'];

      $categories_data = array();

			foreach ($setting['categoriesadded'] as $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id);

				if ($category_info) {
                    $categories_data[] = $category_info;
				}
			}

			$categories = array_slice($categories_data, 0, (int)$setting['limit']);

			foreach ($categories as $category) {
				if ($category['image']) {
          $image40w  = $this->model_tool_image->resize($category['image'], 40, 40);
					$image80w  = $this->model_tool_image->resize($category['image'], 80, 80);
					$image128w = $this->model_tool_image->resize($category['image'], 128, 128);
					$image256w = $this->model_tool_image->resize($category['image'], 256, 256);
					$image     = $image256w;
				} else {
          $image40w  = NULL;
          $image80w  = NULL;
          $image128w = NULL;
          $image256w = NULL;
          $image     = PLACEHOLDER_IMAGE;
				}

				$data['categories'][] = array(
					'category_id' => $category['category_id'],
					'thumb'       => $image,
					'thumb40w'    => $image40w,
					'thumb80w'    => $image80w,
					'thumb128w'   => $image128w,
					'thumb256w'   => $image256w,
					'name'        => $category['name'],
          'href'        => $this->url->link('product/category', 'language=' . $this->config->get('config_language') . '&path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->config->get('config_language');

		if ($data['categories']) {
			return $this->load->view('extension/module/featuredcategory', $data);
		}
	}
}
