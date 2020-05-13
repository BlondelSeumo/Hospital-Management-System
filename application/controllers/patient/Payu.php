<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payu extends Patient_Controller {

    public $payment_method = array();
    public $pay_method = array();
    public $patient_data;

    public function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->load->library('Customlib');

        $this->patient_data = $this->session->userdata('patient');
        $this->payment_method = $this->paymentsetting_model->get();
        $this->pay_method = $this->paymentsetting_model->getActiveMethod();
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->blood_group = $this->config->item('bloodgroup');
    }

    public function index() {

        $posted = array();
        $data = array();
        $id = $this->patient_data['patient_id'];
        $data["id"] = $id;
        $data['productinfo'] = "bill payment smart hospital";
        if ($this->session->has_userdata('payment_amount')) {
            $charges = $this->charge_model->getCharges($id);
            $data["charges"] = $charges;
            $paymentDetails = $this->payment_model->paymentDetails($id);
            $paid_amount = $this->payment_model->getPaidTotal($id);
            $data["paid_amount"] = $paid_amount["paid_amount"];
            $balance_amount = $this->payment_model->getBalanceTotal($id);
            $data["balance_amount"] = $balance_amount["balance_amount"];
            $data["payment_details"] = $paymentDetails;

            $PAYU_BASE_URL = "https://secure.payu.in";
            $amount = $this->session->userdata('payment_amount');
            $ipdid = $amount['record_id'];
            $data['amount'] = $amount['deposit_amount'];
            $data['surl'] = site_url('patient/payu/success');
            $data['furl'] = site_url('patient/payu/success');
            $data['MERCHANT_KEY'] = $this->pay_method->api_secret_key;
            $SALT = $this->pay_method->salt;
            $data['hash'] = '';
            $data['action'] = '';

            $pre_session_data = $this->session->userdata('payment_amount');

            if ($this->input->method(true) == "POST") {

                $data['txnid'] = $this->input->post('txnid');
            } else {

                $data['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            }
            $pre_session_data['txn_id'] = $data['txnid'];
            $this->session->set_userdata("payment_amount", $pre_session_data);
            $data['hashSequence'] = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
            $result = $this->patient_model->getIpdDetails($id,$ipdid);
            $data['patient'] = $result;
            $this->form_validation->set_rules('key', 'key', 'trim|required|xss_clean');
            $this->form_validation->set_rules('txnid', 'txnid', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount', 'amount', 'trim|required|xss_clean');
            $this->form_validation->set_rules('firstname', $this->lang->line('first_name'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('productinfo', 'productinfo', 'trim|required|xss_clean');
            $this->form_validation->set_rules('surl', 'surl', 'trim|required|xss_clean');
            $this->form_validation->set_rules('furl', 'furl', 'trim|required|xss_clean');
            $this->form_validation->set_rules('service_provider', 'service_provider', 'trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                
            } else {
                $hashVarsSeq = explode('|', $data['hashSequence']);
                $hash_string = '';
                foreach ($hashVarsSeq as $hash_var) {
                    $post_value = $this->input->post($hash_var);

                    $hash_string .= isset($post_value) ? $post_value : '';
                    $hash_string .= '|';
                }

                $hash_string .= $SALT;

                $data['hash'] = strtolower(hash('sha512', $hash_string));
                $data['action'] = $PAYU_BASE_URL . '/_payment';
            }

            $this->load->view("layout/patient/header");
            $this->load->view("patient/payu", $data);
            $this->load->view("layout/patient/footer");
        }
    }

    public function success() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $session_data = $this->session->userdata('payment_amount');

            if ($this->input->post('status') == "success") {
                $mihpayid = $this->input->post('mihpayid');
                $transactionid = $this->input->post('txnid');
                $txn_id = $session_data['txn_id'];

                if ($txn_id == $transactionid) {
                    $params = $this->session->userdata('params');

                    $save_record = array(
                        'patient_id' => $this->patient_data['patient_id'],
                        'paid_amount' => $this->input->post('amount'),
                        'date' => date('Y-m-d'),
                        'total_amount' => '',
                        'note' => "Online fees deposit through PayU TXN ID: " . $txn_id . " PayU Ref ID: " . $mihpayid,
                        'payment_mode' => 'Online',
                    );

                    $insert_id = $this->payment_model->addPayment($save_record);
                    redirect(base_url("patient/pay/successinvoice/" . $insert_id));
                } else {
                    redirect(site_url('patient/pay/paymentfailed'));
                }
            } else {

                redirect(site_url('patient/pay/paymentfailed'));
            }
        }
    }

}

?>