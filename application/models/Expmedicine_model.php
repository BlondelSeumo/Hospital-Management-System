<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expmedicine_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('vehicles', $data);
        } else {
            $this->db->insert('vehicles', $data);
            return $this->db->insert_id();
        }
    }

    public function get($id = null) {
        $this->db->select()->from('vehicles');
        if ($id != null) {
            $this->db->where('vehicles.id', $id);
        } else {
            $this->db->order_by('vehicles.id', 'desc');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row();
        } else {
            return $query->result_array();
        }
    }

    public function getDetails($id) {
        $query = $this->db->select('vehicles.*')->where('id', $id)->get('vehicles');
        return $query->row_array();
    }

    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('vehicles');
    }

    public function addCallAmbulance($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('ambulance_call', $data);
        } else {
            $this->db->insert('ambulance_call', $data);
            return $this->db->insert_id();
        }
    }

    public function getCallAmbulance() {
        $query = $this->db->select('ambulance_call.*,vehicles.vehicle_no,vehicles.vehicle_model')
                ->join('vehicles', 'vehicles.id = ambulance_call.vehicle_no')
                ->get('ambulance_call');
        return $query->result_array();
    }

    public function getCallDetails($id) {
        $query = $this->db->select('ambulance_call.*')->where('id', $id)->get('ambulance_call');
        return $query->row_array();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('ambulance_call');
    }

    public function getList() {
        $first_date = date('Y-m-01');
        $last_date = date('Y-m-t 23:59:59.993');

        $query = $this->db->query("select medicine_batch_details.*,pharmacy.medicine_name,pharmacy.medicine_company,pharmacy.supplier,pharmacy.medicine_group,medicine_category.medicine_category from medicine_batch_details JOIN pharmacy ON medicine_batch_details.pharmacy_id = pharmacy.id JOIN medicine_category ON pharmacy.medicine_category_id = medicine_category.id where medicine_batch_details.expiry_date_format >= '" . $first_date . "' and medicine_batch_details.expiry_date_format<= '" . $last_date . "' and medicine_batch_details.expiry_date_format <= '" . date("Y-m-d") . "' order by expiry_date_format");
        return $query->result_array();
    }

}

?>