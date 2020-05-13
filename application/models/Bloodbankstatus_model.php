<?php

class Bloodbankstatus_model extends CI_model {

    public function getBloodGroup($id = null) {
        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get('blood_bank_status');
            return $query->row_array();
        } else {
            $query = $this->db->get("blood_bank_status");
            return $query->result_array();
        }
    }

    public function getBloodbank($patient_id) {
        $query = $this->db->select('blood_issue.*,patients.patient_name,blood_donor.donor_name as donorname,blood_donor.blood_group as bloodgroup')
                ->join('blood_donor', 'blood_donor.id = blood_issue.donor_name')
                ->join('patients', 'patients.id = blood_issue.recieve_to')
                ->where('blood_issue.recieve_to', $patient_id)
                ->get('blood_issue');
        return $query->result_array();
    }

    public function getBillDetailsBloodbank($id) {
        $query = $this->db->select('blood_issue.*,patients.patient_name,blood_donor.donor_name as donorname,blood_donor.blood_group as bloodgroup')
                ->join('blood_donor', 'blood_donor.id = blood_issue.donor_name')
                ->join('patients', 'patients.id = blood_issue.recieve_to')
                ->where('blood_issue.id', $id)
                ->get('blood_issue');
        return $query->row_array();
    }

    public function addBloodGroup($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('blood_bank_status', $data);
        } else {
            $this->db->insert('blood_bank_status', $data);
            return $this->db->insert_id();
        }
    }

    public function getall() {
        $this->datatables->select('id,blood_group,status');
        $this->datatables->from('blood_bank_status');
        $this->datatables->add_column('view', '<a href="' . site_url('admin/bloodbankstatuss/edit/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Edit"> <i class="fa fa-pencil"></i></a><a href="' . site_url('admin/bloodgroup/delete/$1') . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Delete">
                                                        <i class="fa fa-remove"></i>
                                                    </a>', 'id,status');
        return $this->datatables->generate();
    }

}
