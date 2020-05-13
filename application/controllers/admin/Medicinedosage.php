<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicinedosage extends Admin_Controller {

    function __construct() {

        parent::__construct();

        $this->load->helper('file');
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('medicine_dosage', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'medicine/index');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/medicinedosage');
        $medicinecategoryid = $this->input->post("medicinecategoryid");
        $data["title"] = "Add Medicine Dosage";
        $medicineDosage = $this->medicine_dosage_model->getMedicineDosage();
        $data["medicineDosage"] = $medicineDosage;
        $medicineCategory = $this->medicine_category_model->getMedicineCategory();
        $data["medicineCategory"] = $medicineCategory;
        $this->form_validation->set_rules('medicine_category', $this->lang->line('medicine') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('dosage', $this->lang->line('dosage') . " " . $this->lang->line('name'), 'trim|required|xss_clean');

        if ($this->form_validation->run()) {
            $medicineName = $this->input->post("medicine_category");
            $medicinedosageid = $this->input->post("id");
            if (empty($medicinedosageid)) {
                if (!$this->rbac->hasPrivilege('medicine_category', 'can_add')) {
                    access_denied();
                }
            } else {
                if (!$this->rbac->hasPrivilege('medicine_category', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($medicinedosageid)) {
                $data = array('medicine_category_id' => $medicineName, 'dosage' => $this->input->post('dosage'), 'id' => $medicinedosageid);
            } else {

                $data = array('medicine_category_id' => $medicineName, 'dosage' => $this->input->post('dosage'));
            }

            $insert_id = $this->medicine_dosage_model->addMedicineDosage($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/medicinedosage/");
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/pharmacy/medicine_dosage", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add() {
        if ((!$this->rbac->hasPrivilege('medicine_category', 'can_add')) || (!$this->rbac->hasPrivilege('medicine_category', 'can_edit'))) {
            access_denied();
        }
        $medicinedosageid = $this->input->post("dosageid");
        $this->form_validation->set_rules('medicine_category', $this->lang->line('medicine') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('dosage', $this->lang->line('dosage') . " " . $this->lang->line('name'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'medicine_name' => form_error('medicine_category'),
                'dosage' => form_error('dosage'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $medicineCategory = $this->input->post("medicine_category");
            if (!empty($medicinedosageid)) {
                $data = array('id' => $this->input->post("dosageid"), 'medicine_category_id' => $this->input->post("medicine_category"), 'dosage' => $this->input->post("dosage"),);
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
            } else {
                $data = array('medicine_category_id' => $this->input->post("medicine_category"), 'dosage' => $this->input->post("dosage"),);
                $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            }
            $insert_id = $this->medicine_dosage_model->addMedicineDosage($data);
        }
        echo json_encode($array);
    }

    public function get() { //get product data and encode to be JSON object
        header('Content-Type: application/json');
        echo $this->medicine_category_model->getall();
    }

    public function edit($id) {
        if (!$this->rbac->hasPrivilege('medicine_category', 'can_view')) {
            access_denied();
        }
        $result = $this->medicine_dosage_model->getMedicineDosage($id);
        $data["result"] = $result;
        $data["title"] = "Edit Category";
        $medicineCategory = $this->medicine_category_model->getMedicineCategory();
        $data["medicineCategory"] = $medicineCategory;
        $this->load->view("layout/header");
        $this->load->view("admin/pharmacy/medicine_dosage", $data);
        $this->load->view("layout/footer");
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('medicine_category', 'can_delete')) {
            access_denied();
        }
        $this->medicine_dosage_model->delete($id);
        redirect('admin/medicinecategory/medicine');
    }

    public function get_data($id) {
        if (!$this->rbac->hasPrivilege('medicine_category', 'can_view')) {
            access_denied();
        }
        $result = $this->medicine_dosage_model->getMedicineDosage($id);
        echo json_encode($result);
    }

    public function getMedicineDosage() {
        $medicine = $this->input->post('medicine_id');
        $result = $this->medicine_dosage_model->getDosageByMedicine($medicine);
        echo json_encode($result);
    }

}

?>