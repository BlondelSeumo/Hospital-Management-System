<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class visitors_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

    function add($data) {
        $this->db->insert('visitors_book', $data);
        return $query = $this->db->insert_id();
    }

    public function getPurpose() {
        $this->db->select('*');
        $this->db->from('visitors_purpose');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function visitors_list($id = null) {
        $this->db->select()->from('visitors_book');
        if ($id != null) {
            $this->db->where('visitors_book.id', $id);
        } else {
            $this->db->order_by('visitors_book.id', 'desc');
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
        $this->db->delete('visitors_book');
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> Visitor deleted successfully</div>');
        redirect('admin/visitors');
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('visitors_book', $data);
    }

    public function image_add($visitor_id, $image) {
        $array = array('id' => $visitor_id);
        $this->db->set('image', $image);
        $this->db->where($array);
        $this->db->update('visitors_book');
    }

    public function image_update($visitor_id, $image) {
        $array = array('id' => $visitor_id);
        $this->db->set('image', $image);
        $this->db->where($array);
        $this->db->update('visitors_book');
    }

    public function image_delete($id, $img_name) {
        $file = "./uploads/front_office/visitors/" . $img_name;
        unlink($file);
        $this->db->where('id', $id);
        $this->db->delete('visitors_book');
        $controller_name = $this->uri->segment(2);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> ' . ucfirst($controller_name) . ' deleted successfully</div>');
        redirect('admin/' . $controller_name);
    }

}

?>