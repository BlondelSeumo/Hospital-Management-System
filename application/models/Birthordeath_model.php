<?php

class Birthordeath_model extends CI_Model {

    public function getDetails($id) {

        $this->db->select('birth_report.*,patients.patient_name');
        $this->db->join('patients', 'patients.id = birth_report.mother_name');
        $this->db->where('birth_report.id', $id);
        $query = $this->db->get('birth_report');

        return $query->row_array();
    }

    public function getBirthDetails() {
        $this->db->order_by('id', 'desc');
        $this->db->select('birth_report.*,patients.patient_name');
        $this->db->join('patients', 'patients.id=birth_report.mother_name');
        $query = $this->db->get("birth_report");
        return $query->result_array();
    }

    public function getDetailsCustom($id) {

        $query = $this->db->select('custom_fields.*')->where('id', $id)->get('custom_fields');
        return $query->row_array();
    }

    public function getDeDetails($id) {

        $this->db->select('death_report.*,patients.patient_name,patients.gender,patients.address');
        $this->db->join('patients', 'patients.id = death_report.patient');
        $this->db->where('death_report.id', $id);
        $query = $this->db->get('death_report');


        return $query->row_array();
    }

    public function getDeDetailsCustom($id) {
        $query = $this->db->select('custom_fields.*')->where('id', $id)->get('custom_fields');
        return $query->row_array();
    }

    public function delete($id) {
        $query = $this->db->where('id', $id)
                ->delete('birth_report');
    }

    public function deletecustom($id) {
        $query = $this->db->where('id', $id)
                ->delete('custom_fields');
    }

    public function deletedeath($id) {
        $query = $this->db->where('id', $id)
                ->delete('death_report');
    }

    public function getBirthDetailsCustom() {
        $this->db->order_by('id', 'desc');
        $this->db->select('custom_fields.*');
        $this->db->where('belong_to', 'birth_report');
        $query = $this->db->get("custom_fields");
        return $query->result_array();
    }

    public function getDeathDetailsCustom() {
        $this->db->order_by('id', 'desc');
        $this->db->select('custom_fields.*');
        $this->db->where('belong_to', 'death_report');
        $query = $this->db->get("custom_fields");
        return $query->result_array();
    }

    public function getBirthData($id) {

        $this->db->select('birth_report.*');
        $this->db->where('birth_report.id', $id);
        $query = $this->db->get("birth_report");
        return $query->row_array();
    }

    public function getDeathDetails() {

        $this->db->order_by('id', 'desc');
        $this->db->select('death_report.*,patients.patient_name,patients.gender');
        $this->db->join('patients', 'patients.id = death_report.patient');
        $query = $this->db->get("death_report");
        return $query->result_array();
    }

    public function addDeathdata($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('death_report', $data);
        } else {
            $this->db->insert('death_report', $data);
            return $this->db->insert_id();
        }
    }

    public function addBirthdata($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('birth_report', $data);
        } else {
            $this->db->insert('birth_report', $data);
            return $this->db->insert_id();
        }
    }

}

?>