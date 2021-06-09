<?php

class ControllerCheckoutCheckoutShipping extends Controller {
	public function index() {
    $this->load->language('checkout/checkout');

    // Получаем методы доставки
    $data['shipping_methods'] = $this->session->data['shipping_methods'] = $this->getMethods();

    if (empty($this->session->data['shipping_methods'])) {
			$data['error_warning'] = $this->language->get('error_no_shipping');
		} else {
			$data['error_warning'] = '';
		}

    if (isset($this->session->data['shipping_method']['code'])) {
      $data['code'] = $this->session->data['shipping_method']['code'];
    } else {
      $data['code'] = '';
    }

    if (isset($this->session->data['shipping_address']['address_id'])) {
      $data['address_id'] = $this->session->data['shipping_address']['address_id'];
    } else {
      $data['address_id'] = $this->customer->getAddressId();
    }


    $this->load->model('account/address');
    $data['addresses'] = $this->model_account_address->getAddresses();

    if (isset($this->session->data['shipping_address']['address_1'])) {
      $data['address_1'] = $this->session->data['shipping_address']['address_1'];
    } else {
      $data['address_1'] = '';
    }

    if (isset($this->session->data['shipping_address']['address_2'])) {
      $data['address_2'] = $this->session->data['shipping_address']['address_2'];
    } else {
      $data['address_2'] = '';
    }

    if (isset($this->session->data['shipping_address']['city'])) {
      $data['city'] = $this->session->data['shipping_address']['city'];
    } else {
      $data['city'] = '';
    }

    if (isset($this->session->data['shipping_address']['postcode'])) {
      $data['postcode'] = $this->session->data['shipping_address']['postcode'];
    } else {
      $data['postcode'] = '';
    }

    if (isset($this->session->data['shipping_address']['country_id'])) {
      $data['country_id'] = $this->session->data['shipping_address']['country_id'];
    } else {
      $data['country_id'] = $this->config->get('config_country_id');
    }

    if (isset($this->session->data['shipping_address']['zone_id'])) {
      $data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
    } else {
      $data['zone_id'] = '';
    }

    if (isset($this->session->data['shipping_address']['company'])) {
      $data['company'] = $this->session->data['shipping_address']['company'];
    } else {
      $data['company'] = '';
    }


    return $this->load->view('checkout/checkout__shipping', $data);
  }


  private function getMethods() {
		$method_data = array();

    $this->load->model('setting/extension');

    if (!empty($this->session->data['shipping_address']['country_id'])) {
			$country_id = $this->session->data['shipping_address']['country_id'];
		} elseif (!empty($this->session->data['prmn.city_manager'])){
      $country_id = $this->progroman_city_manager->getCountryId();
		} else {
			$country_id = $this->config->get('config_country_id');
		}

    if (!empty($this->session->data['shipping_address']['zone_id'])) {
			$zone_id = $this->session->data['shipping_address']['zone_id'];
		} elseif (!empty($this->session->data['prmn.city_manager'])){
			$zone_id = $this->progroman_city_manager->getZoneId();
		} else {
			$zone_id = 0;
		}

    if (!empty($this->session->data['shipping_address']['postcode'])) {
			$postcode = $this->session->data['shipping_address']['postcode'];
		} else {
			$postcode = '';
		}

    $results = $this->model_setting_extension->getExtensions('shipping');

    foreach ($results as $result) {
      if ($this->config->get('shipping_' . $result['code'] . '_status')) {
        $this->load->model('extension/shipping/' . $result['code']);

        $quote = $this->{'model_extension_shipping_' . $result['code']}->getQuote(array(
					'country_id' => $country_id,
					'postcode' => $postcode,
					'zone_id' => $zone_id
				));

        if ($quote) {
          $method_data[$result['code']] = array(
            'title'      => $quote['title'],
            'quote'      => $quote['quote'],
            'sort_order' => $quote['sort_order'],
            'error'      => $quote['error'],
            'image'      => isset($quote['image']) ? $quote['image'] : '',
            'code' => $result['code']
          );
        }
      }
    }

    $sort_order = array();
		foreach ($method_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}
		array_multisort($sort_order, SORT_ASC, $method_data);

		return $method_data;
  }


}
