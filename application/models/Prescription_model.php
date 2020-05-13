<?php

class Prescription_model extends CI_Model {

    public function getPatientPrescription($id) {
        $query = $this->db->join("opd_details", "prescription.opd_id = opd_details.id")->where("opd_details.patient_id", $id)->get("prescription");
        return $query->result_array();
    }

    public function get($id) {
        $query = $this->db->select("opd_details.*,patients.*,staff.name,staff.surname,staff.local_address,prescription.opd_id")->join("opd_details", "prescription.opd_id = opd_details.id")->join("patients", "patients.id = opd_details.patient_id")->join("staff", "staff.id = opd_details.cons_doctor")->where("prescription.opd_id", $id)->get("prescription");
        return $query->row_array();
    }

    public function getmanual($opdid) {
        $query = $this->db->select("opd_details.*,patients.id as patientid ,patients.patient_name,patients.patient_unique_id,patients.age,patients.gender,patients.address,staff.name,staff.surname,staff.local_address")->join("patients", "patients.id = opd_details.patient_id")->join("staff", "staff.id = opd_details.cons_doctor")->where("opd_details.id", $opdid)->get("opd_details");
        $result = $query->row_array();
        return $result;
    }

    public function update_prescription($data) {
        $this->db->where('id', $data['id'])->update("prescription", $data);
    }

    public function update_ipdprescription($data) {
        $this->db->where('id', $data['id'])->update("ipd_prescription_details", $data);
    }

    public function delete_prescription($delete_arr) {
        foreach ($delete_arr as $key => $value) {
            $id = $value["id"];
            $this->db->where("id", $id)->delete("prescription");
        }
    }

    public function delete_ipdprescription($delete_arr) {
        foreach ($delete_arr as $key => $value) {
            $id = $value["id"];
            $this->db->where("id", $id)->delete("ipd_prescription_details");
        }
    }

    public function deletePrescription($opdid) {
        $this->db->where("opd_id", $opdid)->delete("prescription");
    }

    public function deleteipdPrescription($id) {
        $this->db->where("basic_id", $id)->delete("ipd_prescription_details");
    }

    public function add_ipdprescriptionbasic($ipd_basic_array) {
        $this->db->insert("ipd_prescription_basic", $ipd_basic_array);
        return $this->db->insert_id();
    }

    public function add_ipdprescriptiondetail($ipd_basic_array) {
        $this->db->insert_batch("ipd_prescription_details", $ipd_basic_array);
        return $this->db->insert_id();
    }

    public function getIpdPrescription($ipdid) {
        $query = $this->db->select('ipd_prescription_basic.*')
                ->join('ipd_prescription_details', 'ipd_prescription_basic.id = ipd_prescription_details.basic_id')
                ->where("ipd_prescription_basic.ipd_id", $ipdid)
                ->group_by("ipd_prescription_basic.id")
                ->get('ipd_prescription_basic');
        return $query->result_array();
    }

    public function getIPD($id) {
        $query = $this->db->select("ipd_details.*,patients.*,staff.name,staff.surname,staff.local_address,ipd_prescription_basic.ipd_id,ipd_prescription_basic.header_note,ipd_prescription_basic.footer_note")->join("ipd_details", "ipd_prescription_basic.ipd_id = ipd_details.id")->join("patients", "patients.id = ipd_details.patient_id")->join("staff", "staff.id = ipd_details.cons_doctor")->where("ipd_prescription_basic.id", $id)->get("ipd_prescription_basic");
        return $query->row_array();
    }

    public function getPrescriptionByOPD($id, $visitid = '') {
        if (!empty($visitid)) {
            $this->db->where("prescription.visit_id", $visitid);
        } else {
            $this->db->where("prescription.visit_id", 0);
        }
        $query = $this->db->select('prescription.*,medicine_category.medicine_category,staff.id as staff_id')->join("opd_details", "prescription.opd_id = opd_details.id")->join("medicine_category", "prescription.medicine_category_id = medicine_category.id")->join("patients", "patients.id = opd_details.patient_id")->join("staff", "staff.id = opd_details.cons_doctor")->where("prescription.opd_id", $id)->get("prescription");

        $result = $query->result_array();
        $i = 0;
        foreach ($result as $key => $value) {
            $opd_id = $value["id"];
            $check = $this->db->where("opd_id", $id)->get('prescription');
            if ($check->num_rows() > 0) {
                $result[$i]['prescription'] = 'yes';
            } else {
                $result[$i]['prescription'] = 'no';
                $userdata = $this->customlib->getUserData();
                if ($this->session->has_userdata('hospitaladmin')) {
                    $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
                    if ($doctor_restriction == 'enabled') {
                        if ($userdata["role_id"] == 3) {
                            if ($userdata["id"] == $value["staff_id"]) {
                                
                            } else {
                                $result[$i]['prescription'] = 'not_applicable';
                            }
                        }
                    }
                }
            }
            $i++;
        }
        return $result;
    }

    public function getPrescriptionByIPD($id,$ipdid, $visitid = '') {

         $query = $this->db->select('ipd_prescription_details.*,medicine_category.medicine_category,medicine_dosage.dosage')
                ->join("ipd_prescription_basic", "ipd_prescription_basic.id = ipd_prescription_details.basic_id")
                ->join("ipd_details", "ipd_prescription_basic.ipd_id = ipd_details.id","LEFT")
                ->join("medicine_category", "ipd_prescription_details.medicine_category_id = medicine_category.id","LEFT")
                ->join("patients", "patients.id = ipd_details.patient_id","LEFT")
                ->join("staff", "staff.id = ipd_details.cons_doctor","LEFT")
                ->join("medicine_dosage", "medicine_dosage.id=ipd_prescription_details.dosage","LEFT")
                ->where("ipd_prescription_details.basic_id", $id)
                ->get("ipd_prescription_details");
        

        /* $query = $this->db->select('ipd_prescription_details.*,medicine_category.medicine_category')
                ->join("medicine_category", "ipd_prescription_details.medicine_category_id = medicine_category.id","LEFT")
                ->where("ipd_prescription_details.id", $id)
                ->get("ipd_prescription_details");*/

        $result = $query->result_array();   

       

        $i = 0;
        foreach ($result as $key => $value) {
            $ipd_id = $value["id"];
            $check = $this->db->where("ipd_id", $id)->get('ipd_prescription_basic');
            if ($check->num_rows() > 0) {
                $result[$i]['prescription'] = 'yes';
            } else {
                $result[$i]['prescription'] = 'no';
                $userdata = $this->customlib->getUserData();
                $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
                if ($doctor_restriction == 'enabled') {
                    if ($userdata["role_id"] == 3) {
                        if ($userdata["id"] == $value["staff_id"]) {
                            
                        } else {
                            $result[$i]['prescription'] = 'not_applicable';
                        }
                    }
                }
            }
            $i++;
        }
        return $result;
    }


   

}

?>