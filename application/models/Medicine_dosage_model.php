<?php

/**
 * 
 */
class Medicine_dosage_model extends CI_model {

    public function addMedicineDosage($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('medicine_dosage', $data);
        } else {
            $this->db->insert('medicine_dosage', $data);
            return $this->db->insert_id();
        }
    }

    public function getMedicineDosage($id = null) {

        if (!empty($id)) {
            $query = $this->db->select('medicine_dosage.*,medicine_category.medicine_category')
                    ->join('medicine_category', 'medicine_dosage.medicine_category_id = medicine_category.id')
                    ->where('medicine_dosage.id', $id)
                    ->get('medicine_dosage');
            return $query->row_array();
        } else {
            $query = $this->db->select('medicine_dosage.*,medicine_category.medicine_category')
                    ->join('medicine_category', 'medicine_dosage.medicine_category_id = medicine_category.id')
                    ->get('medicine_dosage');

            return $query->result_array();
        }
    }

    public function getDosageByMedicine($medicine) {
        
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete("medicine_dosage");
    }

}

?>