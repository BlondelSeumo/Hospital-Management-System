<?php

class Timeline_model extends CI_Model {

    public function add($data) {

        if (isset($data["id"])) {

            $this->db->where("id", $data["id"])->update("student_timeline", $data);
        } else {

            $this->db->insert("student_timeline", $data);
            return $this->db->insert_id();
        }
    }

    public function add_staff_timeline($data) {

        if (isset($data["id"])) {

            $this->db->where("id", $data["id"])->update("staff_timeline", $data);
        } else {

            $this->db->insert("staff_timeline", $data);
            return $this->db->insert_id();
        }
    }

    public function getStudentTimeline($id, $status = '') {

        if (!empty($status)) {

            $this->db->where("status", "yes");
        }
        $query = $this->db->where("student_id", $id)->order_by("timeline_date", "asc")->get("student_timeline");
        return $query->result_array();
    }

    public function getStaffTimeline($id, $status = '') {


        if (!empty($status)) {

            $this->db->where("status", $status);
        }
        $query = $this->db->where("staff_id", $id)->order_by("timeline_date", "asc")->get("staff_timeline");
        return $query->result_array();
    }

    public function geteditTimeline($id) {

        $this->db->select('patient_timeline.*,patients.patient_name,patients.patient_name')->from('patient_timeline');
        $this->db->join('patients', 'patients.id = patient_timeline.patient_id');
        $this->db->where('patient_timeline.id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function geteditstaffTimeline($id) {

        $this->db->select('staff_timeline.*,staff.id,staff.name')->from('staff_timeline');
        $this->db->join('staff', 'staff.id = staff_timeline.staff_id');
        $this->db->where('staff_timeline.id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getPatientTimeline($id, $status) {

        if (!empty($status)) {

            $this->db->where("status", $status);
        }
        $query = $this->db->where("patient_id", $id)->order_by("timeline_date", "desc")->get("patient_timeline");
        return $query->result_array();
    }

    public function delete_timeline($id) {

        $this->db->where("id", $id)->delete("student_timeline");
    }

    public function delete_staff_timeline($id) {

        $this->db->where("id", $id)->delete("staff_timeline");
    }

    public function add_patient_timeline($data) {

        if (isset($data["id"])) {

            $this->db->where("id", $data["id"])->update("patient_timeline", $data);
        } else {

            $this->db->insert("patient_timeline", $data);
            return $this->db->insert_id();
        }
    }

    public function delete_patient_timeline($id) {

        $this->db->where("id", $id)->delete("patient_timeline");
    }

}

?>