<?php

class ControllerCheckoutCheckoutTotal extends Controller {
	public function index() {
    $this->load->language('checkout/checkout');

    $data['test'] = 'test';

    return $this->load->view('checkout/checkout__total', $data);
  }

}
