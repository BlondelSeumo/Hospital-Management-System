<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class visitors_purpose_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

    function add($visitors_purpose) {
        $this->db->insert('visitors_purpose', $visitors_purpose);
    }

    public function visitors_purpose_list($id = null) {
        $this->db->select()->from('visitors_purpose');
        if ($id != null) {
            $this->db->where('visitors_purpose.id', $id);
        } else {
            $this->db->order_by('visitors_purpose.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('visitors_purpose');
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('visitors_purpose', $data);
    }

}

?>
