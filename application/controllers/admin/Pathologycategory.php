<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pathologycategory extends Admin_Controller {

    public function addCategory() {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'addCategory/index');
        $pathology_category_id = $this->input->post("pathology_category_id");

        $categoryName = $this->pathology_category_model->getcategoryName();
        $data["categoryName"] = $categoryName;
        $this->form_validation->set_rules(
                'category_name', 'Category Name', array('required',
            array('check_exists', array($this->pathology_category_model, 'valid_category_name'))
                )
        );
        $data["title"] = "Add Pathology Categories";
        if ($this->form_validation->run()) {
            $categoryName = $this->input->post("category_name");
            $pathology_category_id = $this->input->post("id");
            if (empty($pathology_category_id)) {

                if (!$this->rbac->hasPrivilege('pathology_category', 'can_add')) {
                    access_denied();
                }
            } else {

                if (!$this->rbac->hasPrivilege('pathology_category', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($pathology_category_id)) {
                $data = array('category_name' => $categoryName, 'id' => $pathology_category_id);
            } else {
                $data = array('category_name' => $categoryName);
            }

            $insert_id = $this->pathology_category_model->addCategoryName($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/pathologycategory/addCategory");
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/pathology/category", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add() {
        $pathology_category_id = $this->input->post("pathology_category_id");
        $this->form_validation->set_rules(
                'category_name', $this->lang->line('category') . " " . $this->lang->line('name'), array('required',
            array('check_exists', array($this->pathology_category_model, 'valid_category_name'))
                )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('category_name'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $categoryName = $this->input->post("category_name");
            if (!empty($pathology_category_id)) {
                if (!$this->rbac->hasPrivilege('pathology_category', 'can_edit')) {
                    access_denied();
                }
                $data = array('category_name' => $categoryName, 'id' => $pathology_category_id);
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
            } else {
                if (!$this->rbac->hasPrivilege('pathology_category', 'can_add')) {
                    access_denied();
                }
                $data = array('category_name' => $categoryName);
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            }
            $insert_id = $this->pathology_category_model->addCategoryName($data);
        }
        echo json_encode($array);
    }

    public function get() { //get product data and encode to be JSON object
        if (!$this->rbac->hasPrivilege('pathology_category', 'can_view')) {
            access_denied();
        }
        header('Content-Type: application/json');
        echo $this->lab_model->getall();
    }

    public function edit($id) {
        if (!$this->rbac->hasPrivilege('pathology_category', 'can_view')) {
            access_denied();
        }
        $result = $this->pathology_category_model->getCategoryName($id);
        $data["result"] = $result;
        $data["title"] = "Edit Category Name";
        $categoryName = $this->pathology_category_model->getCategoryName();
        $data["categoryName"] = $categoryName;
        $this->load->view("layout/header");
        $this->load->view("admin/pathology/category", $data);
        $this->load->view("layout/footer");
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('pathology_category', 'can_delete')) {
            access_denied();
        }
        $this->pathology_category_model->delete($id);
        redirect('admin/pathologycategory/addCategory');
    }

    public function get_data($id) {
        if (!$this->rbac->hasPrivilege('pathology_category', 'can_view')) {
            access_denied();
        }
        $result = $this->pathology_category_model->getCategoryName($id);
        echo json_encode($result);
    }

}

?>