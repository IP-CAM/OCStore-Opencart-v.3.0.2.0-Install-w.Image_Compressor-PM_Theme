<?php
class ControllerCommonCart extends Controller {
	public function index() {
		$this->load->language('common/cart');

    $data['cart_list'] = $this->load->controller('checkout/cart/getCartList');

    $data['cart_items_quantity'] = $this->cart->countProducts();
		$data['cart_items_quantity_full'] = $data['cart_items_quantity'] . ' товар' . $this->custom->convertEnding($data['cart_items_quantity']);

    $total = $this->cart->getTotal();
    $data['cart_items_total'] = $this->currency->format($total, $this->session->data['currency']);

    $this->registry->set('custom_price', new CustomPrice($this->registry));
    $data['cart_items_total_integer'] = $this->custom_price->getPriceInteger($total);
    $data['cart_items_total_decimal'] = $this->custom_price->getPriceDecimal($total);

    $data['price_currency_symbol'] = $this->currency->getSymbolRight($this->session->data['currency']);

		$data['checkout'] = $this->url->link('checkout/checkout', '', true);

		return $this->load->view('common/cart', $data);
	}

	public function info() {
		$this->response->setOutput($this->index());
	}
}
