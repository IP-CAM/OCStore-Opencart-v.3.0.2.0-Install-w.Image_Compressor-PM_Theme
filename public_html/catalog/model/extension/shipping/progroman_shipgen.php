<?php

use progroman\ShipGen\ShipGen;

class ModelExtensionShippingProgromanShipgen extends Model {

    private $shipping_id;

    /**
     * @param int $shipping_id
     * @return $this
     */
    public function setShippingId($shipping_id) {
        $this->shipping_id = $shipping_id;
        return $this;
    }

    public function getQuote($address) {
        if (!$this->shipping_id) {
            return [];
        }

        $this->load->language('progroman/shipgen');
        $this->load->model('tool/image');
        $quote_data = [];

        $shipgen = new ShipGen($this->registry);
        $shipping = $shipgen->getShipping($this->shipping_id, $address);

        if ($shipping && $shipping['quotes']) {
            // Все способы доставки для текущей службы доставки
            $quotes = $shipping['quotes'];

            foreach ($quotes as $quote) {
                $zone_data = $shipgen->checkQuote($quote, $address);
                if ($zone_data) {
                    $image = $quote['image'] ? $this->model_tool_image->resize($quote['image'], 30, 30, 'w') : '';
                    $quote_data['quote' . $quote['quote_id']] = [
                        'code' => 'progroman_shipgen' . $this->shipping_id . '.quote' . $quote['quote_id'],
                        'title' => $quote['title'],
                        'img' => $image,
                        'image' => $image,
                        'cost' => $zone_data['cost'],
                        'tax_class_id' => 0,
                        'text' => $zone_data['text'],
                        'description' => ($quote['description'] ? nl2br($quote['description']) : '')
                            . ($zone_data['description'] ? ' ' . nl2br($zone_data['description']) : '')
                    ];
                }
            }
        }

        $method_data = [];

        if ($quote_data) {
            $image = $shipping['image'] ? $this->model_tool_image->resize($shipping['image'], 30, 30, 'w') : '';
            $method_data = [
                'code' => 'progroman_shipgen' . $this->shipping_id,
                'title' => $shipping['title'],
                'quote' => $quote_data,
                'sort_order' => $this->config->get('shipping_progroman_shipgen' . $this->shipping_id . '_sort_order'),
                'error' => false,
                'img' => $image,
                'image' => $image
            ];
        }

        return $method_data;
    }

    public function getAllShipping() {
        return $this->db->query("SELECT * FROM prmn_sg_shipping")->rows;
    }

    public function getQuotesByShippingIds($shipping_ids) {
        return !empty($shipping_ids)
            ? $this->db->query("
                  SELECT * FROM prmn_sg_quote 
                    WHERE shipping_id IN (" . implode(',', $shipping_ids) . ") 
                        AND status != 0 
                    ORDER BY sort_order")->rows
            : [];
    }

    public function getZonesByQuotesIds($quotes_ids, $country_id, $zone_id) {
        return !empty($quotes_ids)
            ? $this->db->query("
                  SELECT * FROM prmn_sg_quote_zone 
                    WHERE quote_id IN (" . implode(',', $quotes_ids) . ")
                        AND country_id = '" . (int)$country_id . "'
                        AND zone_id = '" . (int)$zone_id . "'")->rows
            : [];
    }

    public function getGeozonesByQuotesIds($quotes_ids, $country_id, $zone_id) {
        if (!empty($quotes_ids)) {
            // Все геозоны для региона пользователя
            $selected_geozones_ids = [];
            foreach ($this->getGeozonesByAddress($country_id, $zone_id) as $row) {
                $selected_geozones_ids[] = $row['geo_zone_id'];
            }

            if (!empty($selected_geozones_ids)) {
                return $this->db->query("
                  SELECT * FROM prmn_sg_quote_geozone
                   WHERE quote_id IN (" . implode(',', $quotes_ids) . ")
                        AND geo_zone_id IN (" . implode(', ', $selected_geozones_ids) . ")")->rows;
            }
        }

        return [];
    }

    private function getGeozonesByAddress($country_id, $zone_id) {
        return $this->db->query("
                      SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone
                        WHERE country_id = '" . (int)$country_id . "' AND (zone_id = '" . (int)$zone_id . "' OR zone_id = '0')
                        ORDER BY zone_id DESC")->rows;
    }
}