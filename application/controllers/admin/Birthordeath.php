<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Birthordeath extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->config->load("image_valid");
        $this->load->library('form_validation');

        $this->load->library('Customlib');

        $this->load->helper('customfield_helper');

        $this->search_type = $this->config->item('search_type');
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('birth_record', 'can_view')) {
            access_denied();
        }
        
        $resultlist = $this->birthordeath_model->getBirthDetails();
        $data["resultlist"] = $resultlist;
        $this->session->set_userdata('top_menu', 'birthordeath');
        $this->session->set_userdata('sub_menu', 'birthordeath/index');
        $this->load->helper('customfield_helper');
        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;

        $this->load->view("layout/header");
        $this->load->view("admin/birthordeath/birthReport", $data);
        $this->load->view("layout/footer");
    }

    public function edit() {
        if (!$this->rbac->hasPrivilege('birth_record', 'can_edit')) {
            access_denied();
        }
        $id = $this->input->post("id");

        $this->load->helper('customfield_helper');
        $cutom_fields_data = get_custom_table_values($id, 'birth_report');


        $birthrecord = $this->birthordeath_model->getDetails($id);
        $birthrecord["birth_date"] = date($this->customlib->getSchoolDateFormat(true, true), strtotime($birthrecord['birth_date']));
        $birthrecord['field_data'] = $cutom_fields_data;

        // echo "<pre>";
        //print_r($birthrecord);
        echo json_encode($birthrecord);
    }

    public function getBirthdata() {
        if (!$this->rbac->hasPrivilege('birth_record', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $this->load->helper('customfield_helper');
        $cutom_fields_data = get_custom_table_values($id, 'birth_report');
        $birthrecord = $this->birthordeath_model->getDetails($id);
        $birthrecord["birth_date"] = date($this->customlib->getSchoolDateFormat(true, true), strtotime($birthrecord['birth_date']));
        $birthrecord['field_data'] = $cutom_fields_data;
        echo json_encode($birthrecord);
    }

    public function getBirthprintDetails($id) {
        if (!$this->rbac->hasPrivilege('birth_record', 'can_view')) {
            access_denied();
        }
        $print_details = $this->printing_model->get('', 'birth');
        $data["print_details"] = $print_details;
        $data['id'] = $id;
        if (isset($_POST['print'])) {
            $data["print"] = 'yes';
        } else {
            $data["print"] = 'no';
        }

        $result = $this->birthordeath_model->getDetails($id);
        $data['result'] = $result;
        $this->load->view('admin/birthordeath/printBirth', $data);
    }

    public function getDeathprintDetails($id) {
        if (!$this->rbac->hasPrivilege('death_record', 'can_view')) {
            access_denied();
        }

        $print_details = $this->printing_model->get('', 'death');
        $data["print_details"] = $print_details;
        $data['id'] = $id;
        if (isset($_POST['print'])) {
            $data["print"] = 'yes';
        } else {
            $data["print"] = 'no';
        }

        $result = $this->birthordeath_model->getDeDetails($id);
        $data['result'] = $result;
        $this->load->view('admin/birthordeath/printDeath', $data);
    }

    public function deathreport() {
        if (!$this->rbac->hasPrivilege('death_record', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/birthordeath/deathreport');

        $select = 'death_report.*,patients.patient_name,patients.gender as genderdeath';
        $join = array('JOIN patients ON death_report.patient = patients.id');
        $table_name = "death_report";


        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }

        if (empty($search_type)) {

            $search_type = "";
            $resultlist = $this->report_model->getReport($select, $join, $table_name);
        } else {

            $search_table = "death_report";
            $search_column = "created_at";
            $resultlist = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column);
        }

        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data["listCall"] = $resultlist;

        $this->load->view('layout/header');
        $this->load->view('admin/deathreport/deathreport.php', $data);
        $this->load->view('layout/footer');
    }

    public function birthreport() {
        if (!$this->rbac->hasPrivilege('birth_record', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/birthordeath/birthreport');

        $select = 'birth_report.*,patients.patient_name';
        $join = array('JOIN patients ON birth_report.mother_name = patients.id');
        $table_name = "birth_report";


        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }

        if (empty($search_type)) {

            $search_type = "";
            $resultlist = $this->report_model->getReport($select, $join, $table_name);
        } else {

            $search_table = "birth_report";
            $search_column = "created_at";
            $resultlist = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column);
        }

        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data["listCall"] = $resultlist;

        $this->load->view('layout/header');
        $this->load->view('admin/birthreport/birthreport.php', $data);
        $this->load->view('layout/footer');
    }

    public function getDeathdata() {
        if (!$this->rbac->hasPrivilege('death_record', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $this->load->helper('customfield_helper');
        $cutom_fields_data = get_custom_table_values($id, 'death_report');
        $deathrecord = $this->birthordeath_model->getDeDetails($id);
        $deathrecord["death_date"] = date($this->customlib->getSchoolDateFormat(true, true), strtotime($deathrecord['death_date']));
        $deathrecord['field_data'] = $cutom_fields_data;
        echo json_encode($deathrecord);
    }

    public function editDeath() {
        if (!$this->rbac->hasPrivilege('death_record', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $this->load->helper('customfield_helper');
        $cutom_fields_data = get_custom_table_values($id, 'death_report');
        $listVehicle = $this->birthordeath_model->getDeDetails($id);
        $listVehicle["death_date"] = date($this->customlib->getSchoolDateFormat(true, true), strtotime($listVehicle['death_date']));
        $listVehicle['field_data'] = $cutom_fields_data;

        echo json_encode($listVehicle);
    }

    public function death() {
        if (!$this->rbac->hasPrivilege('death_record', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'birthordeath');
        $this->session->set_userdata('sub_menu', 'birthordeath/death');
        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;
        $resultlist = $this->birthordeath_model->getDeathDetails();
        $data["resultlist"] = $resultlist;
        $this->load->view("layout/header");
        $this->load->view("admin/birthordeath/deathReport", $data);
        $this->load->view("layout/footer");
    }

    public function addDeathdata() {
        if (!$this->rbac->hasPrivilege('death_record', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('patient', $this->lang->line('patient'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('death_date', $this->lang->line('death') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('guardian_name', $this->lang->line('guardian') . " " . $this->lang->line('name'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_image_upload');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'patient' => form_error('patient'),
                'death_date' => form_error('death_date'),
                'guardian_name' => form_error('guardian_name'),
                'file' => form_error('file'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $custom_field_post = $this->input->post("custom_fields[death_report]");
            $custom_value_array = array();
            foreach ($custom_field_post as $key => $value) {
                $check_field_type = $this->input->post("custom_fields[death_report][" . $key . "]");
                $field_value = is_array($check_field_type) ? implode(",", $check_field_type) : $check_field_type;
                $array_custom = array(
                    'belong_table_id' => 0,
                    'custom_field_id' => $key,
                    'field_value' => $field_value,
                );
                $custom_value_array[] = $array_custom;
            }
            $deathdate = $this->input->post('death_date');

            $death_date = date('Y-m-d H:i:s', $this->customlib->datetostrtotime($deathdate));

            $death_data = array(
                'opdipd_no' => $this->input->post('opdipd_no'),
                'patient' => $this->input->post('patient'),
                'guardian_name' => $this->input->post('guardian_name'),
                'death_date' => $death_date,
                'death_report' => $this->input->post('death_report'),
                'is_active' => 'yes',
            );
            $insert_id = $this->birthordeath_model->addDeathdata($death_data);
            if ($insert_id) {
                $this->customfield_model->insertRecord($custom_value_array, $insert_id);
            }
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
        if (!$this->rbac->hasPrivilege('birth_record', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('child_name', $this->lang->line('child') . " " . $this->lang->line('Name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('mother_name', $this->lang->line('mother') . " " . $this->lang->line('Name'), 'required');

        $this->form_validation->set_rules('birth_date', $this->lang->line('birth') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('weight', $this->lang->line('weight'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('first_img', $this->lang->line('image'), 'callback_handle_upload');
        $this->form_validation->set_rules('second_img', $this->lang->line('image'), 'callback_check_upload');
        $this->form_validation->set_rules('child_img', $this->lang->line('image'), 'callback_handle_upload');
        $this->form_validation->set_rules('document', $this->lang->line('image'), 'callback_check_upload');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'child_name' => form_error('child_name'),
                'birth_date' => form_error('birth_date'),
                'first_img' => form_error('first_img'),
                'second_img' => form_error('second_img'),
                'mother_name' => form_error('mother_name'),
                'child_name' => form_error('child_name'),
                'document' => form_error('document'),
                'gender' => form_error('gender'),
                'weight' => form_error('weight'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $custom_field_post = $this->input->post("custom_fields[birth_report]");
            $custom_value_array = array();
            foreach ($custom_field_post as $key => $value) {
                $check_field_type = $this->input->post("custom_fields[birth_report][" . $key . "]");
                $field_value = is_array($check_field_type) ? implode(",", $check_field_type) : $check_field_type;
                $array_custom = array(
                    'belong_table_id' => 0,
                    'custom_field_id' => $key,
                    'field_value' => $field_value,
                );
                $custom_value_array[] = $array_custom;
            }

            $birthdate = $this->input->post('birth_date');

            $birth_date = date('Y-m-d H:i:s', $this->customlib->datetostrtotime($birthdate));
            // $birth_date = date($this->customlib->getSchoolDateFormat(true,true),strtotime($birthdate));

            $ref_year = date('Y', strtotime($birthdate));

            $birth_data = array(
                'opd_ipd_no' => $this->input->post('opd_ipd_no'),
                'child_name' => $this->input->post('child_name'),
                'birth_date' => $birth_date,
                'weight' => $this->input->post('weight'),
                'mother_name' => $this->input->post('mother_name'),
                'contact' => $this->input->post('contact'),
                'birth_report' => $this->input->post('birth_report'),
                'father_name' => $this->input->post('father_name'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'is_active' => 'yes',
            );
            // print_r($birth_data);
            // exit();
            $insert_id = $this->birthordeath_model->addBirthdata($birth_data);



            if (!empty($insert_id)) {
                $refno = "BR" . $ref_year . $insert_id;
            } else {
                $refno = "BR" . $ref_year;
            }
            $arrayRefno = array('id' => $insert_id, 'ref_no' => $refno);

            if ($insert_id) {
                $this->customfield_model->insertRecord($custom_value_array, $insert_id);
                $this->birthordeath_model->addBirthdata($arrayRefno);

                if (isset($_FILES["first_img"]) && !empty($_FILES['first_img']['name'])) {
                    $uploaddir = './uploads/birth_image/' . $insert_id . '/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder $uploaddir");
                    }
                    $fileInfo = pathinfo($_FILES["first_img"]["name"]);
                    $first_title = 'mother_pic';
                    $filename = "mother_pic" . $insert_id . '.' . $fileInfo['extension'];
                    $img_name = $uploaddir . $filename;
                    $mother_pic = 'uploads/birth_image/' . $insert_id . '/' . $filename;
                    move_uploaded_file($_FILES["first_img"]["tmp_name"], $img_name);
                } else {

                    $mother_pic = "uploads/patient_images/no_image.png";
                }

                if (isset($_FILES["second_img"]) && !empty($_FILES['second_img']['name'])) {
                    $uploaddir = './uploads/birth_image/' . $insert_id . '/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder $uploaddir");
                    }
                    $fileInfo = pathinfo($_FILES["second_img"]["name"]);
                    $first_title = 'father_pic';
                    $filename = "father_pic" . $insert_id . '.' . $fileInfo['extension'];
                    $img_name = $uploaddir . $filename;
                    $father_pic = 'uploads/birth_image/' . $insert_id . '/' . $filename;
                    move_uploaded_file($_FILES["second_img"]["tmp_name"], $img_name);
                } else {

                    $father_pic = "uploads/patient_images/no_image.png";
                }

                if (isset($_FILES["child_img"]) && !empty($_FILES['child_img']['name'])) {
                    $uploaddir = './uploads/birth_image/' . $insert_id . '/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder $uploaddir");
                    }
                    $fileInfo = pathinfo($_FILES["child_img"]["name"]);
                    $first_title = 'child_img';
                    $filename = "child_img" . $insert_id . '.' . $fileInfo['extension'];
                    $img_name = $uploaddir . $filename;
                    $child_pic = 'uploads/birth_image/' . $insert_id . '/' . $filename;
                    move_uploaded_file($_FILES["child_img"]["tmp_name"], $img_name);
                } else {

                    $child_pic = "uploads/patient_images/no_image.png";
                }

                if (isset($_FILES["document"]) && !empty($_FILES['document']['name'])) {
                    $uploaddir = './uploads/birth_image/' . $insert_id . '/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder $uploaddir");
                    }
                    $fileInfo = pathinfo($_FILES["document"]["name"]);
                    $first_title = 'document';
                    $filename = "document" . $insert_id . '.' . $fileInfo['extension'];
                    $img_name = $uploaddir . $filename;
                    $document = 'uploads/birth_image/' . $insert_id . '/' . $filename;
                    move_uploaded_file($_FILES["document"]["tmp_name"], $img_name);
                } else {

                    $document = "";
                }

                $data_img = array('id' => $insert_id, 'mother_pic' => $mother_pic, 'father_pic' => $father_pic, 'document' => $document, 'child_pic' => $child_pic);

                $this->birthordeath_model->addBirthdata($data_img);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function download($file) {

        $this->load->helper('download');
        $filepath = base_url() . $file . "/birth_image/" . $this->uri->segment(6) . "/" . $this->uri->segment(7);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(7);

        force_download($name, $data);
    }

    public function image_upload() {

        $image_validate = $this->config->item('image_validate');

        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @getimagesize($_FILES['file']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('image_upload', 'Error While Uploading patient Image');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('image_upload', 'Extension Error While Uploading patient Image');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('image_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('image_upload', "File Type / Extension Error Uploading Image");
                return false;
            }

            return true;
        }
        return true;
    }

    public function handle_upload() {

        $image_validate = $this->config->item('image_validate');

        if (isset($_FILES["first_img"]) && !empty($_FILES['first_img']['name'])) {

            $file_type = $_FILES["first_img"]['type'];
            $file_size = $_FILES["first_img"]["size"];
            $file_name = $_FILES["first_img"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @getimagesize($_FILES['first_img']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'Error While Uploading Mother Image');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'Extension Error While Uploading Mother Image');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', "File Type / Extension Error Uploading Mother Image");
                return false;
            }

            return true;
        }
        return true;
    }

    public function check_upload() {

        $image_validate = $this->config->item('image_validate');

        if (isset($_FILES["second_img"]) && !empty($_FILES['second_img']['name'])) {

            $file_type = $_FILES["second_img"]['type'];
            $file_size = $_FILES["second_img"]["size"];
            $file_name = $_FILES["second_img"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @getimagesize($_FILES['second_img']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('check_upload', 'File type Error While Uploading Father Image');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('check_upload', 'Extension Error While Uploading Father Image');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('check_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('check_upload', "File Type / Extension Error Uploading Father Image");
                return false;
            }

            return true;
        }
        return true;
    }

    public function update_birth() {
        if (!$this->rbac->hasPrivilege('birth_record', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('child_name', $this->lang->line('child') . " " . $this->lang->line('Name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('mother_name', $this->lang->line('mother') . " " . $this->lang->line('Name'), 'required');

        $this->form_validation->set_rules('birth_date', $this->lang->line('birth') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('weight', $this->lang->line('weight'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('mother_pic', $this->lang->line('image'), 'callback_handle_upload');
        $this->form_validation->set_rules('father_pic', $this->lang->line('image'), 'callback_check_upload');
        $this->form_validation->set_rules('child_img', $this->lang->line('image'), 'callback_handle_upload');
        $this->form_validation->set_rules('document', $this->lang->line('image'), 'callback_check_upload');
        if ($this->form_validation->run() == false) {
            $msg = array(
                'child_name' => form_error('child_name'),
                'birth_date' => form_error('birth_date'),
                'first_img' => form_error('first_img'),
                'second_img' => form_error('second_img'),
                'child_img' => form_error('child_img'),
                'document' => form_error('document'),
                'mother_name' => form_error('mother_name'),
                'gender' => form_error('gender'),
                'weight' => form_error('weight'),
            );
            $json_array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('id');
            $custom_fields = $this->input->post("custom_field");
            $custom_field_id = $this->input->post("custom_field_id");
            $custom_fieldvalue_array = $this->input->post("custom_field_value");
            $ddata = array();

            // $custom_field_post = $this->input->post("custom_fields[students]");
            $custom_value_array = array();
            if (!empty($custom_field_id)) {
                foreach ($custom_field_id as $key => $value) {
                    $check_field_type = $this->input->post("custom_field_value[" . $key . "]");
                    $field_value = is_array($check_field_type) ? implode(",", $check_field_type) : $check_field_type;
                    $array_custom = array(
                        'belong_table_id' => $id,
                        'custom_field_id' => $value,
                        'field_value' => $field_value,
                    );
                    $custom_value_array[] = $array_custom;
                }

                $this->customfield_model->updateRecord($custom_value_array, $id, 'birth_report');
            }
            $birthdate = $this->input->post('birth_date');

            $birth_date = date('Y-m-d H:i:s', $this->customlib->datetostrtotime($birthdate));


            $birth_data = array(
                'id' => $id,
                'opd_ipd_no' => $this->input->post('opd_ipd_no'),
                'child_name' => $this->input->post('child_name'),
                'birth_date' => $birth_date,
                'weight' => $this->input->post('weight'),
                'mother_name' => $this->input->post('mother_name'),
                'contact' => $this->input->post('contact'),
                'birth_report' => $this->input->post('birth_report'),
                'father_name' => $this->input->post('father_name'),
                'address' => $this->input->post('address'),
                'is_active' => 'yes',
            );
            $insert_id = $this->birthordeath_model->addBirthdata($birth_data);
            if (!empty($id)) {


                if (isset($_FILES["mother_pic"]) && !empty($_FILES['mother_pic']['name'])) {
                    $uploaddir = './uploads/birth_image/' . $insert_id . '/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder $uploaddir");
                    }
                    $fileInfo = pathinfo($_FILES["mother_pic"]["name"]);
                    $first_title = 'mother_pic';
                    $filename = "mother_pic" . $insert_id . '.' . $fileInfo['extension'];
                    $img_name = $uploaddir . $filename;
                    $mother_pic = 'uploads/birth_image/' . $filename;
                    move_uploaded_file($_FILES["mother_pic"]["tmp_name"], $img_name);

                      $data_img = array('id' => $id, 'mother_pic' => $mother_pic);
                      $this->birthordeath_model->addBirthdata($data_img);
                }

                if (isset($_FILES["father_pic"]) && !empty($_FILES['father_pic']['name'])) {
                    $uploaddir = './uploads/birth_image/' . $insert_id . '/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder $uploaddir");
                    }
                    $fileInfo = pathinfo($_FILES["father_pic"]["name"]);
                    $first_title = 'father_pic';
                    $filename = "father_pic" . $insert_id . '.' . $fileInfo['extension'];
                    $img_name = $uploaddir . $filename;
                    $father_pic = 'uploads/birth_image/' . $filename;
                    move_uploaded_file($_FILES["father_pic"]["tmp_name"], $img_name);
                      $data_img = array('id' => $id, 'father_pic' => $father_pic);
                      $this->birthordeath_model->addBirthdata($data_img);
                } 

                if (isset($_FILES["child_img"]) && !empty($_FILES['child_img']['name'])) {
                    $uploaddir = './uploads/birth_image/' . $insert_id . '/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder $uploaddir");
                    }
                    $fileInfo = pathinfo($_FILES["child_img"]["name"]);
                    $first_title = 'child_img';
                    $filename = "child_img" . $insert_id . '.' . $fileInfo['extension'];
                    $img_name = $uploaddir . $filename;
                    $child_pic = 'uploads/birth_image/' . $filename;
                    move_uploaded_file($_FILES["child_img"]["tmp_name"], $img_name);
                      $data_img = array('id' => $id,  'child_pic' => $child_pic );
                      $this->birthordeath_model->addBirthdata($data_img);
                } 

                if (isset($_FILES["document"]) && !empty($_FILES['document']['name'])) {
                    $uploaddir = './uploads/birth_image/' . $insert_id . '/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder $uploaddir");
                    }
                    $fileInfo = pathinfo($_FILES["document"]["name"]);
                    $first_title = 'document';
                    $filename = "document" . $insert_id . '.' . $fileInfo['extension'];
                    $img_name = $uploaddir . $filename;
                    $document = 'uploads/birth_image/' . $filename;
                    move_uploaded_file($_FILES["document"]["tmp_name"], $img_name);
                       $data_img = array('id' => $id,  'document' => $document);
                        $this->birthordeath_model->addBirthdata($data_img);
                } 

             

               
            }
            $json_array = array('status' => 'success', 'error' => '', 'message' => 'Record Added Successfully');
        }
        echo json_encode($json_array);
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('birth_record', 'can_delete')) {
            access_denied();
        }
        $result = $this->birthordeath_model->delete($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('delete_message') . '</div>');
        redirect('admin/birthordeath');
    }

    public function deletedeath($id) {
        if (!$this->rbac->hasPrivilege('death_record', 'can_delete')) {
            access_denied();
        }
        $result = $this->birthordeath_model->deletedeath($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('delete_message') . '</div>');
        redirect('admin/birthordeath');
    }

    public function update_death() {
        if (!$this->rbac->hasPrivilege('death_record', 'can_edit')) {
            access_denied();
        }
        $patient_type = $this->customlib->getPatienttype();
        $this->form_validation->set_rules('patient', $this->lang->line('patient'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('guardian_name', $this->lang->line('guardian') . " " . $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('death_date', $this->lang->line('death') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_image_upload');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'patient' => form_error('patient'),
                'guardian_name' => form_error('guardian_name'),
                'file' => form_error('file'),
                'death_date' => form_error('death_date'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('id');
            $custom_fields = $this->input->post("custom_field");
            $custom_field_id = $this->input->post("custom_field_id");
            $custom_fieldvalue_array = $this->input->post("custom_field_value");
            $ddata = array();
            if (!empty($custom_field_id)) {
                foreach ($custom_field_id as $key => $value) {
                    $check_field_type = $this->input->post("custom_field_value[" . $key . "]");
                    $field_value = is_array($check_field_type) ? implode(",", $check_field_type) : $check_field_type;
                    $array_custom = array(
                        'belong_table_id' => $id,
                        'custom_field_id' => $value,
                        'field_value' => $field_value,
                    );
                    $custom_value_array[] = $array_custom;
                }

                $this->customfield_model->updateRecord($custom_value_array, $id, 'death_report');
            }

            $deathdate = $this->input->post('death_date');
            $death_date = date('Y-m-d H:i:s', $this->customlib->datetostrtotime($deathdate));


            $death_data = array(
                'id' => $id,
                'opdipd_no' => $this->input->post('opdipd_no'),
                'contact' => $this->input->post('contact'),
                'patient' => $this->input->post('patient'),
                'gender' => $this->input->post('gender'),
                'guardian_name' => $this->input->post('guardian_name'),
                'death_date' => $death_date,
                'address' => $this->input->post('address'),
                'death_report' => $this->input->post('death_report'),
                'is_active' => 'yes',
            );


            // print_r($death_data);
            //  exit();
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