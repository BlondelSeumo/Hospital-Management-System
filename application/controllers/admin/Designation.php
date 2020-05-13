<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Designation extends Admin_Controller {

    function __construct() {

        parent::__construct();

        $this->load->helper('file');
        $this->config->load("payroll");
    }

    function designation() {

        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'hr/index');
        $designation = $this->designation_model->get();
        $data["title"] = "Add Designation";
        $data["designation"] = $designation;
        $this->form_validation->set_rules(
                'type', 'Designation Name', array('required',
            array('check_exists', array($this->designation_model, 'valid_designation'))
                )
        );
        if ($this->form_validation->run()) {

            $type = $this->input->post("type");
            $designationid = $this->input->post("designationid");
            $status = $this->input->post("status");
            if (empty($designationid)) {

                if (!$this->rbac->hasPrivilege('designation', 'can_add')) {
                    access_denied();
                }
            } else {

                if (!$this->rbac->hasPrivilege('designation', 'can_edit')) {
                    access_denied();
                }
            }

            if (!empty($designationid)) {
                $data = array('designation' => $type, 'is_active' => 'yes', 'id' => $designationid);
            } else {

                $data = array('designation' => $type, 'is_active' => 'yes');
            }
            $insert_id = $this->designation_model->addDesignation($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/designation/designation");
        } else {

            $this->load->view("layout/header");
            $this->load->view("admin/staff/designation", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add() {
        $this->form_validation->set_rules(
                'type', $this->lang->line('name'), array('required',
            array('check_exists', array($this->designation_model, 'valid_designation'))
                )
        );
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $type = $this->input->post("type");
            $data = array('designation' => $type, 'is_active' => 'yes');
            $insert_id = $this->designation_model->addDesignation($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function edit() {

        $this->form_validation->set_rules(
                'type', $this->lang->line('name'), array('required',
            array('check_exists', array($this->designation_model, 'valid_designation'))
                )
        );
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('designationid');
            $type = $this->input->post("type");
            $data = array('designation' => $type, 'is_active' => 'yes', 'id' => $id);
            $this->designation_model->addDesignation($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function designationdelete($id) {

        $this->designation_model->deleteDesignation($id);
    }

    function get_data($id) {
        $result = $this->designation_model->get($id);
        echo json_encode($result);
    }

}

?>