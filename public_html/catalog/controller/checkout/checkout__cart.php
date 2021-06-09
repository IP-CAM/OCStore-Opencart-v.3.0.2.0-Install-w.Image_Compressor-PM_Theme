<?php
class ControllerCheckoutCheckoutCart extends Controller {
	public function index() {
    $this->load->language('checkout/checkout');

    $data['cart_list'] = $this->load->controller('checkout/cart/getCartlist');

    // расчет стоимости товаров без акций
		$products = $this->cart->getProducts();
    $total_without_sales = 0;
    $total_sales_discount = 0;
		foreach ($products as $product) {
      $unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
      if ($product['common_price']) {
        $total_without_sales = $total_without_sales + $product['common_price'] * $product['quantity'];
        $total_sales_discount = $total_sales_discount + ($product['common_price'] - $unit_price) * $product['quantity'];
      } else {
        $total_without_sales = $total_without_sales + $unit_price * $product['quantity'];
      }
		}
    $data['total_without_sales'] = $this->currency->format($total_without_sales, $this->session->data['currency']);
    if ($total_sales_discount != 0) {
      $data['total_sales_discount'] = '-' . $this->currency->format($total_sales_discount, $this->session->data['currency']);
    } else {
      $data['total_sales_discount'] = false;
    }

    // * промокод
    if ($this->config->get('total_coupon_status')) {
      $this->load->language('extension/total/coupon');

      $data['coupon_action'] = $this->url->link('extension/total/coupon/coupon', '', true);

      if (isset($this->session->data['coupon'])) {
        $data['coupon'] = $this->session->data['coupon'];
      } else {
        $data['coupon'] = '';
      }
    }

    // * totals
    $data['totals'] = array();
    $result = $this->getTotals();
    // * пропускаем первый и последний элемент массива (Итого и Всего)
    for($i = 1; $i < count($result['totals']) - 1; ++$i) {
      $data['totals'][] = array(
        'title' => $result['totals'][$i]['title'],
        'text'  => $result['totals'][$i]['value'] !== 0 ? $this->currency->format($result['totals'][$i]['value'], $this->session->data['currency']) : $this->language->get('text_free')
      );
    }
    $data['total'] = $this->currency->format($result['total'], $this->session->data['currency']);

    return $this->load->view('checkout/checkout__cart', $data);
  }

  public function getCart() {
    if ($this->cart->hasProducts()) {
      $this->response->setOutput($this->index());
    }
  }

  public function getTotals() {
    $this->load->model('setting/extension');

    $totals = array();
    $taxes = $this->cart->getTaxes();
    $total = 0;

    // Because __call can not keep var references so we put them into an array.
    $total_data = array(
      'totals' => &$totals,
      'taxes'  => &$taxes,
      'total'  => &$total
    );

    // Display prices
    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
      $sort_order = array();

      $results = $this->model_setting_extension->getExtensions('total');

      foreach ($results as $key => $value) {
        $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
      }

      array_multisort($sort_order, SORT_ASC, $results);

      foreach ($results as $result) {
        if ($this->config->get('total_' . $result['code'] . '_status')) {
          $this->load->model('extension/total/' . $result['code']);

          // We have to put the totals in an array so that they pass by reference.
          $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
        }
      }

      $sort_order = array();

      foreach ($totals as $key => $value) {
        $sort_order[$key] = $value['sort_order'];
      }

      array_multisort($sort_order, SORT_ASC, $totals);

    }

    return array(
      'total' => $total,
      'totals' => $totals
    );
  }

}
