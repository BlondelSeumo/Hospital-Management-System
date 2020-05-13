<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Suppliercategory extends Admin_Controller {

    public function supplier() {
        if (!$this->rbac->hasPrivilege('supplier', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'supplier/index');
        $supplier = $this->input->post("supplier");
        $data["title"] = "Add Supplier";
        $supplier = $this->supplier_category_model->getSupplier();
        $data["supplier"] = $supplier;
        $this->form_validation->set_rules(
                'supplier', 'Supplier', array('required',
            array('check_exists', array($this->supplier_category_model, 'valid_supplier'))
                )
        );
        if ($this->form_validation->run()) {
            $supplier = $this->input->post("supplier");
            $supplier = $this->input->post("id");
            if (empty($supplier)) {
                if (!$this->rbac->hasPrivilege('supplier', 'can_add')) {
                    access_denied();
                }
            } else {
                if (!$this->rbac->hasPrivilege('supplier', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($supplier)) {
                $data = array('supplier' => $supplier, 'id' => $supplier);
            } else {

                $data = array('supplier' => $supplier);
            }

            $insert_id = $this->supplier_category_model->addsupplier($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/Suppliercategory/supplier");
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/pharmacy/supplier", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add() {
        if ((!$this->rbac->hasPrivilege('supplier', 'can_add')) || (!$this->rbac->hasPrivilege('supplier', 'can_edit'))) {
            access_denied();
        }
        $supplier = $this->input->post("supplier");
        $this->form_validation->set_rules(
                'supplier', $this->lang->line('medicine') . " " . $this->lang->line('category'), array('required',
            array('check_exists', array($this->supplier_category_model, 'valid_supplier'))
                )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('supplier'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $supplier = $this->input->post("supplier");
            if (!empty($supplier)) {
                $data = array('supplier' => $supplier, 'id' => $supplier);
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
            } else {
                $data = array('supplier' => $supplier);
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            }
            $insert_id = $this->supplier_category_model->addsupplier($data);
        }
        echo json_encode($array);
    }

    public function get() { //get product data and encode to be JSON object
        header('Content-Type: application/json');
        echo $this->supplier_category_model->getall();
    }

    public function edit($id) {
        if (!$this->rbac->hasPrivilege('supplier', 'can_view')) {
            access_denied();
        }
        $result = $this->supplier_category_model->getMedicineCategory($id);
        $data["result"] = $result;
        $data["title"] = "Edit Category";
        $supplier = $this->supplier_category_model->getMedicineCategory();
        $data["supplier"] = $supplier;
        $this->load->view("layout/header");
        $this->load->view("admin/pharmacy/supplier", $data);
        $this->load->view("layout/footer");
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('supplier', 'can_delete')) {
            access_denied();
        }
        $this->supplier_category_model->delete($id);
        redirect('admin/medicinecategory/medicine');
    }

    public function get_data($id) {
        if (!$this->rbac->hasPrivilege('supplier', 'can_view')) {
            access_denied();
        }
        $result = $this->supplier_category_model->getMedicineCategory($id);
        echo json_encode($result);
    }

}

?>