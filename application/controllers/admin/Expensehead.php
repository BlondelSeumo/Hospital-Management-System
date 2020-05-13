<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expensehead extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (!$this->rbac->hasPrivilege('expense_head', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'finance/index');
        $data['title'] = 'Expense Head List';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/expensehead/expenseheadList', $data);
        $this->load->view('layout/footer', $data);
    }

    function add() {

        $this->form_validation->set_rules('expensehead', $this->lang->line('expense') . " " . $this->lang->line('head'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('expensehead'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'exp_category' => $this->input->post('expensehead'),
                'description' => $this->input->post('description'),
            );
            $this->expensehead_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function view($id) {
        if (!$this->rbac->hasPrivilege('expense_head', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Expense Head List';
        $category = $this->expensehead_model->get($id);
        $data['category'] = $category;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/expensehead/expenseheadShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('expense_head', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Expense Head List';
        $this->expensehead_model->remove($id);
        redirect('admin/expensehead/index');
    }

    function create() {
        if (!$this->rbac->hasPrivilege('expense_head', 'can_add')) {
            access_denied();
        }
        $data['title'] = 'Add Expense Head';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('expensehead', 'Expense Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/expensehead/expenseheadList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'exp_category' => $this->input->post('expensehead'),
                'description' => $this->input->post('description'),
            );
            $this->expensehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Expense Head added successfully</div>');
            redirect('admin/expensehead/index');
        }
    }

    function edit1($id) {
        if (!$this->rbac->hasPrivilege('expense', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Expense Head';
        $category_result = $this->expensehead_model->get();
        $data['categorylist'] = $category_result;
        $data['id'] = $id;
        $category = $this->expensehead_model->get($id);
        $data['expensehead'] = $category;
        $this->form_validation->set_rules('expensehead', 'Expense Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/expensehead/expenseheadEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'exp_category' => $this->input->post('expensehead'),
                'description' => $this->input->post('description'),
            );
            $this->expensehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Expense Head updated successfully</div>');
            redirect('admin/expensehead/index');
        }
    }

    function edit() {
        if (!$this->rbac->hasPrivilege('expense', 'can_edit')) {
            access_denied();
        }

        $id = $this->input->post('exphead_id');
        $this->form_validation->set_rules('expensehead', $this->lang->line('expense') . " " . $this->lang->line('head'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('expensehead'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'id' => $id,
                'exp_category' => $this->input->post('expensehead'),
                'description' => $this->input->post('description'),
            );
            $this->expensehead_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function get_data($id) {
        $category = $this->expensehead_model->get($id);
        echo json_encode($category);
    }

}

?>