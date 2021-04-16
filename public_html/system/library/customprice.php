<?php
// подключение
// ! так не работает
// 1. в system/framework.php например так
// $custom = new custom();
// $registry->set('custom', $custom);
// * так работает
// 2. в файле контроллера
// $this->registry->set('custom_price', new CustomPrice($this->registry));

// использование
// $this->custom_price->getPriceInteger( $price );

class CustomPrice {
  public function __construct($registry) {
		$this->session = $registry->get('session');
		$this->language = $registry->get('language');
		$this->currency = $registry->get('currency');
		// $this->config = $registry->get('config');
		// $this->customer = $registry->get('customer');
		// $this->db = $registry->get('db');
		// $this->tax = $registry->get('tax');
		// $this->weight = $registry->get('weight');
		// $this->log = $registry->get('log');
		// ... зависит от того, доступ к каким данным вам понадобится в вашей библиотеке.
	}

  public function getPriceInteger($price) {
    $number_formatted = $this->currency->format($price, $this->session->data['currency'], '', true, true);
    return floor($number_formatted);
  }

  public function getPriceDecimal($price) {
    if ($price == 0) return '';

    $decimal_point = $this->language->get('decimal_point');
    $number_formatted = $this->currency->format($price, $this->session->data['currency'], '', true, true);
    return explode($decimal_point, $number_formatted)[1];
  }
}
