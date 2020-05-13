<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends Patient_Controller {

    public $school_name;
    public $school_setting;
    public $setting;
    public $payment_method;

    function __construct() {
        parent::__construct();
        $this->payment_method = $this->paymentsetting_model->getActiveMethod();
        $this->patient_data = $this->session->userdata('patient');
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->appointment_status = $this->config->item('appointment_status');
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->search_type = $this->config->item('search_type');
        $this->blood_group = $this->config->item('bloodgroup');

        $this->charge_type = $this->config->item('charge_type');
        $data["charge_type"] = $this->charge_type;
    }

    function dashboard() {

        $this->session->set_userdata('top_menu', 'Dashboard');
        $patient_id = $this->customlib->getPatientSessionUserID();
        print_r($patient_id);
        die;
        $student = $this->student_model->get($student_id);

        $data = array();
        if (!empty($student)) {
            $student_session_id = $student['student_session_id'];
            $gradeList = $this->grade_model->get();
            $student_due_fee = $this->studentfeemaster_model->getStudentFees($student_session_id);
            $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student_session_id);
            $data['student_discount_fee'] = $student_discount_fee;
            $data['student_due_fee'] = $student_due_fee;
            $timeline = $this->timeline_model->getStudentTimeline($student["id"], $status = 'yes');
            $data["timeline_list"] = $timeline;

            $examList = $this->examschedule_model->getExamByClassandSection($student['class_id'], $student['section_id']);
            $data['examSchedule'] = array();
            if (!empty($examList)) {
                $new_array = array();
                foreach ($examList as $ex_key => $ex_value) {
                    $array = array();
                    $x = array();
                    $exam_id = $ex_value['exam_id'];
                    $student['id'];
                    $exam_subjects = $this->examschedule_model->getresultByStudentandExam($exam_id, $student['id']);
                    foreach ($exam_subjects as $key => $value) {
                        $exam_array = array();
                        $exam_array['exam_schedule_id'] = $value['exam_schedule_id'];
                        $exam_array['exam_id'] = $value['exam_id'];
                        $exam_array['full_marks'] = $value['full_marks'];
                        $exam_array['passing_marks'] = $value['passing_marks'];
                        $exam_array['exam_name'] = $value['name'];
                        $exam_array['exam_type'] = $value['type'];
                        $exam_array['attendence'] = $value['attendence'];
                        $exam_array['get_marks'] = $value['get_marks'];
                        $x[] = $exam_array;
                    }
                    $array['exam_name'] = $ex_value['name'];
                    $array['exam_result'] = $x;
                    $new_array[] = $array;
                }
                $data['examSchedule'] = $new_array;
            }
            $student_doc = $this->student_model->getstudentdoc($student_id);
            $data['student_doc'] = $student_doc;
            $data['student_doc_id'] = $student_id;
            $category_list = $this->category_model->get();
            $data['category_list'] = $category_list;
            $data['gradeList'] = $gradeList;
            $data['student'] = $student;
        }

        $this->load->view('layout/patient/header', $data);
        $this->load->view('user/dashboard', $data);
        $this->load->view('layout/patient/footer', $data);
    }

    function changepass() {
        $data['title'] = 'Change Password';
        $this->form_validation->set_rules('current_pass', $this->lang->line('current_password'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_pass', $this->lang->line('new_password'), 'trim|required|xss_clean|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', $this->lang->line('confirm_password'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $sessionData = $this->session->userdata('loggedIn');
            $this->data['id'] = $sessionData['id'];
            $this->data['username'] = $sessionData['username'];
            $this->load->view('layout/patient/header', $data);
            $this->load->view('user/change_password', $data);
            $this->load->view('layout/patient/footer', $data);
        } else {
            $sessionData = $this->session->userdata('patient');
            $data_array = array(
                'current_pass' => ($this->input->post('current_pass')),
                'new_pass' => ($this->input->post('new_pass')),
                'user_id' => $sessionData['id'],
                'user_name' => $sessionData['username']
            );
            $newdata = array(
                'id' => $sessionData['id'],
                'password' => $this->input->post('new_pass')
            );
            $query1 = $this->user_model->checkOldPass($data_array);

            if ($query1) {
                $query2 = $this->user_model->saveNewPass($newdata);
                if ($query2) {

                    $this->session->set_flashdata('success_msg', $this->lang->line('success_message'));
                    $this->load->view('layout/patient/header', $data);
                    $this->load->view('user/change_password', $data);
                    $this->load->view('layout/patient/footer', $data);
                }
            } else {

                $this->session->set_flashdata('error_msg', $this->lang->line('invalid_current_password'));
                $this->load->view('layout/patient/header', $data);
                $this->load->view('user/change_password', $data);
                $this->load->view('layout/patient/footer', $data);
            }
        }
    }

    function changeusername() {
        $sessionData = $this->session->userdata('patient');
        $data['title'] = 'Change Username';
        $this->form_validation->set_rules('current_username', $this->lang->line('current_username'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_username', $this->lang->line('new_username'), 'trim|required|xss_clean|matches[confirm_username]');
        $this->form_validation->set_rules('confirm_username', $this->lang->line('confirm_password'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {

            $data_array = array(
                'username' => $this->input->post('current_username'),
                'new_username' => $this->input->post('new_username'),
                'role' => $sessionData['role'],
                'user_id' => $sessionData['id'],
            );
            $newdata = array(
                'id' => $sessionData['id'],
                'username' => $this->input->post('new_username')
            );
            $is_valid = $this->user_model->checkOldUsername($data_array);

            if ($is_valid) {
                $is_exists = $this->user_model->checkUserNameExist($data_array);
                if (!$is_exists) {
                    $is_updated = $this->user_model->saveNewUsername($newdata);
                    if ($is_updated) {
                        $this->session->set_flashdata('success_msg', $this->lang->line('success_message'));
                        redirect('user/user/changeusername');
                    }
                } else {
                    $this->session->set_flashdata('error_msg', $this->lang->line('username_already_exists'));
                }
            } else {
                $this->session->set_flashdata('error_msg', $this->lang->line('invalid_username'));
            }
        }
        $this->data['id'] = $sessionData['id'];
        $this->data['username'] = $sessionData['username'];
        $this->load->view('layout/patient/header', $data);
        $this->load->view('user/change_username', $data);
        $this->load->view('layout/patient/footer', $data);
    }

    public function download($student_id, $doc) {
        $this->load->helper('download');
        $filepath = "./uploads/student_documents/$student_id/" . $this->uri->segment(5);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(6);
        force_download($name, $data);
    }

    public function timeline_download($timeline_id, $doc) {
        $this->load->helper('download');
        $filepath = "./uploads/student_timeline/" . $doc;
        $data = file_get_contents($filepath);
        $name = $doc;
        force_download($name, $data);
    }

}

?>