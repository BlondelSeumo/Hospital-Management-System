<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Incomehead extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('income_head', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'finance/index');
        $data['title'] = 'Income Head List';
        $category_result = $this->incomehead_model->get();
        $data['categorylist'] = $category_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/incomehead/incomeheadList', $data);
        $this->load->view('layout/footer', $data);
    }

    function view($id) {
        if (!$this->rbac->hasPrivilege('income_head', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Income Head List';
        $category = $this->incomehead_model->get($id);
        $data['category'] = $category;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/incomehead/incomeheadShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('income_head', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Income Head List';
        $this->incomehead_model->remove($id);
        redirect('admin/incomehead/index');
    }

    function create() {
        if (!$this->rbac->hasPrivilege('income_head', 'can_add')) {
            access_denied();
        }
        $data['title'] = 'Add Income Head';
        $category_result = $this->incomehead_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('incomehead', 'Income Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/incomehead/incomeheadList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'income_category' => $this->input->post('incomehead'),
                'description' => $this->input->post('description'),
            );
            $this->incomehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Income Head added successfully</div>');
            redirect('admin/incomehead/index');
        }
    }

    function add() {

        $this->form_validation->set_rules('incomehead', 'Income Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('incomehead'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'income_category' => $this->input->post('incomehead'),
                'description' => $this->input->post('description'),
            );
            $this->incomehead_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => 'New Income Head Successfully Inserted');
        }

        echo json_encode($array);
    }

    function edit1($id) {
        if (!$this->rbac->hasPrivilege('income_head', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Income Head';
        $category_result = $this->incomehead_model->get();
        $data['categorylist'] = $category_result;
        $data['id'] = $id;
        $category = $this->incomehead_model->get($id);
        $data['incomehead'] = $category;
        $this->form_validation->set_rules('incomehead', 'Income Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/incomehead/incomeheadEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'income_category' => $this->input->post('incomehead'),
                'description' => $this->input->post('description'),
            );
            $this->incomehead_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Income Head updated successfully</div>');
            redirect('admin/incomehead/index');
        }
    }

    function edit() {
        if (!$this->rbac->hasPrivilege('income_head', 'can_edit')) {
            access_denied();
        }

        $id = $this->input->post('income_id');
        $this->form_validation->set_rules('incomehead', 'Income Head', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('expensehead'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'id' => $id,
                'income_category' => $this->input->post('incomehead'),
                'description' => $this->input->post('description'),
            );

            $this->incomehead_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => 'Expense Head Successfully Updated');
        }

        echo json_encode($array);
    }

    function get_data($id) {

        $category_result = $this->incomehead_model->get($id);
        echo json_encode($category_result);
    }

}

?>