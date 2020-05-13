<?php

class Bloodissue_model extends CI_Model {

    public function add($bloodissue) {
        $this->db->insert('blood_issue', $bloodissue);
        return $this->db->insert_id();
    }

    public function searchFullText() {
        $this->db->select('blood_issue.*,patients.patient_name,patients.gender,blood_donor.donor_name,blood_donor.blood_group');
        $this->db->join('patients', 'patients.id = blood_issue.recieve_to');
        $this->db->join('blood_donor', 'blood_issue.donor_name = blood_donor.id');
        $this->db->order_by('blood_issue.id', 'desc');
        $query = $this->db->get('blood_issue');
        return $query->result_array();
    }

    public function getDetails($id) {
        $this->db->select('blood_issue.*,patients.patient_name,patients.gender,blood_donor.donor_name as donor,blood_donor.blood_group');
        $this->db->join('patients', 'patients.id = blood_issue.recieve_to');
        $this->db->join('blood_donor', 'blood_issue.donor_name = blood_donor.id');
        $this->db->where('patients.is_active', 'yes');

        $this->db->where('blood_issue.id', $id);

        $query = $this->db->get('blood_issue');
        return $query->row_array();
    }

    public function getBillDetails($id) {
        $this->db->select('blood_issue.*,patients.patient_name,patients.blood_group,blood_donor.donor_name,staff.name,staff.surname');
        $this->db->where('blood_issue.id', $id);
        $this->db->join('staff', 'staff.id = blood_issue.generated_by');
        $this->db->join('patients', 'patients.id = blood_issue.recieve_to');
        $this->db->join('blood_donor', 'blood_donor.id = blood_issue.donor_name');


        $query = $this->db->get('blood_issue');
        return $query->row_array();
    }

    function getMaxId() {
        $query = $this->db->select('max(id) as bill_no')->get("blood_issue");
        $result = $query->row_array();
        return $result["bill_no"];
    }

    public function getAllBillDetails($id) {
        $query = $this->db->select('blood_issue.*')
                ->where('blood_issue.id', $id)
                ->get('blood_issue');
        return $query->result_array();
    }

    public function update($bloodissue) {
        $query = $this->db->where('id', $bloodissue['id'])
                ->update('blood_issue', $bloodissue);
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete('blood_issue');
    }

    public function getBloodIssue($id = null) {
        $query = $this->db->select('blood_issue.*,staff.name,staff.surname')
                ->join('staff', 'staff.id = blood_issue.generated_by')
                ->get('blood_issue');
        return $query->result_array();
    }

}
