<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userlog_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get($id = null) {
        $this->db->select()->from('userlog');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('login_datetime', 'desc');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getByRole($role) {
        $this->db->select()->from('userlog');
        $this->db->where('role', $role);
        $this->db->order_by('login_datetime', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getByRoleStaff() {
        $this->db->select()->from('userlog');
        $this->db->where('role!=', 'Parent');
        $this->db->where('role!=', 'Student');
        $this->db->order_by('login_datetime', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('userlog', $data);
        } else {
            $this->db->insert('userlog', $data);
        }
    }

}

?>