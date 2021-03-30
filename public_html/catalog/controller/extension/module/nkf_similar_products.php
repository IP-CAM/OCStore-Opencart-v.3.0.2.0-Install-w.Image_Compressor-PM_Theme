<?php
/*
@author  nikifalex
@skype   logoffice1
@email    nikifalex@yandex.ru
@link https://opencartforum.com/files/file/4617-pohozhie-tovary/
*/

class ControllerExtensionModuleNkfSimilarProducts extends Controller {
    public function index($setting) {

        if (isset($this->request->get['product_id']) && $this->request->get['product_id'] > 0) {

            $this->load->language('extension/module/nkf_similar_products');
            $data['heading_title'] = $setting['title'];
            if ($data['heading_title'] == '')
                $data['heading_title'] = $this->language->get('heading_title');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            $data['entry_diff'] = $this->language->get('entry_diff');
            $this->load->model('extension/module/nkf_similar_products');
            $this->load->model('tool/image');
            $data['products'] = array();
            $filter_data = array(
                'module_id'           => $setting['module_id'],
                'use_cache'           => $setting['use_cache'],
                'limit'               => $setting['limit'],
                'use_category'        => $setting['use_category'],
                'use_manufacturer'    => $setting['use_manufacturer'],
                'delimiter'           => $setting['delimiter'],
                'use_price'           => $setting['use_price'],
                'price_percent'       => $setting['price_percent'],
                'use_quantity'        => $setting['use_quantity'],
                'cnt_diff'            => $setting['cnt_diff'],
                'excluded_attributes' => isset($setting['excluded_attributes']) ? $setting['excluded_attributes'] : array(),
                'product_id'          => $this->request->get['product_id'],
            );
            if (isset($setting['use_featured_template']) && $setting['use_featured_template']) {
                $filter_data['only_id'] = true;
                $results = $this->model_extension_module_nkf_similar_products->getProductSimilar($filter_data);
                $setting2 = $setting;
                $setting2['product'] = $results;
                return $this->load->controller('extension/module/featured', $setting2);
            } else {
                $filter_data['only_id'] = false;
                $results = $this->model_extension_module_nkf_similar_products->getProductSimilar($filter_data);
                if ($results) {
                    foreach ($results as $result) {
                        if ($result['image']) {
                            $image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                        }
                        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                            $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                        } else {
                            $price = false;
                        }
                        if ((float)$result['special']) {
                            $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                        } else {
                            $special = false;
                        }
                        if ($this->config->get('config_tax')) {
                            $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                        } else {
                            $tax = false;
                        }
                        if ($this->config->get('config_review_status')) {
                            $rating = $result['rating'];
                        } else {
                            $rating = false;
                        }
                        $data['products'][] = array(
                            'product_id'          => $result['product_id'],
                            'thumb'               => $image,
                            'name'                => $result['name'],
                            'description'         => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                            'price'               => $price,
                            'special'             => $special,
                            'tax'                 => $tax,
                            'diff_attributes'     => ($setting['add_diff_attributes'] == 0 ? array() : $result['diff']['attributes']),
                            'diff_attributes_str' => implode('<br/> ', $result['diff']['attributes']),
                            'rating'              => $rating,
                            'href'                => $this->url->link('product/product', 'product_id=' . $result['product_id']),
                        );
                    }
                    return $this->load->view('extension/module/nkf_similar_products', $data);
                }
            }
        }
    }
}