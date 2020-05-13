<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bloodbankstatus extends Admin_Controller {

    public function index() {

        if (!$this->rbac->hasPrivilege('blood_bank_status', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'blood_bank');
        $data['title'] = 'Blood Bank';
        $bloodGroup = $this->bloodbankstatus_model->getBloodGroup();
        $data["bloodGroup"] = $bloodGroup;

        $this->load->view("layout/header");
        $this->load->view("admin/bloodbank/bloodbankstatus", $data);
        $this->load->view("layout/footer");
    }

    public function status() {
        if (!$this->rbac->hasPrivilege('blood_bank_status', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'blood_bank');
        $this->session->set_userdata('sub_menu', 'admin/bloodbankstatus/status');
        $bloodgroupid = $this->input->post("bloodgroupid");
        $bloodGroup = $this->bloodbankstatus_model->getBloodGroup();
        $data["bloodGroup"] = $bloodGroup;
        $this->form_validation->set_rules('blood_group', $this->lang->line('blood') . " " . $this->lang->line('group'), 'required');
        $this->form_validation->set_rules('status', $this->lang->line('status'), 'required');
        $data["title"] = "Edit Blood Bank Status";
        if ($this->form_validation->run()) {
            $bloodGroup = $this->input->post("blood_group");
            $bloodgroupid = $this->input->post("id");
            $status = $this->input->post("status");
            if (empty($bloodgroupid)) {
                if (!$this->rbac->hasPrivilege('blood_bank_status', 'can_add')) {
                    access_denied();
                }
            } else {
                if (!$this->rbac->hasPrivilege('blood_bank_status', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($bloodgroupid)) {
                $data = array('blood_group' => $bloodGroup, 'status' => $status, 'id' => $bloodgroupid);
            } else {
                $data = array('blood_group' => $bloodGroup, 'status' => $status);
            }
            $insert_id = $this->bloodbankstatus_model->addBloodGroup($data);
            $json_array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
        } else {
            $msg = array('blood_group' => form_error('blood_group'),
                'status' => form_error('status'),
            );
            $json_array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        }
        echo json_encode($json_array);
    }

    function get() {

        header('Content-Type: application/json');
        echo $this->bloodbankstatus_model->getall();
    }

    public function edit($id) {
        if (!$this->rbac->hasPrivilege('blood_bank_status', 'can_edit')) {
            access_denied();
        }
        $result = $this->bloodbankstatus_model->getBloodGroup($id);
        echo json_encode($result);
    }

}

?>