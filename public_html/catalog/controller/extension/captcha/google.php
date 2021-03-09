<?php
class ControllerExtensionCaptchaGoogle extends Controller {
    public function index($error = array()) {
        $this->load->language('extension/captcha/google');

        if (isset($error['captcha'])) {
			$data['error_captcha'] = $error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}

		$data['site_key'] = $this->config->get('captcha_google_key');

        $data['route'] = $this->request->get['route'];

		return $this->load->view('extension/captcha/google', $data);
    }


    // reCaptcha V3
    public function validate($arg) {
      if (empty($this->session->data['gcapcha'])) {
        $this->load->language('extension/captcha/google');

        if (!isset($this->request->post['g-recaptcha-response'])) {
          return $this->language->get('error_captcha');
        }

        $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('captcha_google_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

        $recaptcha = json_decode($recaptcha, true);

        if ($recaptcha['success'] and $recaptcha['score'] >= 0.5 and $recaptcha['action'] == $arg['action']) {
          $this->session->data['gcapcha']	= true;
        } else {
          return $this->language->get('error_captcha');
          // return $this->language->get('error_captcha')
          //   . '<br>action: ожидается: ' . $recaptcha['action'] . ', текущее значение: ' . $arg['action']
          //   . '<br>score: ожидается: > 0.5, текущее значение: ' . $recaptcha['score']
          //   . '<br>success: ожидается: true, текущее значение: ' . $recaptcha['success'];
        }
      }
    }


    // reCaptcha V2
    // public function validate() {
    //   if (empty($this->session->data['gcapcha'])) {
    //     $this->load->language('extension/captcha/google');

    //     if (!isset($this->request->post['g-recaptcha-response'])) {
    //       return $this->language->get('error_captcha');
    //     }

    //     $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('captcha_google_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

    //     $recaptcha = json_decode($recaptcha, true);

    //     if ($recaptcha['success']) {
    //       $this->session->data['gcapcha']	= true;
    //     } else {
    //       return $this->language->get('error_captcha');
    //     }
    //   }
    // }
}
