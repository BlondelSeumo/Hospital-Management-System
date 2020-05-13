<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lab extends Admin_Controller {

    public function addlab() {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'addlab/index');
        $lab_id = $this->input->post("lab_id");

        $labName = $this->lab_model->getlabName();
        $data["labName"] = $labName;
        $this->form_validation->set_rules(
                'lab_name', $this->lang->line('category') . " " . $this->lang->line('name'), array('required',
            array('check_exists', array($this->lab_model, 'valid_lab_name'))
                )
        );
        $data["title"] = "Add Lab";
        if ($this->form_validation->run()) {
            $labName = $this->input->post("lab_name");
            $lab_id = $this->input->post("id");
            if (empty($lab_id)) {
                if (!$this->rbac->hasPrivilege('lab', 'can_add')) {
                    access_denied();
                }
            } else {
                if (!$this->rbac->hasPrivilege('lab', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($lab_id)) {
                $data = array('lab_name' => $labName, 'id' => $lab_id);
            } else {
                $data = array('lab_name' => $labName);
            }

            $insert_id = $this->lab_model->addLabName($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/lab/addlab");
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/radio/lab", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add() {
        if (!$this->rbac->hasPrivilege('lab', 'can_add')) {
            access_denied();
        }
        $labName = $this->input->post("lab_name");
        $lab_id = $this->input->post("lab_id");
        $this->form_validation->set_rules(
                'lab_name', $this->lang->line('category') . " " . $this->lang->line('name'), array('required',
            array('check_exists', array($this->lab_model, 'valid_lab_name'))
                )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('lab_name'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $medicineCategory = $this->input->post("medicine_category");
            if (!empty($lab_id)) {
                $data = array('lab_name' => $labName, 'id' => $lab_id);
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            } else {
                $data = array('lab_name' => $labName);
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
            }
            $insert_id = $this->lab_model->addLabName($data);
        }
        echo json_encode($array);
    }

    public function get() { //get product data and encode to be JSON object
        header('Content-Type: application/json');
        echo $this->lab_model->getall();
    }

    public function edit($id) {
        $result = $this->lab_model->getLabName($id);
        $data["result"] = $result;
        $data["title"] = "Edit Lab Name";
        $labName = $this->lab_model->getLabName();
        $data["labName"] = $labName;
        $this->load->view("layout/header");
        $this->load->view("admin/radio/lab", $data);
        $this->load->view("layout/footer");
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('lab', 'can_delete')) {
            access_denied();
        }
        $this->lab_model->delete($id);
    }

    public function get_data($id) {
        if (!$this->rbac->hasPrivilege('lab', 'can_view')) {
            access_denied();
        }
        $result = $this->lab_model->getLabName($id);
        echo json_encode($result);
    }

}

?>