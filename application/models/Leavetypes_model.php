<?php

class Leavetypes_model extends CI_model {

    function __construct() {
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_date = $this->setting_model->getDateYmd();
    }

    public function addLeaveType($data) {

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('leave_types', $data);
        } else {
            $this->db->insert('leave_types', $data);
            return $this->db->insert_id();
        }
    }

    public function getLeaveType() {

        $query = $this->db->get('leave_types');
        return $query->result_array();
    }

    public function deleteLeaveType($id) {

        $this->db->where('id', $id);
        $this->db->delete('leave_types');
    }

    public function valid_leave_type($str) {
        $type = $this->input->post('type');
        $id = $this->input->post('leavetypeid');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_data_exists($type, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_data_exists($name, $id) {

        if ($id != 0) {
            $data = array('id != ' => $id, 'type' => $name);
            $query = $this->db->where($data)->get('leave_types');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {

            $this->db->where('type', $name);
            $query = $this->db->get('leave_types');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}

?>