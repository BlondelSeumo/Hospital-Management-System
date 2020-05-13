<?php

class Payroll_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_date = $this->setting_model->getDateYmd();
    }

    function searchEmployee($month, $year, $emp_name, $role) {

        $date_month = date("m", strtotime($year));
        if (!empty($role) && !empty($emp_name)) {

            $query = $this->db->query("select staff_payslip.status,
		IFNULL(staff_payslip.id, 0) as payslip_id ,staff.* ,roles.name as user_type ,roles.id as role_id ,staff_designation.designation as designation,department.department_name as department from staff left join staff_payslip on staff.id = staff_payslip.staff_id and month = '" . $month . "' and year = '" . $year . "' left join department on department.id = staff.department left join staff_designation on staff_designation.id = staff.designation left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id where roles.name = '" . $role . "' and name = '" . $emp_name . "' and staff.is_active = 1 ");
        } else if (!empty($role)) {

            $query = $this->db->query("select staff_payslip.status,
		IFNULL(staff_payslip.id, 0) as payslip_id ,staff.*,staff_designation.designation as designation,department.department_name as department ,roles.id as role_id ,roles.name as user_type from staff left join staff_payslip on staff.id = staff_payslip.staff_id and month = '" . $month . "' and year = '" . $year . "' left join department on department.id = staff.department left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id left join staff_designation on staff_designation.id = staff.designation where roles.name = '" . $role . "' and staff.is_active = 1 ");
        } else {

            $query = $this->db->query("select staff_payslip.status,
		IFNULL(staff_payslip.id, 0) as payslip_id ,staff.* ,roles.name as user_type ,roles.id as role_id ,staff_designation.designation as designation,department.department_name as department  from staff left join staff_payslip on staff.id = staff_payslip.staff_id and month = '" . $month . "' and year = '" . $year . "' left join department on department.id = staff.department left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id left join staff_designation on staff_designation.id = staff.designation where staff.is_active = 1 ");
        }


        $result = $query->result_array();

        if ($this->session->has_userdata('hospitaladmin')) {
            $superadmin_rest = $this->session->userdata['hospitaladmin']['superadmin_restriction'];
            if ($superadmin_rest == 'enabled') {
                $search = in_array(7, array_column($result, 'role_id'));
                $search_key = array_search(7, array_column($result, 'role_id'));
                if (!empty($search)) {
                    unset($result[$search_key]);
                }
            }
        }

        return $result;
    }

    function createPayslip($data) {

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('staff_payslip', $data);
        } else {
            $this->db->insert('staff_payslip', $data);
            return $this->db->insert_id();
        }
    }

    function checkPayslip($month, $year, $staff_id) {

        $query = $this->db->where(array('month' => $month, 'year' => $year, 'staff_id' => $staff_id))->get("staff_payslip");

        if ($query->num_rows() > 0) {
            return false;
        } else {

            return true;
        }
    }

    function add_allowance($data) {

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('payslip_allowance', $data);
        } else {
            $this->db->insert('payslip_allowance', $data);
            return $this->db->insert_id();
        }
    }

    function searchPaylist($name, $month, $year) {

        $query = $this->db->select('staff.*,staff_designation.designation as desg,department.department_name as department')->where(array('staff.name' => $name, 'staff_payslip.month' => $month, 'staff_payslip.year' => $year))->join("staff_payslip", "staff.id = staff_payslip.staff_id")->join("staff_designation", "staff.designation = staff_designation.id")->join("department", "staff.department = department.id")->get("staff");

        return $query->result_array();
    }

    function count_attendance($month, $year, $staff_id, $attendance_type = 1) {

        $date_month = date("m", strtotime($month));
        $query = $this->db->select('count(*) as att')->where(array('staff_id' => $staff_id, 'month(date)' => $month, 'year(date)' => $year, 'staff_attendance_type_id' => $attendance_type))->get("staff_attendance");
        return $query->result_array();
    }

    function count_attendance_obj($month, $year, $staff_id, $attendance_type = 1) {


        $query = $this->db->select('count(*) as attendence')->where(array('staff_id' => $staff_id, 'month(date)' => $month, 'year(date)' => $year, 'staff_attendance_type_id' => $attendance_type))->get("staff_attendance");

        return $query->row()->attendence;
    }

    function updatePaymentStatus($status, $id) {

        $data = array('status' => $status);
        $this->db->where("id", $id)->update("staff_payslip", $data);
    }

    function searchEmployeeById($id) {

        $query = $this->db->select('staff.*,roles.name as user_type ,staff_designation.designation,department.department_name as department')->join("staff_designation", "staff_designation.id = staff.designation", "left")->join("department", "department.id = staff.department", "left")->join("staff_roles", "staff_roles.staff_id = staff.id", "left")->join("roles", "staff_roles.role_id = roles.id", "left")->where("staff.id", $id)->get("staff");

        return $query->row_array();
    }

    function searchPayment($id, $month, $year) {

        $query = $this->db->select('staff.name,staff.surname,staff.employee_id,staff.basic_salary,staff_payslip.*,roles.name as role')->where(array('staff_payslip.month' => $month, 'staff_payslip.year' => $year, 'staff_payslip.staff_id' => $id))->join("staff_payslip", "staff.id = staff_payslip.staff_id")->join("staff_roles", "staff.id = staff_roles.staff_id")->join("roles", "roles.id = staff_roles.role_id")->get("staff");

        return $query->row_array();
    }

    function paymentSuccess($data, $payslipid) {

        $this->db->where("id", $payslipid)->update("staff_payslip", $data);
    }

    function getPayslip($id) {

        $query = $this->db->select("staff.name,staff.surname,department.department_name as department,staff_designation.designation,staff.employee_id,staff_payslip.*")->join("staff", "staff.id = staff_payslip.staff_id")->join("staff_designation", "staff.designation = staff_designation.id", 'left')->join("department", "staff.department = department.id", "left")->where("staff_payslip.id", $id)->get("staff_payslip");

        return $query->row_array();
    }

    function getstaff($staff_id) {

        $query = $this->db->select("staff.name,staff.surname")->where("staff.id", $id)->get("staff_payslip");

        return $query->row_array();
    }

    function getAllowance($id, $type = null) {

        if (!empty($type)) {


            $query = $this->db->select("allowance_type,amount,cal_type")->where(array('payslip_id' => $id, 'cal_type' => $type))->get("payslip_allowance");
        } else {

            $query = $this->db->select("allowance_type,amount,cal_type")->where("payslip_id", $id)->get("payslip_allowance");
        }

        return $query->result_array();
    }

    function getSalaryDetails($id) {

        $query = $this->db->select("sum(net_salary) as net_salary, sum(total_allowance) as earnings, sum(total_deduction) as deduction, sum(basic) as basic_salary, sum(tax) as tax")->where(array('staff_id' => $id, 'status' => 'paid'))->get("staff_payslip");
        return $query->row_array();
    }

    function getpayrollReport($month, $year, $role) {

        if ($role == "select" && $month != "") {
            $data = array('staff_payslip.month' => $month, 'staff_payslip.year' => $year, 'staff_payslip.status' => 'paid');
        } else if ($role == "select" && $month == "") {

            $data = array('staff_payslip.year' => $year, 'staff_payslip.status' => 'paid');
        } else if ($role != "select" && $month == "") {

            $data = array('staff_payslip.year' => $year, 'roles.name' => $role, 'staff_payslip.status' => 'paid');
        } else {

            $data = array('staff_payslip.month' => $month, 'staff_payslip.year' => $year, 'roles.name' => $role, 'staff_payslip.status' => 'paid');
        }


        $query = $this->db->select('staff.id,staff.employee_id,staff.name,roles.name as user_type,staff.surname,staff_designation.designation,department.department_name as department,staff_payslip.*')->join("staff_payslip", "staff_payslip.staff_id = staff.id", "inner")->join("staff_designation", "staff.designation = staff_designation.id", "left")->join("department", "staff.department = department.id", "left")->join("staff_roles", "staff_roles.staff_id = staff.id", "left")->join("roles", "staff_roles.role_id = roles.id", "left")->where($data)->get("staff");

        return $query->result_array();
    }

    public function deletePayslip($payslipid) {

        $this->db->where("id", $payslipid)->delete("staff_payslip");
        $this->db->where("payslip_id", $payslipid)->delete("payslip_allowance");
    }

    public function revertPayslipStatus($payslipid) {

        $data = array('status' => "generated");

        $this->db->where("id", $payslipid)->update("staff_payslip", $data);
    }

    function payrollYearCount() {

        $query = $this->db->select("distinct(year) as year")->get("staff_payslip");

        return $query->result_array();
    }

}

?>