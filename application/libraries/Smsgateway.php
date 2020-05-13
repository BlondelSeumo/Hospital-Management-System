<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smsgateway {

    private $_CI;
    private $sch_setting;

    function __construct() {
        $this->_CI = & get_instance();
        $this->_CI->load->model('setting_model');
        $this->_CI->load->model('staff_model');
        $this->_CI->load->model('appointment_model');
        $this->_CI->load->model('smsconfig_model');
        $this->_CI->load->model('payment_model');
        $this->sch_setting = $this->_CI->setting_model->get();
    }

    function sendSMS($send_to, $msg) {
        $sms_detail = $this->_CI->smsconfig_model->getActiveSMS();

        if (!empty($sms_detail)) {
            if ($sms_detail->type == 'clickatell') {

                $params = array(
                    'apiToken' => $sms_detail->api_id
                );
                $this->_CI->load->library('clickatell', $params);
                try {
                    $result = $this->_CI->clickatell->sendMessage(['to' => [$send_to], 'content' => $msg]);
                    foreach ($result['messages'] as $message) {
                        
                    }
                    return true;
                } catch (Exception $e) {
                    return true;
                }
            } else if ($sms_detail->type == 'twilio') {

                $params = array(
                    'mode' => 'sandbox',
                    'account_sid' => $sms_detail->api_id,
                    'auth_token' => $sms_detail->password,
                    'api_version' => '2010-04-01',
                    'number' => $sms_detail->contact,
                );

                $this->_CI->load->library('twilio', $params);

                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $response = $this->_CI->twilio->sms($from, $to, $message);
                if ($response->IsError)
                    return true;
                else
                    return true;
            }else if ($sms_detail->type == 'msg_nineone') {
                $params = array(
                    'authkey' => $sms_detail->authkey,
                    'senderid' => $sms_detail->senderid
                );
                $this->_CI->load->library('msgnineone', $params);
                $this->_CI->msgnineone->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'smscountry') {
                $params = array(
                    'username' => $sms_detail->username,
                    'sernderid' => $sms_detail->senderid,
                    'password' => $sms_detail->password
                );
                $this->_CI->load->library('smscountry', $params);
                $this->_CI->smscountry->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'text_local') {
                $to = $send_to;
                $params = array(
                    'username' => $sms_detail->username,
                    'hash' => $sms_detail->password,
                );
                $this->_CI->load->library('textlocalsms', $params);
                $this->_CI->textlocalsms->sendSms(array($to), $msg, $sms_detail->senderid);
            } else if ($sms_detail->type == 'custom') {
                $this->_CI->load->library('customsms');
                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $this->_CI->customsms->sendSMS($to, $message);
            } else {
                
            }
        }
        return true;
    }

    function sentRegisterSMS($id, $send_to, $ptypeno) {
        $sms_detail = $this->_CI->smsconfig_model->getActiveSMS();

        $msg = $this->getPatientRegistrationContent($id, $ptypeno);
        if (!empty($sms_detail)) {
            if ($sms_detail->type == 'clickatell') {

                $params = array(
                    'apiToken' => $sms_detail->api_id
                );
                $this->_CI->load->library('clickatell', $params);
                try {
                    $result = $this->_CI->clickatell->sendMessage(['to' => [$send_to], 'content' => $msg]);
                    foreach ($result['messages'] as $message) {
                        
                    }
                    return true;
                } catch (Exception $e) {
                    return true;
                }
            } else if ($sms_detail->type == 'twilio') {

                $params = array(
                    'mode' => 'sandbox',
                    'account_sid' => $sms_detail->api_id,
                    'auth_token' => $sms_detail->password,
                    'api_version' => '2010-04-01',
                    'number' => $sms_detail->contact,
                );

                $this->_CI->load->library('twilio', $params);

                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $response = $this->_CI->twilio->sms($from, $to, $message);


                if ($response->IsError)
                    return true;
                else
                    return true;
            }else if ($sms_detail->type == 'msg_nineone') {
                $params = array(
                    'authkey' => $sms_detail->authkey,
                    'senderid' => $sms_detail->senderid
                );
                $this->_CI->load->library('msgnineone', $params);
                $this->_CI->msgnineone->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'smscountry') {
                $params = array(
                    'username' => $sms_detail->username,
                    'sernderid' => $sms_detail->senderid,
                    'password' => $sms_detail->password
                );
                $this->_CI->load->library('smscountry', $params);
                $this->_CI->smscountry->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'text_local') {
                $to = $send_to;
                $params = array(
                    'username' => $sms_detail->username,
                    'hash' => $sms_detail->password,
                );
                $this->_CI->load->library('textlocalsms', $params);
                $this->_CI->textlocalsms->sendSms(array($to), $msg, $sms_detail->senderid);
            } else if ($sms_detail->type == 'custom') {
                $this->_CI->load->library('customsms');
                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $this->_CI->customsms->sendSMS($to, $message);
            } else {
                
            }
        }
        return true;
    }

    function sentDischargedSMS($id, $ipdid) {
        $sms_detail = $this->_CI->smsconfig_model->getActiveSMS();

        $data = $this->getPatientDischargedContent($id, $ipdid);
        $msg = $data["msg"];
        $send_to = $data["contact"];

        if (!empty($sms_detail)) {
            if ($sms_detail->type == 'clickatell') {

                $params = array(
                    'apiToken' => $sms_detail->api_id
                );
                $this->_CI->load->library('clickatell', $params);
                try {
                    $result = $this->_CI->clickatell->sendMessage(['to' => [$send_to], 'content' => $msg]);
                    foreach ($result['messages'] as $message) {
                        
                    }
                    return true;
                } catch (Exception $e) {
                    return true;
                }
            } else if ($sms_detail->type == 'twilio') {

                $params = array(
                    'mode' => 'sandbox',
                    'account_sid' => $sms_detail->api_id,
                    'auth_token' => $sms_detail->password,
                    'api_version' => '2010-04-01',
                    'number' => $sms_detail->contact,
                );

                $this->_CI->load->library('twilio', $params);

                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $response = $this->_CI->twilio->sms($from, $to, $message);


                if ($response->IsError)
                    return true;
                else
                    return true;
            }else if ($sms_detail->type == 'msg_nineone') {
                $params = array(
                    'authkey' => $sms_detail->authkey,
                    'senderid' => $sms_detail->senderid
                );
                $this->_CI->load->library('msgnineone', $params);
                $this->_CI->msgnineone->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'smscountry') {
                $params = array(
                    'username' => $sms_detail->username,
                    'sernderid' => $sms_detail->senderid,
                    'password' => $sms_detail->password
                );
                $this->_CI->load->library('smscountry', $params);
                $this->_CI->smscountry->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'text_local') {
                $to = $send_to;
                $params = array(
                    'username' => $sms_detail->username,
                    'hash' => $sms_detail->password,
                );
                $this->_CI->load->library('textlocalsms', $params);
                $this->_CI->textlocalsms->sendSms(array($to), $msg, $sms_detail->senderid);
            } else if ($sms_detail->type == 'custom') {
                $this->_CI->load->library('customsms');
                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $this->_CI->customsms->sendSMS($to, $message);
            } else {
                
            }
        }
        return true;
    }

    function sentAppointmentConfirmation($id) {
        $sms_detail = $this->_CI->smsconfig_model->getActiveSMS();

        $data = $this->getAppointmentConfirmationContent($id);
        $msg = $data["msg"];
        $send_to = $data["contact"];

        if (!empty($sms_detail)) {
            if ($sms_detail->type == 'clickatell') {

                $params = array(
                    'apiToken' => $sms_detail->api_id
                );
                $this->_CI->load->library('clickatell', $params);
                try {
                    $result = $this->_CI->clickatell->sendMessage(['to' => [$send_to], 'content' => $msg]);
                    foreach ($result['messages'] as $message) {
                        
                    }
                    return true;
                } catch (Exception $e) {
                    return true;
                }
            } else if ($sms_detail->type == 'twilio') {

                $params = array(
                    'mode' => 'sandbox',
                    'account_sid' => $sms_detail->api_id,
                    'auth_token' => $sms_detail->password,
                    'api_version' => '2010-04-01',
                    'number' => $sms_detail->contact,
                );

                $this->_CI->load->library('twilio', $params);

                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $response = $this->_CI->twilio->sms($from, $to, $message);


                if ($response->IsError)
                    return true;
                else
                    return true;
            }else if ($sms_detail->type == 'msg_nineone') {
                $params = array(
                    'authkey' => $sms_detail->authkey,
                    'senderid' => $sms_detail->senderid
                );
                $this->_CI->load->library('msgnineone', $params);
                $this->_CI->msgnineone->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'smscountry') {
                $params = array(
                    'username' => $sms_detail->username,
                    'sernderid' => $sms_detail->senderid,
                    'password' => $sms_detail->password
                );
                $this->_CI->load->library('smscountry', $params);
                $this->_CI->smscountry->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'text_local') {
                $to = $send_to;
                $params = array(
                    'username' => $sms_detail->username,
                    'hash' => $sms_detail->password,
                );
                $this->_CI->load->library('textlocalsms', $params);
                $this->_CI->textlocalsms->sendSms(array($to), $msg, $sms_detail->senderid);
            } else if ($sms_detail->type == 'custom') {
                $this->_CI->load->library('customsms');
                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $this->_CI->customsms->sendSMS($to, $message);
            } else {
                
            }
        }
        return true;
    }

    function sentAddFeeSMS($invoice_id, $sub_invoice_id, $send_to) {

        $sms_detail = $this->_CI->smsconfig_model->getActiveSMS();
        $msg = $this->getAddFeeContent($invoice_id, $sub_invoice_id);

        if (!empty($sms_detail)) {
            if ($sms_detail->type == 'clickatell') {
                $params = array(
                    'apiToken' => $sms_detail->api_id
                );
                $this->_CI->load->library('clickatell', $params);
                try {
                    $result = $this->_CI->clickatell->sendMessage(['to' => [$send_to], 'content' => $msg]);
                    foreach ($result['messages'] as $message) {
                        
                    }
                    return true;
                } catch (Exception $e) {
                    return false;
                }
            } else if ($sms_detail->type == 'twilio') {

                $params = array(
                    'mode' => 'sandbox',
                    'account_sid' => $sms_detail->api_id,
                    'auth_token' => $sms_detail->password,
                    'api_version' => '2010-04-01',
                    'number' => $sms_detail->contact,
                );

                $this->_CI->load->library('twilio', $params);

                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $response = $this->_CI->twilio->sms($from, $to, $message);


                if ($response->IsError)
                    return false;
                else
                    return true;
            }else if ($sms_detail->type == 'msg_nineone') {
                $params = array(
                    'authkey' => $sms_detail->authkey,
                    'senderid' => $sms_detail->senderid
                );
                $this->_CI->load->library('msgnineone', $params);
                $this->_CI->msgnineone->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'smscountry') {
                $params = array(
                    'username' => $sms_detail->username,
                    'sernderid' => $sms_detail->senderid,
                    'password' => $sms_detail->password
                );
                $this->_CI->load->library('smscountry', $params);
                $this->_CI->smscountry->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'text_local') {
                $params = array(
                    'username' => $sms_detail->username,
                    'hash' => $sms_detail->password,
                );
                $this->_CI->load->library('textlocalsms', $params);
                $this->_CI->textlocalsms->sendSms(array($send_to), $msg, $sms_detail->senderid);
            } else if ($sms_detail->type == 'custom') {
                $this->_CI->load->library('customsms');
                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $this->_CI->customsms->sendSMS($to, $message);
            } else {
                
            }
        }
    }

    function sentAbsentStudentSMS($detail) {
        $sms_detail = $this->_CI->smsconfig_model->getActiveSMS();

        if (!empty($sms_detail)) {


            $send_to = $detail['contact_no'];
            $msg = $this->getAbsentStudentContent($detail);

            if ($sms_detail->type == 'clickatell') {
                $params = array(
                    'apiToken' => $sms_detail->api_id
                );
                $this->_CI->load->library('clickatell', $params);

                try {
                    $result = $this->_CI->clickatell->sendMessage(['to' => [$send_to], 'content' => $msg]);
                    foreach ($result['messages'] as $message) {
                        
                    }
                    return true;
                } catch (Exception $e) {
                    return false;
                }
            } else if ($sms_detail->type == 'twilio') {

                $params = array(
                    'mode' => 'sandbox',
                    'account_sid' => $sms_detail->api_id,
                    'auth_token' => $sms_detail->password,
                    'api_version' => '2010-04-01',
                    'number' => $sms_detail->contact,
                );

                $this->_CI->load->library('twilio', $params);

                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $response = $this->_CI->twilio->sms($from, $to, $message);


                if ($response->IsError)
                    return false;
                else
                    return true;
            }else if ($sms_detail->type == 'msg_nineone') {
                $params = array(
                    'authkey' => $sms_detail->authkey,
                    'senderid' => $sms_detail->senderid
                );
                $this->_CI->load->library('msgnineone', $params);
                $this->_CI->msgnineone->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'smscountry') {
                $params = array(
                    'username' => $sms_detail->username,
                    'sernderid' => $sms_detail->senderid,
                    'password' => $sms_detail->password
                );
                $this->_CI->load->library('smscountry', $params);
                $this->_CI->smscountry->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'text_local') {
                $params = array(
                    'username' => $sms_detail->username,
                    'hash' => $sms_detail->password,
                );
                $this->_CI->load->library('textlocalsms', $params);
                $this->_CI->textlocalsms->sendSms(array($send_to), $msg, $sms_detail->senderid);
            } else if ($sms_detail->type == 'custom') {
                $this->_CI->load->library('customsms');
                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $this->_CI->customsms->sendSMS($to, $message);
            } else {
                
            }
        }
    }

    function sentExamResultSMS($detail) {

        $sms_detail = $this->_CI->smsconfig_model->getActiveSMS();
        $msg = $this->getStudentResultContent($detail);
        $send_to = $detail['guardian_phone'];
        if (!empty($sms_detail)) {
            if ($sms_detail->type == 'clickatell') {

                $params = array(
                    'apiToken' => $sms_detail->api_id
                );
                $this->_CI->load->library('clickatell', $params);
                try {
                    $result = $this->_CI->clickatell->sendMessage(['to' => [$send_to], 'content' => $msg]);
                    foreach ($result['messages'] as $message) {
                        
                    }
                    return true;
                } catch (Exception $e) {
                    return true;
                }
            } else if ($sms_detail->type == 'twilio') {

                $params = array(
                    'mode' => 'sandbox',
                    'account_sid' => $sms_detail->api_id,
                    'auth_token' => $sms_detail->password,
                    'api_version' => '2010-04-01',
                    'number' => $sms_detail->contact,
                );

                $this->_CI->load->library('twilio', $params);

                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $response = $this->_CI->twilio->sms($from, $to, $message);


                if ($response->IsError)
                    return true;
                else
                    return true;
            }else if ($sms_detail->type == 'msg_nineone') {
                $params = array(
                    'authkey' => $sms_detail->authkey,
                    'senderid' => $sms_detail->senderid
                );
                $this->_CI->load->library('msgnineone', $params);
                $this->_CI->msgnineone->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'smscountry') {
                $params = array(
                    'username' => $sms_detail->username,
                    'sernderid' => $sms_detail->senderid,
                    'password' => $sms_detail->password
                );
                $this->_CI->load->library('smscountry', $params);
                $this->_CI->smscountry->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'text_local') {
                $to = $send_to;
                $params = array(
                    'username' => $sms_detail->username,
                    'hash' => $sms_detail->password,
                );
                $this->_CI->load->library('textlocalsms', $params);
                $this->_CI->textlocalsms->sendSms(array($to), $msg, $sms_detail->senderid);
            } else if ($sms_detail->type == 'custom') {
                $this->_CI->load->library('customsms');
                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $this->_CI->customsms->sendSMS($to, $message);
            } else {
                
            }
        }
        return true;
    }

    function sendLoginCredential($chk_mail_sms, $sender_details) {
        $sms_detail = $this->_CI->smsconfig_model->getActiveSMS();
        $msg = $this->getLoginCredentialContent($sender_details['credential_for'], $sender_details);
        $send_to = $sender_details['contact_no'];
        if (!empty($sms_detail)) {
            if ($sms_detail->type == 'clickatell') {

                $params = array(
                    'apiToken' => $sms_detail->api_id
                );
                $this->_CI->load->library('clickatell', $params);
                try {
                    $result = $this->_CI->clickatell->sendMessage(['to' => [$send_to], 'content' => $msg]);
                    foreach ($result['messages'] as $message) {
                        
                    }
                    return true;
                } catch (Exception $e) {
                    return true;
                }
            } else if ($sms_detail->type == 'twilio') {

                $params = array(
                    'mode' => 'sandbox',
                    'account_sid' => $sms_detail->api_id,
                    'auth_token' => $sms_detail->password,
                    'api_version' => '2010-04-01',
                    'number' => $sms_detail->contact,
                );

                $this->_CI->load->library('twilio', $params);

                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $response = $this->_CI->twilio->sms($from, $to, $message);


                if ($response->IsError)
                    return true;
                else
                    return true;
            }else if ($sms_detail->type == 'msg_nineone') {
                $params = array(
                    'authkey' => $sms_detail->authkey,
                    'senderid' => $sms_detail->senderid
                );
                $this->_CI->load->library('msgnineone', $params);
                $this->_CI->msgnineone->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'smscountry') {
                $params = array(
                    'username' => $sms_detail->username,
                    'sernderid' => $sms_detail->senderid,
                    'password' => $sms_detail->password
                );
                $this->_CI->load->library('smscountry', $params);
                $this->_CI->smscountry->sendSMS($send_to, $msg);
            } else if ($sms_detail->type == 'text_local') {
                $params = array(
                    'username' => $sms_detail->username,
                    'hash' => $sms_detail->password,
                );
                $this->_CI->load->library('textlocalsms', $params);
                $this->_CI->textlocalsms->sendSms(array($send_to), $msg, $sms_detail->senderid);
            } else if ($sms_detail->type == 'custom') {
                $this->_CI->load->library('customsms');
                $from = $sms_detail->contact;
                $to = $send_to;
                $message = $msg;
                $this->_CI->customsms->sendSMS($send_to, $message);
            } else {
                
            }
        }
        return true;
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
        $hospital_details = $this->_CI->setting_model->getHospitalDetails();
        $hospital_name = $hospital_details["name"];
        $msg = "Dear " . $patient["patient_name"] . ", your " . $patient_type . " registration is successful at " . $hospital_name . " with Patient Id: " . $patient["patient_unique_id"] . " and " . $patient_type . " No: " . $patient_no;
        // $msg = 'Dear test, your OPD registration is successful at Smart Hospital with Patient Id: 7653 and OPD No: 4342';
        return $msg;
    }

    public function getPatientDischargedContent($id, $ipdid) {
        $session_name = $this->_CI->setting_model->getCurrentSessionName();
        $patient = $this->_CI->patient_model->patientProfile($id, $ipdid);
        $payment = $this->_CI->payment_model->getPaidTotal($id, $ipdid);
        $paid_amount = $payment['paid_amount'];
        $charge = $this->_CI->payment_model->getChargeTotal($id, $ipdid);
        $charge_amount = $charge['apply_charge'];

        $hospital_details = $this->_CI->setting_model->getHospitalDetails();
        $currency_symbol = $this->sch_setting[0]['currency_symbol'];
        $hospital_name = $hospital_details["name"];
        $msg = $patient['patient_name'] .
                " is now discharged from " . $hospital_name . " . Total Charges: " . $currency_symbol . $charge_amount . " and Total Payment: " . $currency_symbol . $paid_amount . " Your net payable bill amount was " . $currency_symbol . $patient["net_amount"];

        $email = $patient["email"];
        $contact = $patient["mobileno"];
        $array = array('msg' => $msg, 'email' => $email, 'contact' => $contact);
        return $array;
    }

    public function getAppointmentConfirmationContent($id) {

        $patient = $this->_CI->appointment_model->getDetails($id);
        $msg = "Dear " . $patient['patient_name'] .
                ", your appointment with " . $patient['name'] . " " . $patient['surname'] . " is confirmed on " . date($this->_CI->customlib->getSchoolDateFormat(true, true)) . " with appointment no :" . $patient['appointment_no'];
        $email = $patient['email'];
        $contact = $patient['mobileno'];
        $array = array('msg' => $msg, 'email' => $email, 'contact' => $contact,);
        return $array;
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

    public function getLoginCredentialContent($credential_for, $sender_details) {
        if ($credential_for == "student") {
            $student = $this->_CI->student_model->get($sender_details['id']);
            $msg = "Hello " . $student['firstname'] . " " . $student['lastname'] .
                    ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "parent") {
            $parent = $this->_CI->student_model->get($sender_details['id']);
            $msg = "Hello " . $parent['guardian_name'] . ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "teacher") {
            $teacher = $this->_CI->teacher_model->get($sender_details['id']);
            $msg = "Hello " . $teacher['name'] . ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "librarian") {
            $librarian = $this->_CI->librarian_model->get($sender_details['id']);
            $msg = "Hello " . $librarian['name'] . ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "accountant") {
            $accountant = $this->_CI->accountant_model->get($sender_details['id']);
            $msg = "Hello " . $accountant['name'] . ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "patient") {
            $patient = $this->_CI->patient_model->patientProfile($sender_details['id']);
            $msg = "Hello " . $patient['patient_name'] . ", your login details for Url: " . site_url('site/userlogin') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        } elseif ($credential_for == "staff") {
            $staff = $this->_CI->staff_model->get($sender_details['id']);
            $msg = "Hello " . $staff['name'] . ", your login details for Url: " . site_url('site/login') . " Username: " . $sender_details['username'] . "\n Password: " . $sender_details['password'];
        }
        return $msg;
    }

    public function getAbsentStudentContent($student_detail) {
        $school_name = $this->_CI->setting_model->getCurrentSchoolName();
        $student_name = $student_detail['student_name'];
        $msg = "Absent Notice : " . $student_name . " was absent on date " . $student_detail['date'] . " from " . $school_name;
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