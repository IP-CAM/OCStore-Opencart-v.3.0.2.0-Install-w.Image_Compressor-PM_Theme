<?php
class ControllerExtensionModificationErrorLog extends Controller {
    private $error = array();

    public function index() {
        $data = $this->load->controller('extension/modification/editor/refresh');

        $this->load->language('extension/modification/error_log');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['heading_title'] = $this->language->get('heading_title');
        
        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } elseif (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['empty'])) {
            $data['error_empty'] = $this->session->data['empty'];

            unset($this->session->data['empty']);
        } else {
            $data['error_empty'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_modifications'),
            'href' => $this->url->link('marketplace/modification', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/modification/error_log', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['return'] = $this->url->link('marketplace/modification', 'user_token=' . $this->session->data['user_token'], true);
        $data['download'] = $this->url->link('extension/modification/error_log/download', 'user_token=' . $this->session->data['user_token'], true);
        $data['clear'] = $this->url->link('extension/modification/error_log/clear', 'user_token=' . $this->session->data['user_token'], true);

        $data['log'] = '';

        $file = DIR_LOGS . 'error_ocmod.log';

        if (file_exists($file)) {
            $size = filesize($file);

            if ($size >= 5242880) {
                $suffix = array(
                    'B',
                    'KB',
                    'MB',
                    'GB',
                    'TB',
                    'PB',
                    'EB',
                    'ZB',
                    'YB'
                );

                $i = 0;

                while (($size / 1024) > 1) {
                    $size = $size / 1024;
                    $i++;
                }

                $data['error_warning'] = sprintf($this->language->get('error_warning'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
            } else {
                $data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
            }
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/modification/error_log', $data));
    }

    public function download() {
        $this->load->language('extension/modification/error_log');

        if (!$this->user->hasPermission('modify', 'extension/modification/error_log')) {
            $this->session->data['error'] = $this->language->get('error_permission');
        } else {
            $file = DIR_LOGS . 'error_ocmod.log';

            if (file_exists($file) && filesize($file) > 0) {
                $this->response->addheader('Pragma: public');
                $this->response->addheader('Expires: 0');
                $this->response->addheader('Content-Description: File Transfer');
                $this->response->addheader('Content-Type: application/octet-stream');
                $this->response->addheader('Content-Disposition: attachment; filename="error_ocmod_' . date('d-m-Y_H-i-s', time()) . '.log"');
                $this->response->addheader('Content-Transfer-Encoding: binary');

                $this->response->setOutput(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
            } else {
                $this->session->data['empty'] = $this->language->get('error_empty');

                $this->response->redirect($this->url->link('extension/modification/error_log', 'user_token=' . $this->session->data['user_token'], true));
            }
        }
    }

    public function clear() {
        $this->load->language('extension/modification/error_log');

        if (!$this->user->hasPermission('modify', 'extension/modification/error_log')) {
            $this->session->data['error'] = $this->language->get('error_permission');
        } else {
            $file = DIR_LOGS . 'error_ocmod.log';

            $handle = fopen($file, 'w+');

            fclose($handle);

            $this->session->data['success'] = $this->language->get('text_success');
        }

        $this->response->redirect($this->url->link('extension/modification/error_log', 'user_token=' . $this->session->data['user_token'], true));
    }
}