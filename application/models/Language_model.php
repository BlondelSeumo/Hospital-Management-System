<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Language_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    function getRows($params = array()) {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->order_by('created_at', 'desc');

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get($id = null) {
        $this->db->select()->from('languages');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('language asc');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('languages');
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('languages', $data);
        } else {
            $this->db->insert('languages', $data);
        }
    }

    public function valid_check_exists($str) {
        $language = $this->input->post('language');
        $id = $this->input->post('id');

        if (!isset($id) && $id == "") {
            $id = 0;
        }
        if ($this->check_data_exists($language, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_data_exists($name, $id) {
        $this->db->where('language', $name);

        $this->db->where('id !=', $id);
        $query = $this->db->get('languages');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
