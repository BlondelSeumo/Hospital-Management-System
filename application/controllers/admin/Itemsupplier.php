<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itemsupplier extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('supplier', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'inventory/index');
        $data['title'] = 'Item Supplier List';
        $itemsupplier_result = $this->itemsupplier_model->get();
        $data['itemsupplierlist'] = $itemsupplier_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/itemsupplier/itemsupplierList', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('supplier', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Item Supplier List';
        $this->itemsupplier_model->remove($id);
        redirect('admin/itemsupplier/index');
    }

    function create() {
        if (!$this->rbac->hasPrivilege('supplier', 'can_add')) {
            access_denied();
        }
        $data['title'] = 'Add Item supplier';
        $itemsupplier_result = $this->itemsupplier_model->get();
        $data['itemsupplierlist'] = $itemsupplier_result;

        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('contact_person_phone', 'Phone', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('contact_person_email', 'Email', 'trim|xss_clean|valid_email');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemsupplier/itemsupplierList', $data);
            $this->load->view('layout/footer', $data);
        } else {


            $data = array(
                'phone' => $this->input->post('phone'),
                'contact_person_phone' => $this->input->post('contact_person_phone'),
                'item_supplier' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact_person_name' => $this->input->post('contact_person_name'),
                'contact_person_email' => $this->input->post('contact_person_email'),
                'description' => $this->input->post('description'),
            );
            $this->itemsupplier_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item Supplier added successfully</div>');
            redirect('admin/itemsupplier/index');
        }
    }

    function add() {

        if (!$this->rbac->hasPrivilege('supplier', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('contact_person_phone', $this->lang->line('contact') . " " . $this->lang->line('person') . " " . $this->lang->line('phone'), 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('contact_person_email', $this->lang->line('email'), 'trim|xss_clean|valid_email');


        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('name'),
                'phone' => form_error('phone'),
                'email' => form_error('email'),
                'contact_person_phone' => form_error('contact_person_phone'),
                'contact_person_email' => form_error('contact_person_email')
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'phone' => $this->input->post('phone'),
                'contact_person_phone' => $this->input->post('contact_person_phone'),
                'item_supplier' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact_person_name' => $this->input->post('contact_person_name'),
                'contact_person_email' => $this->input->post('contact_person_email'),
                'description' => $this->input->post('description'),
            );

            $this->itemsupplier_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function edit1($id) {
        if (!$this->rbac->hasPrivilege('supplier', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Item Supplier';
        $itemsupplier_result = $this->itemsupplier_model->get();
        $data['itemsupplierlist'] = $itemsupplier_result;
        $data['id'] = $id;
        $store = $this->itemsupplier_model->get($id);
        $data['itemsupplier'] = $store;

        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('contact_person_phone', 'Phone', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('contact_person_email', 'Email', 'trim|xss_clean|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemsupplier/itemsupplierEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {


            $data = array(
                'id' => $id,
                'phone' => $this->input->post('phone'),
                'contact_person_phone' => $this->input->post('contact_person_phone'),
                'item_supplier' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact_person_name' => $this->input->post('contact_person_name'),
                'contact_person_email' => $this->input->post('contact_person_email'),
                'description' => $this->input->post('description'),
            );
            $this->itemsupplier_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Item Supplier updated successfully</div>');
            redirect('admin/itemsupplier/index');
        }
    }

    function edit() {
        if (!$this->rbac->hasPrivilege('item_category', 'can_edit')) {
            access_denied();
        }

        $id = $this->input->post('supp_id');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('contact_person_phone', $this->lang->line('contact') . " " . $this->lang->line('person') . " " . $this->lang->line('phone'), 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('contact_person_email', $this->lang->line('email'), 'trim|xss_clean|valid_email');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('name'),
                'phone' => form_error('phone'),
                'email' => form_error('email'),
                'contact_person_phone' => form_error('contact_person_phone'),
                'contact_person_email' => form_error('contact_person_email'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'id' => $id,
                'phone' => $this->input->post('phone'),
                'contact_person_phone' => $this->input->post('contact_person_phone'),
                'item_supplier' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact_person_name' => $this->input->post('contact_person_name'),
                'contact_person_email' => $this->input->post('contact_person_email'),
                'description' => $this->input->post('description'),
            );
            $this->itemsupplier_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function get_data($id) {
        $supplier = $this->itemsupplier_model->get($id);
        echo json_encode($supplier);
    }

}

?>