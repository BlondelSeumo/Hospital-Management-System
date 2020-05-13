<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Staffattendance extends Admin_Controller {

    function __construct() {

        parent::__construct();
        $this->load->helper('file');
        $this->config->load("mailsms");
        $this->config->load("payroll");
        $this->load->library('mailsmsconf');
        $this->config_attendance = $this->config->item('attendence');
        $this->staff_attendance = $this->config->item('staffattendance');
    }

    function index() {

        if (!($this->rbac->hasPrivilege('staff_attendance', 'can_view') )) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/staffattendance');
        $data['title'] = 'Staff Attendance List';
        $data['title_list'] = 'Staff Attendance List';
        $user_type = $this->staff_model->getStaffRole();

        $data['classlist'] = $user_type;
        $data['class_id'] = "";
        $data['section_id'] = "";
        $data['date'] = "";
        $user_type_id = $this->input->post('user_id');
        $data["user_type_id"] = $user_type_id;
        if (!(isset($user_type_id))) {

            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/staffattendancelist', $data);
            $this->load->view('layout/footer', $data);
        } else {

            $user_type = $this->input->post('user_id');
            $date = $this->input->post('date');
            $user_list = $this->staffattendancemodel->get();
            $data['userlist'] = $user_list;
            $data['class_id'] = $user_list;
            $data['user_type_id'] = $user_type_id;
            $data['section_id'] = "";
            $data['date'] = $date;
            $search = $this->input->post('search');
            $holiday = $this->input->post('holiday');

            $this->session->set_flashdata('msg', '');

            if ($search == "saveattendence") {

                $user_type_ary = $this->input->post('student_session');
                $absent_student_list = array();
                foreach ($user_type_ary as $key => $value) {
                    $checkForUpdate = $this->input->post('attendendence_id' . $value);

                    if ($checkForUpdate != 0) {


                        if (isset($holiday)) {
                            $arr = array(
                                'id' => $checkForUpdate,
                                'staff_id' => $value,
                                'staff_attendance_type_id' => 5,
                                'remark' => $this->input->post("remark" . $value),
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                            );
                        } else {
                            $arr = array(
                                'id' => $checkForUpdate,
                                'staff_id' => $value,
                                'staff_attendance_type_id' => $this->input->post('attendencetype' . $value),
                                'remark' => $this->input->post("remark" . $value),
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                            );
                        }

                        $insert_id = $this->staffattendancemodel->add($arr);
                    } else {
                        if (isset($holiday)) {
                            $arr = array(
                                'staff_id' => $value,
                                'staff_attendance_type_id' => 5,
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date)),
                                'remark' => ''
                            );
                        } else {


                            $arr = array(
                                'staff_id' => $value,
                                'staff_attendance_type_id' => $this->input->post('attendencetype' . $value),
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date)),
                                'remark' => $this->input->post("remark" . $value),
                            );
                        }

                        $insert_id = $this->staffattendancemodel->add($arr);
                        $absent_config = $this->config_attendance['absent'];
                        if ($arr['staff_attendance_type_id'] == $absent_config) {
                            $absent_student_list[] = $value;
                        }
                    }
                }



                $absent_config = $this->config_attendance['absent'];
                if (!empty($absent_student_list)) {

                    $this->mailsmsconf->mailsms('absent_attendence', $absent_student_list, $date);
                }

                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');

                redirect('admin/staffattendance/index');
            }

            $attendencetypes = $this->staffattendancemodel->getStaffAttendanceType();
            $data['attendencetypeslist'] = $attendencetypes;
            $resultlist = $this->staffattendancemodel->searchAttendenceUserType($user_type, date('Y-m-d', $this->customlib->datetostrtotime($date)));
            $data['resultlist'] = $resultlist;


            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/staffattendancelist', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function attendancereport() {
        if (!$this->rbac->hasPrivilege('staff_attendance_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/staffattendance/attendancereport');
        $attendencetypes = $this->staffattendancemodel->getStaffAttendanceType();
        $data['attendencetypeslist'] = $attendencetypes;
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data['title'] = 'Attendance Report';
        $data['title_list'] = 'Attendance';
        $data['monthlist'] = $this->customlib->geLangMonthList();
        $data['yearlist'] = $this->staffattendancemodel->attendanceYearCount();
        $data['date'] = "";
        $data['month_selected'] = "";
        $data["role_selected"] = "";
        $role = $this->input->post("role");
        $this->form_validation->set_rules('month', $this->lang->line('month'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/attendancereport', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $resultlist = array();
            $month = $this->input->post('month');

            $searchyear = $this->input->post('year');
            $data['month_selected'] = $month;
            $data["role_selected"] = $role;
            $stafflist = $this->staff_model->getEmployee($role);
            $startMonth = $this->setting_model->getStartMonth();
            $month_number = date("m", strtotime($month));

            $year = date('Y');
            $num_of_days = cal_days_in_month(CAL_GREGORIAN, $month_number, $year);
            $attr_result = array();
            $attendence_array = array();
            $student_result = array();
            $data['no_of_days'] = $num_of_days;
            $date_result = array();
            $monthAttendance = array();
            for ($i = 1; $i <= $num_of_days; $i++) {
                $att_date = $searchyear . "-" . $month_number . "-" . sprintf("%02d", $i);

                $attendence_array[] = $att_date;

                $res = $this->staffattendancemodel->searchAttendanceReport($role, $att_date);


                $student_result = $res;
                $s = array();

                foreach ($res as $result_k => $result_v) {

                    $date = $searchyear . "-" . $month;
                    $newdate = date('Y-m-d', strtotime($date));

                    $s[$result_v['id']] = $result_v;
                }

                $date_result[$att_date] = $s;
            }

            foreach ($res as $result_k => $result_v) {

                $date = $searchyear . "-" . $month;
                $newdate = date('Y-m-d', strtotime($date));
                $monthAttendance[] = $this->monthAttendance($newdate, 1, $result_v['id']);
            }
            $data['monthAttendance'] = $monthAttendance;
            $data['resultlist'] = $date_result;
            if (!empty($searchyear)) {
                $data['attendence_array'] = $attendence_array;
                $data['student_array'] = $student_result;
            } else {

                $data['attendence_array'] = array();
                $data['student_array'] = array();
            }

            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/attendancereport', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function monthAttendance($st_month, $no_of_months, $emp) {


        $record = array();

        $r = array();
        $month = date('m', strtotime($st_month));
        $year = date('Y', strtotime($st_month));

        foreach ($this->staff_attendance as $att_key => $att_value) {

            $s = $this->payroll_model->count_attendance_obj($month, $year, $emp, $att_value);

            $r[$att_key] = $s;
        }

        $record[$emp] = $r;

        return $record;
    }

    function profileattendance() {

        $monthlist = $this->customlib->getMonthDropdown();
        $startMonth = $this->setting_model->getStartMonth();
        $data["monthlist"] = $monthlist;
        $data['yearlist'] = $this->staffattendancemodel->attendanceYearCount();
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data["role_selected"] = "";
        $j = 0;
        for ($i = 1; $i <= 31; $i++) {

            $att_date = sprintf("%02d", $i);

            $attendence_array[] = $att_date;

            foreach ($monthlist as $key => $value) {

                $datemonth = date("m", strtotime($value));
                $att_dates = date("Y") . "-" . $datemonth . "-" . sprintf("%02d", $i);
                $date_array[] = $att_dates;
                $res[$att_dates] = $this->staffattendancemodel->searchStaffattendance($staff_id = 8, $att_dates);
            }

            $j++;
        }

        $data["resultlist"] = $res;
        $data["attendence_array"] = $attendence_array;
        $data["date_array"] = $date_array;

        $this->load->view("layout/header");
        $this->load->view("admin/staff/staffattendance", $data);
        $this->load->view("layout/footer");
    }

}

?>