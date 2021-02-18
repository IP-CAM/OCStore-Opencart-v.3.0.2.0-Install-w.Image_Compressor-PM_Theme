<?php
class ControllerExtensionModuleCarousel extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		// $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/swiper.min.css');
		// $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/opencart.css');
		// $this->document->addScript('catalog/view/javascript/jquery/swiper/js/swiper.jquery.js');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

    foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
        $image1x = $this->model_tool_image->resize($result['image'], $setting['width']*1, $setting['height']*1);
        $image2x = $this->model_tool_image->resize($result['image'], $setting['width']*2, $setting['height']*2);
        $image3x = $this->model_tool_image->resize($result['image'], $setting['width']*3, $setting['height']*3);
        $image = $image3x;

				$data['banners'][] = array(
					'title'   => $result['title'],
					'link'    => $result['link'],
					'image'   => $image,
					'image1x' => $image1x,
					'image2x' => $image2x,
					'image3x' => $image3x
				);
			}
		}

    $data['module'] = $module++;
    $data['html_heading'] = html_entity_decode($setting['html_heading'], ENT_QUOTES, 'UTF-8');

		return $this->load->view('extension/module/carousel', $data);
	}
}
