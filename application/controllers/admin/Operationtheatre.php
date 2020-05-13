<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operationtheatre extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->config->load("mailsms");
        $this->notification = $this->config->item('notification');
        $this->notificationurl = $this->config->item('notification_url');
        $this->patient_notificationurl = $this->config->item('patient_notification_url');
        $this->config->load("image_valid");
        $this->load->library('Enc_lib');
        $this->load->library('mailsmsconf');
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->search_type = $this->config->item('search_type');
        $this->blood_group = $this->config->item('bloodgroup');
        $this->charge_type = $this->config->item('charge_type');
        $data["charge_type"] = $this->charge_type;
        $this->patient_login_prefix = "pat";
    }

    public function getBillDetails($id) {
       
        $data['id'] = $id;
        if (isset($_POST['print'])) {
            $data["print"] = 'yes';
        } else {
            $data["print"] = 'no';
        }
        $print_details = $this->printing_model->get('', 'ot');
        $data['print_details'] = $print_details;
        $result = $this->operationtheatre_model->getBillDetails($id);
        $data['result'] = $result;
        $detail = $this->operationtheatre_model->getAllBillDetails($id);
        $data['detail'] = $detail;
        $this->load->view('admin/operationtheatre/printBill', $data);
    }

    public function unauthorized() {
        $data = array();
        $this->load->view('layout/header', $data);
        $this->load->view('unauthorized', $data);
        $this->load->view('layout/footer', $data);
    }

    public function addpatient() {
        if (!$this->rbac->hasPrivilege('patient', 'can_add')) {
            access_denied();
        }
        // $patient_type = $this->customlib->getPatienttype();
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_upload', 'required');
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


            $patient_data = array(
                'patient_name' => $this->input->post('name'),
                'mobileno' => $this->input->post('contact'),
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
                'is_active' => 'yes',
            );
            $insert_id = $this->patient_model->add_patient($patient_data);
            $user_password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
            $data_patient_login = array(
                'username' => $this->patient_login_prefix . $insert_id,
                'password' => $user_password,
                'user_id' => $insert_id,
                'role' => 'patient'
            );
            $this->user_model->add($data_patient_login);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/patient_images/' . $img_name);
                $this->patient_model->add($data_img);
            }
        }
        echo json_encode($array);
    }

    public function handle_upload() {

        $image_validate = $this->config->item('file_validate');

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
                    $this->form_validation->set_message('handle_upload', 'File Extension Not Allowed');
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

    public function add() {
        if (!$this->rbac->hasPrivilege('ot_patient', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('date', $this->lang->line('operation') . " " . $this->lang->line('date'), 'required');

        $this->form_validation->set_rules('consultant_doctor', $this->lang->line('consultant') . " " . $this->lang->line('doctor'), 'required');
        $this->form_validation->set_rules('operation_name', $this->lang->line('operation') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('charge_category_id', $this->lang->line('charge') . " " . $this->lang->line('category'), 'required');
        $this->form_validation->set_rules('code', $this->lang->line('code'), 'required');
        $this->form_validation->set_rules('standard_charge', $this->lang->line('standard') . " " . $this->lang->line('charge'), 'required');
        $this->form_validation->set_rules('apply_charge', $this->lang->line('applied') . " " . $this->lang->line('charge'), 'required');
        $this->form_validation->set_rules('patient_id', $this->lang->line('patient'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'date' => form_error('date'),
                'operation_name' => form_error('operation_name'),
                'consultant_doctor' => form_error('consultant_doctor'),
                'charge_category_id' => form_error('charge_category_id'),
                'code' => form_error('code'),
                'standard_charge' => form_error('standard_charge'),
                'apply_charge' => form_error('apply_charge'),
                'patient_id' => form_error('patient_id'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $patientname = $this->input->post('patientname');


            $opd_ipd_patient_type = $this->input->post('opd_ipd_patient_type');
            $opd_ipd_no = $this->input->post('opd_ipd_no');
            if (($opd_ipd_patient_type != 'opd') && ($opd_ipd_patient_type != 'ipd')) {
                $check_patient_id = $this->patient_model->getMaxId();
                $patient_id = $check_patient_id + 1;
                $patient_data = array(
                    'patient_unique_id' => $patient_id,
                    'patient_type' => 'OT',
                    'organisation' => $this->input->post('organisation'),
                    'guardian_address' => $this->input->post('guardian_address'),
                    'is_active' => 'yes',
                );

                $patient_info = $this->input->post('patient_id');

                $bill_no = $this->operationtheatre_model->getMaxId();
                if (empty($bill_no)) {
                    $bill_no = 0;
                }
                $bill = $bill_no + 1;

                if ($patient_info) {

                    $date = $this->input->post("date");
                    $operation_detail = array(
                        'bill_no' => $bill,
                        'patient_id' => $patient_info,
                        'customer_type' => $this->input->post('customer_type'),
                        'operation_name' => $this->input->post('operation_name'),
                        'Date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($date)),
                        'operation_type' => $this->input->post('operation_type'),
                        'consultant_doctor' => $this->input->post('consultant_doctor'),
                        'ass_consultant_1' => $this->input->post('ass_consultant_1'),
                        'ass_consultant_2' => $this->input->post('ass_consultant_2'),
                        'anesthetist' => $this->input->post('anesthetist'),
                        'anaethesia_type' => $this->input->post('anaethesia_type'),
                        'ot_technician' => $this->input->post('ot_technician'),
                        'ot_assistant' => $this->input->post('ot_assistant'),
                        'charge_id' => $this->input->post('code'),
                        'result' => $this->input->post('result'),
                        'remark' => $this->input->post('note'),
                        'height' => $this->input->post('height'),
                        'weight' => $this->input->post('weight'),
                        'bp' => $this->input->post('bp'),
                        'symptoms' => $this->input->post('symptoms'),
                        'generated_by' => $this->session->userdata('hospitaladmin')['id'],
                        'apply_charge' => $this->input->post('apply_charge')
                    );
                    $insert_id = $this->operationtheatre_model->operation_detail($operation_detail);
                }
            } else {
                $patient_id = $this->input->post('patient_id');
                $date = $this->input->post("date");

                $operation_detail = array(
                    'bill_no' => $bill,
                    'patient_id' => $patient_id,
                    'customer_type' => $this->input->post('customer_type'),
                    'operation_name' => $this->input->post('operation_name'),
                    'Date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($date)),
                    'operation_type' => $this->input->post('operation_type'),
                    'consultant_doctor' => $this->input->post('consultant_doctor'),
                    'ass_consultant_1' => $this->input->post('ass_consultant_1'),
                    'ass_consultant_2' => $this->input->post('ass_consultant_2'),
                    'anesthetist' => $this->input->post('anesthetist'),
                    'anaethesia_type' => $this->input->post('anaethesia_type'),
                    'ot_technician' => $this->input->post('ot_technician'),
                    'ot_assistant' => $this->input->post('ot_assistant'),
                    'charge_id' => $this->input->post('code'),
                    'result' => $this->input->post('result'),
                    'remark' => $this->input->post('remark'),
                    'apply_charge' => $this->input->post('apply_charge')
                );
                $insert_id = $this->operationtheatre_model->operation_detail($operation_detail);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'), 'id' => $insert_id);

            $notificationurl = $this->notificationurl;
            $url_link = $notificationurl["ot"];
            $url = base_url() . $url_link . '/' . $insert_id . '/' . $patient_info;
            $this->otNotification($this->input->post('patient_id'), $this->input->post('consultant_doctor'), $patientname, $url);
        }

        echo json_encode($array);
    }

    public function otNotification($patient_id = '', $doctor_id, $patientname, $url) {
        $notification = $this->notification;
        $notification_desc = $notification["ot_created"];
        $desc = str_replace(array('<patient>', '<url>'), array($patientname, $url), $notification_desc);
        $patient_url = $this->patient_notificationurl['ot'];
        $patient_desc = str_replace(array('<patient>', '<url>'), array($patientname, base_url() . $patient_url), $notification_desc);

        if (!empty($patient_id)) {
            $notification_data = array('notification_title' => 'Operation Theatre Visit Created',
                'notification_desc' => $patient_desc,
                'notification_for' => 'Patient',
                'notification_type' => 'ot',
                'receiver_id' => $patient_id,
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );

            $admin_notification_data = array('notification_title' => 'Operation Theatre Visit Created',
                'notification_desc' => $desc,
                'notification_for' => 'Super Admin',
                'notification_type' => 'ot',
                'receiver_id' => '',
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );

            $this->notification_model->addSystemNotification($notification_data);
            $this->notification_model->addSystemNotification($admin_notification_data);
        }

        if (!empty($doctor_id)) {

            $notification_data = array('notification_title' => 'Operation Theatre Visit Created',
                'notification_desc' => $desc,
                'notification_for' => 'Doctor',
                'notification_type' => 'ot',
                'receiver_id' => $doctor_id,
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );
            $this->notification_model->addSystemNotification($notification_data);
        }
    }

    public function otsearch($id = '') {
        if (!$this->rbac->hasPrivilege('ot_patient', 'can_view')) {
            access_denied();
        }

        $ot_data = $this->session->flashdata('ot_data');
        $data['ot_data'] = $ot_data;

        $this->session->set_userdata('top_menu', 'operation_theatre');
        if (!empty($id)) {
            $data["id"] = $id;
        }

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
        $data['charge_category'] = $this->operationtheatre_model->getChargeCategory();
        $data['resultlist'] = $this->operationtheatre_model->searchFullText();
        $data['organisation'] = $this->organisation_model->get();
        $this->load->view('layout/header');
        $this->load->view('admin/operationtheatre/otsearch.php', $data);
        $this->load->view('layout/footer');
    }

    public function getDetails() {
        if (!$this->rbac->hasPrivilege('ot_patient', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("patient_id");
        $result = $this->operationtheatre_model->getDetails($id);
        if (($result['patient_type'] == 'Inpatient') || ($result['patient_type'] == 'Outpatient')) {
            $opd_ipd_no = $this->operationtheatre_model->getopdipdDetails($id, $result['patient_type']);
            $result['opd_ipd_no'] = $opd_ipd_no;
        }
        $result['admission_date'] = date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['admission_date']));
        $result['date'] = date($this->customlib->getSchoolDateFormat(true, false), strtotime($result['date']));

        echo json_encode($result);
    }

    public function getotDetails($id) {
        if (!$this->rbac->hasPrivilege('ot_patient', 'can_view')) {
            access_denied();
        }

        $result = $this->operationtheatre_model->getotDetails($id);

        echo json_encode($result);
    }

    public function getOtPatientDetails() {
        if (!$this->rbac->hasPrivilege('ot_patient', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $result = $this->operationtheatre_model->getOtPatientDetails($id);
        $result['admission_date'] = date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['admission_date']));
        $result['date'] = date($this->customlib->getSchoolDateFormat(true, false), strtotime($result['date']));
        $result['dob'] = date($this->customlib->getSchoolDateFormat(true, false), strtotime($result['dob']));
        echo json_encode($result);
    }

    public function update() {
        if (!$this->rbac->hasPrivilege('ot_patient', 'can_edit')) {
            access_denied();
        }

        $this->form_validation->set_rules('operation_name', $this->lang->line('operation') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('consultant_doctor', $this->lang->line('consultant') . " " . $this->lang->line('doctor'), 'required');
        $this->form_validation->set_rules('charge_category_id', $this->lang->line('charge') . " " . $this->lang->line('category'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'patient_name' => form_error('patient_name'),
                'date' => form_error('date'),
                'operation_name' => form_error('operation_name'),
                'consultant_doctor' => form_error('consultant_doctor'),
                'charge_category_id' => form_error('charge_category_id'),
                'charge_category_id' => form_error('apply_charge'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('patientid');

            $charge_category_id = $this->input->post('charge_category_id');
            $date = $this->input->post("date");
            $otid = $this->input->post('otid');
            $operation_detail = array(
                'id' => $otid,
                'patient_id' => $id,
                'operation_name' => $this->input->post('operation_name'),
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($date)),
                'operation_type' => $this->input->post('operation_type'),
                'consultant_doctor' => $this->input->post('consultant_doctor'),
                'ass_consultant_1' => $this->input->post('ass_consultant_1'),
                'ass_consultant_2' => $this->input->post('ass_consultant_2'),
                'anesthetist' => $this->input->post('anesthetist'),
                'anaethesia_type' => $this->input->post('anaethesia_type'),
                'ot_technician' => $this->input->post('ot_technician'),
                'ot_assistant' => $this->input->post('ot_assistant'),
                'charge_id' => $charge_category_id,
                'result' => $this->input->post('result'),
                'remark' => $this->input->post('note'),
                'height' => $this->input->post('height'),
                'weight' => $this->input->post('weight'),
                'bp' => $this->input->post('bp'),
                'symptoms' => $this->input->post('symptoms'),
                'apply_charge' => $this->input->post('apply_charge'),
            );
            $this->operationtheatre_model->update_operation_detail($operation_detail);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('ot_patient', 'can_delete')) {
            access_denied();
        }
        if (!empty($id)) {
            $this->operationtheatre_model->delete($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record deleted Successfully');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function add_ot_consultant_instruction() {
        if (!$this->rbac->hasPrivilege('ot_consultant_instruction', 'can_add')) {
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
                'insdate' => form_error('insdate[]'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $date = $this->input->post('date[]');
            $ins_date = $this->input->post('insdate[]');

            $patient_id = $this->input->post('patient_id');
            $doctor = $this->input->post('doctor[]');
            $instruction = $this->input->post('instruction[]');
            $data = array();
            $i = 0;
            foreach ($date as $key => $value) {


                $details = array(
                    'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($date[$i])),
                    'patient_id' => $patient_id,
                    'ins_date' => date('Y-m-d', $this->customlib->datetostrtotime($ins_date[$i])),
                    'cons_doctor' => $doctor[$i],
                    'instruction' => $instruction[$i],
                );
                $data[] = $details;
                $i++;
            }
            $this->operationtheatre_model->add_ot_consultantInstruction($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getConsultantBatch() {
        // if (!$this->rbac->hasPrivilege('ot_consultant_instruction', 'can_view')) {
        //     access_denied();
        // }
        $id = $this->input->post("patient_id");
        $data["id"] = $id;
        $result = $this->operationtheatre_model->getConsultantBatch($id);
        $data["result"] = $result;
        $this->load->view('admin/operationtheatre/patientConsultantDetail', $data);
    }

    public function OtReport() {
        if (!$this->rbac->hasPrivilege('ot_patient', 'can_view')) {
            access_denied();
        }
        $doctorlist = $this->staff_model->getEmployeeByRoleID(3);
        $data['doctorlist'] = $doctorlist;

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/operationtheatre/otreport');
        $select = 'operation_theatre.*,patients.id as pid,patients.patient_unique_id,patients.patient_name,patients.gender,staff.name,staff.surname,charges.id as cid,charges.charge_category,charges.code,charges.description,charges.standard_charge';
        $join = array(
            'JOIN patients ON operation_theatre.patient_id=patients.id',
            'JOIN staff ON staff.id = operation_theatre.consultant_doctor',
            'JOIN charges ON operation_theatre.charge_id = charges.id'
        );
        $where = array(
            "patients.is_active = 'yes' ",
            "operation_theatre.patient_id = patients.id "
        );

        $doctorid = $this->input->post('doctor');

        if (!empty($doctorid)) {
            $where = array("patients.is_active = 'yes' ",
                "operation_theatre.patient_id = patients.id ",
                "operation_theatre.consultant_doctor =" . $doctorid);
        }
        $table_name = "operation_theatre";
        $disable_option = FALSE;
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata['role_id'];
        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {

                $user_id = $userdata["id"];
                $doctorid = $user_id;
                $where = array("patients.is_active = 'yes' ",
                    "operation_theatre.patient_id = patients.id ",
                    "operation_theatre.consultant_doctor =" . $doctorid);
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

            $search_table = "operation_theatre";
            $search_column = "date";
            $resultlist = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column, $where);
        }



        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data["resultlist"] = $resultlist;
        $this->load->view('layout/header');
        $this->load->view('admin/operationtheatre/otReport.php', $data);
        $this->load->view('layout/footer');
    }

    public function deleteConsultant($id) {
        if (!empty($id)) {
            $this->operationtheatre_model->deleteConsultant($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record deleted Successfully');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

}
