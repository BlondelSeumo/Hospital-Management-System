<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Birthordeathcustom extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('encoding_lib');

        $this->custom_fields_list = $this->config->item('custom_fields');
        $this->custom_field_table = $this->config->item('custom_field_table');
        $this->load->helper('customfield_helper');
        $this->config->load('custom_filed-config');
        $this->config->load("payroll");
        $this->load->library('form_validation');
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('birth_death_customfields', 'can_view')) {
            access_denied();
        }
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $resultlist = $this->birthordeath_model->getBirthDetailsCustom();
        $data["resultlist"] = $resultlist;
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'birthordeathcustom/index');
        $customfields = $this->customfield_model->get();
        $data['custom_fields_list'] = $this->custom_fields_list;
        $customfield_bundle = $this->myCustomFieldBundle($customfields);
        $data['customfields'] = $customfield_bundle;
        if ($this->form_validation->run() == true) {

            $data = array(
                'belong_to' => 'birth_report',
                'type' => 'input',
                'bs_column' => $this->input->post('column'),
                'name' => $this->input->post('name'),
                'field_values' => $this->input->post('field_values'),
                'validation' => isset($_POST['validation']) ? $_POST['validation'] : "",
                'visible_on_table' => isset($_POST['display_tbl']) ? $_POST['display_tbl'] : "",
            );
            $this->customfield_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/birthordeathcustom/index');
        }

        $this->load->view("layout/header");
        $this->load->view("admin/birthordeathcustom/birthReport", $data);
        $this->load->view("layout/footer");
    }

    public function myCustomFieldBundle($customfield_values) {

        $field_array = array();
        if (!empty($customfield_values)) {
            foreach ($customfield_values as $f_key => $f_value) {
                $field_array[$f_value['belong_to']][] = $customfield_values[$f_key];
            }
        }

        return $field_array;
    }

    public function edit() {
        if (!$this->rbac->hasPrivilege('birth_death_record', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $listVehicle = $this->birthordeath_model->getDetailsCustom($id);
        echo json_encode($listVehicle);
    }

    public function getBirthdata() {
        if (!$this->rbac->hasPrivilege('birth_death_report', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $listVehicle = $this->birthordeath_model->getDetails($id);
        echo json_encode($listVehicle);
    }

    public function getDeathdata() {
        if (!$this->rbac->hasPrivilege('death_report', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $listVehicle = $this->birthordeath_model->getDeDetails($id);
        echo json_encode($listVehicle);
    }

    public function editDeath() {
        if (!$this->rbac->hasPrivilege('death_record', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $listVehicle = $this->birthordeath_model->getDeDetailsCustom($id);
        echo json_encode($listVehicle);
    }

    public function death() {
        if (!$this->rbac->hasPrivilege('death_record', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'birthordeathcustom/index');
        $resultlist = $this->birthordeath_model->getDeathDetailsCustom();
        $data["resultlist"] = $resultlist;
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $customfields = $this->customfield_model->get();
        $data['custom_fields_list'] = $this->custom_fields_list;
        $customfield_bundle = $this->myCustomFieldBundle($customfields);
        $data['customfields'] = $customfield_bundle;
        if ($this->form_validation->run() == true) {

            $data = array(
                'belong_to' => 'death_report',
                'type' => 'input',
                'name' => $this->input->post('name'),
                'visible_on_table' => isset($_POST['display_tbl']) ? $_POST['display_tbl'] : "",
            );
            $this->customfield_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/birthordeathcustom/death');
        }

        $this->load->view("layout/header");
        $this->load->view("admin/birthordeathcustom/deathReport", $data);
        $this->load->view("layout/footer");
    }

    public function updatedeath() {
        $this->session->set_userdata('top_menu', 'death_record');
        $this->session->set_userdata('sub_menu', 'book/index');
        $cus_field = $this->customfield_model->get($id);
        $data['cus_field'] = $cus_field;
        $customfields = $this->customfield_model->get();
        $data['custom_fields_list'] = $this->custom_fields_list;
        $customfield_bundle = $this->myCustomFieldBundle($customfields);
        $data['customfields'] = $customfield_bundle;

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $id = $this->input->post('id');

        if ($this->form_validation->run() == true) {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'visible_on_table' => isset($_POST['display_tbl']) ? $_POST['display_tbl'] : "",
            );
            $this->customfield_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/birthordeathcustom/death');
        }
        $this->load->view('layout/header');
        $this->load->view('admin/customfield/edit', $data);
        $this->load->view('layout/footer');
    }

    public function updatebirth() {
        $this->session->set_userdata('top_menu', 'birth_record');
        $this->session->set_userdata('sub_menu', 'book/index');
        $cus_field = $this->customfield_model->get($id);
        $data['cus_field'] = $cus_field;
        $customfields = $this->customfield_model->get();
        $data['custom_fields_list'] = $this->custom_fields_list;
        $customfield_bundle = $this->myCustomFieldBundle($customfields);
        $data['customfields'] = $customfield_bundle;


        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $id = $this->input->post('id');

        if ($this->form_validation->run() == true) {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'visible_on_table' => isset($_POST['display_tbl']) ? $_POST['display_tbl'] : "",
            );
            $this->customfield_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/birthordeathcustom');
        }
        $this->load->view('layout/header');
        $this->load->view('admin/customfield/edit', $data);
        $this->load->view('layout/footer');
    }

    public function addDeathcustomfild() {
        $id = "";
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $id = $_POST['id'];
            }
            $data = array(
                'id' => $id,
                'belong_to' => 'death_report',
                'type' => 'input',
                'name' => $this->input->post('name'),
                'visible_on_table' => isset($_POST['display_tbl']) ? $_POST['display_tbl'] : "",
            );

            $this->customfield_model->add($data);
            //echo $this->db->last_query();die;
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function addCustomfiled() {
        $id = "";
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');




        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $id = $_POST['id'];
            }
            $data = array(
                'id' => $id,
                'belong_to' => 'birth_report',
                'type' => 'input',
                'name' => $this->input->post('name'),
                'visible_on_table' => isset($_POST['display_tbl']) ? $_POST['display_tbl'] : "",
            );
            $this->customfield_model->add($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function addDeathdata() {
        if (!$this->rbac->hasPrivilege('death_report', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('patient', $this->lang->line('patient'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'patient' => form_error('patient'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $death_data = array(
                'opdipd_no' => $this->input->post('opdipd_no'),
                'contact' => $this->input->post('contact'),
                'patient' => $this->input->post('patient'),
                'gender' => $this->input->post('gender'),
                'guardian_name' => $this->input->post('guardian_name'),
                'death_date' => $this->input->post('death_date'),
                'address' => $this->input->post('address'),
                'death_report' => $this->input->post('death_report'),
                'is_active' => 'yes',
            );
            $insert_id = $this->birthordeath_model->addDeathdata($death_data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/death_image/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/death_image/' . $img_name);
                $this->birthordeath_model->addDeathdata($data_img);
            }
        }
        echo json_encode($array);
    }

    public function addBirthdata() {
        if (!$this->rbac->hasPrivilege('birth_death_report', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('child_name', $this->lang->line('child'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'child_name' => form_error('child_name'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $birth_data = array(
                'opd_ipd_no' => $this->input->post('opd_ipd_no'),
                'child_name' => $this->input->post('child_name'),
                'birth_date' => $this->input->post('birth_date'),
                'weight' => $this->input->post('weight'),
                'mother_name' => $this->input->post('mother_name'),
                'contact' => $this->input->post('contact'),
                'birth_report' => $this->input->post('birth_report'),
                'father_name' => $this->input->post('father_name'),
                'is_active' => 'yes',
            );
            $insert_id = $this->birthordeath_model->addBirthdata($birth_data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            if (isset($_FILES["mfile"]) && !empty($_FILES['mfile']['name'])) {
                $fileInfo = pathinfo($_FILES["mfile"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["mfile"]["tmp_name"], "./uploads/birth_image/" . $img_name);
                $data_img = array('id' => $insert_id, 'mother_pic' => 'uploads/birth_image/' . $img_name);
                $this->birthordeath_model->addBirthdata($data_img);
            }

            if (isset($_FILES["ffile"]) && !empty($_FILES['ffile']['name'])) {
                $fileInfo = pathinfo($_FILES["ffile"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["ffile"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'father_pic' => 'uploads/patient_images/' . $img_name);
                $this->birthordeath_model->addBirthdata($data_img);
            }
        }
        echo json_encode($array);
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('birth_death_record', 'can_delete')) {
            access_denied();
        }
        $result = $this->birthordeath_model->delete($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('delete_message') . '</div>');
        redirect('admin/birthordeath');
    }

    public function deletecustom($id) {
        if (!$this->rbac->hasPrivilege('birth_death_record', 'can_delete')) {
            access_denied();
        }
        $result = $this->birthordeath_model->deletecustom($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('delete_message') . '</div>');
        redirect('admin/birthordeathcustom');
    }

    public function deletedeath($id) {
        if (!$this->rbac->hasPrivilege('birth_death_report', 'can_delete')) {
            access_denied();
        }
        $result = $this->birthordeath_model->deletedeath($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('delete_message') . '</div>');
        redirect('admin/birthordeath');
    }

    public function update_death() {
        if (!$this->rbac->hasPrivilege('death_report', 'can_edit')) {
            access_denied();
        }
        $patient_type = $this->customlib->getPatienttype();
        $this->form_validation->set_rules('patient', $this->lang->line('patient'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'patient' => form_error('patient'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('id');
            $death_data = array(
                'id' => $id,
                'opdipd_no' => $this->input->post('opdipd_no'),
                'contact' => $this->input->post('contact'),
                'patient' => $this->input->post('patient'),
                'gender' => $this->input->post('gender'),
                'guardian_name' => $this->input->post('guardian_name'),
                'death_date' => $this->input->post('death_date'),
                'address' => $this->input->post('address'),
                'death_report' => $this->input->post('death_report'),
                'is_active' => 'yes',
            );
            $this->birthordeath_model->addDeathdata($death_data);
            $array = array('status' => 'success', 'error' => '', 'message' => "Record Updated Successfully");
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/death_image/" . $img_name);
                $data_img = array('id' => $id, 'image' => 'uploads/death_image/' . $img_name);
                $this->birthordeath_model->addDeathdata($data_img);
            }
        }

        echo json_encode($array);
    }

}

?>