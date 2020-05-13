<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Paypal extends Patient_Controller {

    public $payment_method = array();
    public $pay_method = array();
    public $patient_data;

    public function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->load->library('Customlib');
        $this->load->library('paypal_payment');

        $this->patient_data = $this->session->userdata('patient');
        $this->payment_method = $this->paymentsetting_model->get();
        $this->pay_method = $this->paymentsetting_model->getActiveMethod();
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->blood_group = $this->config->item('bloodgroup');
        $this->setting = $this->setting_model->get();
    }

    public function index() {
        if ($this->session->has_userdata('payment_amount')) {
            $setting = $this->setting[0];
            $data = array();
            $id = $this->patient_data['patient_id'];

            $charges = $this->charge_model->getCharges($id);
            $data["charges"] = $charges;
            $paymentDetails = $this->payment_model->paymentDetails($id);
            $paid_amount = $this->payment_model->getPaidTotal($id);
            $data["paid_amount"] = $paid_amount["paid_amount"];
            $balance_amount = $this->payment_model->getBalanceTotal($id);
            $data["balance_amount"] = $balance_amount["balance_amount"];
            $data["payment_details"] = $paymentDetails;
            $amount = $this->session->userdata('payment_amount');
            $ipdid = $amount['record_id'];
            $data['amount'] = $amount['deposit_amount'];
            $data["id"] = $id;
            $result = $this->patient_model->getIpdDetails($id,$ipdid);
            $data['patient'] = $result;
            $data['currency'] = $setting['currency'];
            $data['hospital_name'] = $setting['name'];
            $data['image'] = $setting['image'];
            
            $this->load->view("layout/patient/header");
            $this->load->view("patient/paypal", $data);
            $this->load->view("layout/patient/footer");
        }
    }

    public function checkout() {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($this->session->has_userdata('payment_amount')) {
                $setting = $this->setting[0];
                $id = $this->patient_data['patient_id'];
                $data["id"] = $id;
                $params = $this->session->userdata('payment_amount');
                $result = $this->patient_model->getIpdDetails($id);
                $data = array();
                $data['total'] = $this->input->post('total');
                $data['productinfo'] = "bill payment smart hospital";
                $data['symbol'] = $setting['currency_symbol'];
                $data['currency_name'] = $setting['currency'];
                $data['name'] = $result['patient_name'];
                $data['guardian_phone'] = $result['mobileno'];

                $response = $this->paypal_payment->payment($data);
                if ($response->isSuccessful()) {
                    
                } elseif ($response->isRedirect()) {
                    $response->redirect();
                } else {
                    echo $response->getMessage();
                }
            }
        }
    }

    public function getsuccesspayment() {
        $data = array();
        $setting = $this->setting[0];
        $id = $this->patient_data['patient_id'];
        $result = $this->patient_model->getIpdDetails($id);
        $params = $this->session->userdata('payment_amount');
        $data['total'] = $params['deposit_amount'];
        $data['symbol'] = $setting['currency_symbol'];
        $data['currency_name'] = $setting['currency'];
        $data['name'] = $result['patient_name'];
        $data['guardian_phone'] = $result['mobileno'];
        $data['productinfo'] = "bill payment smart hospital";

        $response = $this->paypal_payment->success($data);

        $paypalResponse = $response->getData();
        if ($response->isSuccessful()) {
            $purchaseId = $_GET['PayerID'];

            if (isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {
                if ($purchaseId) {
                    $params = $this->session->userdata('payment_amount');
                    $ref_id = $paypalResponse['PAYMENTINFO_0_TRANSACTIONID'];

                    $save_record = array(
                        'patient_id' => $this->patient_data['patient_id'],
                        'paid_amount' => $params['deposit_amount'],
                        'date' => date('Y-m-d'),
                        'total_amount' => '',
                        'note' => "Online fees deposit through Paypal Ref ID: " . $ref_id,
                        'payment_mode' => 'Online',
                    );

                    $insert_id = $this->payment_model->addPayment($save_record);
                    redirect(base_url("patient/pay/successinvoice/" . $insert_id));
                }
            }
        } elseif ($response->isRedirect()) {
            $response->redirect();
        } else {

            redirect(base_url("patient/pay/paymentfailed"));
        }
    }

}

?>