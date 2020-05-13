<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Systemnotification_model extends CI_Model {

    public $current_session;

    public function __construct() {
        parent::__construct();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {

        $userdata = $this->customlib->getUserData();

        $role_id = $userdata["role_id"];
        $sql = "SELECT * from send_notification  JOIN (SELECT send_notification_id, GROUP_CONCAT(role_id) as roles  FROM notification_roles  group by send_notification_id) as notification_roles on notification_roles.send_notification_id = send_notification.id ";

        if ($id != null) {

            $sql .= "where send_notification.id =" . $id;
        }

        $query = $this->db->query($sql);

        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getRole($arr) {

        $query = $this->db->where_in("id", $arr)->get("roles");
        return $query->result_array();
    }

    public function getUnreadStaffNotification($staffid = null, $role_id = null) {


        $sql = "select send_notification.* from send_notification INNER JOIN notification_roles on notification_roles.send_notification_id = send_notification.id left JOIN read_notification on read_notification.staff_id=" . $this->db->escape($staffid) . " and read_notification.notification_id = send_notification.id WHERE send_notification.created_id !=" . $this->db->escape($staffid) . " and send_notification.visible_staff='yes' and read_notification.id IS NULL and notification_roles.role_id=" . $this->db->escape($role_id) . " order by send_notification.id desc";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getNotificationForStudent($studentid = null) {
        $date = date('Y-m-d');
        $query = $this->db->query("SELECT
		send_notification.id,send_notification.title,send_notification.publish_date,send_notification.date,send_notification.message,
		IF (read_notification.id IS NULL,'unread','read') as notification_id
		FROM send_notification
		LEFT JOIN read_notification ON send_notification.id = read_notification.notification_id and read_notification.student_id=" . $this->db->escape($studentid) . " where send_notification.visible_student='Yes' order by send_notification.publish_date desc");
        return $query->result_array();
    }

    public function getNotificationForParent($parentid = null) {
        $date = date('Y-m-d');
        $query = $this->db->query("SELECT
			send_notification.id,send_notification.title,send_notification.publish_date,send_notification.date,send_notification.message,
			IF (read_notification.id IS NULL,'unread','read') as notification_id
			FROM send_notification
			LEFT JOIN read_notification ON send_notification.id = read_notification.notification_id and read_notification.parent_id=" . $this->db->escape($parentid) . " where send_notification.visible_parent='Yes' order by send_notification.publish_date desc");
        return $query->result_array();
    }

    public function countUnreadNotificationStudent($studentid = null) {
        $date = date('Y-m-d');
        $query = $this->db->query("select * from (SELECT  IF (read_notification.id IS NULL,'unread','read') as notification_id FROM send_notification LEFT JOIN read_notification ON send_notification.id = read_notification.notification_id and read_notification.student_id=" . $this->db->escape($studentid) . " where  send_notification.visible_student='Yes') final where notification_id ='unread'");
        return $query->num_rows();
    }

    public function countUnreadNotificationParent($parentid = null) {
        $date = date('Y-m-d');
        $query = $this->db->query("select * from (SELECT  IF (read_notification.id IS NULL,'unread','read') as notification_id FROM send_notification LEFT JOIN read_notification ON send_notification.id = read_notification.notification_id and read_notification.parent_id=" . $this->db->escape($parentid) . " where  send_notification.visible_parent='Yes') final where notification_id ='unread'");
        return $query->num_rows();
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('send_notification');
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('send_notification', $data);
        } else {
            $this->db->insert('send_notification', $data);
            return $this->db->insert_id();
        }
    }

    public function insertBatch($data, $staff_roles, $delete_array = array()) {

        $this->db->trans_start();
        $this->db->trans_strict(FALSE);

        if (isset($data['id'])) {
            $insert_id = $data['id'];
            $this->db->where('id', $data['id']);
            $this->db->update('send_notification', $data);
        } else {
            $this->db->insert('send_notification', $data);
            $insert_id = $this->db->insert_id();
        }


        if (!empty($staff_roles)) {
            foreach ($staff_roles as $stf_role_key => $stf_role_value) {
                $staff_roles[$stf_role_key]['send_notification_id'] = $insert_id;
            }

            $this->db->insert_batch('notification_roles', $staff_roles);
        }
        if (!empty($delete_array)) {

            $this->db->where('send_notification_id', $insert_id);
            $this->db->where_in('role_id', $delete_array);
            $this->db->delete('notification_roles');
        }


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {

            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function updateStatus($notification_id, $studentid) {
        $this->db->where('notification_id', $notification_id);
        $this->db->where('student_id', $studentid);
        $q = $this->db->get('read_notification');
        if ($q->num_rows() > 0) {
            return true;
        } else {
            $data = array(
                'notification_id' => $notification_id,
                'student_id' => $studentid
            );
            $this->db->insert('read_notification', $data);
        }
    }

    public function updateStatusforStaff($notification_id, $staff_id) {
        $this->db->where('notification_id', $notification_id);
        $this->db->where('parent_id', $staff_id);
        $q = $this->db->get('read_notification');
        if ($q->num_rows() > 0) {
            return true;
        } else {
            $data = array(
                'notification_id' => $notification_id,
                'staff_id' => $staff_id
            );
            $this->db->insert('read_notification', $data);
        }
    }

    public function updateStatusforParent($notification_id, $parentid) {
        $this->db->where('notification_id', $notification_id);
        $this->db->where('parent_id', $parentid);
        $q = $this->db->get('read_notification');
        if ($q->num_rows() > 0) {
            return true;
        } else {
            $data = array(
                'notification_id' => $notification_id,
                'parent_id' => $parentid
            );
            $this->db->insert('read_notification', $data);
        }
    }

    function add_exam_schedule($data) {
        $this->db->where('exam_id', $data['exam_id']);
        $this->db->where('teacher_subject_id', $data['teacher_subject_id']);
        $q = $this->db->get('exam_schedules');
        if ($q->num_rows() > 0) {
            $result = $q->row_array();
            $this->db->where('id', $result['id']);
            $this->db->update('exam_schedules', $data);
        } else {
            $this->db->insert('exam_schedules', $data);
        }
    }

}

?>