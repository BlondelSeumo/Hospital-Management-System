<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('users', $data);
        } else {
            $this->db->insert('users', $data);
            return $this->db->insert_id();
        }
    }

    public function updateUser($id,$status)
    {
       $query = $this->db->select("users.id")->where("user_id",$id)->get("users");
       $result = $query->row_array();

        $user_data = array(
            'id' => $result['id'],
            'is_active' => $status,
        );

        $this->add($user_data);
    }

    public function addNewParent($data_parent_login, $student_data) {
        $this->db->trans_start();
        $this->db->trans_strict(FALSE);
        $this->db->insert('users', $data_parent_login);
        $insert_id = $this->db->insert_id();
        $student_data['parent_id'] = $insert_id;
        $this->student_model->add($student_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {

            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function checkLogin($data) {
        $this->db->select('id, username, password,role,is_active');
        $this->db->from('users');
        $this->db->where('username', $data['username']);
        $this->db->where('password', ($data['password']));
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function checkLoginParent($data) {

        $sql = "SELECT users.*,students.admission_no,students.admission_no ,students.guardian_name, students.roll_no,students.admission_date,students.firstname, students.lastname,students.image,students.father_pic,students.mother_pic,students.guardian_pic,students.guardian_relation, students.mobileno, students.email ,students.state , students.city , students.pincode , students.religion, students.dob ,students.current_address, students.permanent_address FROM `users` INNER JOIN (select * from students) as students on students.parent_id= users.id WHERE `username` = " . $this->db->escape($data['username']) . " AND `password` = " . $this->db->escape($data['password']) . " LIMIT 0,1";

        $query = $this->db->query($sql);

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function read_user_information($users_id) {
        $this->db->select('users.*,patients.patient_name,patients.image,patients.guardian_name,patients.patient_type');
        $this->db->from('users');
        $this->db->join('patients', 'patients.id = users.user_id');

        $this->db->where('users.id', $users_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function read_teacher_information($users_id) {
        $this->db->select('users.*,teachers.name');
        $this->db->from('users');
        $this->db->join('teachers', 'teachers.id = users.user_id');
        $this->db->where('users.id', $users_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function read_accountant_information($users_id) {
        $this->db->select('users.*,accountants.name');
        $this->db->from('users');
        $this->db->join('accountants', 'accountants.id = users.user_id');
        $this->db->where('users.id', $users_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function read_librarian_information($users_id) {
        $this->db->select('users.*,librarians.name');
        $this->db->from('users');
        $this->db->join('librarians', 'librarians.id = users.user_id');
        $this->db->where('users.id', $users_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function checkOldUsername($data) {
        $this->db->where('id', $data['user_id']);
        $this->db->where('username', $data['username']);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function checkOldPass($data) {
        $this->db->where('id', $data['user_id']);
        $this->db->where('password', $data['current_pass']);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function checkUserNameExist($data) {
        $this->db->where('role', $data['role']);
        $this->db->where('username', $data['new_username']);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function saveNewPass($data) {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('users', $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function changeStatus($data) {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('users', $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function saveNewUsername($data) {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('users', $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function read_user() {
        $this->db->select('*');
        $this->db->from('users');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function read_single_child($child_id) {
        $this->db->select('*');
        $this->db->where('childs', $child_id);
        $this->db->from('users');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getLoginDetails($student_id) {
        $sql = "SELECT * FROM (select * from users where find_in_set('$student_id',childs) <> 0 union SELECT * FROM `users` WHERE `user_id` = " . $this->db->escape($student_id) . " AND `role` != 'teacher' AND `role` != 'librarian' AND `role` != 'accountant') a order by a.role desc";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getStudentLoginDetails($student_id) {

        $sql = "SELECT users.* FROM users WHERE id in (select students.parent_id from users INNER JOIN students on students.id =users.user_id WHERE users.user_id=" . $this->db->escape($student_id) . " AND users.role ='student') UNION select users.* from users INNER JOIN students on students.id =users.user_id WHERE users.user_id=" . $this->db->escape($student_id) . " AND users.role ='student'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getTeacherLoginDetails($teacher_id) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $teacher_id);
        $this->db->where('role', 'teacher');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getLibrarianLoginDetails($librarian_id) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $librarian_id);
        $this->db->where('role', 'librarian');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getAccountantLoginDetails($accountant_id) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $accountant_id);
        $this->db->where('role', 'accountant');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function updateVerCode($data) {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('users', $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByEmail($table, $role, $email) {
        $this->db->select($table . '.*,users.id as `user_tbl_id`,users.username,users.password as `user_tbl_password`');
        $this->db->from($table);
        $this->db->join('users', 'users.user_id = ' . $table . '.id', 'left');
        $this->db->where('users.role', $role);
        if ($role == 'parent') {
            $this->db->where($table . '.guardian_email', $email);
        } else {
            $this->db->where($table . '.email', $email);
        }
        $query = $this->db->get();
        if ($email != null) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getUserValidCode($table, $role, $code) {
        $this->db->select($table . '.*,users.id as `user_tbl_id`,users.username,users.password as `user_tbl_password`');
        $this->db->from($table);
        $this->db->join('users', 'users.user_id = ' . $table . '.id', 'left');
        $this->db->where('users.role', $role);
        $this->db->where('users.verification_code', $code);


        $query = $this->db->get();
        if ($code != null) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function forgotPassword($usertype, $email) {
        $result = false;
        if ($usertype == 'student') {
            $table = "students";
            $role = "student";
            $result = $this->getUserByEmail($table, $role, $email);
        } elseif ($usertype == 'parent') {
            $table = "students";
            $role = "parent";
            $result = $this->getUserByEmail($table, $role, $email);
        } elseif ($usertype == 'teacher') {

            $table = "teachers";
            $role = "teacher";
            $result = $this->getUserByEmail($table, $role, $email);
        } elseif ($usertype == 'accountant') {
            $table = "accountants";
            $role = "accountant";
            $result = $this->getUserByEmail($table, $role, $email);
        } elseif ($usertype == 'librarian') {
            $table = "librarians";
            $role = "librarian";
            $result = $this->getUserByEmail($table, $role, $email);
        } elseif ($usertype == 'patient') {
            $table = "patients";
            $role = "patient";
            $result = $this->getUserByEmail($table, $role, $email);
        }
        return $result;
    }

    public function getUserByCodeUsertype($usertype, $code) {
        $result = false;

        if ($usertype == 'student') {
            $table = "students";
            $role = "student";
            $result = $this->getUserValidCode($table, $role, $code);
        } elseif ($usertype == 'parent') {
            $table = "students";
            $role = "parent";
            $result = $this->getUserValidCode($table, $role, $code);
        } elseif ($usertype == 'teacher') {

            $table = "teachers";
            $role = "teacher";
            $result = $this->getUserValidCode($table, $role, $code);
        } elseif ($usertype == 'accountant') {
            $table = "accountants";
            $role = "accountant";
            $result = $this->getUserValidCode($table, $role, $code);
        } elseif ($usertype == 'librarian') {
            $table = "librarians";
            $role = "librarian";
            $result = $this->getUserValidCode($table, $role, $code);
        } elseif ($usertype == 'patient') {
            $table = "patients";
            $role = "patient";
            $result = $this->getUserValidCode($table, $role, $code);
        }
        return $result;
    }

    public function reset_password($usertype, $code, $password) {
        echo "string";
        exit();
    }

    public function getUserLoginDetails($student_id) {

        $sql = "SELECT users.* FROM users WHERE user_id =" . $student_id . " and role = 'student'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getParentLoginDetails($student_id) {

        $sql = "SELECT users.* FROM `users` join students on students.parent_id = users.id WHERE students.id = " . $student_id;
        $query = $this->db->query($sql);
        return $query->row_array();
    }

}

?>
