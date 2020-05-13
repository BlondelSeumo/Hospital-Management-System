<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pay extends Patient_Controller {

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

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules(
                'deposit_amount', $this->lang->line('amount'), array('required',
            array('check_exists', array($this->payment_model, 'valid_amount'))
                )
        );

        $deposit_amount = $this->input->post("deposit_amount");

        if ($this->form_validation->run() == false) {
            $msg = array(
                'deposit_amount' => form_error('deposit_amount'),
            );
            $array = array('status' => '0', 'error' => $msg, 'message' => '');
        } else {
            if ($this->session->has_userdata('payment_amount')) {
                $this->session->unset_userdata('payment_amount');
            }
            $newdata = array(
                'record_id' => $this->input->post('record_id'),
                'deposit_amount' => $this->input->post('deposit_amount'),
            );

            $this->session->set_userdata('payment_amount', $newdata);
            $array = array('status' => '1', 'error' => '', 'message' => 'Record Saved Successfully.');
        }
        echo json_encode($array);
    }

    public function billpayment() {

        $data = array();
        if (!empty($this->pay_method)) {

            $payment_amount = $this->session->userdata('payment_amount');
            $record_id = $payment_amount['record_id'];
            $deposit_amount = $payment_amount['deposit_amount'];

            if ($this->pay_method->payment_type == "payu") {
                redirect(base_url("patient/payu"));
            } elseif ($this->pay_method->payment_type == "stripe") {
                redirect(base_url("patient/stripe"));
            } elseif ($this->pay_method->payment_type == "ccavenue") {
                redirect(base_url("patient/ccavenue"));
            } elseif ($this->pay_method->payment_type == "paypal") {
                echo "string";
                redirect(base_url("patient/paypal"));
            }
        }
    }

    // public function calculate() {
    //     $amount = 0;
    //     $patient_id = $this->input->post('id');
    //     //$patient_data = $this->patient_model->getPaymentDetail($patient_id);
    //     $patient_data = $this->patient_model->getPaymentDetail($patient_id);
    //     $amount = ($patient_data->amount_due - $patient_data->amount_deposit);
    //     echo json_encode(array('amount' => $amount));
    // }

     public function calculate() {
        $amount = 0;
        $ipd_id = $this->input->post('ipdid');
        //$patient_data = $this->patient_model->getPaymentDetail($patient_id);
        $patient_data = $this->patient_model->getPaymentDetailpatient($ipd_id);
        $amount = ($patient_data->amount_due - $patient_data->amount_deposit);
        echo json_encode(array('amount' => $amount));
    }

    public function paymentfailed() {

        $data = array();
        $data['title'] = 'Invoice';

        $setting_result = $this->setting_model->get();

        $data['settinglist'] = $setting_result;
        $this->load->view("layout/patient/header");

        $this->load->view('patient/paymentfailed', $data);

        $this->load->view("layout/patient/footer");
    }

    public function successinvoice($invoice_id) {

        $data['title'] = 'Invoice';
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $studentfee = $this->payment_model->paymentByID($invoice_id);

        $record = $studentfee->paid_amount;
        $data['studentfee'] = $studentfee;
        $data['studentfee_detail'] = $record;
        $this->load->view('layout/patient/header', $data);
        $this->load->view('patient/invoice', $data);
        $this->load->view('layout/patient/footer', $data);
    }

}

?>