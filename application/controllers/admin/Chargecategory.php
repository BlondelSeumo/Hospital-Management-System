<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chargecategory extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->charge_type = $this->config->item('charge_type');
    }

    public function charges() {
        if (!$this->rbac->hasPrivilege('charge_category', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'charges/index');
        $chargecategoryid = $this->input->post("chargecategoryid");

        $chargeCategory = $this->charge_category_model->getChargeCategory();
        $data["chargeCategory"] = $chargeCategory;
        $data['charge_type'] = $this->charge_type;
        $this->form_validation->set_rules(
                'name', 'Name', array('required',
            array('check_exists', array($this->charge_category_model, 'valid_charge_category'))
                )
        );
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('charge_type', 'Charge Type', 'required');
        $data["title"] = "Add Charge Category";
        if ($this->form_validation->run()) {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $charge_type = $this->input->post("charge_type");
            $chargecategoryid = $this->input->post("id");

            if (!empty($chargecategoryid)) {
                $data = array('name' => $name, 'description' => $description, 'charge_type' => $charge_type, 'id' => $chargecategoryid);
            } else {

                $data = array('name' => $name, 'description' => $description, 'charge_type' => $charge_type);
            }
            $insert_id = $this->charge_category_model->addChargeCategory($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/charges/chargeCategory", $data);
            $this->load->view("layout/footer");
        }
    }

    function add() {
        if (!$this->rbac->hasPrivilege('charge_category', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules(
                'name', $this->lang->line('name'), array('required',
            array('check_exists', array($this->charge_category_model, 'valid_charge_category'))
                )
        );
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('charge_type', $this->lang->line('charge') . " " . $this->lang->line('type'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
                'description' => form_error('description'),
                'charge_type' => form_error('charge_type'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $charge_type = $this->input->post("charge_type");
            $chargecategoryid = $this->input->post("id");
            if (!empty($chargecategoryid)) {
                $data = array('name' => $name, 'description' => $description, 'charge_type' => $charge_type, 'id' => $chargecategoryid);
            } else {
                $data = array('name' => $name, 'description' => $description, 'charge_type' => $charge_type);
            }
            $insert_id = $this->charge_category_model->addChargeCategory($data);
            if (!empty($chargecategoryid)) {
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
            } else {

                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            }
        }
        echo json_encode($array);
    }

    function get() {
        if (!$this->rbac->hasPrivilege('charge_category', 'can_view')) {
            access_denied();
        }
        header('Content-Type: application/json');
        echo $this->charge_category_model->getall();
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('charge_category', 'can_edit')) {
            access_denied();
        }
        $result = $this->charge_category_model->getChargeCategory($id);
        $data['charge_type'] = $this->charge_type;
        $data["result"] = $result;
        $data["title"] = "Edit Category";
        $chargeCategory = $this->charge_category_model->getChargeCategory();
        $data["chargeCategory"] = $chargeCategory;
        $this->load->view("layout/header");
        $this->load->view("admin/charges/chargeCategory", $data);
        $this->load->view("layout/footer");
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('charge_category', 'can_delete')) {
            access_denied();
        }
        $this->charge_category_model->delete($id);
        redirect('admin/chargecategory/charges');
    }

    function get_data($id) {
        $result = $this->charge_category_model->getChargeCategory($id);
        echo json_encode($result);
    }

}

?>