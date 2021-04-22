<?php
use progroman\ShipGen\ShipGenAdmin;

/**
 * Class ControllerExtensionShippingProgromanShipgen
 * @property ModelProgromanShipgen model_progroman_shipgen
 * @property Language language
 * @property Loader load
 */
class ControllerExtensionShippingProgromanShipgen extends Controller {
    private $error = [];
    private $shipgen;

    public function __construct($registry) {
        parent::__construct($registry);
        $this->shipgen = new ShipGenAdmin($registry);
        $this->language->load('extension/extension/shipping');
        $this->language->load('extension/shipping/progroman_shipgen');
        $this->load->model('progroman/shipgen');
    }

    public function index() {
        $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = $this->getBreadcrumbs();
        $data['url_save_license'] = htmlspecialchars_decode($this->getShipgenUrl('savelicense'));

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error'] = '';
        }

        $data['insert'] = $this->getShipgenUrl('edit');
        $data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'], 'SSL');

        $filter_data = [
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
            'sort' => 'title'
        ];

        $all_shipping = $this->model_progroman_shipgen->getAllShipping($filter_data);
        $total_shipping = $this->model_progroman_shipgen->getTotalShipping();

        $data['extensions'] = [];

        foreach ($all_shipping as $shipping) {
            $data['extensions'][] = [
                'name' => $shipping['title'],
                'status' => $this->config->get('shipping_progroman_shipgen' . $shipping['shipping_id'] . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'sort_order' => $this->config->get('shipping_progroman_shipgen' . $shipping['shipping_id'] . '_sort_order'),
                'edit' => [
                    'text' => $this->language->get('button_edit'),
                    'url' => $this->getShipgenUrl('edit', ['shipping' => $shipping['shipping_id']])
                ],
                'uninstall' => [
                    'text' => $this->language->get('button_uninstall'),
                    'url' => $this->getShipgenUrl('uninstallshipping', ['shipping' => $shipping['shipping_id']])
                ]
            ];
        }

        $data['license'] = $this->config->get('shipping_progroman_shipgen_license');
        $data['valid_license'] = ShipGenAdmin::validateLicense($data['license']);

        if (!$data['valid_license']) {
            $data['error'] = $this->language->get('error_license');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');
        $data['column_left'] = $this->load->controller('common/column_left');

        $pagination = new Pagination();
        $pagination->total = $total_shipping;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/shipping/progroman_shipgen', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

        $data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($total_shipping) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total_shipping - $this->config->get('config_limit_admin'))) ? $total_shipping : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total_shipping, ceil($total_shipping / $this->config->get('config_limit_admin')));

        $this->response->setOutput($this->load->view('extension/shipping/progroman/shipgen/index', $data));
    }

    public function edit() {
        $shipping_id = isset($this->request->get['shipping']) ? (int)$this->request->get['shipping'] : 0;

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $isAdding = $shipping_id;
            $shipping_id = $this->shipgen->saveShipping($this->request->post, $shipping_id);

            if ($isAdding) {
                $this->response->redirect($this->getShipgenUrl());
            } else {
                $this->session->data['text_add_success'] = $this->language->get('text_success');
                $this->response->redirect($this->getShipgenUrl('edit', ['shipping' => $shipping_id]));
            }
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $shipping = $shipping_id ? $this->model_progroman_shipgen->getShipping($shipping_id) : false;

        $data['heading_title'] = $shipping ? $shipping['title'] : $this->language->get('text_new');
        $this->document->setTitle($data['heading_title'] . ' (' . $this->language->get('heading_title') . ')');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['error_title'] = isset($this->error['title']) ? $this->error['title'] : '';
        $data['breadcrumbs'] = $this->getBreadcrumbs();
        $data['breadcrumbs'][] = [
            'text' => $data['heading_title'],
            'href' => $this->getShipgenUrl('edit', ['shipping' => $shipping_id]),
        ];

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->getShipgenUrl('edit', ['shipping' => $shipping_id]);
        $data['cancel'] = $this->getShipgenUrl();
        $data['insert_quote'] = $this->getShipgenUrl('quote', ['shipping' => $shipping_id]);

        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } elseif ($shipping) {
            $data['title'] = $shipping['title'];
        } else {
            $data['title'] = '';
        }

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif ($shipping) {
            $data['image'] = $shipping['image'];
        } else {
            $data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif ($shipping && $shipping['image'] && file_exists(DIR_IMAGE . $shipping['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($shipping['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif ($shipping) {
            $data['status'] = $this->config->get('shipping_progroman_shipgen' . $shipping['shipping_id'] . '_status');
        } else {
            $data['status'] = '';
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif ($shipping) {
            $data['sort_order'] = $this->config->get('shipping_progroman_shipgen' . $shipping['shipping_id'] . '_sort_order');
        } else {
            $data['sort_order'] = '';
        }

        $data['shipping'] = $shipping;
        $data['quotes'] = [];

        if ($shipping) {
            $quotes = $this->model_progroman_shipgen->getQuotes($shipping_id);
            foreach ($quotes as & $quote) {
                $quote['edit'] = [
                    'text' => $this->language->get('button_edit'),
                    'url' => $this->getShipgenUrl('quote', ['shipping' => $shipping_id, 'quote' => $quote['quote_id']])
                ];

                $quote['copy'] = [
                    'text' => $this->language->get('button_copy'),
                    'url' => $this->getShipgenUrl('copyquote', ['shipping' => $shipping_id, 'quote' => $quote['quote_id']])
                ];

                $quote['uninstall'] = [
                    'text' => $this->language->get('button_uninstall'),
                    'url' => $this->getShipgenUrl('uninstallquote', ['shipping' => $shipping_id, 'quote' => $quote['quote_id']])
                ];
            }

            $data['quotes'] = $quotes;
        }

        $data['valid_license'] = ShipGenAdmin::validateLicense($this->config->get('shipping_progroman_shipgen_license'));
        if (!$data['valid_license']) {
            $data['error_warning'] = $this->language->get('error_license');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');
        $data['column_left'] = $this->load->controller('common/column_left');

        $this->response->setOutput($this->load->view('extension/shipping/progroman/shipgen/edit', $data));
    }

    public function uninstallShipping($shipping_id = false) {
        if (!$this->user->hasPermission('modify', 'extension/shipping/progroman_shipgen')) {
            $this->session->data['error'] = $this->language->get('error_permission');
            $this->response->redirect($this->getShipgenUrl());
        } elseif (!ShipGenAdmin::validateLicense($this->config->get('shipping_progroman_shipgen_license'))) {
            $this->session->data['error'] = $this->language->get('error_license');
            $this->response->redirect($this->getShipgenUrl());
        } else {
            if (!$shipping_id) {
                $shipping_id = isset($this->request->get['shipping']) ? (int)$this->request->get['shipping'] : 0;
            }

            $this->shipgen->removeShipping($shipping_id);
            $this->session->data['success'] = $this->language->get('text_success');

            // Если удаление со страницы расширений
            if (isset($this->request->server['HTTP_REFERER']) && strpos($this->request->server['HTTP_REFERER'], '?route=marketplace/extension&') !== false) {
                $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
            } else {
                $this->response->redirect($this->getShipgenUrl());
            }
        }
    }

    public function quote() {
        $shipping_id = isset($this->request->get['shipping']) ? (int)$this->request->get['shipping'] : 0;
        $quote_id = isset($this->request->get['quote']) ? (int)$this->request->get['quote'] : 0;

        $shipping = $shipping_id ? $this->model_progroman_shipgen->getShipping($shipping_id) : false;
        if (!$shipping) {
            $this->response->redirect($this->getShipgenUrl());
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $quote_id = $this->shipgen->saveQuote($this->request->post, $quote_id);
            $this->session->data['text_add_success'] = $this->language->get('text_success');
            $this->response->redirect($this->getShipgenUrl('quote', ['shipping' => $shipping_id, 'quote' => $quote_id]));
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $quote = $quote_id ? $this->model_progroman_shipgen->getQuote($quote_id) : false;

        $data['heading_title'] = $quote ? $quote['title'] : $this->language->get('text_new');
        $this->document->setTitle($this->language->get('heading_quotes') . '. ' . $data['heading_title']);
        $this->document->addScript('view/javascript/progroman/vue.min.js');

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

        $data['breadcrumbs'] = $this->getBreadcrumbs();
        $data['breadcrumbs'][] = [
            'text' => $shipping['title'],
            'href' => $this->getShipgenUrl('edit', ['shipping' => $shipping_id]),
        ];
        $data['breadcrumbs'][] = [
            'text' => $data['heading_title'],
            'href' => $this->getShipgenUrl('quote', ['shipping' => $shipping_id, 'quote' => $quote_id]),
        ];

        $data['action'] = $this->getShipgenUrl('quote', ['shipping' => $shipping_id, 'quote' => $quote_id]);
        $data['cancel'] = $this->getShipgenUrl('edit', ['shipping' => $shipping_id]);
        
        $data['shipping_id'] = $shipping_id;

        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['content_tab_general'] = $this->load->controller('extension/shipping/progroman_shipgen/quotetabgeneral', $quote);
        $data['content_tab_zones'] = $this->load->controller('extension/shipping/progroman_shipgen/quotetabzones', $quote);
        $data['content_tab_geozones'] = $this->load->controller('extension/shipping/progroman_shipgen/quotetabgeozones', $quote);
        $data['popup_zone'] = $this->load->controller('extension/shipping/progroman_shipgen/popupzone', $quote);
        $data['popup_geozone'] = $this->load->controller('extension/shipping/progroman_shipgen/popupgeozone', $quote);

        $this->response->setOutput($this->load->view('extension/shipping/progroman/shipgen/quote', $data));
    }

    public function quoteTabGeneral($quote) {
        $data['error_title'] = isset($this->error['title']) ? $this->error['title'] : [];
        $data['error_description'] = isset($this->error['description']) ? $this->error['description'] : [];
        $data['title'] = isset($this->request->post['title']) ? $this->request->post['title'] : ($quote ? $quote['title'] : '');
        $data['description'] = isset($this->request->post['description']) ? $this->request->post['description'] : ($quote ? $quote['description'] : '');
        $data['image'] = isset($this->request->post['image']) ? $this->request->post['image'] : ($quote ? $quote['image'] : '');
        $data['status'] = isset($this->request->post['status']) ? $this->request->post['status'] : ($quote ? $quote['status'] : '');
        $data['sort_order'] = isset($this->request->post['sort_order']) ? $this->request->post['sort_order'] : ($quote ? $quote['sort_order'] : '');

        $this->load->model('tool/image');
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif ($quote && $quote['image'] && file_exists(DIR_IMAGE . $quote['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($quote['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        return $this->load->view('extension/shipping/progroman/shipgen/quote_tab_general', $data);
    }

    public function quoteTabZones($quote) {
        $data['quote'] = $quote;
        $quotes_zones = isset($this->request->post['quotes_zones']) ? $this->request->post['quotes_zones']
            : $quotes_zones = $this->model_progroman_shipgen->getQuotesZones($quote['quote_id']);

        $this->load->model('localisation/country');
        $this->load->model('localisation/zone');

        foreach ($quotes_zones as & $quote_zone) {
            if (!empty($quote_zone['country_id']) && $country = $this->model_localisation_country->getCountry($quote_zone['country_id'])) {
                $quote_zone['country_name'] = $country['name'];
            } else {
                $quote_zone['country_name'] = '';
            }

            if (!empty($quote_zone['zone_id']) && $zone = $this->model_localisation_zone->getZone($quote_zone['zone_id'])) {
                $quote_zone['zone_name'] = $zone['name'];
            } else {
                $quote_zone['zone_name'] = '';
            }
        }

        $data['quotes_zones'] = $quotes_zones;

        $data['error_zone'] = isset($this->error['zone']) ? $this->error['zone'] : [];
        $data['error_zone_rate'] = isset($this->error['zone_rate']) ? $this->error['zone_rate'] : [];

        return $this->load->view('extension/shipping/progroman/shipgen/quote_tab_zones', $data);
    }

    public function quoteTabGeozones($quote) {
        $data['quote'] = $quote;

        $this->load->model('localisation/geo_zone');
        $quotes_geo_zones = isset($this->request->post['quotes_geo_zones']) ? $this->request->post['quotes_geo_zones']
            : $this->model_progroman_shipgen->getQuotesGeoZones($quote['quote_id']);

        foreach ($quotes_geo_zones as & $quote_geo_zone) {
            if (!empty($quote_geo_zone['geo_zone_id']) && $geo_zone = $this->model_localisation_geo_zone->getGeoZone($quote_geo_zone['geo_zone_id'])) {
                $quote_geo_zone['zone_name'] = $geo_zone['name'];
            } else {
                $quote_geo_zone['zone_name'] = '';
            }
        }

        $data['quotes_geo_zones'] = $quotes_geo_zones;

        $data['error_geo_zone'] = isset($this->error['geo_zone']) ? $this->error['geo_zone'] : [];
        $data['error_geo_zone_rate'] = isset($this->error['geo_zone_rate']) ? $this->error['geo_zone_rate'] : [];

        return $this->load->view('extension/shipping/progroman/shipgen/quote_tab_geozones', $data);
    }

    public function popupZone() {
        $this->load->model('localisation/country');
        $data['countries'] = $this->model_localisation_country->getCountries();
        $data['module_dir'] = DIR_TEMPLATE . 'extension/shipping/progroman/shipgen/';
        $data['url_module'] = 'index.php?route=extension/shipping/progroman_shipgen';
        $data['user_token'] = $this->session->data['user_token'];

        return $this->load->view('extension/shipping/progroman/shipgen/popup_zone', $data);
    }

    public function popupGeozone() {
        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        return $this->load->view('extension/shipping/progroman/shipgen/popup_geozone', $data);
    }

    public function uninstallQuote() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/progroman_shipgen')) {
            $this->session->data['error'] = $this->language->get('error_permission');
            $this->response->redirect($this->getShipgenUrl());
        } elseif (!ShipGenAdmin::validateLicense($this->config->get('shipping_progroman_shipgen_license'))) {
            $this->session->data['error'] = $this->language->get('error_license');
            $this->response->redirect($this->getShipgenUrl());
        }

        $quote_id = isset($this->request->get['quote']) ? (int)$this->request->get['quote'] : 0;
        $shipping_id = isset($this->request->get['shipping']) ? (int)$this->request->get['shipping'] : 0;
        $this->shipgen->removeQuote($quote_id);
        $this->session->data['success'] = $this->language->get('text_success');

        $this->response->redirect($this->getShipgenUrl('edit', ['shipping' => $shipping_id]));
    }

    public function copyQuote() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/progroman_shipgen')) {
            $this->session->data['error'] = $this->language->get('error_permission');
            $this->response->redirect($this->getShipgenUrl());
        } elseif (!ShipGenAdmin::validateLicense($this->config->get('shipping_progroman_shipgen_license'))) {
            $this->session->data['error'] = $this->language->get('error_license');
            $this->response->redirect($this->getShipgenUrl());
        }

        $quote_id = isset($this->request->get['quote']) ? (int)$this->request->get['quote'] : 0;
        $shipping_id = isset($this->request->get['shipping']) ? (int)$this->request->get['shipping'] : 0;
        $this->shipgen->copyQuote($quote_id);
        $this->session->data['success'] = $this->language->get('text_success');

        $this->response->redirect($this->getShipgenUrl('edit', ['shipping' => $shipping_id]));
    }

    protected function validate() {
        $this->checkPermission();

        $title = trim($this->request->post['title']);
        $title_len = utf8_strlen($title);

        if ($title_len < 3 || $title_len > 150) {
            $this->error['title'] = $this->language->get('error_title');
        }

        if (!empty($this->request->post['quotes_zones'])) {
            foreach ($this->request->post['quotes_zones'] as $key => $quote_zone) {
                if (!$quote_zone['country_id'] || !$quote_zone['zone_id']) {
                    $this->error['zone'][$key] = $this->language->get('error_zone');
                }
                if (!trim($quote_zone['rate'])) {
                    $this->error['zone_rate'][$key] = $this->language->get('error_rate');
                }
            }
        }

        if (!empty($this->request->post['quotes_geo_zones'])) {
            foreach ($this->request->post['quotes_geo_zones'] as $key => $quote_zone) {
                if (!$quote_zone['geo_zone_id']) {
                    $this->error['geo_zone'][$key] = $this->language->get('error_geo_zone');
                }
                if (!trim($quote_zone['rate'])) {
                    $this->error['geo_zone_rate'][$key] = $this->language->get('error_rate');
                }
            }
        }

        return !$this->error;
    }

    private function checkPermission() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/progroman_shipgen')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    private function getBreadcrumbs() {
        $breadcrumbs = [];

		$breadcrumbs[] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		];

        $breadcrumbs[] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
		];

        $breadcrumbs[] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->getShipgenUrl(),
        ];

        return $breadcrumbs;
    }

    private function getShipgenUrl($action = '', $params = []) {
        $params['user_token'] = $this->session->data['user_token'];
        return $this->url->link('extension/shipping/progroman_shipgen' . ($action ? '/' . $action : ''), http_build_query($params), 'SSL');
    }

    public function country() {
        $this->load->model('localisation/zone');
        $json['zones'] = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);

        $this->response->setOutput(json_encode($json));
    }

    public function saveLicense() {
        $json = [];
        if ($this->checkPermission()) {
            if (!empty($this->request->post['license'])) {
                $this->load->model('setting/setting');
                $this->model_setting_setting->editSetting('shipping_progroman_shipgen', ['shipping_progroman_shipgen_license' => $this->request->post['license']]);
            }

            $json['message'] = $this->language->get(ShipGenAdmin::validateLicense($this->request->post['license']) ? 'text_license_success' : 'text_license_error');
        } else {
            $json['warning'] = $this->error['warning'];
        }

        $this->response->setOutput(json_encode($json));
    }

    public function install() {
        $this->model_progroman_shipgen->install();
    }
}