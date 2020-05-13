<?php

class Payment_model extends CI_Model {

    public function addPayment($data) {
        $this->db->insert("payment", $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function deleteIpdPatientPayment($id) {
        $query = $this->db->where('id', $id)
                ->delete('payment');
    }

    public function deleteOpdPatientPayment($id) {
        $query = $this->db->where('id', $id)
                ->delete('opd_payment');
    }
    public function paymentDetails($id, $ipdid='') {
        $query = $this->db->select('payment.*,patients.id as pid,patients.note as pnote')
                ->join("patients", "patients.id = payment.patient_id")->where("payment.patient_id", $id)->where("payment.ipd_id", $ipdid)
                ->get("payment");
        return $query->result_array();
    }

    public function opdPaymentDetails($id, $visitid) {
        $query = $this->db->select('opd_payment.*,patients.id as pid,patients.note as pnote')
                ->join("patients", "patients.id = opd_payment.patient_id")->where("opd_payment.patient_id", $id)->where("opd_payment.opd_id", $visitid)
                ->get("opd_payment");
        return $query->result_array();
    }

    public function opdPaymentDetailspat($id) {
        $query = $this->db->select('opd_payment.*,patients.id as pid,patients.note as pnote')
                ->join("patients", "patients.id = opd_payment.patient_id")->where("opd_payment.patient_id", $id)
                ->get("opd_payment");
        return $query->result_array();
    }

    public function paymentByID($id) {
        $query = $this->db->select('payment.*,patients.id as pid,patients.note as pnote')
                ->join("patients", "patients.id = payment.patient_id")->where("payment.id", $id)
                ->get("payment");
        return $query->row();
    }

    public function getBalanceTotal($id, $ipdid='') {
        $query = $this->db->select("IFNULL(sum(balance_amount),'0') as balance_amount")->where("payment.patient_id", $id)->where("payment.ipd_id", $ipdid)->get("payment");
        return $query->row_array();
    }

    public function getOPDBalanceTotal($id) {
        $query = $this->db->select("IFNULL(sum(balance_amount),'0') as balance_amount")->where("opd_payment.patient_id", $id)->get("opd_payment");
        return $query->row_array();
    }

    public function getPaidTotal($id, $ipdid='') {
        $query = $this->db->select("IFNULL(sum(paid_amount), '0') as paid_amount")->where("payment.patient_id", $id)->where("payment.ipd_id", $ipdid)->get("payment");
        return $query->row_array();
    }

    public function getOPDPaidTotal($id, $visitid) {
        $query = $this->db->select("IFNULL(sum(paid_amount), '0') as paid_amount")->where("opd_payment.patient_id", $id)->where("opd_payment.opd_id", $visitid)->get("opd_payment");
        return $query->row_array();
    }

    public function getOPDPaidTotalPat($id) {
        $query = $this->db->select("IFNULL(sum(paid_amount), '0') as paid_amount")->where("opd_payment.patient_id", $id)->get("opd_payment");
        return $query->row_array();
    }

    public function getChargeTotal($id, $ipdid) {
        $query = $this->db->select("IFNULL(sum(apply_charge), '0') as apply_charge")
                ->join('patients', 'patient_charges.patient_id = patients.id', 'inner')
                ->join('charges', 'patient_charges.charge_id = charges.id', 'inner')
                ->join('organisations_charges', 'patient_charges.org_charge_id = organisations_charges.id', 'left')
                ->where('patient_charges.patient_id', $id)
                ->where('patient_charges.ipd_id', $ipdid)
                ->get('patient_charges');
        return $query->row_array();
    }

    public function add_bill($data) {
        $this->db->insert("ipd_billing", $data);
    }

    public function add_opdbill($data) {
        $this->db->insert("opd_billing", $data);
    }

    public function revertBill($patient_id, $bill_id) {
        $this->db->where("id", $bill_id)->delete("ipd_billing");
    }

    public function valid_amount($amount) {
        if ($amount <= 0) {

            $this->form_validation->set_message('check_exists', 'The payment amount must be greater than 0');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function addOPDPayment($data) {
        $this->db->insert("opd_payment", $data);
    }

}

?>