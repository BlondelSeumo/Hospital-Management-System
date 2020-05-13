<?php

class Pathology_category_model extends CI_model {

    public function valid_category_name($str) {
        $category_name = $this->input->post('category_name');
        $id = $this->input->post('pathology_category_id');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_category_exists($category_name, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getCategoryName($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('pathology_category');
            return $query->row_array();
        } else {
            $query = $this->db->get("pathology_category");
            return $query->result_array();
        }
    }

    public function check_category_exists($name, $id) {
        if ($id != 0) {
            $data = array('id != ' => $id, 'category_name' => $name);
            $query = $this->db->where($data)->get('pathology_category');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('category_name', $name);
            $query = $this->db->get('pathology_category');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function addCategoryName($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('pathology_category', $data);
        } else {
            $this->db->insert('pathology_category', $data);
            return $this->db->insert_id();
        }
    }

    public function getall() {
        $this->datatables->select('id,category_name');
        $this->datatables->from('pathology_category');
        $this->datatables->add_column('view', '<a href="' . site_url('admin/pathologycategory/edit/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Edit"> <i class="fa fa-pencil"></i></a><a href="' . site_url('admin/pathologycategory/delete/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Delete">
                                                        <i class="fa fa-remove"></i>
                                                    </a>', 'id');
        return $this->datatables->generate();
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete("pathology_category");
    }

}

?>