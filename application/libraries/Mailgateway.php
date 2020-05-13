<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mailgateway {

    private $_CI;

    function __construct() {
        $this->_CI = & get_instance();
        $this->_CI->load->model('setting_model');
        //$this->_CI->load->model('studentfeemaster_model');
        //$this->_CI->load->model('student_model');
        //$this->_CI->load->model('teacher_model');
        //$this->_CI->load->model('librarian_model');
        $this->_CI->load->model('appointment_model');
        $this->_CI->load->library('mailer');
        $this->_CI->load->model('payment_model');
        $this->_CI->mailer;
        $this->sch_setting = $this->_CI->setting_model->get();
    }

    function sentRegisterMail($id, $send_to, $ptypeno) {

        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Patient Registration";
            $msg = $this->getPatientRegistrationContent($id, $ptypeno);
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }


    function sentDischargedMail($id, $ipd_id) {


        if (!empty($this->_CI->mail_config)) {
            $subject = "Patient Discharged";
            $data = $this->getPatientDischargedContent($id, $ipd_id);
            $msg = $data["msg"];
            $send_to = $data["email"];
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    function sentAppointmentConfirmation($id) {


        if (!empty($this->_CI->mail_config)) {
            $subject = "Appointment Confirmation";
            $data = $this->getAppointmentConfirmationContent($id);
            $msg = $data["msg"];
            $send_to = $data["email"];
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    function sendLoginCredential($chk_mail_sms, $sender_details) {


        $msg = $this->getLoginCredentialContent($sender_details['credential_for'], $sender_details);


        $send_to = $sender_details['email'];

        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Login Credential";
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    function sentAddFeeMail($invoice_id, $sub_invoice_id, $send_to) {

        $msg = $this->getAddFeeContent($invoice_id, $sub_invoice_id);
        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Fees Received";
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    function sentExamResultMail($detail) {

        $msg = $this->getStudentResultContent($detail);
        $send_to = $detail['email'];
        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Exam Result";
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    function sentAbsentStudentMail($detail) {

        $send_to = $detail['email'];
        $msg = $this->getAbsentStudentContent($detail);
        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Absent Notice";
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    public function getAddFeeContent($invoice_id, $sub_invoice_id) {
        $currency_symbol = $this->sch_setting[0]['currency_symbol'];
        $school_name = $this->sch_setting[0]['name'];

        $fee = $this->_CI->studentfeemaster_model->getFeeByInvoice($invoice_id, $sub_invoice_id);
        $a = json_decode($fee->amount_detail);
        $record = $a->{$sub_invoice_id};
        $fee_amount = number_format((($record->amount + $record->amount_fine) - $record->amount_discount), 2, '.', ',');
        $msg = "Fees received for " . $fee->firstname . " " . $fee->lastname . ". Fees Amount " . $currency_symbol . $fee_amount . "/- Received by " . $school_name;

        return $msg;
    }

    public function getAbsentStudentContent($student_detail) {
        $school_name = $this->_CI->setting_model->getCurrentSchoolName();
        $student_name = $student_detail['student_name'];
        $msg = "Absent Notice :" . $student_name . " was absent on date " . $student_detail['date'] . " from " . $school_name;
        return $msg;
    }

    public function getStudentRegistrationContent($id) {
        $session_name = $this->_CI->setting_model->getCurrentSessionName();
        $student = $this->_CI->student_model->get($id);
        $msg = "Dear " . $student['firstname'] . " " . $student['lastname'] .
                ", your admission is confirm in Class: " . $student['class'] .
                ", Section: " . $student['section'] . " for Session: " . $session_name . ", for more detail contact System Admin.";
        return $msg;
    }

    public function getPatientRegistrationContent($id, $ptypeno) {
        $patient = $this->_CI->patient_model->patientProfileType($id,$ptypeno);
        if ($patient["patient_type"] == 'Outpatient') {
            $patient_no = $ptypeno;
            $patient_type = 'OPD';
        } elseif ($patient["patient_type"] == 'Inpatient') {
            $patient_no = $ptypeno;
            $patient_type = 'IPD';
        }
      // print_r($patient);
     //  exit();
        $hospital_details = $this->_CI->setting_model->getHospitalDetails();
        $hospital_name = $hospital_details["name"];
        $msg = "Dear " . $patient["patient_name"] . " your " . $patient_type . " registration is successful at " . $hospital_name . " with Patient Id: " . $patient["patient_unique_id"] . " and " . $patient_type . " No: " . $patient_no;
        return $msg;
    }



    public function getPatientDischargedContent($id, $ipd_id) {

        $hospital_details = $this->_CI->setting_model->getHospitalDetails();
        $currency_symbol = $this->sch_setting[0]['currency_symbol'];
        $patient = $this->_CI->patient_model->getIpdDetails($id, $ipd_id);
        $payment = $this->_CI->payment_model->getPaidTotal($id, $ipd_id);
        $paid_amount = $payment['paid_amount'];
        $charge = $this->_CI->payment_model->getChargeTotal($id, $ipd_id);
        $charge_amount = $charge['apply_charge'];

        $hospital_name = $hospital_details["name"];
        $msg = $patient['patient_name'] .
                " is now discharged from " . $hospital_name . " . Total Charges: " . $currency_symbol . $charge_amount . " and Total Payment: " . $currency_symbol . $paid_amount . " Your net payable bill amount was " . $currency_symbol . $patient["net_amount"];
        $email = $patient['email'];
        $contact = $patient['mobileno'];
        $array = array('msg' => $msg, 'email' => $email, 'contact' => $contact,);
        return $array;
    }

    public function getAppointmentConfirmationContent($id) {

        $patient = $this->_CI->appointment_model->getDetails($id);
        $msg = "Dear " . $patient['patient_name'] .
                ", your appointment with " . $patient['name'] . " " . $patient['surname'] . " is confirmed on " . date($this->_CI->customlib->getSchoolDateFormat(true, true), strtotime($patient['date'])) . " with appointment no :" . $patient['appointment_no'];
        $email = $patient['email'];
        $contact = $patient['mobileno'];
        $array = array('msg' => $msg, 'email' => $email, 'contact' => $contact,);
        return $array;
    }

    public function getLoginCredentialContent($credential_for, $sender_details) {


        if ($credential_for == "student") {
            $student = $this->_CI->student_model->get($sender_details['id']);
            $msg = "Hello " . $student['firstname'] . " " . $student['lastname'] .
                    ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "parent") {
            $parent = $this->_CI->student_model->get($sender_details['id']);
            $msg = "Hello " . $parent['guardian_name'] . ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "staff") {
            $staff = $this->_CI->staff_model->get($sender_details['id']);
            $msg = "Hello " . $staff['name'] . ", your login details for Url: " . site_url('site/login') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "patient") {
            $patient = $this->_CI->patient_model->patientDetails($sender_details['id']);
            $msg = "Hello " . $patient['patient_name'] . ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        }

        // elseif ($credential_for == "librarian") {
        //          $librarian = $this->_CI->librarian_model->get($sender_details['id']);
        //          $msg = "Hello " . $librarian['name'] . ", your login details for Url: ".site_url('site/userlogin')." Username: " .$sender_details['username']. "\n Password: ".$sender_details['password'];
        // }elseif ($credential_for == "accountant") {
        //          $accountant = $this->_CI->accountant_model->get($sender_details['id']);
        //          $msg = "Hello " . $accountant['name'] . ", your login details for Url: ".site_url('site/userlogin')." Username: " .$sender_details['username']. "\n Password: ".$sender_details['password'];
        // }
        return $msg;
    }

    public function getStudentResultContent($student_result_detail) {

        $school_name = $this->_CI->setting_model->getCurrentSchoolName();
        $student_name = $student_result_detail['student_name'];

        $msg = $student_name . " is " . $student_result_detail['result'] . " in " . $student_result_detail['exam_name'] . " with total marks " . $student_result_detail['achive_marks'] . " out of " . $student_result_detail['total_marks'] . ".";
        return $msg;
    }

}

?>