<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {
        $this->db->select()->from('roles');
        if ($id != null) {
            $this->db->where('roles.id', $id);
        } else {
            $this->db->order_by('roles.id');
        }
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
                        $result = array_values($result);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('roles');
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
            $this->db->update('roles', $data);
        } else {
            $this->db->insert('roles', $data);
            return $this->db->insert_id();
        }
    }

    public function valid_check_exists($str) {
        $name = $this->input->post('name');
        $id = $this->input->post('id');

        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_data_exists($name, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_data_exists($name, $id) {
        $this->db->where('name', $name);

        $this->db->where('id !=', $id);
        $query = $this->db->get('roles');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

///======================

    public function find($role_id = null) {
        $this->db->select()->from('permission_group');
        $this->db->order_by('permission_group.sort_order');

        $query = $this->db->get();

        $result = $query->result();
        foreach ($result as $key => $value) {
            $value->permission_category = $this->getPermissions($value->id, $role_id);
        }
        return $result;
    }

    public function getPermissions($group_id, $role_id) {
        $sql = "SELECT permission_category.*,IFNULL(roles_permissions.id,0) as `roles_permissions_id`,roles_permissions.can_view,roles_permissions.can_add ,roles_permissions.can_edit ,roles_permissions.can_delete FROM `permission_category` LEFT JOIN roles_permissions on permission_category.id = roles_permissions.perm_cat_id and roles_permissions.role_id= $role_id WHERE permission_category.perm_group_id = $group_id ORDER BY `permission_category`.`id`";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getInsertBatch($role_id, $to_be_insert = array(), $to_be_update = array(), $to_be_delete = array()) {
        $this->db->trans_start();
        $this->db->trans_strict(FALSE);
        if (!empty($to_be_insert)) {
            $this->db->insert_batch('roles_permissions', $to_be_insert);
        }
        if (!empty($to_be_update)) {

            $this->db->update_batch('roles_permissions', $to_be_update, 'id');
        }


// # Updating data
        if (!empty($to_be_delete)) {
            $this->db->where('role_id', $role_id);
            $this->db->where_in('id', $to_be_delete);
            $this->db->delete('roles_permissions');
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

    public function count_roles($id) {

        $query = $this->db->select("*")->join("staff", "staff.id = staff_roles.staff_id")->where("staff_roles.role_id", $id)->where("staff.is_active", 1)->get("staff_roles");

        return $query->num_rows();
    }

}

?>