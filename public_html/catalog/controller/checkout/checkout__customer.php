<?php

// TODO группы покупателей игнорируются (устанавливается default value, в будущем сделать при необходимости)

class ControllerCheckoutCheckoutCustomer extends Controller {
	public function index() {
    $this->load->language('checkout/checkout');

    $data['logged'] = $this->customer->isLogged();
    $data['login'] = $this->url->link('account/login', '', true);


    if ($this->customer->getFirstName()) {
      $data['firstname'] = $this->customer->getFirstName();
    } elseif (isset($this->session->data['guest']['firstname'])) {
			$data['firstname'] = $this->session->data['guest']['firstname'];
		} else {
			$data['firstname'] = '';
		}

    if ($this->customer->getLastName()) {
      $data['lastname'] = $this->customer->getLastName();
    }	elseif (isset($this->session->data['guest']['lastname'])) {
			$data['lastname'] = $this->session->data['guest']['lastname'];
		} else {
			$data['lastname'] = '';
		}

    if ($this->customer->getTelephone()) {
      $data['telephone'] = $this->customer->getTelephone();
		} elseif (isset($this->session->data['guest']['telephone'])) {
			$data['telephone'] = $this->session->data['guest']['telephone'];
		} else {
			$data['telephone'] = '';
		}

    if ($this->customer->getEmail()) {
      $data['email'] = $this->customer->getEmail();
		} elseif (isset($this->session->data['guest']['email'])) {
			$data['email'] = $this->session->data['guest']['email'];
		} else {
			$data['email'] = '';
		}

    if ($this->customer->getGroupId()) {
      $data['customer_group_id'] = $this->customer->getGroupId();
    } elseif (isset($this->session->data['guest']['customer_group_id'])) {
			$data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
		} else {
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}


    return $this->load->view('checkout/checkout__customer', $data);
  }


  public function validateAndSave() {
    $this->load->language('checkout/checkout__customer');

    $errors = array();

    // * field validation and session save
    if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
      $errors['firstname'] = $this->language->get('error_firstname');
    } else {
      $this->session->data['guest']['firstname'] = $this->request->post['firstname'];
    }

    if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
      $errors['lastname'] = $this->language->get('error_lastname');
    } else {
      $this->session->data['guest']['lastname'] = $this->request->post['lastname'];
    }

    if ((utf8_strlen($this->request->post['telephone']) < 7) || (utf8_strlen($this->request->post['telephone']) > 32)) {
      $errors['telephone'] = $this->language->get('error_telephone');
    } else {
      $this->session->data['guest']['telephone'] = $this->request->post['telephone'];
    }

    if ((utf8_strlen($this->request->post['email']) > 96)) {
      $errors['email'] = $this->language->get('error_email');
    } else {
      $this->session->data['guest']['email'] = $this->request->post['email'];
    }

    return $errors;
  }

}
