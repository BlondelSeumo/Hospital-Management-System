<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LeaveTypes extends Admin_Controller {

    function __construct() {

        parent::__construct();

        $this->load->helper('file');
        $this->config->load("payroll");
    }

    function index() {

        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'hr/index');
        $data["title"] = "Add Leave Type";
        $LeaveTypes = $this->leavetypes_model->getLeaveType();
        $data["leavetype"] = $LeaveTypes;
        $this->load->view("layout/header");
        $this->load->view("admin/staff/leavetypes", $data);
        $this->load->view("layout/footer");
    }

    function createLeaveType() {


        $this->form_validation->set_rules(
                'type', $this->lang->line('leave_type'), array('required',
            array('check_exists', array($this->leavetypes_model, 'valid_leave_type'))
                )
        );
        $data["title"] = "Add Leave Type";
        if ($this->form_validation->run()) {

            $type = $this->input->post("type");
            $leavetypeid = $this->input->post("leavetypeid");
            $status = $this->input->post("status");
            if (empty($leavetypeid)) {

                if (!$this->rbac->hasPrivilege('leave_types', 'can_add')) {
                    access_denied();
                }
            } else {

                if (!$this->rbac->hasPrivilege('leave_types', 'can_edit')) {
                    access_denied();
                }
            }

            if (!empty($leavetypeid)) {
                $data = array('type' => $type, 'is_active' => 'yes', 'id' => $leavetypeid);
            } else {

                $data = array('type' => $type, 'is_active' => 'yes');
            }

            $insert_id = $this->leavetypes_model->addLeaveType($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        } else {

            $msg = array(
                'e1' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        }
        echo json_encode($array);
    }

    function leaveedit() {

        $this->form_validation->set_rules(
                'type', $this->lang->line('leave_type'), array('required',
            array('check_exists', array($this->leavetypes_model, 'valid_leave_type'))
                )
        );
        $data["title"] = "Add Leave Type";
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'e1' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $type = $this->input->post("type");
            $leavetypeid = $this->input->post("leavetypeid");
            $status = $this->input->post("status");
            if (empty($leavetypeid)) {

                if (!$this->rbac->hasPrivilege('leave_types', 'can_add')) {
                    access_denied();
                }
            } else {

                if (!$this->rbac->hasPrivilege('leave_types', 'can_edit')) {
                    access_denied();
                }
            }

            if (!empty($leavetypeid)) {

                $data = array('type' => $type, 'is_active' => 'yes', 'id' => $leavetypeid);
            } else {

                $data = array('type' => $type, 'is_active' => 'yes');
            }

            $insert_id = $this->leavetypes_model->addLeaveType($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function get_type($id) {
        $result = $this->staff_model->getLeaveType($id);
        echo json_encode($result);
    }

    function leavedelete($id) {

        $this->leavetypes_model->deleteLeaveType($id);
    }

}

?>