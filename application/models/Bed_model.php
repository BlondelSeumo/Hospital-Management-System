<?php

Class Bed_model extends CI_Model {

    public function bedcategorie($table_name) {
        $this->db->select('id, name');
        $this->db->from($table_name);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function valid_bed($str) {
        $name = $this->input->post('name');
        if ($this->check_floor_exists($name)) {
            $this->form_validation->set_message('check_exists', 'Bed already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_floor_exists($name) {
        $bedid = $this->input->post("bedid");
        if ($bedid != 0) {
            $data = array('name' => $name, 'id !=' => $bedid);
            $query = $this->db->where($data)->get('bed');

            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('name', $name);
            $query = $this->db->get('bed');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function bedNoType() {
        $query = $this->db->select('bed.*,bed_type.id as btid,bed_type.name as bed_type')
                ->join('bed_type', 'bed.bed_type_id = bed_type.id')
                ->where('bed.is_active', 'yes')
                ->get('bed');
        return $query->result_array();
    }

    public function bed_list($id = null) {
        $data = array();
        $this->db->select('bed.*, bed_type.name as bed_type_name,floor.name as floor_name, bed_group.name as bedgroup,bed_group.id as bedgroupid,patients.id as pid,patients.discharged,patients.is_active as patient_status,patients.patient_unique_id,patients.patient_name,patients.gender,patients.guardian_name,patients.mobileno,ipd_details.date,ipd_details.bed, ipd_details.discharged as ipd_discharged, staff.name as staff,staff.surname')->from('bed');
        $this->db->join('bed_type', 'bed.bed_type_id = bed_type.id','left');
        $this->db->join('bed_group', 'bed.bed_group_id = bed_group.id','left');
        $this->db->join('floor', 'floor.id = bed_group.floor','left');
        $this->db->join('ipd_details', 'bed.id = ipd_details.bed', 'left');
        $this->db->join('staff', 'staff.id = ipd_details.cons_doctor', 'left');
        $this->db->join('patients', 'patients.id = ipd_details.patient_id', 'left');
       // $this->db->group_by('bed.id',$id);
        $this->db->order_by('bed.id', 'asc');

        if ($id) {
            $this->db->where('bed.id', $id);
           // $this->db->group_by('bed.id',$id);
        } else {
            $this->db->order_by('bed.id', 'desc');
        }
        $query = $this->db->get();

      // echo $this->db->last_query();
       // die;
        if ($id != null) {
            $result = $query->row_array();
        } else {
            $result = $query->result_array();
        }


         if (!empty($result)) {
            foreach ($result as $key => $value) {
                if ($value["pid"]) {
                    if (($value['patient_status'] == 'yes') && ($value['ipd_discharged'] == 'no')) {
                        $data[] = $value;
                    //print_r($value);
                   //  exit();
                    } elseif (($value['is_active'] == 'yes')) {
                        $val =  $value['bed'];
                        $data[$val] = $value;
                       
                    }
                } else {
                    $data[] = $value ;
                } 
            }
        }

        
        return $data;
    }


   public function bed_active() {
       
    $query = $this->db->query("SELECT bed.id, bed.name, bed.is_active,patients.id as pid,patients.discharged,patients.is_active as patient_status,patients.patient_unique_id,patients.patient_name,patients.gender,patients.guardian_name,patients.mobileno,ipd_details.bed as bid,ipd_details.discharged as ipd_discharged FROM bed RIGHT JOIN ipd_details ON ipd_details.bed = bed.id RIGHT JOIN patients ON patients.id = ipd_details.patient_id where bed.is_active = 'yes' group by bed.id");

       $result =  $query->result_array();
        
        return $result;
    }
    public function bed_listsearch($id = null) {
        $data = array();
        $this->db->select('bed.*, bed_type.name as bed_type_name,floor.name as floor_name, bed_group.name as bedgroup,bed_group.id as bedgroupid')->from('bed');
        $this->db->join('bed_type', 'bed.bed_type_id = bed_type.id');
        $this->db->join('bed_group', 'bed.bed_group_id = bed_group.id');
        $this->db->join('floor', 'floor.id = bed_group.floor');


        $this->db->order_by('bed.id', 'asc');
        if ($id != null) {
            $this->db->where('bed.id', $id);
        } else {
            $this->db->order_by('bed.id', 'desc');
        }
        $query = $this->db->get();
        if ($id != null) {
            $result = $query->row_array();
        } else {
            $result = $query->result_array();
        }

        return $result;
    }

    public function getBedDetails($id) {
        $data = array();
        $this->db->select('bed.*, bed_type.name as bed_type_name,floor.name as floor_name, bed_group.name as bedgroup,bed_group.id as bedgroupid')->from('bed');
        $this->db->join('bed_type', 'bed.bed_type_id = bed_type.id');
        $this->db->join('bed_group', 'bed.bed_group_id = bed_group.id');
        $this->db->join('floor', 'floor.id = bed_group.floor');
        $this->db->where("bed.id", $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function savebed($data) {
        if (isset($data["id"])) {
            $this->db->where("id", $data["id"])->update("bed", $data);
        } else {
            $this->db->insert("bed", $data);
        }
    }

    public function getbedbybedgroup($bed_group, $active = '', $bed_id) {
        $this->db->select('bed.*, bed_type.name as bed_type_name,bed_group.name as bedgroup ')->from('bed');
        $this->db->join('bed_type', 'bed.bed_type_id = bed_type.id');
        $this->db->join('bed_group', 'bed.bed_group_id = bed_group.id');
        if (!empty($active)) {
            $this->db->where('bed.is_active', $active);
        }
        $this->db->where('bed.bed_group_id', $bed_group);

        if (!empty($bed_id)) {
            $this->db->or_where('bed.id', $bed_id);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete("bed");
    }

    public function getBedStatus() {
        $this->db->select('bed.*, bed_type.name as bed_type_name,bed_group.name as bedgroup,floor.name as floor_name')->from('bed');
        $this->db->join('bed_type', 'bed.bed_type_id = bed_type.id');
        $this->db->join('bed_group', 'bed.bed_group_id = bed_group.id');
        $this->db->join('floor', 'floor.id = bed_group.floor');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function checkbed($bedid) {
        $query = $this->db->select('bed.is_active')->where("id", $bedid)->get("bed");
        $result = $query->row_array();
        if ($result['is_active'] == 'yes') {
            return true;
        } else {
            return false;
        }
    }

}
