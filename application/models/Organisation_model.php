<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Organisation_model extends CI_Model {

    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('organisation', $data);
        } else {
            $this->db->insert('organisation', $data);
        }
    }

    public function get($id = null) {
        $this->db->select()->from('organisation');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('organisation');
    }

    public function Charge($ch_type) {
        $this->db->select(' charges.id , charges.standard_charge, schedule_charge_category.schedule');
        $this->db->join('schedule_charge_category', 'schedule_charges.schedule_charge_id = schedule_charge_category.id', 'left');
        $this->db->join('charges', 'schedule_charges.charge_id = charges.id', 'left');
        $this->db->where('charges.charge_type', $ch_type);
        $query = $this->db->get('schedule_charges');
        return $query->result_array();
    }

}

?>