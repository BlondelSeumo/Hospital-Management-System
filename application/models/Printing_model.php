<?php

class Printing_model extends CI_Model {

    public function add($data) {
        if (isset($data["id"])) {

            $this->db->where("id", $data["id"])->update("print_setting", $data);
        } else {

            $this->db->insert("print_setting", $data);
            return $this->db->insert_id();
        }
    }

    public function get($id = '', $setting_for = '') {
        if (!empty($id)) {

            $query = $this->db->where("id", $id)->get("print_setting");
            return $query->row_array();
        } else {
            $query = $this->db->where("setting_for", $setting_for)->get("print_setting");
            return $query->result_array();
        }
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete('print_setting');
    }

}

?>