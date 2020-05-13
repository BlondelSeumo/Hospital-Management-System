<?php

class Staffattendancemodel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_date = $this->setting_model->getDateYmd();
    }

    public function get($id = null) {
        $this->db->select("staff.*,staff_attendance.*,staff_roles.role_id")->join("staff", "staff.id = staff_attendance.staff_id")->join("staff_roles", "staff.id = staff_roles.staff_id")->from('staff_attendance');
        $this->db->where("staff.is_active", 1);
        if ($id != null) {
            $this->db->where('staff_attendance.id', $id);
        } else {
            $this->db->order_by('staff_attendance.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            $result = $query->row_array();
        } else {
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
        }
        return $result;
    }

    public function getUserType() {

        $query = $this->db->query("select distinct user_type from staff where is_active = 1");

        return $query->result_array();
    }

    public function searchAttendenceUserType($user_type, $date) {

        if ($user_type == "select") {

            $query = $this->db->query("select staff_attendance.id, staff_attendance.staff_attendance_type_id,staff_attendance.remark,staff.name,staff.surname,staff.employee_id,staff.contact_no,staff.email,roles.id as role_id,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date,staff.id as staff_id from staff left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " where staff.is_active = 1");
        } else {

            $query = $this->db->query("select staff_attendance.staff_attendance_type_id,staff_attendance.remark,staff.name,staff.surname,staff.employee_id,staff.contact_no,staff.email,roles.name as user_type,roles.id as role_id,IFNULL(staff_attendance.date, 'xxx') as date, IFNULL(staff_attendance.id, 0) as id, staff.id as staff_id from staff left join staff_roles on (staff.id = staff_roles.staff_id) left join roles on (roles.id = staff_roles.role_id) left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " where roles.name = '" . $user_type . "' and staff.is_active = 1");
        }
        $result = $query->result_array();
        if ($this->session->has_userdata('hospitaladmin')) {
            $superadmin_rest = $this->session->userdata['hospitaladmin']['superadmin_restriction'];
            if ($superadmin_rest == 'enabled') {
                $search = in_array(7, array_column($result, 'role_id'));
                $search_key = array_search(7, array_column($result, 'role_id'));
                if (!empty($search)) {
                    unset($result[$search_key]);
                    $result = array_values($result);
                }
            }
        }

        return $result;
    }

    public function add($data) {

        if (isset($data['id'])) {

            $this->db->where('id', $data['id']);
            $this->db->update('staff_attendance', $data);
        } else {
            $this->db->insert('staff_attendance', $data);
        }
    }

    public function getStaffAttendanceType() {

        $query = $this->db->select('*')->where("is_active", 'yes')->get("staff_attendance_type");

        return $query->result_array();
    }

    public function searchAttendanceReport($user_type, $date) {


        if ($user_type == "select") {

            $query = $this->db->query("select staff_attendance.staff_attendance_type_id,staff_attendance_type.type as `att_type`,staff_attendance_type.key_value as `key`,staff_attendance.remark,staff.name,staff.surname,staff.employee_id,staff.contact_no,staff.email,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date, IFNULL(staff_attendance.id, 0) as attendence_id, staff.id as id from staff left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " left join staff_attendance_type on staff_attendance_type.id = staff_attendance.staff_attendance_type_id left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id where staff.is_active = 1");
        } else {

            $query = $this->db->query("select staff_attendance.staff_attendance_type_id,staff_attendance_type.type as `att_type`,staff_attendance_type.key_value as `key`,staff_attendance.remark,staff.name,staff.surname,staff.employee_id,staff.contact_no,staff.email,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date, IFNULL(staff_attendance.id, 0) as attendence_id, staff.id as id from staff  left join staff_roles on (staff.id = staff_roles.staff_id) left join roles on (roles.id = staff_roles.role_id) left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " left join staff_attendance_type on staff_attendance_type.id = staff_attendance.staff_attendance_type_id  where roles.name = '" . $user_type . "' and staff.is_active = 1 ");
        }


        return $query->result_array();
    }

    function attendanceYearCount() {

        $query = $this->db->select("distinct year(date) as year")->get("staff_attendance");

        return $query->result_array();
    }

    function searchStaffattendance($staff_id = 8, $date) {

        $query = $this->db->query("select staff_attendance.staff_attendance_type_id,staff_attendance_type.type as `att_type`,staff_attendance_type.key_value as `key`,staff_attendance.remark,staff.name,staff.surname,staff.contact_no,staff.email,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date, IFNULL(staff_attendance.id, 0) as attendence_id, staff.id as id from staff left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id left join staff_attendance_type on staff_attendance_type.id = staff_attendance.staff_attendance_type_id  where staff.id = '" . $staff_id . "' and staff.is_active = 1 ");

        return $query->row_array();
    }

}

?>