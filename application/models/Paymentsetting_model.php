<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentsetting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get() {
        $this->db->select()->from('payment_settings');
        $query = $this->db->get();
        return $query->result();
    }

    public function getActiveMethod() {
        $this->db->select()->from('payment_settings');
        $this->db->where('is_active', 'yes');
        $query = $this->db->get();
        return $query->row();
    }

    public function add($data) {
        $this->db->where('payment_type', $data['payment_type']);
        $q = $this->db->get('payment_settings');

        if ($q->num_rows() > 0) {

            $this->db->where('id', $q->row()->id);
            $this->db->update('payment_settings', $data);
        } else {

            $this->db->insert('payment_settings', $data);
        }
    }

    public function valid_paymentsetting() {

        $payment_setting = $this->input->post('payment_setting');
        if ($payment_setting == "none") {
            return true;
        }
        if (!$this->check_data_exists($payment_setting)) {
            $this->form_validation->set_message('paymentsetting', 'Please fill your %s detail');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_data_exists($payment_setting) {
        $this->db->where('payment_type', $payment_setting);
        $query = $this->db->get('payment_settings');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function active($data, $other = false) {


        if (!$other) {
            $this->db->where('payment_type', $data['payment_type']);
            $this->db->update('payment_settings', $data);
            $data['is_active'] = "no";
            $payment_type = $data['payment_type'];
            unset($data['payment_type']);
            $this->db->where('payment_type !=', $payment_type);
            $this->db->update('payment_settings', $data);
        } else {

            $this->db->update('payment_settings', $data);
        }
    }

}

?>