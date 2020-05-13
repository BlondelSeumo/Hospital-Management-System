<?php

class Medicine_category_model extends CI_model {

    public function valid_medicine_category($str) {
        $medicine_category = $this->input->post('medicine_category');
        $id = $this->input->post('id');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_category_exists($medicine_category, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function valid_medicine_name($str) {
        $medicine_name = $this->input->post('medicine_name');
        $id = $this->input->post('id');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_name_exists($medicine_name, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_name_exists($name, $id) {
        if ($id != 0) {
            $data = array('id != ' => $id, 'medicine_name' => $name);
            $query = $this->db->where($data)->get('pharmacy');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('medicine_name', $name);
            $query = $this->db->get('pharmacy');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function valid_supplier_category($str) {
        $supplier_category = $this->input->post('supplier_category');
        $id = $this->input->post('suppliercategoryid');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_category_existssupplier($supplier_category, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getMedicineCategory($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('medicine_category');
            return $query->row_array();
        } else {
            $query = $this->db->get("medicine_category");
            return $query->result_array();
        }
    }

    public function getSupplierCategory($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('supplier_category');
            return $query->row_array();
        } else {
            $query = $this->db->get("supplier_category");
            return $query->result_array();
        }
    }

    public function getMedicineCategoryPat($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('medicine_category');
            return $query->row_array();
        } else {
            $query = $this->db->get("medicine_category");
            return $query->result_array();
        }
    }

    public function getSupplierCategoryPat($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('supplier_category');
            return $query->row_array();
        } else {
            $query = $this->db->get("supplier_category");
            return $query->result_array();
        }
    }

    public function check_category_exists($name, $id) {
        if ($id != 0) {
            $data = array('id != ' => $id, 'medicine_category' => $name);
            $query = $this->db->where($data)->get('medicine_category');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('medicine_category', $name);
            $query = $this->db->get('medicine_category');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function check_category_existssupplier($name, $id) {
        if ($id != 0) {
            $data = array('id != ' => $id, 'supplier_category' => $name);
            $query = $this->db->where($data)->get('supplier_category');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('supplier_category', $name);
            $query = $this->db->get('supplier_category');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function addMedicineCategory($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('medicine_category', $data);
        } else {
            $this->db->insert('medicine_category', $data);
            return $this->db->insert_id();
        }
    }

    public function addSupplierCategory($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('supplier_category', $data);
        } else {
            $this->db->insert('supplier_category', $data);
            return $this->db->insert_id();
        }
    }

    public function getall() {
        $this->datatables->select('id,medicine_category');
        $this->datatables->from('medicine_category');
        $this->datatables->add_column('view', '<a href="' . site_url('admin/medicinecategory/edit/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Edit"> <i class="fa fa-pencil"></i></a><a href="' . site_url('admin/medicinecategory/delete/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Delete">
                                                        <i class="fa fa-remove"></i>
                                                    </a>', 'id');
        return $this->datatables->generate();
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete("medicine_category");
    }

    public function deletesupplier($id) {
        $this->db->where("id", $id)->delete("supplier_category");
    }

}

?>