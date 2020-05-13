<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visitorspurpose extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('setup_front_office', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'admin/visitorspurpose');
        $this->form_validation->set_rules('visitors_purpose', 'Visitors Purpose', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['visitors_purpose_list'] = $this->visitors_purpose_model->visitors_purpose_list();
            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/visitorspurposeview', $data);
            $this->load->view('layout/footer');
        } else {
            $visitors_purpose = array(
                'visitors_purpose' => $this->input->post('visitors_purpose'),
                'description' => $this->input->post('description')
            );
            $this->visitors_purpose_model->add($visitors_purpose);
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Visitors Purpose added successfully</div>');
            redirect('admin/visitorspurpose');
        }
    }

    function add() {

        $this->form_validation->set_rules('visitors_purpose', $this->lang->line('purpose'), 'required');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('visitors_purpose'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $visitors_purpose = array(
                'visitors_purpose' => $this->input->post('visitors_purpose'),
                'description' => $this->input->post('description')
            );
            $this->visitors_purpose_model->add($visitors_purpose);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function edit() {

        $this->form_validation->set_rules('visitors_purpose', $this->lang->line('purpose'), 'required');
        $id = $this->input->post('id');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('visitors_purpose'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $visitors_purpose = array(
                'visitors_purpose' => $this->input->post('visitors_purpose'),
                'description' => $this->input->post('description')
            );

            $this->visitors_purpose_model->update($id, $visitors_purpose);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function edit1($visitors_purpose_id) {
        if (!$this->rbac->hasPrivilege('setup_front_office', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('visitors_purpose', 'Visitors Purpose', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['visitors_purpose_list'] = $this->visitors_purpose_model->visitors_purpose_list();
            $data['visitors_purpose_data'] = $this->visitors_purpose_model->visitors_purpose_list($visitors_purpose_id);
            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/visitorspurposeeditview', $data);
            $this->load->view('layout/footer');
        } else {
            $visitors_purpose = array(
                'visitors_purpose' => $this->input->post('visitors_purpose'),
                'description' => $this->input->post('description')
            );
            $this->visitors_purpose_model->update($visitors_purpose_id, $visitors_purpose);
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Visitors Purpose updated successfully</div>');
            redirect('admin/visitorspurpose');
        }
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('setup_front_office', 'can_delete')) {
            access_denied();
        }
        $this->visitors_purpose_model->delete($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> Visitors Purpose deleted successfully</div>');
        redirect('admin/visitorspurpose');
    }

    function get_data($id) {

        $result = $this->visitors_purpose_model->visitors_purpose_list($id);
        echo json_encode($result);
    }

}

?>