<?php

class Appointment_model extends CI_Model
{

//========================================================================================
    public function add($appointment)
    {
        $this->db->insert('appointment', $appointment);
        return $this->db->insert_id();
    }

//=========================================================================================
    public function searchFullText()
    {
        $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
        $userdata           = $this->customlib->getUserData();
        $role_id            = $userdata['role_id'];
        if ($doctor_restriction == 'enabled') {
            if ($role_id == 3) {
                $user_id  = $userdata["id"];
                $doctorid = $user_id;
                $this->db->where('appointment.doctor', $user_id);
            }
        }
        $this->db->select('appointment.*,staff.name, IFNULL(patients.patient_name, appointment.patient_name) as patient_name,IFNULL(patients.gender, appointment.gender) as gender, IFNULL(patients.email, appointment.email) as email, IFNULL(patients.mobileno, appointment.mobileno) as mobileno,staff.surname');
        $this->db->join('staff', 'appointment.doctor = staff.id', "inner");
        $this->db->join('patients', 'appointment.patient_id = patients.id', "left");
        $this->db->where('`appointment`.`doctor`=`staff`.`id`');
        $this->db->order_by('`appointment`.`date`', 'desc');
        $query = $this->db->get('appointment');
        return $query->result_array();
    }

//==========================================================================================

    public function getMaxId()
    {
        $query  = $this->db->select('max(id) as maxid')->get("`appointment`");
        $result = $query->row_array();
        return $result["maxid"];
    }

//==========================================================================================
    public function getDetails($id)
    {
        $this->db->select('appointment.*,staff.name,staff.surname,IFNULL(patients.patient_name, appointment.patient_name) as patient_name,IFNULL(patients.gender, appointment.gender) as gender, IFNULL(patients.email, appointment.email) as email, IFNULL(patients.mobileno, appointment.mobileno) as mobileno');
        $this->db->join('staff', 'appointment.doctor = staff.id', "inner");
        $this->db->join('patients', 'appointment.patient_id = patients.id', "left");
        $this->db->where('appointment.id', $id);
        $query = $this->db->get('appointment');
        return $query->row_array();
    }

//=========================================================================================
    public function update($appointment)
    {
        $query = $this->db->where('id', $appointment['id'])
            ->update('appointment', $appointment);
    }

//=========================================================================================
    public function delete($id)
    {
        $this->db->where("id", $id)->delete('appointment');
    }

//=========================================================================================
    public function getAppointment($id = null)
    {
        $query = $this->db->order_by('id', 'desc')->get('appointment');
        return $query->result_array();
    }

//=========================================================================================
    public function status($id, $data)
    {
        $this->db->where("id", $id)->update("appointment", $data);
    }

    public function move($id, $data)
    {
        $this->db->where("id", $id)->update("appointment", $data);
    }

    public function getpatientDetails($id)
    {
        $query = $this->db->select('patients.*')
        // ->join('opd_details', 'patients.id = opd_details.patient_id')
            ->where('patients.patient_unique_id', $id)
            ->get('patients');
        if ($query->num_rows() > 0) {

            return $query->row_array();
        }
        return false;
    }

}
