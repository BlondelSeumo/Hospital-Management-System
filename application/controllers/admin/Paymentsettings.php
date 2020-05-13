<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentsettings extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (!$this->rbac->hasPrivilege('payment_methods', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'schsettings/index');
        $this->session->set_userdata('inner_menu', 'admin/paymentsettings');

        $data['title'] = 'SMS Config List';
        $payment_result = $this->paymentsetting_model->get();

        $data['statuslist'] = $this->customlib->getStatus();
        $data['paymentlist'] = $payment_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/payment_setting/paymentsettingList', $data);
        $this->load->view('layout/footer', $data);
    }

    public function paypal() {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('paypal_username', $this->lang->line('username'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('paypal_password', $this->lang->line('password'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('paypal_signature', $this->lang->line('signature'), 'trim|required|xss_clean');

        if ($this->form_validation->run()) {
            $data = array(
                'payment_type' => 'paypal',
                'api_username' => $this->input->post('paypal_username'),
                'api_password' => $this->input->post('paypal_password'),
                'api_signature' => $this->input->post('paypal_signature'),
                'paypal_demo' => 'TRUE',
            );
            $this->paymentsetting_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => $this->lang->line('update_message')));
        } else {

            $data = array(
                'paypal_username' => form_error('paypal_username'),
                'paypal_password' => form_error('paypal_password'),
                'paypal_signature' => form_error('paypal_signature'),
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function stripe() {

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('api_secret_key', $this->lang->line('stripe_api_secret_key'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('api_publishable_key', $this->lang->line('stripe_publishable_key'), 'trim|required|xss_clean');

        if ($this->form_validation->run()) {
            $data = array(
                'api_secret_key' => $this->input->post('api_secret_key'),
                'api_publishable_key' => $this->input->post('api_publishable_key'),
                'payment_type' => 'stripe',
            );

            $this->paymentsetting_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => $this->lang->line('update_message')));
        } else {

            $data = array(
                'api_secret_key' => form_error('api_secret_key'),
                'api_publishable_key' => form_error('api_publishable_key'),
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function payu() {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('key', $this->lang->line('key'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('salt', $this->lang->line('salt'), 'trim|required|xss_clean');
        if ($this->form_validation->run()) {
            $data = array(
                'api_secret_key' => $this->input->post('key'),
                'salt' => $this->input->post('salt'),
                'payment_type' => 'payu',
            );
            $this->paymentsetting_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => $this->lang->line('update_message')));
        } else {
            $data = array(
                'key' => form_error('key'),
                'salt' => form_error('salt')
            );
            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function twocheckout() {
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('api_secret_key', $this->lang->line('key'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('api_publishable_key', $this->lang->line('salt'), 'trim|required|xss_clean');
        if ($this->form_validation->run()) {
            $data = array(
                'api_secret_key' => $this->input->post('api_secret_key'),
                'api_publishable_key' => $this->input->post('api_publishable_key'),
                'payment_type' => 'twocheckout',
            );
            $this->paymentsetting_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => $this->lang->line('update_message')));
        } else {
            $data = array(
                'api_secret_key' => form_error('api_secret_key'),
                'api_publishable_key' => form_error('api_publishable_key')
            );
            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function ccavenue() {
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('ccavenue_secret', 'Key', 'trim|required|xss_clean');
        $this->form_validation->set_rules('ccavenue_salt', 'Salt', 'trim|required|xss_clean');
        if ($this->form_validation->run()) {
            $data = array(
                'api_secret_key' => $this->input->post('ccavenue_secret'),
                'salt' => $this->input->post('ccavenue_salt'),
                'payment_type' => 'ccavenue',
            );
            $this->paymentsetting_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {
            $data = array(
                'ccavenue_secret' => form_error('ccavenue_secret'),
                'ccavenue_salt' => form_error('ccavenue_salt')
            );
            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function setting() {

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules(
                'payment_setting', 'Payment Setting', array(
            'required',
            array('paymentsetting', array($this->paymentsetting_model, 'valid_paymentsetting'))
                )
        );
        if ($this->form_validation->run()) {
            $paymentsetting = $this->input->post('payment_setting');
            $other = false;
            if ($paymentsetting == "none") {
                $other = true;
                $data = array(
                    'is_active' => 'no'
                );
            } else {
                $data = array(
                    'payment_type' => $this->input->post('payment_setting'),
                    'is_active' => 'yes'
                );
            }
            $this->paymentsetting_model->active($data, $other);

            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {

            $data = array(
                'payment_setting' => form_error('payment_setting')
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

}

?>