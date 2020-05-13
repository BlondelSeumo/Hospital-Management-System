<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ComplaintType_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function add($table, $data) {
        $this->db->insert($table, $data);
    }

    public function get($table, $id = null) {
        $this->db->select()->from($table);
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function update($table, $complaint_type_id, $data) {
        $this->db->where('id', $complaint_type_id);
        $query = $this->db->update($table, $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $id) {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

}
