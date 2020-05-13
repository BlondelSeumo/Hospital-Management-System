<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Staff extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->load->library('mailsmsconf');

        $this->contract_type = $this->config->item('contracttype');
        $this->marital_status = $this->config->item('staff_marital_status');
        $this->staff_attendance = $this->config->item('staffattendance');
        $this->payroll_status = $this->config->item('payroll_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->status = $this->config->item('status');
        $this->blood_group = $this->config->item('staff_bloodgroup');
        $this->config->load('image_valid');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('staff', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Staff Search';

        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/staff');
        $search = $this->input->post("search");
        $resultlist = $this->staff_model->searchFullText("", 1);
        $data['resultlist'] = $resultlist;


        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data["role_id"] = "";

        $search_text = $this->input->post('search_text');
        if (isset($search)) {
            if ($search == 'search_filter') {
                $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {

                    $data["resultlist"] = array();
                } else {
                    $data['searchby'] = "filter";
                    $role = $this->input->post('role');
                    $data['employee_id'] = $this->input->post('empid');
                    $data["role_id"] = $role;
                    $data['search_text'] = $this->input->post('search_text');
                    $resultlist = $this->staff_model->getEmployee($role, 1);
                    $data['resultlist'] = $resultlist;
                }
            } else if ($search == 'search_full') {
                $data['searchby'] = "text";



                $data['search_text'] = trim($this->input->post('search_text'));

                $resultlist = $this->staff_model->searchFullText($search_text, 1);

                $data['resultlist'] = $resultlist;
                $data['title'] = 'Search Details: ' . $data['search_text'];
            }
        }
        //echo "<pre>"; print_r($data); echo "<pre>";die;
        $this->load->view('layout/header');
        $this->load->view('admin/staff/staffsearch', $data);
        $this->load->view('layout/footer');
    }

    function server_data() {


        $columns = array(
            0 => 'employee_id',
            1 => 'name',
            2 => 'user_type',
            3 => 'department',
            4 => 'designation',
            5 => 'contact_no',
        );

        $limit = 2;

        $start = $this->input->post('start');
        if (empty($start)) {

            $start = 0;
        }

        $order = 'staff.' . $columns[1];
        $dir = 'asc';
        $totalData = 4;
        $totalFiltered = $totalData;



        $posts = $this->staff_model->searchFullText("", 1, $order, $dir, $limit, $start);




        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {

                $nestedData['employee_id'] = $post["employee_id"];
                $nestedData['name'] = $post["name"];
                $nestedData['user_type'] = $post["user_type"];
                ;
                $nestedData['department'] = $post["department"];
                $nestedData['designation'] = $post["designation"];
                $nestedData['contact_no'] = $post["contact_no"];
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => 1,
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => 4,
            "data" => $data
        );

        echo json_encode($json_data);
    }

    function disablestafflist() {

        if (!$this->rbac->hasPrivilege('disable_staff', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/staff/disablestafflist');
        $data['title'] = 'Staff Search';
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;

        $search = $this->input->post("search");
        $search_text = $this->input->post('search_text');
        $resultlist = $this->staff_model->searchFullText($search_text, 0);
        $data['resultlist'] = $resultlist;

        if (isset($search)) {
            if ($search == 'search_filter') {
                $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {

                    $resultlist = array();
                    $data['resultlist'] = $resultlist;
                } else {
                    $data['searchby'] = "filter";
                    $role = $this->input->post('role');
                    $data['employee_id'] = $this->input->post('empid');

                    $data['search_text'] = $this->input->post('search_text');
                    $resultlist = $this->staff_model->getEmployee($role, 0);
                    $data['resultlist'] = $resultlist;
                }
            } else if ($search == 'search_full') {
                $data['searchby'] = "text";
                $data['search_text'] = trim($this->input->post('search_text'));
                $resultlist = $this->staff_model->searchFullText($search_text, 0);
                $data['resultlist'] = $resultlist;
                $data['title'] = 'Search Details: ' . $data['search_text'];
            }
        }
        $this->load->view('layout/header', $data);
        $this->load->view('admin/staff/disablestaff', $data);
        $this->load->view('layout/footer', $data);
    }

    function profile($id) {
        if (!$this->rbac->hasPrivilege('staff', 'can_view')) {
            access_denied();
        }
         $data['enable_disable']=1;
        $staff_data = $this->session->flashdata('staff_data');
        $data['staff_data'] = $staff_data;


        $data["id"] = $id;
        $data['title'] = 'Staff Details';
        $staff_info = $this->staff_model->getProfile($id);
        $userdata = $this->customlib->getUserData();
        $userid = $userdata['id'];
        $timeline_status = '';
        if ($userid == $id) {
            $data['enable_disable']=0;
            $timeline_status = 'yes';
        }
        $timeline_list = $this->timeline_model->getStaffTimeline($id, $timeline_status);
        $data["timeline_list"] = $timeline_list;
        $staff_payroll = $this->staff_model->getStaffPayroll($id);
        $staff_leaves = $this->leaverequest_model->staff_leave_request($id);
        $alloted_leavetype = $this->staff_model->allotedLeaveType($id);

        $salary = $this->payroll_model->getSalaryDetails($id);
        $attendencetypes = $this->staffattendancemodel->getStaffAttendanceType();
        $data['attendencetypeslist'] = $attendencetypes;
        $i = 0;
        $leaveDetail = array();
        foreach ($alloted_leavetype as $key => $value) {
            $count_leaves[] = $this->leaverequest_model->countLeavesData($id, $value["leave_type_id"]);
            $leaveDetail[$i]['type'] = $value["type"];
            $leaveDetail[$i]['alloted_leave'] = $value["alloted_leave"];
            $leaveDetail[$i]['approve_leave'] = $count_leaves[$i]['approve_leave'];
            $i++;
        }
        $data["leavedetails"] = $leaveDetail;
        $data["staff_leaves"] = $staff_leaves;
        $data['staff_doc_id'] = $id;
        $data['staff'] = $staff_info;
        $data['staff_payroll'] = $staff_payroll;
        $data['salary'] = $salary;

        $monthlist = $this->customlib->getMonthDropdown();
        $startMonth = $this->setting_model->getStartMonth();
        $data["monthlist"] = $monthlist;
        $data['yearlist'] = $this->staffattendancemodel->attendanceYearCount();

        $year = date("Y");

        $j = 0;
        for ($n = 1; $n <= 31; $n++) {

            $att_date = sprintf("%02d", $n);

            $attendence_array[] = $att_date;

            foreach ($monthlist as $key => $value) {

                $datemonth = date("m", strtotime($value));
                $att_dates = $year . "-" . $datemonth . "-" . sprintf("%02d", $n);
                $date_array[] = $att_dates;
                $res[$att_dates] = $this->staffattendancemodel->searchStaffattendance($id, $att_dates);
            }

            $j++;
        }

        $session = $this->setting_model->getCurrentSessionName();

        $session_start = explode("-", $session);
        $start_year = $session_start[0];

        $date = $start_year . "-" . $startMonth;
        $newdate = date("Y-m-d", strtotime($date . "+1 month"));

        $countAttendance = $this->countAttendance($start_year, $startMonth, $id);
        $data["countAttendance"] = $countAttendance;

        $data["resultlist"] = $res;
        $data["attendence_array"] = $attendence_array;
        $data["date_array"] = $date_array;
        $data["payroll_status"] = $this->payroll_status;
        $data["payment_mode"] = $this->payment_mode;
        $data["contract_type"] = $this->contract_type;
        $data["status"] = $this->status;
        $roles = $this->role_model->get();
        $data["roles"] = $roles;

        $stafflist = $this->staff_model->get();
        $data['stafflist'] = $stafflist;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/staff/staffprofile', $data);
        $this->load->view('layout/footer', $data);
    }

    function countAttendance($st_month, $no_of_months, $emp) {

        $record = array();
        for ($i = 1; $i <= 1; $i++) {

            $r = array();
            $month = date('m', strtotime($st_month . " -$i month"));
            $year = date('Y', strtotime($st_month . " -$i month"));

            foreach ($this->staff_attendance as $att_key => $att_value) {

                $s = $this->staff_model->count_attendance($year, $emp, $att_value);


                $r[$att_key] = $s;
            }

            $record[$year] = $r;
        }

        return $record;
    }

    function getSession() {
        $session = $this->session_model->getAllSession();
        $data = array();
        $session_array = $this->session->has_userdata('session_array');
        $data['sessionData'] = array('session_id' => 0);
        if ($session_array) {
            $data['sessionData'] = $this->session->userdata('session_array');
        } else {
            $setting = $this->setting_model->get();

            $data['sessionData'] = array('session_id' => $setting[0]['session_id']);
        }
        $data['sessionList'] = $session;

        return $data;
    }

    public function getSessionMonthDropdown() {
        $startMonth = $this->setting_model->getStartMonth();
        $array = array();
        for ($m = $startMonth; $m <= $startMonth + 11; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $array[$month] = $month;
        }
        return $array;
    }

    public function download($staff_id, $doc) {

        $this->load->helper('download');
        $filepath = "./uploads/staff_documents/$staff_id/" . $this->uri->segment(5);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(5);

        force_download($name, $data);
    }

    function doc_delete($id, $doc, $file) {
        $this->staff_model->doc_delete($id, $doc, $file);
        $this->session->set_flashdata('msg', '<i class="fa fa-check-square-o" aria-hidden="true"></i> Document Deleted Successfully');
        redirect('admin/staff/profile/' . $id);
    }

    function ajax_attendance($id) {

        $attendencetypes = $this->staffattendancemodel->getStaffAttendanceType();
        $data['attendencetypeslist'] = $attendencetypes;
        $year = $this->input->post("year");
        if (!empty($year)) {

            $monthlist = $this->customlib->getMonthDropdown();
            $startMonth = $this->setting_model->getStartMonth();
            $data["monthlist"] = $monthlist;
            $data['yearlist'] = $this->staffattendancemodel->attendanceYearCount();
            $session_current = $this->setting_model->getCurrentSessionName();
            $startMonth = $this->setting_model->getStartMonth();


            $j = 0;
            for ($n = 1; $n <= 31; $n++) {

                $att_date = sprintf("%02d", $n);

                $attendence_array[] = $att_date;

                foreach ($monthlist as $key => $value) {

                    $datemonth = date("m", strtotime($value));
                    $att_dates = $year . "-" . $datemonth . "-" . sprintf("%02d", $n);
                    $date_array[] = $att_dates;
                    $res[$att_dates] = $this->staffattendancemodel->searchStaffattendance($id, $att_dates);
                }

                $j++;
            }



            $date = $year . "-" . $startMonth;
            $newdate = date("Y-m-d", strtotime($date . "+1 month"));

            $countAttendance = $this->countAttendance($year, $startMonth, $id);
            $data["countAttendance"] = $countAttendance;
            $data["id"] = $id;
            $data["resultlist"] = $res;
            $data["attendence_array"] = $attendence_array;
            $data["date_array"] = $date_array;

            $this->load->view("admin/staff/ajaxattendance", $data);
        } else {

            echo "No Record Found";
        }
    }

    function create() {

        $image_validate = $this->config->item('image_validate');

        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/staff');
        $roles = $this->role_model->get();
        $data["roles"] = $roles;
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $payscaleList = $this->staff_model->getPayroll();
        $leavetypeList = $this->staff_model->getLeaveType();
        $data["leavetypeList"] = $leavetypeList;
        $data["payscaleList"] = $payscaleList;
        $designation = $this->staff_model->getStaffDesignation();
        $data["designation"] = $designation;
        $department = $this->staff_model->getDepartment();
        $data["department"] = $department;
        $marital_status = $this->marital_status;
        $data["marital_status"] = $marital_status;
        $data["bloodgroup"] = $this->blood_group;
        $data['title'] = 'Add Staff';
        $data["contract_type"] = $this->contract_type;
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', $this->lang->line('date_of_birth'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('email'), array('required', 'valid_email',
            array('check_exists', array($this->staff_model, 'valid_email_id'))
                )
        );
        $this->form_validation->set_rules('employee_id', $this->lang->line('staff') . " " . $this->lang->line('id'), array('required',
            array('check_exists', array($this->staff_model, 'valid_employee_id'))
                )
        );
        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_upload');


        if ($this->form_validation->run() == FALSE) {

            $this->load->view('layout/header', $data);
            $this->load->view('admin/staff/staffcreate', $data);
            $this->load->view('layout/footer', $data);
        } else {


            $employee_id = $this->input->post("employee_id");
            $department = $this->input->post("department");
            $designation = $this->input->post("designation");
            $role = $this->input->post("role");
            $name = $this->input->post("name");
            $gender = $this->input->post("gender");
            $marital_status = $this->input->post("marital_status");
            $dob = $this->input->post("dob");
            if (!empty($dob)) {
                $insert_dob = date('Y-m-d', $this->customlib->datetostrtotime($dob));
            }
            $contact_no = $this->input->post("contactno");
            $emergency_no = $this->input->post("contactno");
            $email = $this->input->post("email");
            $date_of_joining = $this->input->post("date_of_joining");
            if (!empty($date_of_joining)) {
                $insert_date_of_joining = date('Y-m-d', $this->customlib->datetostrtotime($date_of_joining));
            } else {
                $insert_date_of_joining = "";
            }

            $date_of_leaving = $this->input->post("date_of_leaving");
            $address = $this->input->post("address");
            $qualification = $this->input->post("qualification");
            $work_exp = $this->input->post("work_exp");
            $basic_salary = $this->input->post('basic_salary');
            $account_title = $this->input->post("account_title");
            $bank_account_no = $this->input->post("bank_account_no");
            $bank_name = $this->input->post("bank_name");
            $ifsc_code = $this->input->post("ifsc_code");
            $bank_branch = $this->input->post("bank_branch");
            $contract_type = $this->input->post("contract_type");
            $shift = $this->input->post("shift");
            $location = $this->input->post("location");
            $leave = $this->input->post("leave");
            $facebook = $this->input->post("facebook");
            $twitter = $this->input->post("twitter");
            $linkedin = $this->input->post("linkedin");
            $instagram = $this->input->post("instagram");
            $permanent_address = $this->input->post("permanent_address");
            $father_name = $this->input->post("father_name");
            $surname = $this->input->post("surname");
            $mother_name = $this->input->post("mother_name");
            $specialization = $this->input->post("specialization");
            $note = $this->input->post("note");
            $epf_no = $this->input->post("epf_no");
            $blood_group = $this->input->post("blood_group");

            $password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
            $data_insert = array(
                'password' => $this->enc_lib->passHashEnc($password),
                'employee_id' => $employee_id,
                'department' => $department,
                'designation' => $designation,
                'qualification' => $qualification,
                'work_exp' => $work_exp,
                'name' => $name,
                'contact_no' => $contact_no,
                'emergency_contact_no' => $emergency_no,
                'email' => $email,
                'dob' => $insert_dob,
                'marital_status' => $marital_status,
                'date_of_joining' => $insert_date_of_joining,
                'date_of_leaving' => '',
                'local_address' => $address,
                'permanent_address' => $permanent_address,
                'note' => $note,
                'surname' => $surname,
                'mother_name' => $mother_name,
                'father_name' => $father_name,
                'gender' => $gender,
                'account_title' => $account_title,
                'bank_account_no' => $bank_account_no,
                'bank_name' => $bank_name,
                'ifsc_code' => $ifsc_code,
                'bank_branch' => $bank_branch,
                'payscale' => '',
                'basic_salary' => $basic_salary,
                'epf_no' => $epf_no,
                'contract_type' => $contract_type,
                'blood_group' => $blood_group,
                'shift' => $shift,
                'location' => $location,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'linkedin' => $linkedin,
                'instagram' => $instagram,
                'specialization' => $specialization,
                'is_active' => 1
            );
            $leave_type = $this->input->post('leave_type');
            $leave_array = array();
            if (!empty($leave_type)) {
                foreach ($leave_type as $leave_key => $leave_value) {
                    $leave_array[] = array(
                        'staff_id' => 0,
                        'leave_type_id' => $leave_value,
                        'alloted_leave' => $this->input->post('alloted_leave_' . $leave_value)
                    );
                }
            }

            $role_array = array('role_id' => $this->input->post('role'), 'staff_id' => 0);
            $insert_id = $this->staff_model->batchInsert($data_insert, $role_array, $leave_array);
            $staff_id = $insert_id;

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {


                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/staff_images/" . $img_name);
                $data_img = array('id' => $staff_id, 'image' => $img_name);
                $this->staff_model->add($data_img);
            }

            if (isset($_FILES["first_doc"]) && !empty($_FILES['first_doc']['name'])) {
                $uploaddir = './uploads/staff_documents/' . $staff_id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["first_doc"]["name"]);
                $first_title = 'resume';
                $resume = "resume" . $staff_id . '.' . $fileInfo['extension'];
                $img_name = $uploaddir . $resume;
                move_uploaded_file($_FILES["first_doc"]["tmp_name"], $img_name);
            } else {

                $resume = "";
            }

            if (isset($_FILES["second_doc"]) && !empty($_FILES['second_doc']['name'])) {
                $uploaddir = './uploads/staff_documents/' . $insert_id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["second_doc"]["name"]);
                $first_title = 'joining_letter';
                $joining_letter = "joining_letter" . $staff_id . '.' . $fileInfo['extension'];
                $img_name = $uploaddir . $joining_letter;
                move_uploaded_file($_FILES["second_doc"]["tmp_name"], $img_name);
            } else {

                $joining_letter = "";
            }

            if (isset($_FILES["third_doc"]) && !empty($_FILES['third_doc']['name'])) {
                $uploaddir = './uploads/staff_documents/' . $insert_id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["third_doc"]["name"]);
                $first_title = 'resignation_letter';
                $resignation_letter = "resignation_letter" . $staff_id . '.' . $fileInfo['extension'];
                $img_name = $uploaddir . $resignation_letter;
                move_uploaded_file($_FILES["third_doc"]["tmp_name"], $img_name);
            } else {

                $resignation_letter = "";
            }
            if (isset($_FILES["fourth_doc"]) && !empty($_FILES['fourth_doc']['name'])) {
                $uploaddir = './uploads/staff_documents/' . $insert_id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["fourth_doc"]["name"]);
                $fourth_title = 'Other Doucment';
                $fourth_doc = "otherdocument" . $staff_id . '.' . $fileInfo['extension'];
                $img_name = $uploaddir . $fourth_doc;
                move_uploaded_file($_FILES["fourth_doc"]["tmp_name"], $img_name);
            } else {
                $fourth_title = "";
                $fourth_doc = "";
            }


            $data_doc = array('id' => $staff_id, 'resume' => $resume, 'joining_letter' => $joining_letter, 'resignation_letter' => $resignation_letter, 'other_document_name' => $fourth_title, 'other_document_file' => $fourth_doc);
            $this->staff_model->add($data_doc);

            //===================
            if ($staff_id) {

                $teacher_login_detail = array('id' => $staff_id, 'credential_for' => 'staff', 'username' => $email, 'password' => $password, 'contact_no' => $contact_no, 'email' => $email);

                $this->mailsmsconf->mailsms('login_credential', $teacher_login_detail);
            }

            //==========================

            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');

            redirect('admin/staff');
        }
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
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array(strtolower($ext), $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('staff', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Staff';
        $data['id'] = $id;
        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $payscaleList = $this->staff_model->getPayroll();
        $leavetypeList = $this->staff_model->getLeaveType();
        $data["leavetypeList"] = $leavetypeList;
        $data["payscaleList"] = $payscaleList;
        $staffRole = $this->staff_model->getStaffRole();
        $data["getStaffRole"] = $staffRole;
        $designation = $this->staff_model->getStaffDesignation();
        $data["designation"] = $designation;
        $department = $this->staff_model->getDepartment();
        $data["department"] = $department;
        $data["bloodgroup"] = $this->blood_group;
        $marital_status = $this->marital_status;
        $data["marital_status"] = $marital_status;
        $data['title'] = 'Edit Staff';
        $staff = $this->staff_model->get($id);
        $data['staff'] = $staff;
        $data["contract_type"] = $this->contract_type;

        $staffLeaveDetails = $this->staff_model->getLeaveDetails($id);
        $data['staffLeaveDetails'] = $staffLeaveDetails;


        $resume = $this->input->post("resume");
        $joining_letter = $this->input->post("joining_letter");
        $resignation_letter = $this->input->post("resignation_letter");
        $other_document_name = $this->input->post("other_document_name");
        $other_document_file = $this->input->post("other_document_file");

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', $this->lang->line('date_of_birth'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_upload');
        $this->form_validation->set_rules(
                'email', $this->lang->line('email'), array('required', 'valid_email',
            array('check_exists', array($this->staff_model, 'valid_email_id'))
                )
        );
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('layout/header', $data);
            $this->load->view('admin/staff/staffedit', $data);
            $this->load->view('layout/footer', $data);
        } else {

            $employee_id = $this->input->post("employee_id");
            $department = $this->input->post("department");
            $designation = $this->input->post("designation");
            $role = $this->input->post("role");
            $name = $this->input->post("name");
            $gender = $this->input->post("gender");
            $marital_status = $this->input->post("marital_status");
            $dob = $this->input->post("dob");
            $contact_no = $this->input->post("contactno");
            $emergency_no = $this->input->post("emergency_no");
            $email = $this->input->post("email");
            $date_of_joining = $this->input->post("date_of_joining");
            $date_of_leaving = $this->input->post("date_of_leaving");
            if (!empty($this->input->post("date_of_leaving"))) {
                $date_of_leaving = date("Y-m-d", strtotime($this->input->post("date_of_leaving")));
            } else {
                $date_of_leaving = '';
            }
            $address = $this->input->post("address");
            $qualification = $this->input->post("qualification");
            $work_exp = $this->input->post("work_exp");

            $basic_salary = $this->input->post('basic_salary');
            $account_title = $this->input->post("account_title");
            $bank_account_no = $this->input->post("bank_account_no");
            $bank_name = $this->input->post("bank_name");
            $ifsc_code = $this->input->post("ifsc_code");
            $bank_branch = $this->input->post("bank_branch");
            $contract_type = $this->input->post("contract_type");
            $shift = $this->input->post("shift");
            $location = $this->input->post("location");
            $leave = $this->input->post("leave");
            $facebook = $this->input->post("facebook");
            $twitter = $this->input->post("twitter");
            $linkedin = $this->input->post("linkedin");
            $instagram = $this->input->post("instagram");
            $permanent_address = $this->input->post("permanent_address");
            $father_name = $this->input->post("father_name");
            $surname = $this->input->post("surname");
            $mother_name = $this->input->post("mother_name");
            $blood_group = $this->input->post("blood_group");
            $note = $this->input->post("note");
            $epf_no = $this->input->post("epf_no");
            $specialization = $this->input->post("specialization");



            $data1 = array('id' => $id,
                'employee_id' => $employee_id,
                'department' => $department,
                'designation' => $designation,
                'qualification' => $qualification,
                'work_exp' => $work_exp,
                'name' => $name,
                'contact_no' => $contact_no,
                'emergency_contact_no' => $emergency_no,
                'email' => $email,
                'dob' => date('Y-m-d', $this->customlib->datetostrtotime($dob)),
                'marital_status' => $marital_status,
                'date_of_joining' => date('Y-m-d', $this->customlib->datetostrtotime($date_of_joining)),
                'date_of_leaving' => $date_of_leaving,
                'local_address' => $address,
                'permanent_address' => $permanent_address,
                'note' => $note,
                'surname' => $surname,
                'mother_name' => $mother_name,
                'father_name' => $father_name,
                'gender' => $gender,
                'account_title' => $account_title,
                'bank_account_no' => $bank_account_no,
                'bank_name' => $bank_name,
                'ifsc_code' => $ifsc_code,
                'bank_branch' => $bank_branch,
                'payscale' => '',
                'basic_salary' => $basic_salary,
                'epf_no' => $epf_no,
                'contract_type' => $contract_type,
                'specialization' => $specialization,
                'blood_group' => $blood_group,
                'shift' => $shift,
                'location' => $location,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'linkedin' => $linkedin,
                'instagram' => $instagram,
            );
            $insert_id = $this->staff_model->add($data1);

            $role_id = $this->input->post("role");

            $role_data = array('staff_id' => $id, 'role_id' => $role_id);

            $this->staff_model->update_role($role_data);

            $leave_type = $this->input->post("leave_type_id");

            $alloted_leave = $this->input->post("alloted_leave");
            $altid = $this->input->post("altid");
            if (!empty($leave_type)) {
                $i = 0;
                foreach ($leave_type as $key => $value) {

                    if (!empty($altid[$i])) {

                        $data2 = array('staff_id' => $id,
                            'leave_type_id' => $leave_type[$i],
                            'id' => $altid[$i],
                            'alloted_leave' => $alloted_leave[$i],
                        );
                    } else {

                        $data2 = array('staff_id' => $id,
                            'leave_type_id' => $leave_type[$i],
                            'alloted_leave' => $alloted_leave[$i],
                        );
                    }



                    $this->staff_model->add_staff_leave_details($data2);
                    $i++;
                }
            }

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/staff_images/" . $img_name);
                $data_img = array('id' => $id, 'image' => $img_name);
                $this->staff_model->add($data_img);
            }


            if (isset($_FILES["first_doc"]) && !empty($_FILES['first_doc']['name'])) {
                $uploaddir = './uploads/staff_documents/' . $id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["first_doc"]["name"]);
                $first_title = 'resume';
                $resume_doc = "resume" . $id . '.' . $fileInfo['extension'];
                $img_name = $uploaddir . $resume_doc;
                move_uploaded_file($_FILES["first_doc"]["tmp_name"], $img_name);
            } else {

                $resume_doc = $resume;
            }

            if (isset($_FILES["second_doc"]) && !empty($_FILES['second_doc']['name'])) {
                $uploaddir = './uploads/staff_documents/' . $id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["second_doc"]["name"]);
                $first_title = 'joining_letter';
                $joining_letter_doc = "joining_letter" . $id . '.' . $fileInfo['extension'];
                $img_name = $uploaddir . $joining_letter_doc;
                move_uploaded_file($_FILES["second_doc"]["tmp_name"], $img_name);
            } else {

                $joining_letter_doc = $joining_letter;
            }

            if (isset($_FILES["third_doc"]) && !empty($_FILES['third_doc']['name'])) {
                $uploaddir = './uploads/staff_documents/' . $id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["third_doc"]["name"]);
                $first_title = 'resignation_letter';
                $resignation_letter_doc = "resignation_letter" . $id . '.' . $fileInfo['extension'];
                $img_name = $uploaddir . $resignation_letter_doc;
                move_uploaded_file($_FILES["third_doc"]["tmp_name"], $img_name);
            } else {

                $resignation_letter_doc = $resignation_letter;
            }
            if (isset($_FILES["fourth_doc"]) && !empty($_FILES['fourth_doc']['name'])) {
                $uploaddir = './uploads/staff_documents/' . $id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["fourth_doc"]["name"]);
                $fourth_title = 'Other Doucment';
                $fourth_doc = "otherdocument" . $id . '.' . $fileInfo['extension'];
                $img_name = $uploaddir . $fourth_doc;
                move_uploaded_file($_FILES["fourth_doc"]["tmp_name"], $img_name);
            } else {
                $fourth_title = 'Other Document';
                $fourth_doc = $other_document_file;
            }

            $data_doc = array('id' => $id, 'resume' => $resume_doc, 'joining_letter' => $joining_letter_doc, 'resignation_letter' => $resignation_letter_doc, 'other_document_name' => $fourth_title, 'other_document_file' => $fourth_doc);

            $this->staff_model->add($data_doc);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/staff/edit/' . $id);
        }
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('staff', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Staff List';
        $this->staff_model->remove($id);
        redirect('admin/staff');
    }

    function disablestaff($id) {
        if (!$this->rbac->hasPrivilege('disable_staff', 'can_view')) {

            access_denied();
        }
        $this->staff_model->disablestaff($id);
        redirect('admin/staff/profile/' . $id);
    }

    function enablestaff($id) {
        $this->staff_model->enablestaff($id);
        redirect('admin/staff/profile/' . $id);
    }

    function staffLeaveSummary() {

        $resultdata = $this->staff_model->getLeaveSummary();
        $data["resultdata"] = $resultdata;


        $this->load->view("layout/header");
        $this->load->view("admin/staff/staff_leave_summary", $data);
        $this->load->view("layout/footer");
    }

    function getEmployeeByRole() {

        $role = $this->input->post("role");

        $data = $this->staff_model->getEmployee($role);

        echo json_encode($data);
    }

    function dateDifference($date_1, $date_2, $differenceFormat = '%a') {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat) + 1;
    }

    function permission($id) {
        $data['title'] = 'Add Role';
        $data['id'] = $id;
        $staff = $this->staff_model->get($id);
        $data['staff'] = $staff;
        $userpermission = $this->userpermission_model->getUserPermission($id);
        $data['userpermission'] = $userpermission;

        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $staff_id = $this->input->post('staff_id');
            $prev_array = $this->input->post('prev_array');
            if (!isset($prev_array)) {
                $prev_array = array();
                ;
            }
            $module_perm = $this->input->post('module_perm');
            $delete_array = array_diff($prev_array, $module_perm);
            $insert_diff = array_diff($module_perm, $prev_array);
            $insert_array = array();
            if (!empty($insert_diff)) {

                foreach ($insert_diff as $key => $value) {
                    $insert_array[] = array(
                        'staff_id' => $staff_id,
                        'permission_id' => $value
                    );
                }
            }

            $this->userpermission_model->getInsertBatch($insert_array, $staff_id, $delete_array);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/staff');
        }

        $this->load->view('layout/header');
        $this->load->view('admin/staff/permission', $data);
        $this->load->view('layout/footer');
    }

    public function leaverequest() {
        if (!$this->rbac->hasPrivilege('apply_leave', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/staff/leaverequest');
        $userdata = $this->customlib->getUserData();

        $leave_request = $this->leaverequest_model->user_leave_request($userdata["id"]);

        $data["leave_request"] = $leave_request;


        $LeaveTypes = $this->leaverequest_model->allotedLeaveType($userdata["id"]);
        $data["staff_id"] = $userdata["id"];
        $data["leavetype"] = $LeaveTypes;

        $staffRole = $this->staff_model->getStaffRole();
        $data["staffrole"] = $staffRole;
        $data["status"] = $this->status;


        $this->load->view("layout/header", $data);
        $this->load->view("admin/staff/leaverequest", $data);
        $this->load->view("layout/footer", $data);
    }

    function change_password($id) {

        $sessionData = $this->session->userdata('hospitaladmin');
        $userdata = $this->customlib->getUserData();

        $this->form_validation->set_rules('new_pass', $this->lang->line('password'), 'trim|required|xss_clean|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', $this->lang->line('confirm_password'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'new_pass' => form_error('new_pass'),
                'confirm_pass' => form_error('confirm_pass'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            if (!empty($id)) {
                $newdata = array(
                    'id' => $id,
                    'password' => $this->enc_lib->passHashEnc($this->input->post('new_pass'))
                );


                $query2 = $this->admin_model->saveNewPass($newdata);
                if ($query2) {
                    $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('password_changed_successfully'));
                } else {

                    $array = array('status' => 'fail', 'error' => '', 'message' => $this->lang->line('password_not_changed'));
                }
            } else {
                $array = array('status' => 'fail', 'error' => '', 'message' => $this->lang->line('password_not_changed'));
            }
        }
        echo json_encode($array);
    }

}

?>