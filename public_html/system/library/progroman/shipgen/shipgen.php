<?php

namespace progroman\ShipGen;

class ShipGen {

    /** @var array */
    static private $shipping;

    /** @var float Вес корзины, кэшируем значение, чтобы сократить запросы к БД */
    static private $cart_weight;

    /** @var float Стоимость заказа, кэшируем значение, чтобы сократить запросы к БД */
    static private $cart_sub_total;

    /** @var \Registry */
    private $registry;

    /** @var \ModelExtensionShippingProgromanShipgen|\ModelShippingProgromanShipgen */
    private $model_shipgen;

    public function __construct($registry) {
        $this->registry = $registry;

        if (VERSION < 2.3) {
            $registry->get('load')->model('shipping/progroman_shipgen');
            $this->model_shipgen = $registry->get('model_shipping_progroman_shipgen');
        } else {
            $registry->get('load')->model('extension/shipping/progroman_shipgen');
            $this->model_shipgen = $registry->get('model_extension_shipping_progroman_shipgen');
        }
    }

    /**
     * Возвращает доставку с котировками для текущего региона
     * @param $shipping_id
     * @param $address
     * @return bool
     */
    public function getShipping($shipping_id, $address) {
        if (is_null(self::$shipping)) {
            foreach ($this->model_shipgen->getAllShipping() as $shipping) {
                if ($this->checkStatus($shipping['shipping_id'])) {
                    $shipping['quotes'] = [];
                    self::$shipping[$shipping['shipping_id']] = $shipping;
                }
            }

            if (!empty(self::$shipping)) {
                $quotes = [];
                foreach ($this->model_shipgen->getQuotesByShippingIds(array_keys(self::$shipping)) as $quote) {
                    $quotes[$quote['quote_id']] = $quote;
                }

                if (!empty($quotes)) {
                    foreach ($this->model_shipgen->getZonesByQuotesIds(array_keys($quotes), $address['country_id'], $address['zone_id']) as $zone) {
                        $quotes[$zone['quote_id']]['zones'][] = $zone;
                    }

                    foreach ($this->model_shipgen->getGeozonesByQuotesIds(array_keys($quotes), $address['country_id'], $address['zone_id']) as $geozone) {
                        $quotes[$geozone['quote_id']]['geozones'][] = $geozone;
                    }
                }

                foreach ($quotes as $quote) {
                    self::$shipping[$quote['shipping_id']]['quotes'][$quote['quote_id']] = $quote;
                }
            }
        }

        return isset(self::$shipping[$shipping_id]) ? self::$shipping[$shipping_id] : false;
    }

    /**
     * Проверяет соответствие котировки текущим условиям
     * @param $quote
     * @param $address
     * @return array|bool Массив с данными для доставки (стоимость, описание и т.д.), если котировка подходит, иначе false
     */
    public function checkQuote($quote, $address) {
        $zone_data = false;

        // Тарифы и другие данные для региона
        if (!empty($quote['zones'])) {
            $zone_data = $this->getDataForZone($quote['zones'], $address);
        }

        // Тарифы и другие данные для геозон
        if (!$zone_data && !empty($quote['geozones'])) {
            $zone_data = $this->getDataForZone($quote['geozones'], $address);
        }

        return $zone_data;
    }

    private function getDataForZone($zones, $address) {
        $current_city = isset($address['city']) ? utf8_strtolower($address['city']) : '';
        $weight = $this->getCartWeight();
        $sub_total = $this->getCartSubTotal();
        $result = [];

        foreach ($zones as $zone) {
            // Проверим города, для которых работает эта доставка
            if (!empty($zone['enabled_cities'])) {
                $enabled_cities = [];
                foreach (explode(',', $zone['enabled_cities']) as $city) {
                    $enabled_cities[utf8_strtolower(trim($city))] = 1;
                }

                if (!isset($enabled_cities[$current_city])) {
                    continue;
                }
            }

            // Проверим города, для которых эта доставка отключена
            if (!empty($zone['disabled_cities'])) {
                $disabled_cities = [];
                foreach (explode(',', $zone['disabled_cities']) as $city) {
                    $disabled_cities[utf8_strtolower(trim($city))] = 1;
                }

                if (isset($disabled_cities[$current_city])) {
                    continue;
                }
            }

            // Проверим ограничение по стоимости заказа
            if ($zone['min_price'] > 0 && $zone['min_price'] > $sub_total) {
                continue;
            }

            if ($zone['max_price'] > 0 && $zone['max_price'] < $sub_total) {
                continue;
            }

            if (empty($zone['rate'])) {
                continue;
            }

            // Вычисляем стоимость
            $cost = null;

            // Тарифы по весу
            if (preg_match('#[\d\.]+:[\d\.]?#', $zone['rate'], $matches)) {
                $rates = explode(',', $zone['rate']);

                // Найдем стоимость доставки в зависимости от веса
                foreach ($rates as $rate) {
                    $data = explode(':', $rate);
                    if ($data[0] >= $weight) {
                        if (isset($data[1])) {
                            $cost = $data[1];
                        }

                        break;
                    }
                }
            } else { // Фиксированная стоимость или текст
                $cost = $zone['rate'];
            }

            // Посчитаем скидку на доставку.
            if (!is_null($cost)) {
                $result_discount = 0;
                if (is_numeric($cost) && $cost > 0) {
                    if ($zone['discount']) {
                        $discounts = explode(',', $zone['discount']);

                        foreach ($discounts as $discount) {
                            $data = explode(':', $discount);

                            if ($data[0] >= $sub_total) {
                                if (isset($data[1])) {
                                    $result_discount = $data[1];
                                }

                                break;
                            }
                        }
                    }
                }

                $currency = $this->registry->get('currency');
                $session = $this->registry->get('session');

                if ($result_discount > 0) {
                    if ($result_discount > 100) {
                        $result_discount = 100;
                    }

                    $discount_cost = $cost * $result_discount / 100;
                    $text = '<span style="text-decoration: line-through; color: red;">'
                        . $currency->format($cost, $session->data['currency']) . '</span> '
                        . $currency->format($cost - $discount_cost, $session->data['currency'])
                        . ' (' . ' -' . $result_discount . '%)';

                    $cost -= $discount_cost;
                } else {
                    if (is_numeric($cost)) {
                        $text = $currency->format($cost, $session->data['currency']);
                    } else {
                        $text = $cost;
                        $cost = 0;
                    }
                }

                $result = ['cost' => $cost, 'text' => $text, 'description' => $zone['description']];

                // Если указан город, дальше не проверяем - тариф найден
                // Если только регион - проверим остальные, может быть, там есть тариф для города
                if (!empty($zone['enabled_cities'])) {
                    return $result;
                }
            }
        }

        return $result;
    }

    private function getCartWeight() {
        if (is_null(self::$cart_weight)) {
            self::$cart_weight = $this->registry->get('cart')->getWeight();
        }

        return self::$cart_weight;
    }

    private function getCartSubTotal() {
        if (is_null(self::$cart_sub_total)) {
            self::$cart_sub_total = $this->registry->get('cart')->getSubTotal();
        }

        return self::$cart_sub_total;
    }

    private function checkStatus($shipping_id) {
        $key = 'progroman_shipgen' . $shipping_id . '_status';
        if (VERSION >= 3) {
            $key = 'shipping_' . $key;
        }

        return $this->registry->get('config')->get($key);
    }
}