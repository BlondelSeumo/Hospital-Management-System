<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tpa_model extends CI_Model {

    function add($data) {
        $this->db->insert_batch("organisations_charges", $data);
    }

    function addcharge($data) {
        $this->db->insert_batch("tpa_doctorcharges", $data);
    }

    public function charge($org_id, $ch_type) {

        $sql = "SELECT * FROM charges WHERE id not in (SELECT charge_id from `organisations_charges` WHERE organisations_charges.org_id = " . $org_id . " ) and charges.charge_type = '" . $ch_type . "'";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function org_charge($org_id, $charge_type) {

        $this->db->select('organisations_charges.*, charges.description, charges.standard_charge,charges.charge_category, charges.code');
        $this->db->join('charges', 'charges.id=organisations_charges.charge_id', 'inner');
        $this->db->where('organisations_charges.charge_type', $charge_type);
        $this->db->where('organisations_charges.org_id', $org_id);
        $query = $this->db->get('organisations_charges');
        return $query->result_array();
    }

    public function get_org_charge($id) {

        $this->db->select('charges.*,organisations_charges.id as org_charge_id, organisations_charges.org_charge');
        $this->db->join('charges', 'charges.id=organisations_charges.charge_id', 'inner');
        $this->db->where('organisations_charges.id', $id);
        $query = $this->db->get('organisations_charges');
        return $query->row_array();
    }

    public function edit_org($id, $charge) {

        $this->db->where('id', $id);
        $this->db->update('organisations_charges', $charge);
    }

    public function edit_orgtpa($id, $charge) {

        $this->db->where('id', $id);
        $this->db->update('tpa_doctorcharges', $charge);
    }

    public function delete($id) {

        $this->db->where('id', $id);
        $this->db->delete('organisations_charges');
    }

}

?>