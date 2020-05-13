<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Stripe extends Patient_Controller {

    public $payment_method = array();
    public $pay_method = array();
    public $patient_data;
    public $setting;

    public function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->load->library('Customlib');
        $this->load->library('stripe_payment');

        $this->patient_data = $this->session->userdata('patient');
        $this->payment_method = $this->paymentsetting_model->get();
        $this->pay_method = $this->paymentsetting_model->getActiveMethod();
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->blood_group = $this->config->item('bloodgroup');
        $this->setting = $this->setting_model->get();
    }

    public function index() {

        $setting = $this->setting[0];
        $data = array();
        $id = $this->patient_data['patient_id'];
        $data["id"] = $id;
        $data['productinfo'] = "bill payment smart hospital";
        if ($this->session->has_userdata('payment_amount')) {

            //$id = $this->patient_data['patient_id'];
            $charges = $this->charge_model->getCharges($id);
            $data["charges"] = $charges;
            $paymentDetails = $this->payment_model->paymentDetails($id);
            $paid_amount = $this->payment_model->getPaidTotal($id);
            $data["paid_amount"] = $paid_amount["paid_amount"];
            $balance_amount = $this->payment_model->getBalanceTotal($id);
            $data["balance_amount"] = $balance_amount["balance_amount"];
            $data["payment_details"] = $paymentDetails;

            $api_publishable_key = ($this->pay_method->api_publishable_key);
            $api_secret_key = ($this->pay_method->api_secret_key);
            $data['api_publishable_key'] = $api_publishable_key;
            $data['api_secret_key'] = $api_secret_key;
            $amount = $this->session->userdata('payment_amount');
            $ipdid = $amount['record_id'];
           
            $data['amount'] = $amount['deposit_amount'];

            $result = $this->patient_model->getIpdDetails($id,$ipdid);
           // $result = $this->patient_model->getpatientDetails($id,$ipdid);
            $data['patient'] = $result;
            $data['currency'] = $setting['currency'];
            $data['hospital_name'] = $setting['name'];
            $data['image'] = $setting['image'];

            $this->load->view("layout/patient/header");
            $this->load->view("patient/stripe", $data);
            $this->load->view("layout/patient/footer");
        }
    }

    public function complete() {


        $stripeTokenType = $this->input->post('stripeTokenType');
        $stripeEmail = $this->input->post('stripeEmail');
        $data = $this->input->post();
        $data['currency'] = 'USD';
        $amount = $this->session->userdata('payment_amount');
        $ipdid = $amount['record_id'];
        $response = $this->stripe_payment->payment($data);
        if ($response->isSuccessful()) {
            $transactionid = $response->getTransactionReference();
            $response = $response->getData();
            if ($response['status'] == 'succeeded') {

                $payment_data['transactionid'] = $transactionid;

                $save_record = array(
                    'patient_id' => $this->patient_data['patient_id'],
                    'paid_amount' => ($response['amount'] / 100),
                    'ipd_id' => $ipdid,
                    'date' => date('Y-m-d'),
                    'total_amount' => '',
                    'note' => "Online fees deposit through Stripe TXN ID: " . $transactionid,
                    'payment_mode' => 'Online',
                );

                $insert_id = $this->payment_model->addPayment($save_record);
                redirect(base_url("patient/pay/successinvoice/" . $insert_id));


                redirect(site_url('parent/parents/dashboard'));
            }
        } elseif ($response->isRedirect()) {
            $response->redirect();
        } else {

            redirect(site_url('parent/parents/dashboard'));
        }
    }

}

?>