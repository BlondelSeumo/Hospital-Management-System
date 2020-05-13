<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->blood_group = $this->config->item('bloodgroup');
        $this->load->library('mailsmsconf');


        $this->charge_type = $this->config->item('charge_type');
        $data["charge_type"] = $this->charge_type;
    }

    function create() {
        if (!empty($_FILES['document']['name'])) {
            $config['upload_path'] = 'uploads/payment_document/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = $_FILES['document']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('document')) {
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else {
            $picture = '';
        }

        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('payment_date', $this->lang->line('payment') . " " . $this->lang->line('date'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'amount' => form_error('amount'),
                'payment_date' => form_error('payment_date'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $patient_id = $this->input->post("patient_id");
            $ipd_id = $this->input->post("ipdid");
            $date = $this->input->post("payment_date");
            $payment_date = date('Y-m-d', $this->customlib->datetostrtotime($date));

            $paid_amount = $this->input->post('amount');
            $paid_total = $this->payment_model->getPaidTotal($patient_id, $ipd_id);
            $totalPaidamount = $paid_total["paid_amount"] + $paid_amount;


            $total = $this->input->post('total');
            $balance_amount = ($total) - ($totalPaidamount);

            $data = array('patient_id' => $this->input->post('patient_id'),
                'paid_amount' => $paid_amount,
                'balance_amount' => $balance_amount,
                'total_amount' => $total,
                'ipd_id' => $this->input->post('ipdid'),
                'payment_mode' => $this->input->post('payment_mode'),
                'note' => $this->input->post('note'),
                'date' => $payment_date,
                'document' => $picture,
            );

            $this->payment_model->addPayment($data);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
        }


        echo json_encode($array);
    }

    function addOPDPayment() {
        if (!empty($_FILES['document']['name'])) {
            $config['upload_path'] = 'uploads/payment_document/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = $_FILES['document']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('document')) {
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else {
            $picture = '';
        }
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('payment_date', $this->lang->line('payment') . " " . $this->lang->line('date'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'amount' => form_error('amount'),
                'payment_date' => form_error('payment_date'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $patient_id = $this->input->post("patient_id");
            $date = $this->input->post("payment_date");
            $payment_date = date('Y-m-d', $this->customlib->datetostrtotime($date));

            $paid_amount = $this->input->post('amount');
            $paid_total = $this->payment_model->getOPDPaidTotal($patient_id, '');
            $totalPaidamount = $paid_total["paid_amount"] + $paid_amount;


            $total = $this->input->post('total');
            $balance_amount = ($total) - ($totalPaidamount);

            $data = array('patient_id' => $this->input->post('patient_id'),
                'opd_id' => $this->input->post('opd_id'),
                'paid_amount' => $paid_amount,
                'balance_amount' => $balance_amount,
                'total_amount' => $total,
                'payment_mode' => $this->input->post('payment_mode'),
                'note' => $this->input->post('note'),
                'date' => $payment_date,
                'document' => $picture,
            );

            $this->payment_model->addOPDPayment($data);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
        }


        echo json_encode($array);
    }

    public function download($doc) {
        $this->load->helper('download');
        $filepath = "./uploads/payment_document/" . $doc;
        $data = file_get_contents($filepath);
        force_download($doc, $data);
    }

    public function getBill() {
        $id = $this->input->post("patient_id");
        $ipdid = $this->input->post("ipdid");
        $data['total_amount'] = $this->input->post("total_amount");
        $data['discount'] = $this->input->post("discount");
        $data['other_charge'] = $this->input->post("other_charge");
        $data['gross_total'] = $this->input->post("gross_total");
        $data['tax'] = $this->input->post("tax");
        $data['net_amount'] = $this->input->post("net_amount");
        $data["print_details"] = $this->printing_model->get('', 'ipd');
        $status = $this->input->post("status");
        $result = $this->patient_model->getIpdDetails($id, $ipdid, $status);
        $charges = $this->charge_model->getCharges($id, $ipdid);
        $paymentDetails = $this->payment_model->paymentDetails($id, $ipdid);
        $paid_amount = $this->payment_model->getPaidTotal($id, $ipdid);
        $balance_amount = $this->payment_model->getBalanceTotal($id, $ipdid);
        $data["paid_amount"] = $paid_amount["paid_amount"];
        $data["balance_amount"] = $balance_amount["balance_amount"];
        $data["payment_details"] = $paymentDetails;
        $data["charges"] = $charges;
        $data["result"] = $result;
        $this->load->view("admin/patient/ipdBill", $data);
    }

    public function getOPDBill() {

        $id = $this->input->post("patient_id");
        $opdid = $this->input->post("opdid");
        $data['total_amount'] = $this->input->post("total_amount");
        $data['discount'] = $this->input->post("discount");
        $data['other_charge'] = $this->input->post("other_charge");
        $data['gross_total'] = $this->input->post("gross_total");
        $data['tax'] = $this->input->post("tax");
        $data['net_amount'] = $this->input->post("net_amount");
        $data["print_details"] = $this->printing_model->get('', 'opd');
        $status = $this->input->post("status");
        $result = $this->patient_model->getDetails($id,$opdid);
        $charges = $this->charge_model->getOPDCharges($id, $opdid);

        $paymentDetails = $this->payment_model->opdPaymentDetails($id, $opdid);
        $paid_amount = $this->payment_model->getOPDPaidTotal($id, $opdid);
        $balance_amount = $this->payment_model->getOPDBalanceTotal($id);
        $data["paid_amount"] = $paid_amount["paid_amount"];
        $data["balance_amount"] = $balance_amount["balance_amount"];
        $data["payment_details"] = $paymentDetails;
        $data["charges"] = $charges;
        $data["result"] = $result;
        $this->load->view("admin/patient/opdBill", $data);
    }

    public function getVisitBill() {

        $id = $this->input->post("patient_id");
        $visit_id = $this->input->post("visit_id");

        $data["print_details"] = $this->printing_model->get('', 'opd');
        $status = $this->input->post("status");
        $result = $this->patient_model->printVisitDetails($id, $visit_id);


        $data["result"] = $result;
        $this->load->view("admin/patient/visitBill", $data);
    }

    public function addbill() {
        $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('net_amount', 'Net Amount', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'total_amount' => form_error('total_amount'),
                'net_amount' => form_error('net_amount'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $patient_id = $this->input->post('patient_id');
            $ipdid = $this->input->post('ipdid');
            $data = array('patient_id' => $this->input->post('patient_id'),
                'ipd_id' => $this->input->post('ipdid'),
                'discount' => $this->input->post('discount'),
                'other_charge' => $this->input->post('other_charge'),
                'total_amount' => $this->input->post('total_amount'),
                'gross_total' => $this->input->post('gross_total'),
                'tax' => $this->input->post('tax'),
                'net_amount' => $this->input->post('net_amount'),
                'date' => date("Y-m-d"),
                'generated_by' => $this->session->userdata('hospitaladmin')['id'],
                'status' => 'paid'
            );
            $this->payment_model->add_bill($data);
            $bed_no = $this->input->post('bed_no');
            $bed_data = array('id' => $bed_no, 'is_active' => 'yes');
            $this->bed_model->savebed($bed_data);

            $ipd_data = array('id' => $ipdid, 'discharged' => 'yes', 'discharged_date' => date("Y-m-d"));
            $this->patient_model->add_ipd($ipd_data);

            $patient_data = array('id' => $patient_id, 'discharged' => 'yes');
            $this->patient_model->add($patient_data);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
            $sender_details = array('patient_id' => $patient_id, 'ipd_id' => $ipdid, 'contact_no' => '', 'email' => '');
            $this->mailsmsconf->mailsms('patient_discharged', $sender_details);
        }

        echo json_encode($array);
    }

    public function addopdbill() {
        $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('net_amount', 'Net Amount', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'total_amount' => form_error('total_amount'),
                'net_amount' => form_error('net_amount'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $patient_id = $this->input->post('patient_id');
            $data = array('patient_id' => $this->input->post('patient_id'),
                'opd_id' => $this->input->post('opd_id'),
                'discount' => $this->input->post('discount'),
                'other_charge' => $this->input->post('other_charge'),
                'total_amount' => $this->input->post('total_amount'),
                'gross_total' => $this->input->post('gross_total'),
                'tax' => $this->input->post('tax'),
                'net_amount' => $this->input->post('net_amount'),
                'date' => date("Y-m-d"),
                'generated_by' => $this->session->userdata('hospitaladmin')['id'],
                'status' => 'paid'
            );
            $this->payment_model->add_opdbill($data);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
        }

        echo json_encode($array);
    }

}

?>