<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dispatch_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

    public function insert($table, $data) {
        $this->db->insert($table, $data);
        return $query = $this->db->insert_id();
    }

    public function image_add($type, $dispatch_id, $image) {
        $array = array('id' => $dispatch_id, 'type' => $type);
        $this->db->set('image', $image);
        $this->db->where($array);
        $this->db->update('dispatch_receive');
    }

    public function dispatch_list() {
        $this->db->select('*');
        $this->db->where('type', 'dispatch');
        $this->db->from('dispatch_receive');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function receive_list() {
        $this->db->select('*');
        $this->db->where('type', 'receive');
        $this->db->order_by('id', 'desc');
        $this->db->from('dispatch_receive');
        $query = $this->db->get();
        return $query->result();
    }

    public function dis_rec_data($id, $type) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('type', $type);
        $this->db->from('dispatch_receive');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recevie_data($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('dispatch_receive');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_dispatch($table, $id, $type, $data) {
        $this->db->where('id', $id);
        $this->db->where('type', $type);
        $this->db->update($table, $data);
    }

    public function image_update($type, $id, $img_name) {
        $this->db->set('image', $img_name);
        $this->db->where('id', $id);
        $this->db->where('type', $type);
        $this->db->update('dispatch_receive');
    }

    public function image_delete($id, $img_name) {
        $file = "./uploads/front_office/dispatch_receive/" . $img_name;
        unlink($file);
        $this->db->where('id', $id);
        $this->db->delete('dispatch_receive');
        $controller_name = $this->uri->segment(2);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('dispatch_receive');
        $controller_name = $this->uri->segment(2);
    }

}

?>