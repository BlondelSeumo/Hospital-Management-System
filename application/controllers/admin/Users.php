<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'schsettings/index');
        $this->session->set_userdata('inner_menu', 'users/index');
        $studentList = array();
        $staffList = $this->staff_model->getAll();
        $patientList = $this->patient_model->getPatientList();
        $parentList = array();
        $data['studentList'] = $studentList;
        $data['patientList'] = $patientList;
        $data['parentList'] = $parentList;
        $data['staffList'] = $staffList;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/users/userList', $data);
        $this->load->view('layout/footer', $data);
    }

    function changeStatus() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $role = $this->input->post('role');
        $data = array('id' => $id, 'is_active' => $status);
        if ($role != "staff") {
            $result = $this->user_model->changeStatus($data);
        } else {
            if ($status == "yes") {
                $data['is_active'] = 1;
            } else {
                $data['is_active'] = 0;
            }
            $result = $this->staff_model->update($data);
        }

        if ($result) {
            $response = array('status' => 1, 'msg' => $this->lang->line('success_message'));
            echo json_encode($response);
        }
    }

    function admissionreport() {
        if (!$this->rbac->hasPrivilege('student_history', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Student Information');
        $this->session->set_userdata('sub_menu', 'admin/users/admissionreport');
        $data['title'] = 'Admission Report';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();
        $carray = array();
        if (!empty($data["classlist"])) {
            foreach ($data["classlist"] as $ckey => $cvalue) {

                $carray[] = $cvalue["id"];
            }
        }
        $class_id = $this->input->post("class_id");
        $year = $this->input->post("year");

        $admission_year = $this->student_model->admissionYear();

        $data["admission_year"] = $admission_year;
        if ((empty($class_id)) && (empty($year))) {

            $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {

                $resultlist = $this->student_model->studentAdmissionDetails($carray);
                $data["resultlist"] = $resultlist;
            }
        } else {


            $resultlist = $this->student_model->searchAdmissionDetails($class_id, $year);
            $data["resultlist"] = $resultlist;
        }
        if (!empty($resultlist)) {
            foreach ($resultlist as $key => $value) {

                $id = $value["sid"];
                $sessionlist[] = $this->student_model->studentSessionDetails($id);
            }
            $data["sessionlist"] = $sessionlist;
        }
        $this->load->view("layout/header", $data);
        $this->load->view("admin/users/admissionReport", $data);
        $this->load->view("layout/footer", $data);
    }

    function logindetailreport() {
        if (!$this->rbac->hasPrivilege('student_login_credential', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Student Information');
        $this->session->set_userdata('sub_menu', 'admin/users/logindetailreport');
        $class = $this->class_model->get();
        $data['classlist'] = $class;

        $studentdata = $this->student_model->get();
        if (isset($_POST["search"])) {

            $class_id = $this->input->post("class_id");
            $section_id = $this->input->post("section_id");

            $studentdata = $this->student_model->searchByClassSection($class_id, $section_id);
        }

        foreach ($studentdata as $key => $value) {
            $resultlist = $this->user_model->getUserLoginDetails($value["id"]);
            $parentlist = $this->user_model->getParentLoginDetails($value["id"]);
            if ($resultlist["role"] == "student") {
                $studentdata[$key]["student_username"] = $resultlist["username"];
                $studentdata[$key]["student_password"] = $resultlist["password"];
                $studentdata[$key]["parent_username"] = $parentlist["username"];
                $studentdata[$key]["parent_password"] = $parentlist["password"];
            }
        }

        $data["resultlist"] = $studentdata;
        $this->load->view("layout/header");
        $this->load->view("admin/users/logindetailreport", $data);
        $this->load->view("layout/footer");
    }

}

?>