<?php

class Prescription extends Patient_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->load->library('Customlib');
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->blood_group = $this->config->item('bloodgroup');
    }

    function getPrescription($id, $opdid, $visitid = '') {
        $result = $this->prescription_model->get($id);

        $prescription_list = $this->prescription_model->getPrescriptionByOPD($result['opd_id'], $visitid);

        $data["print_details"] = $this->printing_model->get('', 'opd');
        $data["result"] = $result;
        $data["id"] = $id;
        $data["opdid"] = $opdid;
        if (isset($_POST['print'])) {
            $data["print"] = 'yes';
        } else {
            $data["print"] = 'no';
        }
        $data["prescription_list"] = $prescription_list;
        $this->load->view("patient/prescription", $data);
    }

     function getIPDPrescription($id, $ipdid, $visitid = '') {
        $result = $this->prescription_model->getIPD($id);
        $prescription_list = $this->prescription_model->getPrescriptionByIPD($ipdid, $visitid);
        $data["print_details"] = $this->printing_model->get('', 'ipdpres');
        $data["result"] = $result;
        $data["id"] = $id;
        $data["ipdid"] = $ipdid;
        if (isset($_POST['print'])) {
            $data["print"] = 'yes';
        } else {
            $data["print"] = 'no';
        }
        $data["prescription_list"] = $prescription_list;
        $this->load->view("patient/ipdprescription", $data);
    }

}

?>