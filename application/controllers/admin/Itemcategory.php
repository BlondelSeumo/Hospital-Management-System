<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itemcategory extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('item_category', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'inventory/index');
        $data['title'] = 'Item Categorey List';
        $category_result = $this->itemcategory_model->get();
        $data['categorylist'] = $category_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/itemcategory/itemcategoryList', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('item_category', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Item Categorey List';
        $this->itemcategory_model->remove($id);
    }

    function create() {
        if (!$this->rbac->hasPrivilege('item_category', 'can_add')) {
            access_denied();
        }
        $data['title'] = 'Add Item category';
        $category_result = $this->itemcategory_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('itemcategory', $this->lang->line('item_category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemcategory/itemcategoryList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'item_category' => $this->input->post('itemcategory'),
                'description' => $this->input->post('description'),
            );

            $this->itemcategory_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item Categorey added successfully</div>');
            redirect('admin/itemcategory/index');
        }
    }

    function add() {
        if (!$this->rbac->hasPrivilege('item_category', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('itemcategory', $this->lang->line('item') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('itemcategory'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'item_category' => $this->input->post('itemcategory'),
                'description' => $this->input->post('description'),
            );
            $this->itemcategory_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function edit() {
        if (!$this->rbac->hasPrivilege('item_category', 'can_edit')) {
            access_denied();
        }
        $id = $this->input->post('cat_id');
        $this->form_validation->set_rules('itemcategory', $this->lang->line('item') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('itemcategory'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'id' => $id,
                'item_category' => $this->input->post('itemcategory'),
                'description' => $this->input->post('description'),
            );
            $this->itemcategory_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function get_data($id) {
        $category = $this->itemcategory_model->get($id);
        echo json_encode($category);
    }

}

?>