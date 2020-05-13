<?php

class Calendar_model extends CI_Model {

    public function saveEvent($data) {
        if (isset($data["id"])) {

            $this->db->where("id", $data["id"])->update("events", $data);
        } else {

            $this->db->insert("events", $data);
        }
    }

    public function getEvents($id = null) {

        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get("events");
            return $query->row_array();
        } else {

            $query = $this->db->get("events");
            return $query->result_array();
        }
    }       

    public function getStudentEvents($id = null) {

        $cond = "event_type = 'public' or event_type = 'task' ";
        $query = $this->db->where($cond)->get("events");
        return $query->result_array();
    }

    public function deleteEvent($id) {

        $this->db->where("id", $id)->delete("events");
    }

    public function getTask($limit = null, $offset = null, $id, $role_id) {


        $query = $this->db->where(array('event_type' => 'task', 'event_for' => $id, 'role_id' => $role_id))->order_by("is_active,start_date", "asc")->limit($limit, $offset)->get("events");

        return $query->result_array();
    }

    function countrows() {

        $query = $this->db->where("event_type", "task")->get("events");

        return $query->num_rows();
    }

    function countincompleteTask($id) {

        $query = $this->db->where("event_type", "task")->where("is_active", "no")->where("event_for", $id)->where("start_date", date("Y-m-d"))->get("events");

        return $query->num_rows();
    }

    function getincompleteTask($id) {


        $query = $this->db->where("event_type", "task")->where("is_active", "no")->where("event_for", $id)->where("start_date", date("Y-m-d"))->order_by("start_date", "asc")->get("events");

        return $query->result_array();
    }

}

?>