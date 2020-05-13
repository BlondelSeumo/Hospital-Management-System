<?php

class Bedtype_model extends CI_Model {

    public function valid_bed_type($str) {
        $name = $this->input->post('name');
        if ($this->check_bed_type_exists($name)) {
            $this->form_validation->set_message('check_exists', 'Bed Type already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_bed_type_exists($name) {
        if ($name != 0) {
            $data = array('name' => $name);
            $query = $this->db->where($data)->get('bed_type');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('name', $name);
            $query = $this->db->get('bed_type');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function savebed($data) {
        if (isset($data["id"])) {
            $this->db->where("id", $data["id"])->update("bed_type", $data);
        } else {
            $this->db->insert("bed_type", $data);
        }
    }

    public function bedtype_list($id = null) {
        $this->db->select()->from('bed_type');
        if ($id != null) {
            $this->db->where('bed_type.id', $id);
        } else {
            $this->db->order_by('bed_type.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete("bed_type");
    }

}
