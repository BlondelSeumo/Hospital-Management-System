<?php

class Blooddonor_model extends CI_Model {

    public function add($bloodbank) {
        $this->db->insert('blood_donor', $bloodbank);
    }

    public function searchFullText() {
        $query = $this->db->order_by('id', 'desc')->get('blood_donor');
        return $query->result_array();
    }

    public function getDetails($id) {
        $this->db->select('blood_donor.*');
        $this->db->where('blood_donor.id', $id);
        $query = $this->db->get('blood_donor');
        return $query->row_array();
    }

    public function update($blooddonor) {
        $query = $this->db->where('id', $blooddonor['id'])
                ->update('blood_donor', $blooddonor);
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete('blood_issue');
    }

    public function getBloodBank($id = null) {
        $query = $this->db->get('blood_donor');
        return $query->result_array();
    }

    public function deleteBloodDonor($id) {
        $this->db->where("blood_donor_id", $id)->delete("blood_donor_cycle");
        $this->db->where("id", $id)->delete("blood_donor");
    }

    public function getDonorBloodgroup($donor_id) {
        $query = $this->db->where("blood_donor.id", $donor_id)->get("blood_donor");

        return $query->row_array();
    }

}
