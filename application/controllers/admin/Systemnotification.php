<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Systemnotification extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Enc_lib');
        $this->config->load("mailsms");
        $this->notificationicon = $this->config->item('notification_icon');
        $this->notificationurl = $this->config->item('notification_url');
    }

    public function index() {
        $notifications = $this->notification_model->getSystemNotification();

        $config['base_url'] = base_url() . "admin/systemnotification/index";
        $config['total_rows'] = sizeof($notifications);
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
        $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
        $config['next_tag_open'] = '<li class="pg-next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="pg-prev">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $this->load->library('pagination', $config);

        $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) ) : 0;
        $notificationlist = $this->notification_model->getSystemNotification($config['per_page'], $page);
        $data["notifications"] = $notificationlist;
        $data['notificationicon'] = $this->notificationicon;
        $data['notificationurl'] = $this->notificationurl;
        $this->pagination->initialize($config);
        $this->load->view('layout/header', $data);
        $this->load->view('admin/systemnotification/index', $data);
        $this->load->view('layout/footer', $data);
    }

//-------------------------------------------------------------------------------------------------------------
    public function updateStatus() {
        $notification_id = $this->input->post("id");

        $userdata = $this->customlib->getUserData();
        $userid = $userdata["id"];
        $data = array('notification_id' => $notification_id,
            'receiver_id' => $userid,
            'is_active' => 'no',
            'date' => date("Y-m-d H:i:s")
        );
        $this->notification_model->updateReadNotification($data);
    }

//-------------------------------------------------------------------------------------------------------------
    public function unreadNotification() {
        $result = $this->notification_model->getUnreadNotification();
    }

//-------------------------------------------------------------------------------------------------------------
    public function moveotpatient($id, $patientid) {

        $ot_details = $this->operationtheatre_model->getotDetails($id, $patientid);


        $ot_id = $ot_details['id'];
        $patient_name = $ot_details['patient_name'];
        $operation_name = $ot_details['operation_name'];
        $patient_id = $ot_details['patient_id'];
        $patient_unique_id = $ot_details['patient_unique_id'];
        $charge_id = $ot_details['charge_id'];
        $gender = $ot_details['gender'];
        $email = $ot_details['email'];
        $phone = $ot_details['mobileno'];
        $age = $ot_details['age'];
        $month = $ot_details['month'];
        $doctor = $ot_details['consultant_doctor'];
        $consultant1 = $ot_details['ass_consultant_1'];
        $consultant2 = $ot_details['ass_consultant_2'];
        $note = $ot_details['message'];
        $ot_date = $ot_details['date'];
        $amount = $ot_details['apply_charge'];

        $ot_data = array(
            'patient_id' => $patient_id,
            'patient_name' => $patient_name,
            'operation_name' => $operation_name,
            'patient_unique_id' => $patient_unique_id,
            'gender' => $gender,
            'age' => $age,
            'month' => $month,
            'mobileno' => $phone,
            'date' => $ot_date,
            'ass_consultant_1' => $consultant1,
            'ass_consultant_2' => $consultant2,
        );

        if (!empty($ot_id)) {
            $data['ot_data'] = $ot_data;
        }

        $this->session->set_flashdata('ot_data', $data);
        redirect("admin/operationtheatre/otsearch/");
    }

//-------------------------------------------------------------------------------------------------------------
    public function moveappointment($id) {

        $details = $this->appointment_model->getDetails($id);


        $app_id = $details['id'];
        $patient_name = $details['patient_name'];
        $appointment_no = $details['appointment_no'];
        $patient_id = $details['patient_id'];
        $gender = $details['gender'];
        $email = $details['email'];
        $phone = $details['mobileno'];
        $appointment_status = $details['appointment_status'];
        $appointment_no = $details['appointment_no'];

        $doctor = $details['doctor'];
        $note = $details['message'];
        $date = $details['date'];
        $docname = $details['name'];
        $docsname = $details['surname'];


        $app_data = array(
            'id' => $app_id,
            'patient_id' => $patient_id,
            'patient_name' => $patient_name,
            'appointment_no' => $appointment_no,
            'gender' => $gender,
            'mobileno' => $phone,
            'appointment_status' => $appointment_status,
            'date' => $date,
            'email' => $email,
            'name' => $docname,
            'surname' => $docsname,
            'message' => $note,
        );

        if (!empty($app_id)) {
            $data['app_data'] = $app_data;
        }

        $this->session->set_flashdata('app_data', $data);
        redirect("admin/appointment/search/");
    }

//-------------------------------------------------------------------------------------------------------------
    public function moveipdnotification($patientid, $id) {

        $details = $this->patient_model->getIpdnotiDetails($id);
        $ipdid = $details['id'];
        $patient_id = $details['patient_id'];
        // print_r($ipdid);
        // exit();
        $ipd_data = array(
            'id' => $ipdid,
            'patient_id' => $patient_id,
        );

        if (!empty($ipdid)) {
            $data['ipd_data'] = $ipd_data;
        }


        redirect("admin/patient/ipdprofile/" . $patient_id);
    }

//-------------------------------------------------------------------------------------------------------------
    public function moveopdnotification($patientid, $id) {

        $details = $this->patient_model->getOpdnotiDetails($id);
        $opdid = $details['id'];
        $patient_id = $details['patient_id'];

        $opdn_data = array(
            'id' => $opdid,
            'patient_id' => $patient_id,
        );

        if (!empty($opdid)) {
            $data['opdn_data'] = $opdn_data;
        }

        $this->session->set_flashdata('opdn_data', $data);
        redirect("admin/patient/profile/" . $patient_id);
    }

//-------------------------------------------------------------------------------------------------------------

    public function movesalarypay($staffid, $id) {

        $details = $this->staff_model->getstaffProfile($staffid, $id);


        $staffid = $details['staffid'];
        $payslipid = $details['id'];
        $staff_name = $details['name'];
        $staff_surname = $details['surname'];
        $employee_id = $details['employee_id'];

        $staff_data = array(
            'staffid' => $staffid,
            'id' => $payslipid,
            'name' => $staff_name,
            'surname' => $staff_surname,
            'employee_id' => $employee_id,
        );

        if (!empty($staffid)) {
            $data['staff_data'] = $staff_data;
        }

        $this->session->set_flashdata('staff_data', $data);
        redirect("admin/staff/profile/" . $staffid);
    }

}

?>