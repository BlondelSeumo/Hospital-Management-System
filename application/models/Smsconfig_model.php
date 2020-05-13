<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smsconfig_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get($id = null) {
        $this->db->select()->from('sms_config');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result();
        }
    }

    public function changeStatus($type) {
        $data = array('is_active' => 'disabled');
        $this->db->where('type !=', $type);
        $this->db->update('sms_config', $data);
    }

    public function add($data) {
        $this->db->where('type', $data['type']);
        $q = $this->db->get('sms_config');

        if ($q->num_rows() > 0) {
            $this->db->where('type', $data['type']);
            $this->db->update('sms_config', $data);
        } else {
            $this->db->insert('sms_config', $data);
        }
        if ($data['is_active'] == "enabled") {
            $this->changeStatus($data['type']);
        }
    }

    public function getActiveSMS() {
        $this->db->select()->from('sms_config');
        $this->db->where('is_active', 'enabled');
        $query = $this->db->get();
        return $query->row();
    }

}

?>