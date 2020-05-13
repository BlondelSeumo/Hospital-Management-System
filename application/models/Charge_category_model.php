<?php

class Charge_category_model extends CI_model {

    public function valid_charge_category($str) {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_category_exists($id, $name)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getChargeCategory($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('charge_categories');
            return $query->row_array();
        } else {
            $query = $this->db->get("charge_categories");
            return $query->result_array();
        }
    }

    public function check_category_exists($id, $name) {
        if ($id != 0) {
            $data = array('id != ' => $id, 'name' => $name);
            $query = $this->db->where($data)->get('charge_categories');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('name', $name);
            $query = $this->db->get('charge_categories');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function addChargeCategory($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('charge_categories', $data);
        } else {
            $this->db->insert('charge_categories', $data);
            return $this->db->insert_id();
        }
    }

    public function getall() {
        $this->datatables->select('id,name,description,charge_type');
        $this->datatables->from('charge_categories');
        $this->datatables->add_column('view', '<a href="' . site_url('admin/chargecategory/edit/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Edit"> <i class="fa fa-pencil"></i></a><a href="' . site_url('admin/chargecategory/delete/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Delete">
                                                        <i class="fa fa-remove"></i>
                                                    </a>', 'id');
        return $this->datatables->generate();
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete("charge_categories");
    }

}
