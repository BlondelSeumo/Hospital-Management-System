<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class customfield_model extends CI_Model {

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
        $this->db->select()->from('custom_fields');
        if ($id != null) {
            $this->db->where('custom_fields.id', $id);
        } else {
            $this->db->order_by('custom_fields.belong_to', 'asc');
            $this->db->order_by('custom_fields.weight', 'asc');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row();
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
        $this->db->delete('custom_fields');
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id']) && $data['id'] != '') {
            $this->db->where('id', $data['id']);
            $this->db->update('custom_fields', $data);
        } else {
            $this->db->insert('custom_fields', $data);
            return $this->db->insert_id();
        }
    }

    public function updateorder($data) {
        $this->db->update_batch('custom_fields', $data, 'id');
    }

    public function getByBelong($belong_to) {
        $this->db->from('custom_fields');
        $this->db->where('belong_to', $belong_to);
        $this->db->order_by('custom_fields.belong_to', 'asc');
        $this->db->order_by('custom_fields.weight', 'asc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function insertRecord($custom_value_array, $insert_id) {

        $this->db->trans_begin();

        foreach ($custom_value_array as $insert_key => $insert_value) {
            $custom_value_array[$insert_key]['belong_table_id'] = $insert_id;
        }
        $this->db->insert_batch('custom_field_values', $custom_value_array);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function updateRecord($custom_value_array, $id, $belong_to) {

        $this->db->trans_begin();
        foreach ($custom_value_array as $custom_value_key => $custom_value_value) {
            $this->db->where('belong_table_id', $id);
            $this->db->where('custom_field_id', $custom_value_value['custom_field_id']);
            $q = $this->db->get('custom_field_values');

            if ($q->num_rows() > 0) {
                $results = $q->row();
                $this->db->where('id', $results->id);
                $this->db->update('custom_field_values', $custom_value_value);
            } else {

                $this->db->insert('custom_field_values', $custom_value_value);
            }
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    function get_custom_fields($belongs_to, $display_table = null) {


        $this->db->from('custom_fields');
        $this->db->where('belong_to', $belongs_to);

        if (!empty($display_table)) {
            $this->db->where('visible_on_table', $display_table);
        }
        $this->db->order_by("custom_fields.weight", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

}
