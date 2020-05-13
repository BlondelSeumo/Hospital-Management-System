<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payroll extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->config->load("mailsms");
        $this->notification = $this->config->item('notification');
        $this->notificationurl = $this->config->item('notification_url');
        $this->patient_notificationurl = $this->config->item('patient_notification_url');
        $this->config->load("payroll");
        $this->load->library('mailsmsconf');
        $this->config_attendance = $this->config->item('attendence');
        $this->staff_attendance = $this->config->item('staffattendance');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->search_type = $this->config->item('search_type');

        $this->payroll_status = $this->config->item('payroll_status');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/payroll');
        $data["staff_id"] = "";
        $data["name"] = "";
        $data["month"] = date("F", strtotime("-1 month"));
        $data["year"] = date("Y");
        $data["present"] = 0;
        $data["absent"] = 0;
        $data["late"] = 0;
        $data["half_day"] = 0;
        $data["holiday"] = 0;
        $data["leave_count"] = 0;
        $data["alloted_leave"] = 0;
        $data["basic"] = 0;
        $data["payment_mode"] = $this->payment_mode;
        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;
        $data['monthlist'] = $this->customlib->getMonthDropdown();
        $submit = $this->input->post("search");
        if (isset($submit) && $submit == "search") {

            $month = $this->input->post("month");
            $year = $this->input->post("year");
            $emp_name = $this->input->post("name");
            $role = $this->input->post("role");

            $searchEmployee = $this->payroll_model->searchEmployee($month, $year, $emp_name, $role);

            $data["resultlist"] = $searchEmployee;
            $data["name"] = $emp_name;
            $data["month"] = $month;
            $data["year"] = $year;
        }
        $data["payroll_status"] = $this->payroll_status;
        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/stafflist", $data);
        $this->load->view("layout/footer", $data);
    }

    function create($month, $year, $id) {
        $data["staff_id"] = "";
        $data["basic"] = "";
        $data["name"] = "";
        $data["month"] = "";
        $data["year"] = "";
        $data["present"] = 0;
        $data["absent"] = 0;
        $data["late"] = 0;
        $data["half_day"] = 0;
        $data["holiday"] = 0;
        $data["leave_count"] = 0;
        $data["alloted_leave"] = 0;
        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;

        $date = $year . "-" . $month;


        $searchEmployee = $this->payroll_model->searchEmployeeById($id);

        $data['result'] = $searchEmployee;
        $data["month"] = $month;
        $data["year"] = $year;



        $alloted_leave = $this->staff_model->alloted_leave($id);

        $newdate = date('Y-m-d', strtotime($date . " +1 month"));

        $data['monthAttendance'] = $this->monthAttendance($newdate, 3, $id);
        $data['monthLeaves'] = $this->monthLeaves($newdate, 3, $id);

        $data["attendanceType"] = $this->staffattendancemodel->getStaffAttendanceType();

        $data["alloted_leave"] = $alloted_leave[0]["alloted_leave"];

        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/create", $data);
        $this->load->view("layout/footer", $data);
    }

    function monthAttendance($st_month, $no_of_months, $emp) {
        $record = array();
        for ($i = 1; $i <= $no_of_months; $i++) {

            $r = array();
            $month = date('m', strtotime($st_month . " -$i month"));
            $year = date('Y', strtotime($st_month . " -$i month"));


            foreach ($this->staff_attendance as $att_key => $att_value) {

                $s = $this->payroll_model->count_attendance_obj($month, $year, $emp, $att_value);


                $r[$att_key] = $s;
            }

            $record['01-' . $month . '-' . $year] = $r;
        }
        return $record;
    }

    function monthLeaves($st_month, $no_of_months, $emp) {
        $record = array();
        for ($i = 1; $i <= $no_of_months; $i++) {

            $r = array();
            $month = date('m', strtotime($st_month . " -$i month"));
            $year = date('Y', strtotime($st_month . " -$i month"));
            $leave_count = $this->staff_model->count_leave($month, $year, $emp);
            if (!empty($leave_count["tl"])) {
                $l = $leave_count["tl"];
            } else {
                $l = "0";
            }

            $record[$month] = $l;
        }

        return $record;
    }

    function payslip() {
        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_add')) {
            access_denied();
        }
        $basic = $this->input->post("basic");
        $total_allowance = $this->input->post("total_allowance");
        $total_deduction = $this->input->post("total_deduction");
        $net_salary = $this->input->post("net_salary");
        $status = $this->input->post("status");
        $staff_id = $this->input->post("staff_id");
        $month = $this->input->post("month");
        $name = $this->input->post("name");
        $year = $this->input->post("year");
        $tax = $this->input->post("tax");
        $leave_deduction = $this->input->post("leave_deduction");
        $this->form_validation->set_rules('net_salary', $this->lang->line('net_salary'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $this->create($month, $year, $staff_id);
        } else {

            $data = array('staff_id' => $staff_id,
                'basic' => $basic,
                'total_allowance' => $total_allowance,
                'total_deduction' => $total_deduction,
                'net_salary' => $net_salary,
                'payment_date' => date("Y-m-d"),
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'tax' => $tax,
                'leave_deduction' => '0'
            );
            $checkForUpdate = $this->payroll_model->checkPayslip($month, $year, $staff_id);
            if ($checkForUpdate == true) {
                $insert_id = $this->payroll_model->createPayslip($data);
                $payslipid = $insert_id;
                $allowance_type = $this->input->post("allowance_type");
                $deduction_type = $this->input->post("deduction_type");

                $allowance_amount = $this->input->post("allowance_amount");
                $deduction_amount = $this->input->post("deduction_amount");
                if (!empty($allowance_type)) {

                    $i = 0;
                    foreach ($allowance_type as $key => $all) {

                        $all_data = array('payslip_id' => $payslipid,
                            'allowance_type' => $allowance_type[$i],
                            'amount' => $allowance_amount[$i],
                            'staff_id' => $staff_id,
                            'cal_type' => "positive",
                        );

                        $insert_payslip_allowance = $this->payroll_model->add_allowance($all_data);

                        $i++;
                    }
                }

                if (!empty($deduction_type)) {
                    $j = 0;
                    foreach ($deduction_type as $key => $type) {

                        $type_data = array('payslip_id' => $payslipid,
                            'allowance_type' => $deduction_type[$j],
                            'amount' => $deduction_amount[$j],
                            'staff_id' => $staff_id,
                            'cal_type' => "negative",
                        );

                        $insert_payslip_allowance = $this->payroll_model->add_allowance($type_data);

                        $j++;
                    }
                }

                redirect('admin/payroll');
            } else {

                $this->session->set_flashdata("msg", "<div class='alert alert-warning'>" . $this->lang->line('payslip_already_generated') . "</div>");

                redirect('admin/payroll');
            }
        }
    }

    function search($month, $year, $role = '') {

        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;
        $data['monthlist'] = $this->customlib->getMonthDropdown();

        $searchEmployee = $this->payroll_model->searchEmployee($month, $year, $emp_name = '', $role);

        $data["resultlist"] = $searchEmployee;
        $data["name"] = $emp_name;
        $data["month"] = $month;
        $data["year"] = $year;

        $data["payroll_status"] = $this->payroll_status;
        $data["resultlist"] = $searchEmployee;
        $data["payment_mode"] = $this->payment_mode;

        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/stafflist", $data);
        $this->load->view("layout/footer", $data);
    }

    public function payrollNotification($staff_id, $role, $month, $amount, $staffname, $url) {
        $notification = $this->notification;
        $notification_desc = $notification["salary_paid"];
        $desc = str_replace(array('<amount>', '<month>', '<staffname>', '<url>'), array($amount, $month, $staffname, $url), $notification_desc);

        if (!empty($staff_id)) {

            $notification_data = array('notification_title' => 'Salary paid',
                'notification_desc' => $desc,
                'notification_for' => $role,
                'notification_type' => 'salary',
                'receiver_id' => $staff_id,
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );
            $this->notification_model->addSystemNotification($notification_data);

            $admin_notification_data = array('notification_title' => 'Salary paid',
                'notification_desc' => $desc,
                'notification_for' => 'Super Admin',
                'notification_type' => 'salary',
                'receiver_id' => '',
                'date' => date("Y-m-d H:i:s"),
                'is_active' => 'yes',
            );
            $this->notification_model->addSystemNotification($admin_notification_data);
        }
    }

    function paymentRecord() {

        $month = $this->input->get_post("month");
        $year = $this->input->get_post("year");
        $id = $this->input->get_post("staffid");
        $searchEmployee = $this->payroll_model->searchPayment($id, $month, $year);

        $data['result'] = $searchEmployee;
        $data["month"] = $month;
        $data["year"] = $year;
        echo json_encode($data);
    }

    function paymentStatus($status) {

        $id = $this->input->get('id');

        $updateStaus = $this->payroll_model->updatePaymentStatus($status, $id);

        redirect("admin/payroll");
    }

    function paymentSuccess() {

        $pay_id = $this->input->post("paymentid");
        $payment_mode = $this->input->post("payment_mode");
        $date = $this->input->post("payment_date");
        $payment_date = date('Y-m-d', $this->customlib->datetostrtotime($date));
        $remark = $this->input->post("remarks");
        $paymentmonth = $this->input->post("paymentmonth");
        $amount = $this->input->post("amount");
        $status = 'paid';
        $staff_id = $this->input->post("staff_id");
        $notificationurl = $this->notificationurl;
        $url_link = $notificationurl["salary"];
        $url = base_url() . $url_link . '/' . $staff_id . '/' . $pay_id;

        if ($staff_id) {
            $result = $this->staff_model->getstaff($staff_id);
        }
        $staffname = $result['name'] . " " . $result['surname'];

        $staff_role = $this->input->post("staff_role");

        $payslipid = $this->input->post("paymentid");
        $this->form_validation->set_rules('payment_mode', $this->lang->line('payment') . " " . $this->lang->line('mode'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'payment_mode' => form_error('payment_mode'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array('payment_mode' => $payment_mode, 'payment_date' => $payment_date, 'remark' => $remark, 'status' => $status);

            $this->payroll_model->paymentSuccess($data, $payslipid);
            $this->payrollNotification($staff_id, $staff_role, $paymentmonth, $amount, $staffname, $url);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    function payslipView() {
        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_view')) {
            access_denied();
        }
        $data["payment_mode"] = $this->payment_mode;

        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result[0];
        $data['print_details'] = $this->printing_model->get('', 'payslip');
        $id = $this->input->post("payslipid");
        $result = $this->payroll_model->getPayslip($id);
        $allowance = $this->payroll_model->getAllowance($result["id"]);
        $data["allowance"] = $allowance;
        $positive_allowance = $this->payroll_model->getAllowance($result["id"], "positive");
        $data["positive_allowance"] = $positive_allowance;
        $negative_allowance = $this->payroll_model->getAllowance($result["id"], "negative");
        $data["negative_allowance"] = $negative_allowance;
        $data["result"] = $result;
        if (!empty($result)) {
            $this->load->view("admin/payroll/payslipview", $data);
        } else {
            echo $this->lang->line('no_record_found');
        }
    }

    function payslippdf() {


        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result[0];

        $id = 15;
        $result = $this->payroll_model->getPayslip($id);
        $allowance = $this->payroll_model->getAllowance($result["id"]);
        $data["allowance"] = $allowance;
        $positive_allowance = $this->payroll_model->getAllowance($result["id"], "positive");
        $data["positive_allowance"] = $positive_allowance;
        $negative_allowance = $this->payroll_model->getAllowance($result["id"], "negative");
        $data["negative_allowance"] = $negative_allowance;
        $data["result"] = $result;
        $this->load->view("admin/payroll/payslippdf", $data);
    }

    function payrollreport() {
        if (!$this->rbac->hasPrivilege('payroll_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/payroll/payrollreport');
        $month = $this->input->post("month");
        $year = $this->input->post("year");
        $role = $this->input->post("role");
        $data["month"] = $month;
        $data["year"] = $year;
        $data["role_select"] = $role;
        $data['monthlist'] = $this->customlib->getMonthDropdown();
        $data['yearlist'] = $this->payroll_model->payrollYearCount();
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data["payment_mode"] = $this->payment_mode;

        $this->form_validation->set_rules('year', 'Year', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $this->load->view("layout/header", $data);
            $this->load->view("admin/payroll/payrollreport", $data);
            $this->load->view("layout/footer", $data);
        } else {

            $result = $this->payroll_model->getpayrollReport($month, $year, $role);
            $data["result"] = $result;
            $this->load->view("layout/header", $data);
            $this->load->view("admin/payroll/payrollreport", $data);
            $this->load->view("layout/footer", $data);
        }
    }

    function deletepayroll($payslipid, $month, $year, $role = '') {
        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_delete')) {
            access_denied();
        }
        if (!empty($payslipid)) {

            $this->payroll_model->deletePayslip($payslipid);
        }

        redirect('admin/payroll/search/' . $month . "/" . $year . "/" . $role);
    }

    function revertpayroll($payslipid, $month, $year, $role = '') {


        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_delete')) {
            access_denied();
        }

        if (!empty($payslipid)) {

            $this->payroll_model->revertPayslipStatus($payslipid);
        }

        redirect('admin/payroll/search/' . $month . "/" . $year . "/" . $role);
    }

    public function payrollsearch() {
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/payroll/payrollsearch');
        $select = 'staff.id,staff.employee_id,staff.name,roles.name as user_type,roles.id as role_id,staff.surname,staff_designation.designation,department.department_name as department,staff_payslip.*';
        $join = array(
            'JOIN staff_payslip ON staff_payslip.staff_id=staff.id',
            'LEFT JOIN staff_designation ON staff.designation = staff_designation.id',
            'LEFT JOIN department ON staff.department = department.id',
            'JOIN staff_roles ON staff_roles.staff_id = staff.id',
            'JOIN roles ON staff_roles.role_id = roles.id',
        );
        $where = array();
        $table_name = "staff";

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

            $search_table = "staff_payslip";
            $search_column = "payment_date";
            $resultlist = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column, $where);
        }


        if ($this->session->has_userdata('hospitaladmin')) {
            $superadmin_rest = $this->session->userdata['hospitaladmin']['superadmin_restriction'];
            if ($superadmin_rest == 'enabled') {
                $search = in_array(7, array_column($resultlist, 'role_id'));
                $search_key = array_search(7, array_column($resultlist, 'role_id'));
                if (!empty($search)) {
                    unset($resultlist[$search_key]);
                    $resultlist = array_values($resultlist);
                }
            }
        }

        $data["searchlist"] = $this->search_type;
        $data["payment_mode"] = $this->payment_mode;

        $data["search_type"] = $search_type;
        $data["resultlist"] = $resultlist;

        $this->load->view('layout/header');
        $this->load->view('admin/payroll/payrollsearch.php', $data);
        $this->load->view('layout/footer');
    }

}

?>