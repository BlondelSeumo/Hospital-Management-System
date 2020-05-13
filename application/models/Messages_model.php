<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Messages_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {
        $this->db->select()->from('messages');
        if ($id != null) {
            $this->db->where('messages.id', $id);
        } else {
            $this->db->order_by('messages.created_at', 'desc');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('messages');
    }

    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('messages', $data);
        } else {
            $this->db->insert('messages', $data);
            return $this->db->insert_id();
        }
    }

}

?>