<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Generalcall extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('phone_call_log', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'front_office');
        $this->session->set_userdata('sub_menu', 'admin/generalcall');

        $this->form_validation->set_rules('call_type', $this->lang->line('call_type'), 'required');

        $this->form_validation->set_rules('contact', 'Phone Number', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['CallList'] = $this->general_call_model->call_list();
            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/generalcallview', $data);
            $this->load->view('layout/footer');
        } else {
            $calls = array(
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
                'follow_up_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('follow_up_date'))),
                'call_dureation' => $this->input->post('call_dureation'),
                'note' => $this->input->post('note'),
                'call_type' => $this->input->post('call_type')
            );

            $this->general_call_model->add($calls);
            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Call added successfully</div>');
            redirect('admin/generalcall');
        }
    }

    function add() {

        $date = "";
        $this->form_validation->set_rules('call_type', $this->lang->line('call_type'), 'required');

        $this->form_validation->set_rules('contact', $this->lang->line('contact'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'call_type' => form_error('call_type'),
                'check_default' => form_error('check_default'),
                'contact' => form_error('contact'),
                'date' => form_error('date'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            if (!empty($this->input->post('follow_up_date'))) {
                $date = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('follow_up_date')));
            }
            $calls = array(
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
                'follow_up_date' => $date,
                'call_dureation' => $this->input->post('call_dureation'),
                'note' => $this->input->post('note'),
                'call_type' => $this->input->post('call_type')
            );
            $this->general_call_model->add($calls);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    function edit() {
        if (!$this->rbac->hasPrivilege('phone_call_log', 'can_edit')) {
            access_denied();
        }

        $date = "";
        $id = $this->input->post('id');
        $this->form_validation->set_rules('call_type', $this->lang->line('call') . " " . $this->lang->line('type'), 'required|callback_check_default');
        $this->form_validation->set_message('check_default', 'The Call Type field is required');
        $this->form_validation->set_rules('contact', $this->lang->line('contact'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'call_type' => form_error('call_type'),
                'check_default' => form_error('check_default'),
                'contact' => form_error('contact'),
                'date' => form_error('date'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            if (!empty($this->input->post('follow_up_date'))) {
                $date = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('follow_up_date')));
            }
            $calls_update = array(
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
                'follow_up_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('follow_up_date'))),
                'call_dureation' => $this->input->post('call_dureation'),
                'note' => $this->input->post('note'),
                'call_type' => $this->input->post('call_type')
            );

            $this->general_call_model->call_update($id, $calls_update);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    function details($id) {
        if (!$this->rbac->hasPrivilege('phone_call_log', 'can_view')) {
            access_denied();
        }

        $data['Call_data'] = $this->general_call_model->call_list($id);
        $this->load->view('admin/frontoffice/Generalmodelview', $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('phone_call_log', 'can_delete')) {
            access_denied();
        }
        $this->general_call_model->delete($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> Call deleted successfully</div>');
        redirect('admin/generalcall');
    }

    public function check_default($post_string) {
        return $post_string == '' ? FALSE : TRUE;
    }

    function test() {

        $perm = $this->rbac->module_permission('student_information');
        if ($perm['is_active'] == '1') {
            echo "gc_disable()";
        }
    }

    function get_calls($id) {

        $data = $this->general_call_model->call_list($id);

        $a = array(
            'datedd' => date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($data['date'])),
            'efollow_up_date' => date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($data['follow_up_date'])),
        );

        $result = array_merge($a, $data);

        echo json_encode($result);
    }

}
