<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notificationsetting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get($id = null) {
        $this->db->select()->from('notification_setting');
        if ($id != null) {
            $this->db->where('notification_setting.id', $id);
        } else {
            $this->db->order_by('notification_setting.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    public function add($data) {
        $this->db->select()->from('notification_setting');
        $this->db->where('notification_setting.type', $data['type']);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            $result = $q->row();

            $this->db->where('id', $result->id);
            $this->db->update('notification_setting', $data);
        } else {
            $this->db->insert('notification_setting', $data);
            return $this->db->insert_id();
        }
    }

}

?>