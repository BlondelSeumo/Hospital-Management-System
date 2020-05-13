<?php

class Blood_donorcycle_model extends CI_Model {

    public function donorCycle($donor_cycle) {
        $this->db->insert('blood_donor_cycle', $donor_cycle);
    }

    public function getDonorBloodBatch($blood_donor_id) {
        $this->db->select('blood_donor_cycle.*, blood_donor.id as blood_donor_id, blood_donor.created_at as donate_date');
        $this->db->join('blood_donor', 'blood_donor_cycle.blood_donor_id = blood_donor.id', 'inner');
        $this->db->where('blood_donor.id', $blood_donor_id);
        $query = $this->db->get('blood_donor_cycle');
        return $query->result();
    }

    public function deleteCycle($id) {
        $this->db->where("id", $id)->delete('blood_donor_cycle');
    }

}
