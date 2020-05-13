<?php

class Bedgroup_model extends CI_Model {

    function get_bedgroup($id = null) {

        $this->db->select('bed_group.*,floor.name as floor_name')->from('bed_group')
                ->join('floor', 'bed_group.floor = floor.id');
        if ($id != null) {
            $this->db->where('bed_group.id', $id);
        } else {
            $this->db->order_by('bed_group.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function valid_bed_group($str) {
        $name = $this->input->post('name');
        if ($this->check_bed_group_exists($name)) {
            $this->form_validation->set_message('check_exists', 'Bed Group already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_bed_group_exists($name) {
        if ($name != 0) {
            $data = array('name' => $name);
            $query = $this->db->where($data)->get('bed_group');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('name', $name);
            $query = $this->db->get('bed_group');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    function add_bed_group($data) {

        if (isset($data["id"])) {

            $this->db->where("id", $data["id"])->update("bed_group", $data);
        } else {
            $this->db->insert("bed_group", $data);
        }
    }

    function bedgroup_list($id = null) {

        if (!empty($id)) {
            $query = $this->db->select("bed_group.*,floor.name as floor_name")->join("floor", "bed_group.floor = floor.id")->where("bed_group.id", $id)->get("bed_group");
            return $query->row_array();
        } else {

            $query = $this->db->select("bed_group.*,floor.name as floor_name")->join("floor", "bed_group.floor = floor.id")->get("bed_group");
            return $query->result_array();
        }
    }

    function delete_bedgroup($id) {

        $this->db->where("id", $id)->delete("bed_group");
    }

    public function bedGroupFloor() {
        $query = $this->db->select('bed_group.*,floor.id as fid,floor.name as floor_name')
                ->join('floor', 'bed_group.floor = floor.id')
                ->get('bed_group');
        return $query->result_array();
    }

}

?>