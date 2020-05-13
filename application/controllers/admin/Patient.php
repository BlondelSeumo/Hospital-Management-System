<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class patient extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->config->load("image_valid");
        $this->config->load("mailsms");
        $this->notification = $this->config->item('notification');
        $this->notificationurl = $this->config->item('notification_url');
        $this->patient_notificationurl = $this->config->item('patient_notification_url');
        $this->load->library('Enc_lib');
        $this->load->library('encoding_lib');
        $this->load->library('mailsmsconf');
        $this->load->library('CSVReader');
        $this->load->library('Customlib');
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->search_type = $this->config->item('search_type');
        $this->blood_group = $this->config->item('bloodgroup');

        $this->charge_type = $this->config->item('charge_type');
        $data["charge_type"] = $this->charge_type;
        $this->patient_login_prefix = "pat";
    }

    public function unauthorized() {
        $data = array();
        $this->load->view('layout/header', $data);
        $this->load->view('unauthorized', $data);
        $this->load->view('layout/footer', $data);
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_add')) {
            access_denied();
        }
        $patient_type = $this->customlib->getPatienttype();

        $this->form_validation->set_rules('appointment_date', $this->lang->line('appointment') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('consultant_doctor', $this->lang->line('consultant') . " " . $this->lang->line('doctor'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('patient_id', $this->lang->line('patient'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('applied') . " " . $this->lang->line('charge'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'appointment_date' => form_error('appointment_date'),
                'consultant_doctor' => form_error('consultant_doctor'),
                'patient_id' => form_error('patient_id'),
                'amount' => form_error('amount')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $check_opd_id = $this->patient_model->getMaxOPDId();
            $opdnoid = $check_opd_id + 1;
            $doctor_id = $this->input->post('consultant_doctor');
            $insert_id = $this->input->post('patient_id');
            $email = $this->input->post('email');
            $mobileno = $this->input->post('mobileno');
            $patient_name = $this->input->post('patient_name');
            $appointment_date = $this->input->post('appointment_date');
            $isopd = $this->input->post('is_opd');
            $appointmentid = $this->input->post('appointment_id');
            $opd_data = array(
                'appointment_date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($appointment_date)),
                'case_type' => $this->input->post('case'),
                'opd_no' => 'OPDN' . $opdnoid,
                'symptoms' => $this->input->post('symptoms'),
                'refference' => $this->input->post('refference'),
                'cons_doctor' => $doctor_id,
                'height' => $this->input->post('height'),
                'weight' => $this->input->post('weight'),
                'bp' => $this->input->post('bp'),
                'patient_id' => $insert_id,
                'casualty' => $this->input->post('casualty'),
                'payment_mode' => $this->input->post('payment_mode'),
                'note_remark' => $this->input->post('note'),
                'amount' => $this->input->post('amount'),
                'generated_by' => $this->session->userdata('hospitaladmin')['id'],
            );
            $opdn_id = $this->patient_model->add_opd($opd_data);
            $opd_no = 'OPDN' . $opdnoid;
            $notificationurl = $this->notificationurl;
            $url_link = $notificationurl["opd"];
            $url = base_url() . $url_link . '/' . $insert_id . '/' . $opdn_id;

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'), 'id' => $insert_id, 'opd_id' => $opdn_id);

            if ($this->session->has_userdata("appointment_id")) {
                $appointment_id = $this->session->userdata("appointment_id");
                $updateData = array('id' => $appointment_id, 'is_opd' => 'yes');
                $this->appointment_model->update($updateData);
                $this->session->unset_userdata('appointment_id');
            }

            $this->opdNotification($insert_id, $doctor_id, $opd_no, $url);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/patient_images/' . $img_name);
                $this->patient_model->add($data_img);
            }

            $sender_details = array('patient_id' => $insert_id,'patient_name' => $patient_name,'opd_no' => $opd_no, 'contact_no' => $mobileno, 'email' => $email);
            $this->mailsmsconf->mailsms('opd_patient_registration', $sender_details);
           /* $sender_details = array('patient_id' => $insert_id, 'opd_no' => $opd_no, 'contact_no' => $this->input->post('contact'), 'email' => $this->input->post('email'));
            $this->mailsmsconf->mailsms('opd_patient_registration', $sender_details);*/

        }
        echo json_encode($array);
    }

    public function patientDetails() {

        if (!$this->rbac->hasPrivilege('patient', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $data = $this->patient_model->patientDetails($id);
        if (($data['dob'] == '') || ($data['dob'] == '0000-00-00') || ($data['dob'] == '1970-01-01')) {
            $data['dob'] = "";
        } else {
            $data['dob'] = date($this->customlib->getSchoolDateFormat(true, false), strtotime($data['dob']));
        }
        // $data['dob'] = date($this->customlib->getSchoolDateFormat(true,false),strtotime($data['dob']));
        //$listVehicle["death_date"] = date($this->customlib->getSchoolDateFormat(true, true), strtotime($listVehicle['death_date']));
        echo json_encode($data);
    }

    public function getPatientType() {
        $opd_ipd_patient_type = $this->input->post('opd_ipd_patient_type');
        $opd_ipd_no = $this->input->post('opd_ipd_no');
        if ($opd_ipd_patient_type == 'opd') {
            if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
                access_denied();
            }
            $result = $this->patient_model->getOpdPatient($opd_ipd_no);
        } elseif ($opd_ipd_patient_type == 'ipd') {
            if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
                access_denied();
            }
            $result = $this->patient_model->getIpdPatient($opd_ipd_no);
        }
        echo json_encode($result);
    }

    public function add_revisit() {
        if (!$this->rbac->hasPrivilege('revisit', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('appointment_date', $this->lang->line('appointment') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('consultant_doctor', $this->lang->line('consultant') . " " . $this->lang->line('doctor'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'appointment_date' => form_error('appointment_date'),
                'amount' => form_error('amount'),
                'consultant_doctor' => form_error('consultant_doctor'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $check_patient_id = $this->patient_model->getMaxOPDId();
            if (empty($check_patient_id)) {
                $check_patient_id = 0;
            }
            $patient_id = $this->input->post('id');
            $email = $this->input->post('email');
            $mobileno = $this->input->post('mobileno');
            $opdn_id = $check_patient_id + 1;

            $patient_data = array(
                'id' => $this->input->post('id'),
                'old_patient' => $this->input->post('old_patient'),
            );
            $this->patient_model->add($patient_data);
            $appointment_date = $this->input->post('appointment_date');
            $opd_data = array(
                'patient_id' => $this->input->post('id'),
                'appointment_date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($appointment_date)),
                'opd_no' => 'OPDN' . $opdn_id,
                'height' => $this->input->post('height'),
                'weight' => $this->input->post('weight'),
                'bp' => $this->input->post('bp'),
                'case_type' => $this->input->post('revisit_case'),
                'symptoms' => $this->input->post('symptoms'),
                'known_allergies' => $this->input->post('known_allergies'),
                'refference' => $this->input->post('refference'),
                'cons_doctor' => $this->input->post('consultant_doctor'),
                'amount' => $this->input->post('amount'),
                'casualty' => $this->input->post('casualty'),
                'payment_mode' => $this->input->post('payment_mode'),
                'note_remark' => $this->input->post('note_remark'),
                'generated_by' => $this->session->userdata('hospitaladmin')['id'],
            );
            $opd_id = $this->patient_model->add_opd($opd_data);

            $notificationurl = $this->notificationurl;
            $url_link = $notificationurl["opd"];
            $url = base_url() . $url_link . '/' . $patient_id . '/' . $opd_id;

           // $sender_details = array('patient_id' => $patient_id, 'opd_no' => 'OPDN' . $opdn_id, 'contact_no' => $this->input->post('contact'), 'email' => $this->input->post('email'));


            $this->opdNotification($this->input->post("id"), $this->input->post("consultant_doctor"), 'OPDN' . $opdn_id, $url);

            $sender_details = array('patient_id' => $patient_id,'opd_no' => 'OPDN' . $opdn_id, 'contact_no' => $mobileno, 'email' => $email);
            $this->mailsmsconf->mailsms('patient_revisit', $sender_details);

            $array = array('status' => 'success', 'error' => '', 'id' => $opd_id, 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getPatientId() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
            access_denied();
        }
        $result = $this->patient_model->getPatientId();
        $data["result"] = $result;
        echo json_encode($result);
    }


    public function doctCharge() {

        if (!$this->rbac->hasPrivilege('doctor_charges', 'can_view')) {
            access_denied();
        }
        $doctor = $this->input->post("doctor");
        $organisation = $this->input->post("organisation");
        $data = $this->patient_model->doctortpaCharge($doctor, $organisation);

        echo json_encode($data);
    }

    public function doctortpaCharge() {
        if (!$this->rbac->hasPrivilege('patient', 'can_view')) {
            access_denied();
        }

        $doctor = $this->input->post("doctor");
        $organisation = $this->input->post("organisation");
        $result = $this->patient_model->doctortpaCharge($doctor, $organisation);
        $data['result'] = $result;
        echo json_encode($result);
    }

    public function doctName() {

       
        $doctor = $this->input->post("doctor");
        $data = $this->patient_model->doctName($doctor);
        echo json_encode($data);
    }

    public function opdNotification($patient_id = '', $doctor_id, $opd_no = '', $url) {

        $notification = $this->notification;
        $notification_desc = $notification["opd_created"];
        $desc = str_replace(array('<opdno>', '<url>'), array($opd_no, $url), $notification_desc);
        $patient_url = $this->patient_notificationurl['opd'];
        $patient_desc = str_replace(array('<opdno>', '<url>'), array($opd_no, base_url() . $patient_url), $notification_desc);
        if (!empty($patient_id)) {
            $notification_data = array('notification_title' => 'OPD Visit Created',
                'notification_desc' => $patient_desc,
                'notification_for' => 'Patient',
                'notification_type' => 'opd',
                'receiver_id' => $patient_id,
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );
            $admin_notification_data = array('notification_title' => 'OPD Visit Created',
                'notification_desc' => $desc,
                'notification_for' => 'Super Admin',
                'notification_type' => 'opd',
                'receiver_id' => '',
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );
            $this->notification_model->addSystemNotification($notification_data);
            $this->notification_model->addSystemNotification($admin_notification_data);
        }

        if (!empty($doctor_id)) {

            $notification_data = array('notification_title' => 'OPD Visit Created',
                'notification_desc' => $desc,
                'notification_for' => 'Doctor',
                'notification_type' => 'opd',
                'receiver_id' => $doctor_id,
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );
            $this->notification_model->addSystemNotification($notification_data);
        }
    }

    public function ipdNotification($patient_id = '', $doctor_id, $ipdno = '', $url) {

        $notification = $this->notification;
        $notification_desc = $notification["ipd_created"];
        $desc = str_replace(array('<ipdno>', '<url>'), array($ipdno, $url), $notification_desc);
        $patient_url = $this->patient_notificationurl['ipd'];
        $patient_desc = str_replace(array('<ipdno>', '<url>'), array($ipdno, base_url() . $patient_url), $notification_desc);

        if (!empty($patient_id)) {
            $notification_data = array('notification_title' => 'IPD Visit Created',
                'notification_desc' => $patient_desc,
                'notification_for' => 'Patient',
                'notification_type' => 'ipd',
                'receiver_id' => $patient_id,
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );

            $admin_notification_data = array('notification_title' => 'IPD Visit Created',
                'notification_desc' => $desc,
                'notification_for' => 'Super Admin',
                'notification_type' => 'ipd',
                'receiver_id' => '',
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );
            $this->notification_model->addSystemNotification($notification_data);
            $this->notification_model->addSystemNotification($admin_notification_data);
        }

        if (!empty($doctor_id)) {

            $notification_data = array('notification_title' => 'IPD Visit Created',
                'notification_desc' => $desc,
                'notification_for' => 'Doctor',
                'notification_type' => 'ipd',
                'receiver_id' => $doctor_id,
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );
            $this->notification_model->addSystemNotification($notification_data);
        }
    }

    public function addpatient() {
        // if (!$this->rbac->hasPrivilege('patient', 'can_add')) {
        //     access_denied();
        // }

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_upload');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
                'file' => form_error('file'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $check_patient_id = $this->patient_model->getMaxId();

            if (empty($check_patient_id)) {
                $check_patient_id = 1000;
            }

            $patient_id = $check_patient_id + 1;
            $dobdate = $this->input->post('dob');

            // $dob =   date("Y-m-d H:i:s", $this->customlib->datetostrtotime($dobdate));
            if ($dobdate == "") {
                $dob = "";
            } else {
                $dob = date('Y-m-d', $this->customlib->datetostrtotime($dobdate));
            }
            // print_r($dob);
            //  exit();
            // print_r($dob);
            //  exit();
            $patient_data = array(
                'patient_name' => $this->input->post('name'),
                'mobileno' => $this->input->post('mobileno'),
                'marital_status' => $this->input->post('marital_status'),
                'email' => $this->input->post('email'),
                'gender' => $this->input->post('gender'),
                'guardian_name' => $this->input->post('guardian_name'),
                'blood_group' => $this->input->post('blood_group'),
                'address' => $this->input->post('address'),
                'known_allergies' => $this->input->post('known_allergies'),
                'patient_unique_id' => $patient_id,
                'note' => $this->input->post('note'),
                'age' => $this->input->post('age'),
                'month' => $this->input->post('month'),
                'dob' => $dob,
                'is_active' => 'yes',
                'discharged' => 'no',
            );
            $insert_id = $this->patient_model->add_patient($patient_data);
            if ($this->session->has_userdata("appointment_id")) {
                $appointment_id = $this->session->userdata("appointment_id");
                $updateData = array('id' => $appointment_id, 'patient_id' => $insert_id);
                $this->appointment_model->update($updateData);
                $this->session->unset_userdata('appointment_id');
            }
            $user_password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
            $data_patient_login = array(
                'username' => $this->patient_login_prefix . $insert_id,
                'password' => $user_password,
                'user_id' => $insert_id,
                'role' => 'patient'
            );
            $this->user_model->add($data_patient_login);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'), 'id' => $insert_id);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/patient_images/' . $img_name);
            } else {
                $data_img = array('id' => $insert_id, 'image' => 'uploads/patient_images/no_image.png');
            }
            $this->patient_model->add($data_img);

             $sender_details = array('id' => $insert_id, 'credential_for' => 'patient', 'username' => $this->patient_login_prefix . $insert_id, 'password' => $user_password, 'contact_no' => $this->input->post('mobileno'), 'email' => $this->input->post('email'));
            $this->mailsmsconf->mailsms('login_credential', $sender_details);   


        }
        echo json_encode($array);
    }

    public function handle_upload() {

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
                    $this->form_validation->set_message('handle_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array(strtolower($ext), $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', "File Type / Extension Not Allowed");
                return false;
            }

            return true;
        }
        return true;
    }

    public function handle_csv_upload() {

        $image_validate = $this->config->item('filecsv_validate');

        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = filesize($_FILES['file']['tmp_name'])) {

                if (!in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_csv_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_csv_upload', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_csv_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_csv_upload', "File Type / Extension Not Allowed");
                return false;
            }

            return true;
        }else{
          $this->form_validation->set_message('handle_csv_upload', "File field is required");
                return false;  
        }
        return true;
    }

    // public function getOldPatient() {
    //     if (!$this->rbac->hasPrivilege('old_patient', 'can_view')) {
    //         access_denied();
    //     }
    //     $this->session->set_userdata('top_menu', 'OPD_Out_Patient');
    //     $setting = $this->setting_model->get();
    //     $data['setting'] = $setting;
    //     $data['title'] = 'old_patient';
    //     $opd_month = $setting[0]['opd_record_month'];
    //     $data["marital_status"] = $this->marital_status;
    //     $data["payment_mode"] = $this->payment_mode;
    //     $data["bloodgroup"] = $this->blood_group;
    //     $doctors = $this->staff_model->getStaffbyrole(3);
    //     $data["doctors"] = $doctors;
    //     $resultlist = $this->patient_model->searchFullText($opd_month, '');
    //     $data['organisation'] = $this->organisation_model->get();
    //     $i = 0;
    //     foreach ($resultlist as $visits) {
    //         $patient_id = $visits["id"];
    //         $total_visit = $this->patient_model->totalVisit($patient_id);
    //         $last_visit = $this->patient_model->lastVisit($patient_id);
    //         $resultlist[$i]["total_visit"] = $total_visit["total_visit"];
    //         $resultlist[$i]["last_visit"] = $last_visit["last_visit"];
    //         $i++;
    //     }
    //     $data["resultlist"] = $resultlist;
    //     $this->load->view('layout/header');
    //     $this->load->view('admin/patient/search.php', $data);
    //     $this->load->view('layout/footer');
    // }

    public function exportformat() {
        $this->load->helper('download');
        $filepath = "./backend/import/import_patient_sample_file.csv";
        $data = file_get_contents($filepath);
        $name = 'import_patient_sample_file.csv';

        force_download($name, $data);
    }

    public function import() {
        if (!$this->rbac->hasPrivilege('patient_import', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'patient/import');
        
        $fields = array('patient_name', 'guardian_name', 'gender', 'age', 'month', 'blood_group', 'marital_status', 'mobileno', 'email', 'address', 'note', 'known_allergies');
        $data["fields"] = $fields;
        $this->form_validation->set_rules('file', $this->lang->line('file'), 'callback_handle_csv_upload');

       if ($this->form_validation->run() == FALSE) {
         
            $this->load->view('layout/header');
            $this->load->view('admin/patient/import', $data);
            $this->load->view('layout/footer');
            
        } else {

         
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

                if ($ext == 'csv') {
                    $file = $_FILES['file']['tmp_name'];
                    $result = $this->csvreader->parse_file($file);

                    if (!empty($result)) {
                        $check_patient_id = $this->patient_model->getMaxId();
                        if (empty($check_patient_id)) {
                            $check_patient_id = 1000;
                        }
                        $patient_id = $check_patient_id + 1;

                        $count = 0;
                        for ($i = 1; $i <= count($result); $i++) {

                            $patient_data[$i] = array();
                            $n = 0;
                            foreach ($result[$i] as $key => $value) {

                                $patient_data[$i][$fields[$n]] = $this->encoding_lib->toUTF8($result[$i][$key]);
                                $patient_data[$i]['is_active'] = 'yes';
                                $patient_data[$i]['discharged'] = 'no';
                                $patient_data[$i]['image'] = 'uploads/patient_images/no_image.png';
                                if ($i == 0) {
                                    $uniqueid = $patient_id;
                                } else {
                                    $uniqueid = $patient_id + $i;
                                }

                                $patient_data[$i]['patient_unique_id'] = $uniqueid;
                                $n++;
                            }

                            $patient_name = $patient_data[$i]["patient_name"];


                            if (!empty($patient_name)) {
                                $insert_id = $this->patient_model->addImport($patient_data[$i]);
                            }

                            if (!empty($insert_id)) {
                                $data['csvData'] = $result;
                                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">' . $this->lang->line('students_imported_successfully') . '</div>');
                                $count++;
                                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Total ' . count($result) . " records found in CSV file. Total " . $count . ' records imported successfully.</div>');
                            } else {

                                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">' . $this->lang->line('record_already_exists') . '</div>');
                            }

                        $user_password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
                        $data_patient_login = array(
                            'username' => $this->patient_login_prefix . $insert_id,
                            'password' => $user_password,
                            'user_id' => $insert_id,
                            'role' => 'patient'
                        );
                        $this->user_model->add($data_patient_login);
                       // $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'), 'id' => $insert_id);
                        }
                    }
                }
                redirect('admin/patient/import');
            }
        }
    }

    function check_medicine_exists($medicine_name, $medicine_category_id) {

        $this->db->where(array('medicine_category_id' => $medicine_category_id, 'medicine_name' => $medicine_name));
        $query = $this->db->join("medicine_category", "medicine_category.id = pharmacy.medicine_category_id")->get('pharmacy');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function search() {

        if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
            access_denied();
        }
        $opd_data = $this->session->flashdata('opd_data');
        $data['opd_data'] = $opd_data;
        $data["title"] = 'opd_patient';
        $this->session->set_userdata('top_menu', 'OPD_Out_Patient');
        $setting = $this->setting_model->get();
        $data['setting'] = $setting;
        $opd_month = $setting[0]['opd_record_month'];
        $data["marital_status"] = $this->marital_status;
        $data["payment_mode"] = $this->payment_mode;
        $data["bloodgroup"] = $this->blood_group;
        $doctors = $this->staff_model->getStaffbyrole(3);
        $data["doctors"] = $doctors;
        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata['role_id'];
        $doctorid = "";
        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        $disable_option = FALSE;
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {
                $disable_option = TRUE;
                $doctorid = $userdata['id'];
            }
        }
        $data["doctor_select"] = $doctorid;
        $data["disable_option"] = $disable_option;
        $resultlist = $this->patient_model->searchFullText('1', '');
        // echo "<pre>";
        // print_r($resultlist);
        // echo "</pre>";
        // exit();
        $data['organisation'] = $this->organisation_model->get();
        $i = 0;
        foreach ($resultlist as $visits) {
            $patient_id = $visits["pid"];
            $total_visit = $this->patient_model->totalVisit($patient_id);
            $last_visit = $this->patient_model->lastVisit($patient_id);
            $opdno = $this->patient_model->lastVisitopdno($patient_id);
            $consultant = $this->patient_model->getConsultant($patient_id, $opd_month);
            $resultlist[$i]["total_visit"] = $total_visit["total_visit"];
            $resultlist[$i]["last_visit"] = $last_visit["last_visit"];
            $resultlist[$i]["opdno"] = $opdno['opdno'];
            $i++;
        }

        $data["resultlist"] = $resultlist;

        $this->load->view('layout/header');
        $this->load->view('admin/patient/search.php', $data);
        $this->load->view('layout/footer');
    }

    public function getPatientList() {
        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;
        echo json_encode($patients);
    }

    public function ipdsearch($bedid = '', $bedgroupid = '') {
        if (!$this->rbac->hasPrivilege('ipd_patient', 'can_view')) {
            access_denied();
        }

        $ipd_data = $this->session->flashdata('ipd_data');
        $data['ipd_data'] = $ipd_data;

        if (!empty($bedgroupid)) {
            $data["bedid"] = $bedid;
            $data["bedgroupid"] = $bedgroupid;
        }
        $this->session->set_userdata('top_menu', 'IPD_in_patient');
        $data["marital_status"] = $this->marital_status;
        $data["payment_mode"] = $this->payment_mode;
        $data["bloodgroup"] = $this->blood_group;
        $data['bed_list'] = $this->bed_model->bedNoType();
        $data['floor_list'] = $this->floor_model->floor_list();
        $data['bedlist'] = $this->bed_model->bed_list();
        $data['bedgroup_list'] = $this->bedgroup_model->bedGroupFloor();
        $doctors = $this->staff_model->getStaffbyrole(3);
        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;
        $data["doctors"] = $doctors;
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata['role_id'];
        $doctorid = "";
        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        $disable_option = FALSE;
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {
                $disable_option = TRUE;
                $doctorid = $userdata['id'];
            }
        }

        $data["doctor_select"] = $doctorid;
        $data["disable_option"] = $disable_option;
        $setting = $this->setting_model->get();

        $data['setting'] = $setting;

        $data['resultlist'] = $this->patient_model->search_ipd_patients('');
        //echo $this->db->last_query();
       // exit;
        $i = 0;
        foreach ($data['resultlist'] as $key => $value) {
            $charges = $this->patient_model->getCharges($value["id"], $value["ipdid"]);
            $data['resultlist'][$i]["charges"] = $charges['charge'];
            $payment = $this->patient_model->getPayment($value["id"], $value["ipdid"]);
            $data['resultlist'][$i]["payment"] = $payment['payment'];
            $i++;
        }

        $data['organisation'] = $this->organisation_model->get();

        $this->load->view('layout/header');
        $this->load->view('admin/patient/ipdsearch.php', $data);
        $this->load->view('layout/footer');
    }

    public function discharged_patients() {
        if (!$this->rbac->hasPrivilege('discharged patients', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'IPD_in_patient');
        $data["marital_status"] = $this->marital_status;
        $data["payment_mode"] = $this->payment_mode;
        $data["bloodgroup"] = $this->blood_group;
        $data['bed_list'] = $this->bed_model->bedNoType();
        $data['bedgroup_list'] = $this->bedgroup_model->bedGroupFloor();
        $doctors = $this->staff_model->getStaffbyrole(3);
        $data["doctors"] = $doctors;
        $setting = $this->setting_model->get();
        $data['setting'] = $setting;
        $data['resultlist'] = $this->patient_model->search_ipd_patients('', $active = 'yes', $discharged = 'yes');

        $i = 0;
        foreach ($data['resultlist'] as $key => $value) {
            $charges = $this->patient_model->getCharges($value["id"], $value["ipdid"]);
            $data['resultlist'][$i]["charges"] = $charges['charge'];
            $payment = $this->patient_model->getPayment($value["id"], $value["ipdid"]);
            $data['resultlist'][$i]["payment"] = $payment['payment'];
            $discharge_details = $this->patient_model->getIpdBillDetails($value["id"], $value["ipdid"]);
            $data['resultlist'][$i]["discharge_date"] = $discharge_details['date'];
            $data['resultlist'][$i]["other_charge"] = $discharge_details['other_charge'];
            $data['resultlist'][$i]["tax"] = $discharge_details['tax'];
            $data['resultlist'][$i]["discount"] = $discharge_details['discount'];
            $data['resultlist'][$i]["net_amount"] = $discharge_details['net_amount'] + $payment['payment'];
            $i++;
        }
        $data['organisation'] = $this->organisation_model->get();
        $this->load->view('layout/header');
        $this->load->view('admin/patient/dischargedPatients.php', $data);
        $this->load->view('layout/footer');
    }

    public function visitDetails($id,$visitid) {

        if (!empty($id)) {

            $result = $this->patient_model->getDetails($id,$visitid);
            $data['result'] = $result;
            $data["id"] = $id;
            $billstatus = $this->patient_model->getBillstatus($result["id"], $visitid);
            $data["billstatus"] = $billstatus;

            //print_r($billstatus);
            //exit();
            $data['visit_id'] = $visitid;
            $opd_details = $this->patient_model->getOPDetails($id);
            $visit_details = $this->patient_model->getVisitDetails($id, $visitid);
            $data['visit_details'] = $visit_details;
            $revisit_details = $this->patient_model->getVisitDetailsByOPD($id, $visitid);
            $data['revisit_details'] = $revisit_details;
            $doctors = $this->staff_model->getStaffbyrole(3);
            $data["doctors"] = $doctors;
            $userdata = $this->customlib->getUserData();
            $role_id = $userdata['role_id'];
            $doctorid = "";
            $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
            $disable_option = FALSE;
            if ($doctor_restriction == 'enabled') {
                if ($role_id == 3) {
                    $disable_option = TRUE;
                    $doctorid = $userdata['id'];
                }
            }
            $data['organisation'] = $this->organisation_model->get();
            $data["doctor_select"] = $doctorid;
            $data["disable_option"] = $disable_option;
            $data["marital_status"] = $this->marital_status;
            $data["payment_mode"] = $this->payment_mode;
            $data["bloodgroup"] = $this->blood_group;
             $data["charge_type"] = $this->charge_type;
            $paymentDetails = $this->payment_model->opdPaymentDetails($id, $visitid);
            $diagnosis_details = $this->patient_model->getDiagnosisDetails($id);
            $timeline_list = $this->timeline_model->getPatientTimeline($id, $timeline_status = '');
            $data["timeline_list"] = $timeline_list;
            $data['opd_details'] = $opd_details;
            $data["payment_details"] = $paymentDetails;
            $data['diagnosis_details'] = $diagnosis_details;
            $data['medicineCategory'] = $this->medicine_category_model->getMedicineCategory();
            $data['dosage'] = $this->medicine_dosage_model->getMedicineDosage();
            $data['medicineName'] = $this->pharmacy_model->getMedicineName();
           
            $charges = $this->charge_model->getOPDCharges($id, $visitid);
            $paymentDetails = $this->payment_model->opdPaymentDetails($id, $visitid);
            $data["charges_detail"] = $charges;
            $data["payment_details"] = $paymentDetails;
            $paid_amount = $this->payment_model->getOPDPaidTotal($id, $visitid);
            $data["paid_amount"] = $paid_amount["paid_amount"];
            // print_r($result);
            // exit();
            if ($result['status'] == 'paid') {
                $generate = $this->patient_model->getopdBillInfo($result["id"], $visitid);
                $data["bill_info"] = $generate;
            }
            $this->load->view("layout/header");
            $this->load->view("admin/patient/visitDetails", $data);
            $this->load->view("layout/footer");
        }
    }

    public function addvisitDetails() {
        if (!$this->rbac->hasPrivilege('revisit', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('appointment_date', $this->lang->line('appointment') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'firstname' => form_error('name'),
                'appointment_date' => form_error('appointment_date'),
                'amount' => form_error('amount'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $check_patient_id = $this->patient_model->getMaxOPDId();

            if (empty($check_patient_id)) {
                $check_patient_id = 0;
            }

            $opdn_id = $check_patient_id + 1;

            $patient_id = $this->input->post('id');


            $appointment_date = $this->input->post('appointment_date');
            $opd_data = array(
                'patient_id' => $this->input->post('id'),
                'appointment_date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($appointment_date)),
                'opd_no' => $this->input->post('opd_no'),
                'opd_id' => $this->input->post('opd_id'),
                'height' => $this->input->post('height'),
                'weight' => $this->input->post('weight'),
                'bp' => $this->input->post('bp'),
                'case_type' => $this->input->post('revisit_case'),
                'symptoms' => $this->input->post('symptoms'),
                'known_allergies' => $this->input->post('known_allergies'),
                'refference' => $this->input->post('refference'),
                'cons_doctor' => $this->input->post('consultant_doctor'),
                'amount' => $this->input->post('amount'),
                'casualty' => $this->input->post('casualty'),
                'payment_mode' => $this->input->post('payment_mode'),
                'note' => $this->input->post('note_remark'),
                'generated_by' => $this->session->userdata('hospitaladmin')['id'],
            );
            $opd_id = $this->patient_model->addvisitDetails($opd_data);
            $sender_details = array('patient_id' => $patient_id, 'opd_no' => 'OPDN' . $opdn_id, 'contact_no' => $this->input->post('contact'), 'email' => $this->input->post('email'));

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function profile($id) {


        if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
            access_denied();
        }

        $opd_data = $this->session->flashdata('opd_data');
        $data['opd_data'] = $opd_data;
        $opdn_data = $this->session->flashdata('opdn_data');
        $data['opdn_data'] = $opdn_data;
        $data["marital_status"] = $this->marital_status;
        $data["payment_mode"] = $this->payment_mode;
        $data["bloodgroup"] = $this->blood_group;
        $data['medicineCategory'] = $this->medicine_category_model->getMedicineCategory();
        $data['dosage'] = $this->medicine_dosage_model->getMedicineDosage();
        $data['medicineName'] = $this->pharmacy_model->getMedicineName();
        $data["charge_type"] = $this->charge_type;
        $charges = $this->charge_model->getOPDCharges($id, '');
        $paymentDetails = $this->payment_model->paymentDetails($id, '');
        $data["charges_detail"] = $charges;
        $data["payment_details"] = $paymentDetails;
        $paid_amount = $this->payment_model->getPaidTotal($id, '');
        $data["paid_amount"] = $paid_amount["paid_amount"];

        $data["id"] = $id;
        $doctors = $this->staff_model->getStaffbyrole(3);
        $data["doctors"] = $doctors;
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata['role_id'];
        $doctorid = "";
        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        $disable_option = FALSE;
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {
                $disable_option = TRUE;
                $doctorid = $userdata['id'];
            }
        }

        $data["doctor_select"] = $doctorid;
        $data["disable_option"] = $disable_option;
        $result = array();
        $diagnosis_details = array();
        $opd_details = array();
        $timeline_list = array();

        if (!empty($id)) {
            //print_r($id);
            // exit();
            $result = $this->patient_model->getDetails($id);


            if ($result['status'] == 'paid') {
                $generate = $this->patient_model->getBillInfo($result["id"]);
                $data["bill_info"] = $generate;
            }

            $opd_details = $this->patient_model->getOPDetails($id);
            $diagnosis_details = $this->patient_model->getDiagnosisDetails($id);
            $timeline_list = $this->timeline_model->getPatientTimeline($id, $timeline_status = '');
        }
        // exit();

        $data["result"] = $result;
        $data["diagnosis_detail"] = $diagnosis_details;
        //print_r($opd_details);
        //exit;
        $data["opd_details"] = $opd_details;
        $data["timeline_list"] = $timeline_list;
        $data['organisation'] = $this->organisation_model->get();
        $this->load->view("layout/header");
        $this->load->view("admin/patient/profile", $data);
        $this->load->view("layout/footer");
    }

    public function ipdprofile($id, $ipdid = '', $active = 'yes') {

        if (!$this->rbac->hasPrivilege('ipd_patient', 'can_view')) {
            access_denied();
        }
        if ($ipdid == '') {
            $ipdresult = $this->patient_model->search_ipd_patients($searchterm = '', $active = 'yes', $discharged = 'no', $id);
            $ipdid = $ipdresult["ipdid"];
        }
        $this->session->set_userdata('top_menu', 'IPD_in_patient');
        $data['bed_list'] = $this->bed_model->bedNoType();
        $data['bedgroup_list'] = $this->bedgroup_model->bedGroupFloor();
        $data['medicineCategory'] = $this->medicine_category_model->getMedicineCategory();
        $data['dosage'] = $this->medicine_dosage_model->getMedicineDosage();
        $data['medicineName'] = $this->pharmacy_model->getMedicineName();
        $data["marital_status"] = $this->marital_status;
        $data["payment_mode"] = $this->payment_mode;
        $data["bloodgroup"] = $this->blood_group;
        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;
        $data['organisation'] = $this->organisation_model->get();
        $data["id"] = $id;
        $data["ipdid"] = $ipdid;
        $doctors = $this->staff_model->getStaffbyrole(3);
        $data["doctors"] = $doctors;
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata['role_id'];
        $doctorid = "";
        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        $disable_option = FALSE;
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {
                $disable_option = TRUE;
                $doctorid = $userdata['id'];
            }
        }

        $data["doctor_select"] = $doctorid;
        $data["disable_option"] = $disable_option;
        $result = array();
        $diagnosis_details = array();
        $opd_details = array();
        $timeline_list = array();
        $charges = array();
        if (!empty($id)) {
            $result = $this->patient_model->getIpdDetails($id, $ipdid, $active);
            if ($result['status'] == 'paid') {
                $generate = $this->patient_model->getBillInfo($result["id"]);
                $data["bill_info"] = $generate;
            }

            $diagnosis_details = $this->patient_model->getDiagnosisDetails($id);
            $timeline_list = $this->timeline_model->getPatientTimeline($id, $timeline_status = '');
            $prescription_details = $this->prescription_model->getIpdPrescription($ipdid);

            $consultant_register = $this->patient_model->getPatientConsultant($id, $ipdid);
            $charges = $this->charge_model->getCharges($id, $ipdid);
            $paymentDetails = $this->payment_model->paymentDetails($id, $ipdid);
            $paid_amount = $this->payment_model->getPaidTotal($id, $ipdid);
            $data["paid_amount"] = $paid_amount["paid_amount"];
            $balance_amount = $this->payment_model->getBalanceTotal($id, $ipdid);
            $data["balance_amount"] = $balance_amount["balance_amount"];
            $data["payment_details"] = $paymentDetails;
            $data["consultant_register"] = $consultant_register;
            $data["result"] = $result;
            $data["diagnosis_detail"] = $diagnosis_details;
            $data["prescription_detail"] = $prescription_details;
            $data["opd_details"] = $opd_details;
            $data["timeline_list"] = $timeline_list;
            $data["charge_type"] = $this->charge_type;
            $data["charges"] = $charges;
        }

        $this->load->view("layout/header");
        $this->load->view("admin/patient/ipdprofile", $data);
        $this->load->view("layout/footer");
    }

    public function patientipddetails($patient_id) {

        $data['resultlist'] = $this->patient_model->patientipddetails($patient_id);
        $i = 0;
        foreach ($data['resultlist'] as $key => $value) {
            $charges = $this->patient_model->getCharges($value["id"]);
            $data['resultlist'][$i]["charges"] = $charges['charge'];
            $payment = $this->patient_model->getPayment($value["id"]);
            $data['resultlist'][$i]["payment"] = $payment['payment'];
            $i++;
        }
        $data['organisation'] = $this->organisation_model->get();

        $this->load->view('layout/header');
        $this->load->view('admin/patient/patientipddetails.php', $data);
        $this->load->view('layout/footer');
    }

    public function deleteIpdPatientCharge($pateint_id, $id) {
        if (!$this->rbac->hasPrivilege('charges', 'can_delete')) {
            access_denied();
        }
        $this->charge_model->deleteIpdPatientCharge($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Patient Charges deleted successfully</div>');
        redirect('admin/patient/ipdprofile/' . $pateint_id . '#charges');
    }

    public function deleteOpdPatientCharge($pateint_id,$opdid,$id) {

        if (!$this->rbac->hasPrivilege('charges', 'can_delete')) {
            access_denied();
        }
        $this->charge_model->deleteOpdPatientCharge($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Patient Charges deleted successfully</div>');
        redirect('admin/patient/visitDetails/' . $pateint_id .'/'.$opdid.'#charges');
    }

    public function deleteIpdPatientConsultant($pateint_id, $id) {
        if (!$this->rbac->hasPrivilege('consultant register', 'can_add')) {
            access_denied();
        }
        $this->patient_model->deleteIpdPatientConsultant($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Patient Consultant deleted successfully</div>');
    }

    public function deleteIpdPatientDiagnosis($pateint_id, $id) {
        if (!$this->rbac->hasPrivilege('ipd diagnosis', 'can_delete')) {
            access_denied();
        }
        $this->patient_model->deleteIpdPatientDiagnosis($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Patient Diagnosis deleted successfully</div>');
        redirect('admin/patient/ipdprofile/' . $pateint_id . '#diagnosis');
    }

    public function deleteIpdPatientPayment($pateint_id, $id) {
        if (!$this->rbac->hasPrivilege('payment', 'can_delete')) {
            access_denied();
        }
        $this->payment_model->deleteIpdPatientPayment($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Patient Payment deleted successfully</div>');
        redirect('admin/patient/ipdprofile/' . $pateint_id . '#payment');
    }

     public function deleteOpdPatientPayment($pateint_id, $id,$opd_id) {
        if (!$this->rbac->hasPrivilege('payment', 'can_delete')) {
            access_denied();
        }
        $this->payment_model->deleteopdPatientPayment($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Patient Payment deleted successfully</div>');
        redirect('admin/patient/visitdetails/' . $pateint_id . '/'.$opd_id.'#payment');
    }

    public function deleteOpdPatientDiagnosis($pateint_id, $id) {
        if (!$this->rbac->hasPrivilege('opd diagnosis', 'can_delete')) {
            access_denied();
        }
        $this->patient_model->deleteIpdPatientDiagnosis($id);
    }

    public function report_download($doc) {
        $this->load->helper('download');
        $filepath = "./" . $this->uri->segment(4) . "/" . $this->uri->segment(5) . "/" . $this->uri->segment(6);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(6);
        force_download($name, $data);
    }

    public function getDetails() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("patient_id");
     
        $opdid = $this->input->post("opd_id");
       
        $visitid = $this->input->post("visitid");

        $result = $this->patient_model->getDetails($id,$opdid);
      //print_r($result);
      //  exit();
       

        if ((!empty($visitid))) {

            $result = $this->patient_model->getpatientDetailsByVisitId($id, $visitid);
        }

        $appointment_date = date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['appointment_date']));

        $result["appointment_date"] = $appointment_date;

        echo json_encode($result);
    }

    public function getpatientDetails() {
        if (!$this->rbac->hasPrivilege('patient', 'can_view')) {
            access_denied();
        }

        $id = $this->input->post("id");

        $result = $this->patient_model->getpatientDetails($id);
        if (($result['dob'] == '') || ($result['dob'] == '0000-00-00') || ($result['dob'] == '1970-01-01')) {
            $result['dob'] = "";
        } else {
            $result['dob'] = date($this->customlib->getSchoolDateFormat(true, false), strtotime($result['dob']));
        }

        echo json_encode($result);
    }

    public function getIpdDetails() {
        if (!$this->rbac->hasPrivilege('ipd_patient', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("recordid");
        $ipdid = $this->input->post("ipdid");
        $active = $this->input->post("active");
        $result = $this->patient_model->getIpdDetails($id, $ipdid, $active);
        $result['date'] = date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['date']));
        echo json_encode($result);
    }

    public function update() {
        if (!$this->rbac->hasPrivilege('patient', 'can_edit')) {
            access_denied();
        }
        $patient_type = $this->customlib->getPatienttype();
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_upload');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
                'file' => form_error('file'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('updateid');
            $dobdate = $this->input->post('dob');
            $dob = date("Y-m-d", $this->customlib->datetostrtotime($dobdate));
            $patient_data = array(
                'id' => $this->input->post('updateid'),
                'patient_name' => $this->input->post('name'),
                'mobileno' => $this->input->post('contact'),
                'marital_status' => $this->input->post('marital_status'),
                'blood_group' => $this->input->post('blood_group'),
                'email' => $this->input->post('email'),
                'dob' => $dob,
                'gender' => $this->input->post('gender'),
                'guardian_name' => $this->input->post('guardian_name'),
                'address' => $this->input->post('address'),
                'note' => $this->input->post('note'),
                'age' => $this->input->post('age'),
                'month' => $this->input->post('month'),
                'organisation' => $this->input->post('organisation'),
                'known_allergies' => $this->input->post('known_allergies'),
                'credit_limit' => $this->input->post('credit_limit'),
                'is_active' => 'yes',
            );

            $this->patient_model->add($patient_data);
            // String of all alphanumeric character 
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            // Shufle the $str_result and returns substring 
            // of specified length 
            $alfa_no = substr(str_shuffle($str_result), 0, 5);
            $array = array('status' => 'success', 'error' => '', 'message' => "Record Updated Successfully");
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $alfa_no . "_" . $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $id, 'image' => 'uploads/patient_images/' . $img_name);


                $this->patient_model->add($data_img);
            }
        }

        echo json_encode($array);
    }

    public function deactivePatient() {
        if (!$this->rbac->hasPrivilege('patient_deactive', 'can_edit')) {
            access_denied();
        }
        $id = $this->input->post('id');
        $patient_data = array(
            'id' => $id,
            'is_active' => 'no',
        );

         

        $this->patient_model->add($patient_data);
        $this->user_model->updateUser($id,'no');
        $array = array('status' => 'success', 'error' => '', 'message' => "Record Deactive");
        echo json_encode($array);
    }

    public function activePatient() {
        if (!$this->rbac->hasPrivilege('patient_active', 'can_edit')) {
            access_denied();
        }
        $id = $this->input->post('activeid');

        $patientact_data = array(
            'id' => $id,
            'is_active' => 'yes',
        );

        $this->patient_model->add_patient($patientact_data);
           $this->user_model->updateUser($id,'yes');
        $array = array('status' => 'success', 'error' => '', 'message' => "Record Active");
        echo json_encode($array);
    }

    public function ipd_update() {
        if (!$this->rbac->hasPrivilege('ipd_patient', 'can_edit')) {
            access_denied();
        }
        $patient_type = $this->customlib->getPatienttype();

        $this->form_validation->set_rules('cons_doctor', $this->lang->line('consultant') . " " . $this->lang->line('doctor'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('appointment_date', $this->lang->line('admission') . " " . $this->lang->line('date'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'patients_id' => form_error('patients_id'),
                'cons_doctor' => form_error('cons_doctor'),
                'appointment_date' => form_error('appointment_date'),
                'file' => form_error('file')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('updateid');
            $appointment_date = $this->input->post('appointment_date');


            $patientid = $this->input->post('patient_id');
            $previous_bed_id = $this->input->post('previous_bed_id');
            $current_bed_id = $this->input->post('bed_no');
            if ($previous_bed_id != $current_bed_id) {
                $beddata = array('id' => $previous_bed_id, 'is_active' => 'yes');
                $this->bed_model->savebed($beddata);
            }
            $ipd_data = array(
                'id' => $this->input->post('ipdid'),
                'patient_id' => $patientid,
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($appointment_date)),
                'bed' => $this->input->post('bed_no'),
                'bed_group_id' => $this->input->post('bed_group_id'),
                'height' => $this->input->post('height'),
                'bp' => $this->input->post('bp'),
                'weight' => $this->input->post('weight'),
                'case_type' => $this->input->post('case_type'),
                'symptoms' => $this->input->post('symptoms'),
                'known_allergies' => $this->input->post('known_allergies'),
                'refference' => $this->input->post('refference'),
                'cons_doctor' => $this->input->post('cons_doctor'),
                'casualty' => $this->input->post('casualty'),
                'note' => $this->input->post('note'),
                'credit_limit' => $this->input->post('credit_limit'),
            );
            $bed_data = array('id' => $this->input->post('bed_no'), 'is_active' => 'no');
            $this->bed_model->savebed($bed_data);
            $ipd_id = $this->patient_model->add_ipd($ipd_data);
            $array = array('status' => 'success', 'error' => '', 'message' => "Patient Updated Successfully");
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $id, 'image' => 'uploads/patient_images/' . $img_name);
                $this->patient_model->add($data_img);
            }
        }
        echo json_encode($array);
    }

    public function opd_detail_update() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_edit')) {
            access_denied();
        }
        $id = $this->input->post('opdid');
        $this->form_validation->set_rules('appointment_date', $this->lang->line('appointment') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('consultant_doctor', $this->lang->line('consultant') . " " . $this->lang->line('doctor'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('opdid', $this->lang->line('opd') . " " . $this->lang->line('id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $appointment_date = $this->input->post('appointment_date');

            $visitid = $this->input->post("visitid");
            $patient_data = array('id' => $this->input->post('patientid'),
                'organisation' => $this->input->post('organisation'),
                'old_patient' => $this->input->post('old_patient'),
            );
            if (!empty($visitid)) {
                $opd_data = array(
                    'id' => $this->input->post('visitid'),
                    'appointment_date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($appointment_date)),
                    'case_type' => $this->input->post('case'),
                    'symptoms' => $this->input->post('symptoms'),
                    'known_allergies' => $this->input->post('known_allergies'),
                    'refference' => $this->input->post('refference'),
                    'cons_doctor' => $this->input->post('consultant_doctor'),
                    'amount' => $this->input->post('amount'),
                    'bp' => $this->input->post('bp'),
                    'height' => $this->input->post('height'),
                    'weight' => $this->input->post('weight'),
                    'tax' => $this->input->post('tax'),
                    'casualty' => $this->input->post('casualty'),
                    'payment_mode' => $this->input->post('payment_mode'),
                    'note_remark' => $this->input->post('revisit_note'),
                );

                $opd_id = $this->patient_model->addvisitDetails($opd_data);
            } else {
                $opd_data = array(
                    'id' => $this->input->post('opdid'),
                    'appointment_date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($appointment_date)),
                    'case_type' => $this->input->post('case'),
                    'symptoms' => $this->input->post('symptoms'),
                    'known_allergies' => $this->input->post('known_allergies'),
                    'refference' => $this->input->post('refference'),
                    'cons_doctor' => $this->input->post('consultant_doctor'),
                    'amount' => $this->input->post('amount'),
                    'bp' => $this->input->post('bp'),
                    'height' => $this->input->post('height'),
                    'weight' => $this->input->post('weight'),
                    'tax' => $this->input->post('tax'),
                    'casualty' => $this->input->post('casualty'),
                    'payment_mode' => $this->input->post('payment_mode'),
                    'note_remark' => $this->input->post('revisit_note'),
                );

                $opd_id = $this->patient_model->add_opd($opd_data);
            }

            $this->patient_model->add($patient_data);

            $array = array('status' => 'success', 'error' => '', 'message' => "Record Updated Successfully");
        } else {

            $msg = array(
                'appointment_date' => form_error('appointment_date'),
                'consultant_doctor' => form_error('consultant_doctor'),
                'opdid' => form_error('opdid'),
                'amount' => form_error('amount'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        }
        echo json_encode($array);
    }

    public function opd_details() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("recordid");
        $opdid = $this->input->post("opdid");
        $result = $this->patient_model->getOPDetails($id, $opdid);

        if (!empty($result['appointment_date'])) {
            $appointment_date = date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['appointment_date']));
            $result["appointment_date"] = $appointment_date;
        }

        echo json_encode($result);
    }

    public function editvisitdetails() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("recordid");
        $visitid = $this->input->post("visitid");
        if ((!empty($visitid))) {

            $result = $this->patient_model->getpatientDetailsByVisitId($id, $visitid);
        }

        if (!empty($result['appointment_date'])) {
            $appointment_date = date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['appointment_date']));
            $result["appointment_date"] = $appointment_date;
        }
        echo json_encode($result);
    }

    public function editDiagnosis() {

        if (!$this->rbac->hasPrivilege('opd editdiagnosis', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $result = $this->patient_model->geteditDiagnosis($id);
        $result["report_date"] = date($this->customlib->getSchoolDateFormat(true, false), strtotime($result['report_date']));
        echo json_encode($result);
    }

    public function editTimeline() {

        if (!$this->rbac->hasPrivilege('opd timeline', 'can_edit')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $result = $this->timeline_model->geteditTimeline($id);

        echo json_encode($result);
    }

    public function editstaffTimeline() {

        if (!$this->rbac->hasPrivilege('staff_timeline', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");

        $result = $this->timeline_model->geteditstaffTimeline($id);

        echo json_encode($result);
    }

    public function add_diagnosis() {
        $this->form_validation->set_rules('report_type', $this->lang->line('report') . " " . $this->lang->line('type'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'report_type' => form_error('report_type'),
                'description' => form_error('description'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $report_date = $this->input->post('report_date');
            $data = array(
                'report_type' => $this->input->post("report_type"),
                'report_date' => date('Y-m-d', $this->customlib->datetostrtotime($report_date)),
                'patient_id' => $this->input->post("patient"),
                'description' => $this->input->post("description"),
            );
            $insert_id = $this->patient_model->add_diagnosis($data);
            if (isset($_FILES["report_document"]) && !empty($_FILES['report_document']['name'])) {
                $fileInfo = pathinfo($_FILES["report_document"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["report_document"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'document' => 'uploads/patient_images/' . $img_name);
                $this->patient_model->add_diagnosis($data_img);
            }
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Added Successfully.');
        }
        echo json_encode($array);
    }

    public function update_diagnosis() {
        $this->form_validation->set_rules('report_type', $this->lang->line('report') . " " . $this->lang->line('type'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'report_type' => form_error('report_type'),
                'description' => form_error('description'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $report_date = $this->input->post('report_date');
            $id = $this->input->post('diagnosis_id');
            $patientid = $this->input->post("diagnosispatient_id");
            $this->load->library('Customlib');
            $data = array(
                'id' => $id,
                'report_type' => $this->input->post("report_type"),
                'report_date' => date('Y-m-d', $this->customlib->datetostrtotime($report_date)),
                'patient_id' => $patientid,
                'description' => $this->input->post("description"),
            );
            $insert_id = $this->patient_model->add_diagnosis($data);
            if (isset($_FILES["report_document"]) && !empty($_FILES['report_document']['name'])) {
                $fileInfo = pathinfo($_FILES["report_document"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["report_document"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $id, 'document' => 'uploads/patient_images/' . $img_name);
                $this->patient_model->add_diagnosis($data_img);
            }
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Added Successfully.');
        }
        echo json_encode($array);
    }

    public function add_prescription() {
        if (!$this->rbac->hasPrivilege('prescription', 'can_add')) {
            access_denied();
        }
        //$this->form_validation->set_rules('medicine[]', $this->lang->line('medicine'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('medicine_cat[]', $this->lang->line('medicine'). " " . $this->lang->line('category'), 'trim|required|xss_clean');
       $this->form_validation->set_rules('opd_no', $this->lang->line('opd_no'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                //'medicine' => form_error('medicine[]'),
                'medicine_cat' => form_error('medicine_cat[]'),
                'opd_no' => form_error('opd_no')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $opd_id = $this->input->post('opd_no');


            $visit_id = $this->input->post('visit_id');

            $medicine = $this->input->post("medicine[]");
            $medicine_cat = $this->input->post("medicine_cat[]");
            $dosage = $this->input->post("dosage[]");
            $instruction = $this->input->post("instruction[]");
            $header_note = $this->input->post("header_note");
            $footer_note = $this->input->post("footer_note");
            $data_array = array();
            $i = 0;
            foreach ($medicine as $key => $value) {
                $inst = '';
                $do = '';
                $medicine_cat_value = '';
                if (!empty($dosage[$i])) {
                    $do = $dosage[$i];
                }
                if (!empty($instruction[$i])) {
                    $inst = $instruction[$i];
                }

                if (!empty($medicine_cat[$i])) {
                    $medicine_cat_value = $medicine_cat[$i];
                }
                $data = array('opd_id' => $opd_id, 'visit_id' => $visit_id, 'medicine' => $value, 'medicine_category_id' => $medicine_cat_value, 'dosage' => $do, 'instruction' => $inst);
                $data_array[] = $data;
                $i++;
            }
            $opd_array = array('id' => $opd_id, 'header_note' => $header_note, 'footer_note' => $footer_note);
            $this->patient_model->add_prescription($data_array);
            $this->patient_model->add_opd($opd_array);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);

    }

    public function add_ipdprescription() {
        if (!$this->rbac->hasPrivilege('prescription', 'can_add')) {
            access_denied();
        }
       
        $this->form_validation->set_rules('ipd_no', $this->lang->line('ipd_no') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        //$this->form_validation->set_rules('medicine[]', $this->lang->line('medicine'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('medicine_cat[]', $this->lang->line('medicine'). " " . $this->lang->line('category'), 'trim|required|xss_clean');  
     
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
               //'medicine' => form_error('medicine[]'),
                'medicine_cat' => form_error('medicine_cat[]'),
                'ipd_no' => form_error('ipd_no'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $ipd_id = $this->input->post('ipd_no');

            $visit_id = 1;
            $medicine = $this->input->post("medicine[]");
            $medicine_cat = $this->input->post("medicine_cat[]");
            $dosage = $this->input->post("dosage[]");
            $instruction = $this->input->post("instruction[]");
            $header_note = $this->input->post("header_note");
            $footer_note = $this->input->post("footer_note");
            $data_array = array();
            $ipd_basic_array = array('ipd_id' => $ipd_id, 'header_note' => $header_note, 'footer_note' => $footer_note, 'date' => date("Y-m-d"));
            $basic_id = $this->prescription_model->add_ipdprescriptionbasic($ipd_basic_array);

            $i = 0;
            foreach ($medicine as $key => $value) {
                $inst = '';
                $do = '';
                $medicine_cat_value = '';
                if (!empty($dosage[$i])) {
                    $do = $dosage[$i];
                }
                if (!empty($instruction[$i])) {
                    $inst = $instruction[$i];
                }

                if (!empty($medicine_cat[$i])) {
                    $medicine_cat_value = $medicine_cat[$i];
                }

                $data = array('basic_id' => $basic_id, 'ipd_id' => $ipd_id, 'medicine' => $value, 'dosage' => $do, 'medicine_category_id' => $medicine_cat_value, 'instruction' => $inst);
                $data_array[] = $data;
                $i++;
            }

            $this->prescription_model->add_ipdprescriptiondetail($data_array);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function update_prescription() {
        if (!$this->rbac->hasPrivilege('prescription', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('opd_id', $this->lang->line('opd_no'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'opd_id' => form_error('opd_id'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $opd_id = $this->input->post('opd_id');
            $visit_id = $this->input->post('visit_id');
            $medicine = $this->input->post("medicine[]");
            $medicine_cat = $this->input->post("medicine_cat[]");
            $prescription_id = $this->input->post("prescription_id[]");
            $previous_pres_id = $this->input->post("previous_pres_id[]");

            $dosage = $this->input->post("dosage[]");
            $instruction = $this->input->post("instruction[]");
            $header_note = $this->input->post("header_note");
            $footer_note = $this->input->post("footer_note");


            $data_array = array();
            $delete_arr = array();
            foreach ($previous_pres_id as $pkey => $pvalue) {
                if (in_array($pvalue, $prescription_id)) {
                    
                } else {
                    $delete_arr[] = array('id' => $pvalue,);
                }
            }

            $i = 0;
            foreach ($medicine as $key => $value) {
                $inst = '';
                $do = '';
                $medicine_cat_value = '';
                if (!empty($dosage[$i])) {
                    $do = $dosage[$i];
                }
                if (!empty($instruction[$i])) {
                    $inst = $instruction[$i];
                }
                if (!empty($medicine_cat[$i])) {
                    $medicine_cat_value = $medicine_cat[$i];
                }
                if ($prescription_id[$i] == 0) {
                    $add_data = array('opd_id' => $opd_id, 'visit_id' => $visit_id, 'medicine' => $value, 'medicine_category_id' => $medicine_cat_value, 'dosage' => $do, 'instruction' => $inst);

                    $data_array[] = $add_data;
                } else {

                    $update_data = array('id' => $prescription_id[$i], 'medicine_category_id' => $medicine_cat_value, 'opd_id' => $opd_id, 'medicine' => $value, 'dosage' => $do, 'instruction' => $inst);

                    $this->prescription_model->update_prescription($update_data);
                }


                $i++;
            }

            $opd_array = array('id' => $opd_id, 'header_note' => $header_note, 'footer_note' => $footer_note);

            if (!empty($data_array)) {
                $this->patient_model->add_prescription($data_array);
            }
            if (!empty($delete_arr)) {

                $this->prescription_model->delete_prescription($delete_arr);
            }
            $this->patient_model->add_opd($opd_array);

            $array = array('status' => 'success', 'error' => '', 'message' => 'Prescription Added Successfully');
        }
        echo json_encode($array);
    }

    public function update_ipdprescription() {
        if (!$this->rbac->hasPrivilege('prescription', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('ipd_id', $this->lang->line('ipd_no'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'ipd_id' => form_error('ipd_id'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $ipd_id = $this->input->post('ipd_id');
            $visit_id = $this->input->post('visit_id');

            $medicine = $this->input->post("medicine[]");
            $medicine_cat = $this->input->post("medicine_cat[]");
            $prescription_id = $this->input->post("prescription_id[]");
            $previous_pres_id = $this->input->post("previous_pres_id[]");

            $dosage = $this->input->post("dosage[]");
            $instruction = $this->input->post("instruction[]");
            $header_note = $this->input->post("header_note");
            $footer_note = $this->input->post("footer_note");


            $data_array = array();
            $delete_arr = array();
            foreach ($previous_pres_id as $pkey => $pvalue) {
                if (in_array($pvalue, $prescription_id)) {
                    
                } else {
                    $delete_arr[] = array('id' => $pvalue,);
                }
            }

            $i = 0;
            foreach ($medicine as $key => $value) {
                $inst = '';
                $do = '';
                $medicine_cat_value = '';
                if (!empty($dosage[$i])) {
                    $do = $dosage[$i];
                }
                if (!empty($instruction[$i])) {
                    $inst = $instruction[$i];
                }
                if (!empty($medicine_cat[$i])) {
                    $medicine_cat_value = $medicine_cat[$i];
                }
                if ($prescription_id[$i] == 0) {
                    $add_data = array('ipd_id' => $ipd_id, 'basic_id' => $visit_id, 'medicine' => $value, 'medicine_category_id' => $medicine_cat_value, 'dosage' => $do, 'instruction' => $inst);

                    $data_array[] = $add_data;
                } else {

                    $update_data = array('id' => $prescription_id[$i], 'medicine_category_id' => $medicine_cat_value, 'ipd_id' => $ipd_id, 'medicine' => $value, 'dosage' => $do, 'instruction' => $inst);

                    $this->prescription_model->update_ipdprescription($update_data);
                }


                $i++;
            }

            $ipd_array = array('id' => $visit_id, 'header_note' => $header_note, 'footer_note' => $footer_note);

            if (!empty($data_array)) {
                $this->patient_model->add_ipdprescription($data_array);
            }
            if (!empty($delete_arr)) {

                $this->prescription_model->delete_ipdprescription($delete_arr);
            }
            $this->patient_model->addipd($ipd_array);

            $array = array('status' => 'success', 'error' => '', 'message' => 'Prescription Added Successfully');
        }
        echo json_encode($array);
    }

    public function add_inpatient() {
        if (!$this->rbac->hasPrivilege('ipd_patient', 'can_add')) {
            access_denied();
        }
        $patient_type = $this->customlib->getPatienttype();

        $this->form_validation->set_rules('appointment_date', $this->lang->line('appointment') . " " . $this->lang->line('date'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('consultant_doctor', $this->lang->line('consultant') . " " . $this->lang->line('doctor'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('bed_no', $this->lang->line('bed') . " " . $this->lang->line('no'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('patient_id', $this->lang->line('patient'), 'callback_valid_patient');



        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'appointment_date' => form_error('appointment_date'),
                'bed_no' => form_error('bed_no'),
                'consultant_doctor' => form_error('consultant_doctor'),
                'patient_id' => form_error('patient_id'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {


            $check_ipd_id = $this->patient_model->getMaxIPDId();
            $ipdnoid = $check_ipd_id + 1;
            $ipdno = 'IPDN' . $ipdnoid;
            // $patientun_id = $this->input->post('patientunique_id');
            // $ipdno = "IPDN".$patientun_id;
            $appointment_date = $this->input->post('appointment_date');
            $insert_id = $this->input->post('patient_id');
            $email = $this->input->post('email');
            $mobileno = $this->input->post('mobileno');
            $patient_name = $this->input->post('patient_name');

            $ipd_data = array(
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($appointment_date)),
                'ipd_no' => $ipdno,
                'bed' => $this->input->post('bed_no'),
                'bed_group_id' => $this->input->post('bed_group_id'),
                'height' => $this->input->post('height'),
                'weight' => $this->input->post('weight'),
                'bp' => $this->input->post('bp'),
                'case_type' => $this->input->post('case'),
                'symptoms' => $this->input->post('symptoms'),
                'refference' => $this->input->post('refference'),
                'cons_doctor' => $this->input->post('consultant_doctor'),
                'patient_id' => $insert_id,
                'casualty' => $this->input->post('casualty'),
                'discharged' => 'no'
                );

            $ipdpatient_data = array(
                'id' => $insert_id,
                'organisation' => $this->input->post('organisation'),
            );
            $ipd_id = $this->patient_model->add_ipd($ipd_data);
            
            $bed_data = array('id' => $this->input->post('bed_no'), 'is_active' => 'no');
            $this->bed_model->savebed($bed_data);
            $updateData = array('id' => $insert_id, 'is_ipd' => 'yes', 'discharged' => 'no');
            $this->patient_model->add($updateData);
            $ipdid = $this->patient_model->add($ipdpatient_data);
            $array = array('status' => 'success', 'error' => '', 'message' => "Patient Added Successfully");
            if ($this->session->has_userdata("appointment_id")) {

                $appointment_id = $this->session->userdata("appointment_id");
                $updateData = array('id' => $appointment_id, 'is_ipd' => 'yes');
                $this->appointment_model->update($updateData);
                $this->session->unset_userdata('appointment_id');
            }

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/patient_images/' . $img_name);
                $this->patient_model->add($data_img);
            }

            $notificationurl = $this->notificationurl;
            $url_link = $notificationurl["ipd"];
            $url = base_url() . $url_link . '/' . $insert_id . '/' . $ipd_id;
            $this->ipdNotification($insert_id, $this->input->post('consultant_doctor'), $ipdno, $url);

            $sender_details = array('patient_id' => $insert_id,'patient_name' => $patient_name,'ipd_no' => $ipdno, 'contact_no' => $mobileno, 'email' => $email);
            $this->mailsmsconf->mailsms('ipd_patient_registration', $sender_details);
        }
        
        echo json_encode($array);
    }

    public function valid_patient() {
        $id = $this->input->post('patient_id');

        if ($id > 0) {
            $check_exists = $this->patient_model->valid_patient($id);
            if ($check_exists == TRUE) {
                $this->form_validation->set_message('valid_patient', 'Record already exists');
                return FALSE;
            }
        }
    }

    public function add_consultant_instruction() {
        if (!$this->rbac->hasPrivilege('consultant register', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('date[]', $this->lang->line('applied') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('doctor[]', $this->lang->line('consultant'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('instruction[]', $this->lang->line('instruction'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('insdate[]', $this->lang->line('instruction') . " " . $this->lang->line('date'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'date' => form_error('date[]'),
                'doctor' => form_error('doctor[]'),
                'instruction' => form_error('instruction[]'),
                'datee' => form_error('insdate[]')
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $date = $this->input->post('date[]');
            $ins_date = $this->input->post('insdate[]');
            //$ins_time = $this->input->post('instime[]');
            $patient_id = $this->input->post('patient_id');
            $ipd_id = $this->input->post('ipdid');
            $doctor = $this->input->post('doctor[]');
            $instruction = $this->input->post('instruction[]');
            $data = array();
            $i = 0;
            foreach ($date as $key => $value) {
                $details = array(
                    'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($date[$i])),
                    'patient_id' => $patient_id,
                    'ipd_id' => $ipd_id,
                    'ins_date' => date('Y-m-d', $this->customlib->datetostrtotime($ins_date[$i])),
                    'cons_doctor' => $doctor[$i],
                    'instruction' => $instruction[$i],
                );
                $data[] = $details;
                $i++;
            }
            $this->patient_model->add_consultantInstruction($data);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Added Successfully');
        }
        echo json_encode($array);
    }

    public function ipdCharge() {
        $code = $this->input->post('code');
        $org_id = $this->input->post('organisation_id');
       
        $patient_charge = $this->patient_model->ipdCharge($code, $org_id);
        $data['patient_charge'] = $patient_charge;
        echo json_encode($patient_charge);
    }

    public function opd_report() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_view')) {
            access_denied();
        }
        $doctorlist = $this->staff_model->getEmployeeByRoleID(3);
        $data['doctorlist'] = $doctorlist;

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/patient/opd_report');
        $this->session->set_userdata('top_menu', 'Reports');
        $select = 'opd_details.*,staff.name,staff.surname,patients.id as pid,patients.patient_name,patients.patient_unique_id,patients.guardian_name,patients.address,patients.admission_date,patients.gender,patients.mobileno,patients.age,patients.month';
        $join = array(
            'JOIN staff ON opd_details.cons_doctor = staff.id',
            'JOIN patients ON opd_details.patient_id = patients.id',
            
        );
        $where = array();
        $doctorid = $this->input->post('doctor');

        if (!empty($doctorid)) {
            $where = array('opd_details.cons_doctor =' . $doctorid);
        }
        $table_name = "opd_details";

        $disable_option = FALSE;
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata['role_id'];
        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {

                $user_id = $userdata["id"];
                $doctorid = $user_id;
                $where = array(
                    "opd_details.cons_doctor = " . $user_id,
                );
                $disable_option = TRUE;
            }
        }
        $data['disable_option'] = $disable_option;
        $data['doctor_select'] = $doctorid;
        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }

        if (empty($search_type)) {

            $search_type = "";
            $resultlist = $this->report_model->getReport($select, $join, $table_name, $where);
        } else {

            $search_table = "opd_details";
            $search_column = "appointment_date";
            $resultlist = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column, $where);
        }
         /* $resultList2 = $this->report_model->searchReport($select = 'opd_details.*,opd_patient_charges.apply_charge as amount, opd_patient_charges.created_at as payment_date,staff.name,staff.surname,patients.id as pid,patients.patient_name,patients.patient_unique_id,patients.guardian_name,patients.address,patients.admission_date,patients.gender,patients.mobileno,patients.age,patients.month', $join = array(
            'JOIN staff ON opd_details.cons_doctor = staff.id',
            'JOIN patients ON opd_details.patient_id = patients.id',
            'JOIN opd_patient_charges ON opd_patient_charges.opd_id = opd_details.id',
                ), $table_name = 'opd_details', $search_type, $search_table = 'opd_patient_charges', $search_column = 'created_at', $where);
        // echo $this->db->last_query();  
        if (!empty($resultList2)) {
            array_push($resultlist, $resultList2[0]);
        }*/
        // echo "<pre>";
        // print_r($resultlist);
        // exit;
        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data["resultlist"] = $resultlist;
$i = 0;
        if (!empty($resultlist)) {
            foreach ($data['resultlist'] as $key => $value) {
                $charges = $this->patient_model->getOPDCharges($value["pid"], $value["id"]);
             if(!empty($charges))
               $data['resultlist'][$i]["charges"] = $charges['charge'];
                $i++;
            }
        }
    
     
        $this->load->view('layout/header');
        $this->load->view('admin/patient/opdReport.php', $data);
        $this->load->view('layout/footer');
    }

    public function ipdReport() {
        if (!$this->rbac->hasPrivilege('ipd_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/patient/ipdreport');

        $doctorlist = $this->staff_model->getEmployeeByRoleID(3);
        $data['doctorlist'] = $doctorlist;
        $status = 'no';
        $patient_status = $this->input->post("patient_status");
        if(empty($patient_status)){
           $patient_status = 'on_bed' ;
        }
        if($patient_status == 'all'){
            $status = '';
        }else if($patient_status == 'on_bed'){
            $status = 'yes';
        }else if($patient_status == 'discharged'){
            $status = 'no';
        }
      //  echo $patient_status."-".$status ;
        $select = 'ipd_details.*,ipd_details.discharged as ipd_discharge,payment.paid_amount, payment.date as payment_date, staff.name,staff.surname,patients.id as pid,patients.patient_name,patients.patient_unique_id,patients.guardian_name,patients.address,patients.admission_date,patients.gender,patients.mobileno,patients.age,patients.month';
        $join = array(
            'JOIN staff ON ipd_details.cons_doctor = staff.id',
            'JOIN patients ON ipd_details.patient_id = patients.id',
            'LEFT JOIN payment ON payment.ipd_id = ipd_details.id',
        );
        $table_name = "ipd_details";

        $additional_where = array("patients.is_active = 'yes'", "ipd_details.discharged != '".$status."'");
        $doctorid = $this->input->post('doctor');

        if (!empty($doctorid)) {
            $additional_where = array("patients.is_active = 'yes' ", "ipd_details.cons_doctor ='" . $doctorid . "'", "ipd_details.discharged != '".$status."'");
        }
        $disable_option = FALSE;
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata['role_id'];

        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {

                $user_id = $userdata["id"];
                $doctorid = $user_id;
                $additional_where = array(
                    "ipd_details.cons_doctor = " . $user_id,
                    "patients.discharged != 'yes'"
                );
                $disable_option = TRUE;
            }
        }
        $data['disable_option'] = $disable_option;
        $data['doctor_select'] = $doctorid;

        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }

        if (empty($search_type)) {
            $search_type = "";
            $resultlist = $this->report_model->getReport($select, $join, $table_name, $additional_where);
        } else {

            $search_table = "ipd_details";
            $search_column = "date";
            $resultlist = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column, $additional_where);
            //echo $this->db->last_query();
            //exit;
        }
        $resultList2 = $this->report_model->searchReport($select = 'ipd_details.*,ipd_details.discharged as ipd_discharge,ipd_billing.net_amount as paid_amount, ipd_billing.date as payment_date,staff.name,staff.surname,patients.id as pid,patients.patient_name,patients.patient_unique_id,patients.guardian_name,patients.address,patients.admission_date,patients.gender,patients.mobileno,patients.age,patients.month', $join = array(
            'JOIN staff ON ipd_details.cons_doctor = staff.id',
            'JOIN patients ON ipd_details.patient_id = patients.id',
            'LEFT JOIN payment ON payment.patient_id = patients.id',
            'JOIN ipd_billing ON ipd_billing.ipd_id = ipd_details.id',
                ), $table_name = 'ipd_details', $search_type, $search_table = 'ipd_billing', $search_column = 'date', $additional_where);
        // echo $this->db->last_query();  
        if (!empty($resultList2)) {
            array_push($resultlist, $resultList2[0]);
        }
        // echo "<pre>";
        //print_r($resultlist);
        //   exit;
        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data["resultlist"] = $resultlist;
        $i = 0;
        if (!empty($resultlist)) {
            foreach ($data['resultlist'] as $key => $value) {
                $charges = $this->patient_model->getCharges($value["pid"], $value["id"]);
                $data['resultlist'][$i]["charges"] = $charges['charge'];
                $i++;
            }
        }
        if(!empty($patient_status)) { 
           $data['patient_status'] = $patient_status;

            }else{
          $data['patient_status'] = 'on_bed';

            }
        $this->load->view('layout/header');
        $this->load->view('admin/patient/ipdReport.php', $data);
        $this->load->view('layout/footer');
    }

    public function dischargepatientReport() {
        if (!$this->rbac->hasPrivilege('ipd_report', 'can_view')) {
            access_denied();
        }
        $doctorlist = $this->staff_model->getEmployeeByRoleID(3);
        $data['doctorlist'] = $doctorlist;

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/patient/dischargepatientReport');
        $select = 'ipd_details.*,payment.paid_amount, payment.date as payment_date, staff.name,staff.surname,patients.id as pid,patients.patient_name,patients.patient_unique_id,patients.guardian_name,patients.address,patients.admission_date,patients.gender,patients.mobileno,patients.age';
        $join = array(
            'JOIN staff ON ipd_details.cons_doctor = staff.id',
            'JOIN patients ON ipd_details.patient_id = patients.id',
            'LEFT JOIN payment ON payment.ipd_id = ipd_details.id',
        );
        $table_name = "ipd_details";
        $additional_where = array("ipd_details.discharged = 'yes'");
        $doctorid = $this->input->post('doctor');

        $disable_option = FALSE;
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata['role_id'];

        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {

                $user_id = $userdata["id"];
                $doctorid = $user_id;
                $additional_where = array(
                    "ipd_details.discharged = 'yes' ",
                    "ipd_details.cons_doctor = " . $user_id,
                );
                $disable_option = TRUE;
            }
        }
        $data['doctor_select'] = $doctorid;
        $data['disable_option'] = $disable_option;

        if (!empty($doctorid)) {
            $additional_where = array("patients.is_active = 'yes' ", "ipd_details.discharged = 'yes'", "ipd_details.cons_doctor ='" . $doctorid . "'");
        }
        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }

        if (empty($search_type)) {
            $search_type = "";
            $resultlist = $this->report_model->getReport($select, $join, $table_name, $additional_where);
        } else {

            $search_table = "ipd_details";
            $search_column = "date";
            $resultlist = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column, $additional_where);
        }

        $resultList2 = $this->report_model->searchReport($select = 'ipd_details.*,ipd_billing.net_amount as paid_amount, ipd_billing.date as payment_date,staff.name,staff.surname,patients.id as pid,patients.patient_name,patients.patient_unique_id,patients.guardian_name,patients.address,patients.admission_date,patients.gender,patients.mobileno,patients.age', $join = array(
            'JOIN staff ON ipd_details.cons_doctor = staff.id',
            'JOIN patients ON ipd_details.patient_id = patients.id',
            'LEFT JOIN payment ON payment.ipd_id = ipd_details.id',
            'JOIN ipd_billing ON ipd_billing.ipd_id = ipd_details.id',
                ), $table_name = 'ipd_details', $search_type, $search_table = 'ipd_billing', $search_column = 'date', $additional_where);
        if (!empty($resultList2)) {
            array_push($resultlist, $resultList2[0]);
        }


        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data["resultlist"] = $resultlist;

        $i = 0;
        if (!empty($resultlist)) {
            foreach ($data['resultlist'] as $key => $value) {
                $charges = $this->patient_model->getCharges($value["pid"], $value["id"]);
                $data['resultlist'][$i]["charges"] = $charges['charge'];
                $discharge_details = $this->patient_model->getIpdBillDetails($value["pid"], $value["id"]);
                $payment = $this->patient_model->getPayment($value["pid"], $value["id"]);
                $data['resultlist'][$i]["discharge_date"] = $discharge_details['date'];
                $data['resultlist'][$i]["other_charge"] = $discharge_details['other_charge'];
                $data['resultlist'][$i]["tax"] = $discharge_details['tax'];
                $data['resultlist'][$i]["discount"] = $discharge_details['discount'];
                $data['resultlist'][$i]["net_amount"] = $discharge_details['net_amount'] + $payment['payment'];
                $i++;
            }
        }

        $this->load->view('layout/header');
        $this->load->view('admin/patient/dischargePatientReport.php', $data);
        $this->load->view('layout/footer');
    }

    public function revertBill() {
        $patient_id = $this->input->post('patient_id');
        $bill_id = $this->input->post('bill_id');
        $bed_id = $this->input->post('bed_id');
             $ipd_id = $this->input->post('ipdid');

        if ((!empty($patient_id)) && (!empty($bill_id))) {
            $patient_data = array('id' => $patient_id, 'discharged' => 'no');
            $this->patient_model->add($patient_data);

            $ipd_data = array('id' => $ipd_id, 'discharged' => 'no');
            $this->patient_model->add_ipd($ipd_data);

            $bed_data = array('id' => $bed_id, 'is_active' => 'no');
            $this->bed_model->savebed($bed_data);
            $revert = $this->payment_model->revertBill($patient_id, $bill_id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Updated Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => 'Record Not Updated.');
        }
       echo json_encode($array);
    }

    public function deleteOPD() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_delete')) {
            access_denied();
        }
        $opdid = $this->input->post('opdid');
        if (!empty($opdid)) {
            $this->patient_model->deleteOPD($opdid);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Deleted Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function deletePatient() {
        if (!$this->rbac->hasPrivilege('patient', 'can_delete')) {
            access_denied();
        }
        $id = $this->input->post('delid');
        if (!empty($id)) {
            $this->patient_model->deletePatient($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Deleted Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function deleteOPDPatient() {
        if (!$this->rbac->hasPrivilege('opd_patient', 'can_delete')) {
            access_denied();
        }
        $id = $this->input->post('id');
        if (!empty($id)) {
            $this->patient_model->deleteOPDPatient($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Deleted Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function patientCredentialReport() {
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/patient/patientcredentialreport');
        $credential = $this->patient_model->patientCredentialReport();
        $data["credential"] = $credential;
        $this->load->view("layout/header");
        $this->load->view("admin/patient/patientcredentialreport", $data);
        $this->load->view("layout/footer");
    }

   

    public function deleteIpdPatient($id) {
        if (!empty($id)) {
            $this->patient_model->deleteIpdPatient($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Deleted Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function getBedStatus() {
        $floor_list = $this->floor_model->floor_list();
        $bedlist = $this->bed_model->bed_list();
        $bedactive = $this->bed_model->bed_active();
        $bedgroup_list = $this->bedgroup_model->bedGroupFloor();
        $data["floor_list"] = $floor_list;
        $data["bedlist"] = $bedlist;
        $data["bedgroup_list"] = $bedgroup_list;
        $data['bedactive'] = $bedactive;
        //print_r($bedactive);
        //exit();
        $this->load->view("layout/bedstatusmodal", $data);
    }

    public function updateBed() {
        $this->form_validation->set_rules('bedgroup', $this->lang->line('bed') . " " . $this->lang->line('group'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bedno', $this->lang->line('bed'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'bedgroup' => form_error('bedgroup'),
                'bedno' => form_error('bedno'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array(
                'ipd_no' => $this->input->post('ipd_no'),
                'bed_group_id' => $this->input->post('bedgroup'),
                'bed' => $this->input->post('bedno'),
            );
         
            $this->patient_model->updatebed($data);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function moveipd($id) {


        $appointment_details = $this->patient_model->getDetails($id);
        $patient_name = $appointment_details['patient_name'];
        $patient_id = $appointment_details['id'];
        $gender = $appointment_details['gender'];
        $email = $appointment_details['email'];
        $phone = $appointment_details['mobileno'];
        $doctor = $appointment_details['cons_doctor'];
        $note = $appointment_details['note'];
        $appointment_date = $appointment_details['appointment_date'];
        $amount = $appointment_details['amount'];
        $patient_data = array(
            'patient_id' => $patient_id,
            'patient_name' => $patient_name,
            'gender' => $gender,
            'email' => $email,
            'phone' => $phone,
            'appointment_date' => $appointment_date,
            'cons_doctor' => $doctor,
        );
        $data['ipd_data'] = $patient_data;
        //print_r($patient_data);
        //exit();       
        $updateData = array('id' => $patient_id, 'is_ipd' => 'yes');
        $this->appointment_model->update($updateData);
        $this->session->set_flashdata('ipd_data', $data);
        redirect("admin/patient/ipdsearch/");
    }

    public function deleteVisit($id) {
        $this->patient_model->deleteVisit($id);
        $json_array = array('status' => 'success',);
        echo json_encode($json_array);
    }

}
