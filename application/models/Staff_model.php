<?php

class Staff_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get($id = null) {

        $this->db->select('staff.*,roles.name as user_type,roles.id as role_id')->from('staff')->join("staff_roles", "staff_roles.staff_id = staff.id", "left")->join("roles", "staff_roles.role_id = roles.id", "left");

        if ($id != null) {
            $this->db->where('staff.id', $id);
        } else {
            $this->db->where('staff.is_active', 1);
            $this->db->order_by('staff.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            $result = $query->row_array();
        } else {
            $result = $query->result_array();
            if ($this->session->has_userdata('hospitaladmin')) {
                $superadmin_rest = $this->session->userdata['hospitaladmin']['superadmin_restriction'];
                if ($superadmin_rest == 'disabled') {
                    $search = in_array(7, array_column($result, 'role_id'));
                    $search_key = array_search(7, array_column($result, 'role_id'));

                    if (!empty($search)) {
                        unset($result[$search_key]);
                        $result = array_values($result);
                    }
                }
            }
        }

        return $result;
    }

    public function getstaff($staff_id) {

        $this->db->select('staff.name,staff.surname');
        $this->db->from('staff');
        $this->db->where('staff.id', $staff_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getAll($id = null, $is_active = null) {

        $this->db->select("staff.*,staff_designation.designation,department.department_name as department, roles.id as role_id, roles.name as role");
        $this->db->from('staff');
        $this->db->join('staff_designation', "staff_designation.id = staff.designation", "left");
        $this->db->join('staff_roles', "staff_roles.staff_id = staff.id", "left");
        $this->db->join('roles', "roles.id = staff_roles.role_id", "left");
        $this->db->join('department', "department.id = staff.department", "left");




        if ($id != null) {
            $this->db->where('staff.id', $id);
        } else {
            if ($is_active != null) {

                $this->db->where('staff.is_active', $is_active);
            }
            $this->db->order_by('staff.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function add($data) {

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('staff', $data);
        } else {
            $this->db->insert('staff', $data);
            return $this->db->insert_id();
        }
    }

    public function update($data) {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('staff', $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function getByVerificationCode($ver_code) {
        $condition = "verification_code =" . "'" . $ver_code . "'";
        $this->db->select('*');
        $this->db->from('staff');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function batchInsert($data, $roles = array(), $leave_array = array()) {

        $this->db->trans_start();
        $this->db->trans_strict(FALSE);

        $this->db->insert('staff', $data);
        $staff_id = $this->db->insert_id();
        $roles['staff_id'] = $staff_id;
        $this->db->insert_batch('staff_roles', array($roles));

        if (!empty($leave_array)) {
            foreach ($leave_array as $key => $value) {
                $leave_array[$key]['staff_id'] = $staff_id;
            }

            $this->db->insert_batch('staff_leave_details', $leave_array);
        }
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {

            $this->db->trans_commit();
            return $staff_id;
        }
    }

    public function adddoc($data) {

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('staff_documents', $data);
        } else {
            $this->db->insert('staff_documents', $data);
            return $this->db->insert_id();
        }
    }

    public function remove($id) {

        $this->db->where('id', $id);
        $this->db->delete('staff');


        $this->db->where('staff_id', $id);
        $this->db->delete('staff_payslip');

        $this->db->where('staff_id', $id);
        $this->db->delete('staff_leave_request');

        $this->db->where('staff_id', $id);
        $this->db->delete('staff_attendance');

        $this->db->where('staff_id', $id);
        $this->db->delete('staff_roles');
    }

    public function add_staff_leave_details($data2) {

        if (isset($data2['id'])) {
            $this->db->where('id', $data2['id']);
            $this->db->update('staff_leave_details', $data2);
        } else {
            $this->db->insert('staff_leave_details', $data2);
            return $this->db->insert_id();
        }
    }

    public function getPayroll($id = null) {

        $this->db->select()->from('staff_payroll');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getLeaveType($id = null) {

        $this->db->select()->from('leave_types');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->where('is_active', 'yes');
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function valid_employee_id($str) {
        $name = $this->input->post('name');
        $id = $this->input->post('employee_id');
        $staff_id = $this->input->post('editid');

        if (!isset($id)) {
            $id = 0;
        }
        if (!isset($staff_id)) {
            $staff_id = 0;
        }

        if ($this->check_data_exists($name, $id, $staff_id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_data_exists($name, $id, $staff_id) {

        if ($staff_id != 0) {
            $data = array('id != ' => $staff_id, 'employee_id' => $id);
            $query = $this->db->where($data)->get('staff');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {

            $this->db->where('employee_id', $id);
            $query = $this->db->get('staff');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function valid_email_id($str) {
        $email = $this->input->post('email');
        $id = $this->input->post('employee_id');
        $staff_id = $this->input->post('editid');

        if (!isset($id)) {
            $id = 0;
        }
        if (!isset($staff_id)) {
            $staff_id = 0;
        }

        if ($this->check_email_exists($email, $id, $staff_id)) {
            $this->form_validation->set_message('check_exists', 'Email already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_email_exists($email, $id, $staff_id) {

        if ($staff_id != 0) {
            $data = array('id != ' => $staff_id, 'email' => $email);
            $query = $this->db->where($data)->get('staff');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {

            $this->db->where('email', $email);
            $query = $this->db->get('staff');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function getStaffRole($id = null) {

        $this->db->select('roles.id,roles.name as type')->from('roles');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $this->db->where("is_active", "yes");
        $query = $this->db->get();
        if ($id != null) {
            $result = $query->row_array();
        } else {
            $result = $query->result_array();
            if ($this->session->has_userdata('hospitaladmin')) {
                $superadmin_rest = $this->session->userdata['hospitaladmin']['superadmin_restriction'];
                if ($superadmin_rest == 'disabled') {
                    $search = in_array(7, array_column($result, 'id'));
                    $search_key = array_search(7, array_column($result, 'id'));
                    if (!empty($search)) {
                        unset($result[$search_key]);
                    }
                }
            }
        }


        return $result;
    }

    public function count_leave($month, $year, $staff_id) {

        $query1 = $this->db->select('sum(leave_days) as tl')->where(array('month(date)' => $month, 'year(date)' => $year, 'staff_id' => $staff_id, 'status' => 'approve'))->get("staff_leave_request");
        return $query1->row_array();
    }

    public function alloted_leave($staff_id) {


        $query2 = $this->db->select('sum(alloted_leave) as alloted_leave')->where(array('staff_id' => $staff_id))->get("staff_leave_details");

        return $query2->result_array();
    }

    public function allotedLeaveType($id) {

        $query = $this->db->select('staff_leave_details.*,leave_types.type')->where(array('staff_id' => $id))->join("leave_types", "staff_leave_details.leave_type_id = leave_types.id")->get("staff_leave_details");

        return $query->result_array();
    }

    function getAllotedLeave($staff_id) {

        $query = $this->db->select('*')->join("leave_types", "staff_leave_details.leave_type_id = leave_types.id")->where("staff_id", $staff_id)->get("staff_leave_details");

        return $query->result_array();
    }

    function getEmployee($role, $active = 1) {

        $query = $this->db->select("staff.*,staff_designation.designation,department.department_name as department,roles.name as user_type")->join('staff_designation', "staff_designation.id = staff.designation", "left")->join('staff_roles', "staff_roles.staff_id = staff.id", "left")->join('roles', "roles.id = staff_roles.role_id", "left")->join('department', "department.id = staff.department", "left")->where("staff.is_active", $active)->where("roles.name", $role)->get("staff");

        return $query->result_array();
    }

    function getEmployeeByRoleID($role, $active = 1) {


        $query = $this->db->select("staff.*,staff_designation.designation,department.department_name as department, roles.id as role_id, roles.name as role")->join('staff_designation', "staff_designation.id = staff.designation", "left")->join('staff_roles', "staff_roles.staff_id = staff.id", "left")->join('roles', "roles.id = staff_roles.role_id", "left")->join('department', "department.id = staff.department", "left")->where("staff.is_active", $active)->where("roles.id", $role)->get("staff");


        return $query->result_array();
    }

    function getStaffDesignation() {

        $query = $this->db->select('*')->where("is_active", "yes")->get("staff_designation");

        return $query->result_array();
    }

    function getDepartment() {

        $query = $this->db->select('*')->where("is_active", "yes")->get('department');
        return $query->result_array();
    }

    function getLeaveRecord($id) {

        $query = $this->db->select('leave_types.type,leave_types.id as lid,staff.name,staff.id as staff_id,staff.surname,roles.name as user_type,staff.employee_id,staff_leave_request.*')->join("leave_types", "leave_types.id = staff_leave_request.leave_type_id")->join("staff", "staff.id = staff_leave_request.staff_id")->join("staff_roles", "staff.id = staff_roles.staff_id")->join("roles", "staff_roles.role_id = roles.id")->where("staff_leave_request.id", $id)->get("staff_leave_request");

        return $query->row();
    }

    function getStaffId($empid) {

        $data = array('employee_id' => $empid);
        $query = $this->db->select('id')->where($data)->get("staff");
        return $query->row_array();
    }

    function getProfile($id) {

        $this->db->select('staff.*,staff_designation.designation as designation,staff_roles.role_id, department.department_name as department,roles.name as user_type');
        $this->db->join("staff_designation", "staff_designation.id = staff.designation", "left");
        $this->db->join("department", "department.id = staff.department", "left");
        $this->db->join("staff_roles", "staff_roles.staff_id = staff.id", "left");
        $this->db->join("roles", "staff_roles.role_id = roles.id", "left");

        $this->db->where("staff.id", $id);

        $this->db->from('staff');
        $query = $this->db->get();

        return $query->row_array();
    }

    function getstaffProfile($staffid, $id) {

        $query = $this->db->select("staff.id as staffid,staff.name,staff.surname,department.department_name as department,staff_designation.designation,staff.employee_id,staff_payslip.*")->join("staff", "staff.id = staff_payslip.staff_id")->join("staff_designation", "staff.designation = staff_designation.id", 'left')->join("department", "staff.department = department.id", "left")->where("staff_payslip.id", $id)->get("staff_payslip");


        return $query->row_array();
    }

    public function searchFullText($searchterm, $active, $order = 'staff.employee_id', $dir = 'desc', $limit = 5, $start = 0) {

        $query = $this->db->query("SELECT `staff`.*, `staff_designation`.`designation` as `designation`, `department`.`department_name` as `department`,`roles`.`name` as user_type,`roles`.`id` as role_id  FROM `staff` LEFT JOIN `staff_designation` ON `staff_designation`.`id` = `staff`.`designation` LEFT JOIN `staff_roles` ON `staff_roles`.`staff_id` = `staff`.`id` LEFT JOIN `roles` ON `staff_roles`.`role_id` = `roles`.`id` LEFT JOIN `department` ON `department`.`id` = `staff`.`department` WHERE  `staff`.`is_active` = '$active' and (`staff`.`name` LIKE '%$searchterm%' ESCAPE '!' OR `staff`.`surname` LIKE '%$searchterm%' ESCAPE '!' OR `staff`.`employee_id` LIKE '%$searchterm%' ESCAPE '!' OR `staff`.`local_address` LIKE '%$searchterm%' ESCAPE '!'  OR `staff`.`contact_no` LIKE '%$searchterm%' ESCAPE '!' OR `staff`.`email` LIKE '%$searchterm%' ESCAPE '!') ");

        $result = $query->result_array();
        if ($this->session->has_userdata('hospitaladmin')) {
            $superadmin_rest = $this->session->userdata['hospitaladmin']['superadmin_restriction'];
            if ($superadmin_rest == 'disabled') {
                $search = in_array(7, array_column($result, 'role_id'));
                $search_key = array_search(7, array_column($result, 'role_id'));
                if (!empty($search)) {
                    unset($result[$search_key]);
                }
            }
        }

        return $result;
    }

    public function searchByEmployeeId($employee_id) {

        $this->db->select('*');
        $this->db->from('staff');
        $this->db->like('staff.employee_id', $employee_id);
        $this->db->like('staff.is_active', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getStaffDoc($id) {

        $this->db->select('*');
        $this->db->from('staff_documents');
        $this->db->where('staff_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function count_attendance($year, $staff_id, $att_type) {


        $query = $this->db->select('count(*) as attendence')->where(array('staff_id' => $staff_id, 'year(date)' => $year, 'staff_attendance_type_id' => $att_type))->get("staff_attendance");

        return $query->row()->attendence;
    }

    public function getStaffPayroll($id) {

        $this->db->select('*');
        $this->db->from('staff_payslip');
        $this->db->where('staff_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function doc_delete($id, $doc, $file) {

        if ($doc == 1) {

            $data = array('resume' => '',);
        } else
        if ($doc == 2) {

            $data = array('joining_letter' => '',);
        } else
        if ($doc == 3) {

            $data = array('resignation_letter' => '',);
        } else
        if ($doc == 4) {

            $data = array('other_document_name' => '', 'other_document_file' => '',);
        }
        unlink(BASEPATH . "uploads/staff_documents/" . $file);
        $this->db->where('id', $id)->update("staff", $data);
    }

    public function getLeaveDetails($id) {

        $query = $this->db->select('staff_leave_details.alloted_leave,staff_leave_details.id as altid,leave_types.type,leave_types.id')->join("leave_types", "staff_leave_details.leave_type_id = leave_types.id", "inner")->where("staff_leave_details.staff_id", $id)->get("staff_leave_details");

        return $query->result_array();
    }

    public function disablestaff($id) {

        $data = array('is_active' => 0);

        $query = $this->db->where("id", $id)->update("staff", $data);
    }

    public function enablestaff($id) {

        $data = array('is_active' => 1);

        $query = $this->db->where("id", $id)->update("staff", $data);
    }

    public function getByEmail($email) {
        $this->db->select('*');
        $this->db->from('staff');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function checkLogin($data) {


        $record = $this->getByEmail($data['email']);
        if ($record) {
            $pass_verify = $this->enc_lib->passHashDyc($data['password'], $record->password);
            if ($pass_verify) {
                $roles = $this->staffroles_model->getStaffRoles($record->id);

                $record->roles = array($roles[0]->name => $roles[0]->role_id);

                return $record;
            }
        }
        return false;
    }

    function getStaffbyrole($id) {
        if ($this->session->has_userdata('hospitaladmin')) {
            $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
            $userdata = $this->customlib->getUserData();
            $role_id = $userdata['role_id'];
            if ($doctor_restriction == 'enabled') {
                if ($role_id == 3) {

                    $user_id = $userdata["id"];
                    $doctorid = $user_id;
                    $this->db->where('staff.id', $user_id);
                }
            }
        }

        $this->db->select('staff.*,staff_designation.designation as designation,staff_roles.role_id, department.department_name as department,roles.name as user_type');
        $this->db->join("staff_designation", "staff_designation.id = staff.designation", "left");
        $this->db->join("department", "department.id = staff.department", "left");
        $this->db->join("staff_roles", "staff_roles.staff_id = staff.id", "left");
        $this->db->join("roles", "staff_roles.role_id = roles.id", "left");
        $this->db->where("staff_roles.role_id", $id);
        $this->db->where("staff.is_active", "1");
        $this->db->from('staff');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchNameLike($searchterm, $role) {
        $this->db->select('staff.*')->from('staff');
        $this->db->join('staff_roles', 'staff_roles.staff_id = staff.id');
        $this->db->group_start();
        $this->db->like('staff.name', $searchterm);
        $this->db->group_end();
        $this->db->where('staff_roles.role_id', $role);
        $this->db->order_by('staff.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_role($role_data) {

        $this->db->where("staff_id", $role_data["staff_id"])->update("staff_roles", $role_data);
    }

}

?>