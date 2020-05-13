<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department extends Admin_Controller {

    function __construct() {

        parent::__construct();
        $this->load->library('datatables');
        $this->load->helper('file');
        $this->config->load("payroll");
    }

    function index() {

        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'hr/index');

        $this->form_validation->set_rules(
                'type', 'Department Name', array('required',
            array('check_exists', array($this->department_model, 'valid_department'))
                )
        );

        $data["title"] = "Add Department";
        if ($this->form_validation->run()) {

            $type = $this->input->post("type");
            $departmenttypeid = $this->input->post("departmenttypeid");
            $status = $this->input->post("status");
            if (empty($departmenttypeid)) {

                if (!$this->rbac->hasPrivilege('department', 'can_add')) {
                    access_denied();
                }
            } else {

                if (!$this->rbac->hasPrivilege('department', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($departmenttypeid)) {
                $data = array('department_name' => $type, 'is_active' => 'yes', 'id' => $departmenttypeid);
            } else {

                $data = array('department_name' => $type, 'is_active' => 'yes');
            }
            $insert_id = $this->department_model->addDepartmentType($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/department");
        } else {

            $this->load->view("layout/header");
            $this->load->view("admin/staff/departmentType", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add() {
        $this->form_validation->set_rules(
                'type', $this->lang->line('department') . " " . $this->lang->line('name'), array('required',
            array('check_exists', array($this->department_model, 'valid_department'))
                )
        );
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $type = $this->input->post("type");
            $data = array('department_name' => $type, 'is_active' => 'yes');
            $insert_id = $this->department_model->addDepartmentType($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function get() { //get product data and encode to be JSON object
        header('Content-Type: application/json');
        echo $this->department_model->getall();
    }

    function get_data($id) {
        $result = $this->department_model->getDepartmentType($id);
        echo json_encode($result);
    }

    function edit() {
        $this->form_validation->set_rules(
                'type', $this->lang->line('department') . " " . $this->lang->line('name'), array('required',
            array('check_exists', array($this->department_model, 'valid_department'))
                )
        );
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $departmenttypeid = $this->input->post("departmenttypeid");
            $type = $this->input->post("type");
            $data = array('department_name' => $type, 'is_active' => 'yes', 'id' => $departmenttypeid);
            $this->department_model->addDepartmentType($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function departmentdelete($id) {

        if (!empty($id)) {
            $this->department_model->deleteDepartment($id);
        }
        redirect("admin/department");
    }

}

?>