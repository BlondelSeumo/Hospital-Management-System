<?php

class Supplier_category_model extends CI_model {

    public function valid_supplier($str) {
        $supplier = $this->input->post('supplier_name');
        $id = $this->input->post('supplierid');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_category_exists($supplier, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getSupplier($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('supplier');
            return $query->row_array();
        } else {
            $query = $this->db->get("supplier");
            return $query->result_array();
        }
    }

    public function getSupplierPat($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('supplier');
            return $query->row_array();
        } else {
            $query = $this->db->get("supplier");
            return $query->result_array();
        }
    }

    public function check_supplier_exists($name, $id) {
        if ($id != 0) {
            $data = array('id != ' => $id, 'supplier' => $name);
            $query = $this->db->where($data)->get('supplier');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('supplier', $name);
            $query = $this->db->get('supplier');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function addsupplier($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('supplier', $data);
        } else {
            $this->db->insert('supplier', $data);
            return $this->db->insert_id();
        }
    }

    public function getall() {
        $this->datatables->select('id,supplier');
        $this->datatables->from('supplier');
        $this->datatables->add_column('view', '<a href="' . site_url('admin/medicinecategory/edit/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Edit"> <i class="fa fa-pencil"></i></a><a href="' . site_url('admin/medicinecategory/delete/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Delete">
                                                        <i class="fa fa-remove"></i>
                                                    </a>', 'id');
        return $this->datatables->generate();
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete("supplier");
    }

}

?>