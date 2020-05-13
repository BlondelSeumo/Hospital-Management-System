<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Complainttype extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('setup_font_office', 'can_view')) {
            access_denied();
        }
        $this->form_validation->set_rules('complaint_type', 'Complaint Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['complaint_type_list'] = $this->complaintType_model->get('complaint_type');
            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/complainttypeview', $data);
            $this->load->view('layout/footer');
        } else {
            $complaint_type = array(
                'complaint_type' => $this->input->post('complaint_type'),
                'description' => $this->input->post('description')
            );
            $this->complaintType_model->add('complaint_type', $complaint_type);
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Complaint Type added successfully</div>');
            redirect('admin/complainttype');
        }
    }

    function add() {

        $this->form_validation->set_rules('complaint_type', $this->lang->line('complain_type'), 'required');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('complaint_type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $complaint_type = array(
                'complaint_type' => $this->input->post('complaint_type'),
                'description' => $this->input->post('description')
            );
            $this->complaintType_model->add('complaint_type', $complaint_type);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function edit() {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('complaint_type', $this->lang->line('complain_type'), 'required');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('complaint_type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $complaint_type = array(
                'complaint_type' => $this->input->post('complaint_type'),
                'description' => $this->input->post('description')
            );
            $this->complaintType_model->update('complaint_type', $id, $complaint_type);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function editcomplainttype($complainttype_id) {
        if (!$this->rbac->hasPrivilege('setup_font_office', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('complaint_type', 'Complaint Type', 'required');


        if ($this->form_validation->run() == FALSE) {
            $data['complaint_type_list'] = $this->complaintType_model->get('complaint_type');
            $data['complaint_type_data'] = $this->complaintType_model->get('complaint_type', $complainttype_id);

            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/complainttypeeditview', $data);
            $this->load->view('layout/footer');
        } else {

            $complaint_type = array(
                'complaint_type' => $this->input->post('complaint_type'),
                'description' => $this->input->post('description')
            );
            $this->complaintType_model->update('complaint_type', $complainttype_id, $complaint_type);
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Complaint Type updated successfully</div>');
            redirect('admin/complainttype');
        }
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('setup_font_office', 'can_delete')) {
            access_denied();
        }
        $this->complaintType_model->delete('complaint_type', $id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> Complaint Type deleted successfully</div>');
        redirect('admin/complainttype');
    }

    function get_data($id) {

        $result = $this->complaintType_model->get('complaint_type', $id);
        echo json_encode($result);
    }

}
