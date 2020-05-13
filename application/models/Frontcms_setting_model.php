<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontcms_setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {
        $this->db->select()->from('front_cms_settings');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id']) && $data['id'] != 0) {
            $this->db->where('id', $data['id']);
            $this->db->update('front_cms_settings', $data);
        } else {
            $this->db->insert('front_cms_settings', $data);
            return $this->db->insert_id();
        }
    }

    public function valid_check_exists($str) {
        $url = $this->input->post('url');
        $id = $this->input->post('id');

        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_data_exists($url, $id)) {
            $this->form_validation->set_message('check_exists', 'URL already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>