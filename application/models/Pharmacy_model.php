<?php

class Pharmacy_model extends CI_Model {
//---------------------------Server side code datatable--------------------------------------
    var $column_order = array('medicine_name','medicine_company','medicine_composition','medicine_category','medicine_group','unit'); //set column field database for datatable orderable
    var $column_search = array('medicine_name','medicine_company','medicine_composition','medicine_category','medicine_group','unit');




//---------------------------Server side code datatable--------------------------------------

    public function add($pharmacy) {
        $this->db->insert('pharmacy', $pharmacy);
        return $this->db->insert_id();
    }

    public function addImport($medicine_data) {
        $this->db->insert('pharmacy', $medicine_data);
        return $this->db->insert_id();
    }

    public function search_datatable() {

        $this->db->select('pharmacy.*,medicine_category.id as medicine_category_id,medicine_category.medicine_category,(SELECT sum(available_quantity) FROM `medicine_batch_details` WHERE pharmacy_id=pharmacy.id) as `total_qty`');
        $this->db->join('medicine_category', 'pharmacy.medicine_category_id = medicine_category.id', 'left');
        $this->db->where('`pharmacy`.`medicine_category_id`=`medicine_category`.`id`'); 

        if(!empty($_POST['search']['value']) ) {   // if there is a search parameter
            $counter=true;
            $this->db->group_start();
  
         foreach ($this->column_search as $colomn_key => $colomn_value) {
         if($counter){
              $this->db->like($colomn_value, $_POST['search']['value']);      
              $counter=false;
         }
              $this->db->or_like($colomn_value, $_POST['search']['value']);
        }
        $this->db->group_end();
           
        }


        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->order_by($this->column_order[$_POST['order'][0]['column']],$_POST['order'][0]['dir']);
        $query = $this->db->get('pharmacy');
        return $query->result();
    }
        public function search_datatable_count() {
        
        $this->db->join('medicine_category', 'pharmacy.medicine_category_id = medicine_category.id', 'left');
        $this->db->where('`pharmacy`.`medicine_category_id`=`medicine_category`.`id`');
        if(!empty($_POST['search']['value']) ) {   // if there is a search parameter
            $counter=true;
            $this->db->group_start();
  
         foreach ($this->column_search as $colomn_key => $colomn_value) {
         if($counter){
              $this->db->like($colomn_value, $_POST['search']['value']);      
              $counter=false;
         }
              $this->db->or_like($colomn_value, $_POST['search']['value']);
        }
        $this->db->group_end();
           
        }

        $query = $this->db->from('pharmacy');
        $total_result= $query->count_all_results();
        return $total_result;
    }

       public function searchFullText() {
        $this->db->select('pharmacy.*,medicine_category.id as medicine_category_id,medicine_category.medicine_category');
        $this->db->join('medicine_category', 'pharmacy.medicine_category_id = medicine_category.id', 'left');
        $this->db->where('`pharmacy`.`medicine_category_id`=`medicine_category`.`id`');
        $this->db->order_by('pharmacy.medicine_name');
        $query = $this->db->get('pharmacy');
        return $query->result_array();
    }

     public function searchtestdata() {
        $this->db->select('pharmacy.*');
       
        $this->db->order_by('pharmacy.medicine_name');
        $query = $this->db->get('pharmacy');
        return $query->result_array();
    }


    function check_medicine_exists($medicine_name, $medicine_category_id) {

        $this->db->where(array('medicine_category_id' => $medicine_category_id, 'medicine_name' => $medicine_name));
        $query = $this->db->join("medicine_category", "medicine_category.id = pharmacy.medicine_category_id")->get('pharmacy');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function searchFullTextPurchase() {
        $this->db->select('supplier_bill_detail.*,supplier_bill_basic.supplier_id,supplier_bill_basic.supplier_name,supplier_bill_basic.total,supplier_bill_basic.net_amount,supplier_category.supplier_category,supplier_category.supplier_person,supplier_category.supplier_person,supplier_category.contact,supplier_category.supplier_person_contact,supplier_category.address,medicine_category,pharmacy.medicine_name');
        $this->db->join('supplier_bill_basic', 'supplier_bill_detail.supplier_bill_basic_id=supplier_bill_basic.id');
        $this->db->join('supplier_category', 'supplier_bill_basic.supplier_id=supplier_category.id');
        $this->db->join('medicine_category', 'supplier_bill_detail.medicine_category_id = medicine_category.id', 'left');
        $this->db->join('pharmacy', 'supplier_bill_detail.medicine_name = pharmacy.id', 'left');


        $query = $this->db->get('supplier_bill_detail');
        return $query->result_array();
    }

    public function getDetails($id) {
        $this->db->select('pharmacy.*,medicine_category.id as medicine_category_id,medicine_category.medicine_category');
        $this->db->join('medicine_category', 'pharmacy.medicine_category_id = medicine_category.id', 'inner');
        $this->db->where('pharmacy.id', $id);
        $this->db->order_by('pharmacy.id', 'desc');
        $query = $this->db->get('pharmacy');
        return $query->row_array();
    }

    public function update($pharmacy) {
        $query = $this->db->where('id', $pharmacy['id'])
                ->update('pharmacy', $pharmacy);
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete('pharmacy');
    }

    public function getPharmacy($id = null) {
        $query = $this->db->get('pharmacy');
        return $query->result_array();
    }

    public function medicineDetail($medicine_batch) {
        $this->db->insert('medicine_batch_details', $medicine_batch);
    }

    public function getMedicineBatch($pharm_id) {
        $this->db->select('medicine_batch_details.*, pharmacy.id as pharmacy_id, pharmacy.medicine_name');
        $this->db->join('pharmacy', 'medicine_batch_details.pharmacy_id = pharmacy.id', 'inner');
        $this->db->where('pharmacy.id', $pharm_id);
        $query = $this->db->get('medicine_batch_details');
        return $query->result();
    }

    public function getMedicineName() {
        $query = $this->db->select('pharmacy.id,pharmacy.medicine_name')->get('pharmacy');
        return $query->result_array();
    }

    public function getMedicineNamePat() {
        $query = $this->db->select('pharmacy.id,pharmacy.medicine_name')->get('pharmacy');
        return $query->result_array();
    }

    public function addBill($data) {
        if (isset($data["id"])) {
            $this->db->where("id", $data["id"])->update("pharmacy_bill_basic", $data);
        } else {
            $this->db->insert("pharmacy_bill_basic", $data);
            $Id = $this->db->insert_id();
            return $Id;
        }
    }

    public function addBillSupplier($data) {
        if (isset($data["id"])) {
            $this->db->where("id", $data["id"])->update("supplier_bill_basic", $data);
        } else {
            $this->db->insert("supplier_bill_basic", $data);
            return $this->db->insert_id();
        }
    }

    public function addBillBatch($data) {
        $query = $this->db->insert_batch('pharmacy_bill_detail', $data);
    }

    public function addBillBatchSupplier($data) {
        $query = $this->db->insert_batch('supplier_bill_detail', $data);
    }

    public function addBillMedicineBatchSupplier($data1) {
        $query = $this->db->insert_batch('medicine_batch_details', $data1);
    }

    public function updateBillBatch($data) {
        $this->db->where('pharmacy_bill_basic_id', $data['id'])->update('pharmacy_bill_detail');
    }

    public function updateBillBatchSupplier($data) {
        $this->db->where('supplier_bill_basic_id', $data['id'])->update('supplier_bill_basic_id');
    }

    public function updateBillDetail($data) {
        $this->db->where('id', $data['id'])->update('pharmacy_bill_detail', $data);
    }

    public function updateBillSupplierDetail($data) {
        $this->db->where('id', $data['id'])->update('supplier_bill_detail', $data);
    }

    public function updateMedicineBatchDetail($data1) {

        $query = $this->db->where('id', $data1['id'])->update('medicine_batch_details', $data1);
        $this->db->last_query();
    }

    public function deletePharmacyBill($id) {
        $query = $this->db->where("pharmacy_bill_basic_id", $id)->delete("pharmacy_bill_detail");
        if ($query) {
            $this->db->where("id", $id)->delete("pharmacy_bill_basic");
        }
    }

    public function deleteSupplierBill($id) {
        $query = $this->db->where("supplier_bill_basic_id", $id)->delete("medicine_batch_details");
        if ($query) {
            $this->db->where("id", $id)->delete("supplier_bill_basic");
        }
    }

    function getMaxId() {
        $query = $this->db->select('max(id) as purchase_no')->get("supplier_bill_basic");
        $result = $query->row_array();
        return $result["purchase_no"];
    }
    function getindate($purchase_id) {
      $query = $this->db->select('supplier_bill_basic.*,')
                ->where('supplier_bill_basic.id', $purchase_id)
                ->get('supplier_bill_basic');
    return $query->row_array();
    }

    function getdate($id) {
      $query = $this->db->select('pharmacy_bill_basic.*,')
                ->where('pharmacy_bill_basic.id', $id)
                ->get('pharmacy_bill_basic');
    return $query->row_array();
    }
    public function getSupplier() {
        $query = $this->db->select('supplier_bill_basic.*,supplier_category.supplier_category')
                ->join('supplier_category', 'supplier_category.id = supplier_bill_basic.supplier_id')
                ->order_by('id', 'desc')
                ->get('supplier_bill_basic');
        return $query->result_array();
    }

    public function getBillBasic($limit=100,$start="") {
        $query = $this->db->select('pharmacy_bill_basic.*,patients.patient_name')
                ->order_by('pharmacy_bill_basic.id', 'desc')
                ->join('patients', 'patients.id = pharmacy_bill_basic.patient_id')
                ->where("patients.is_active", "yes")->limit($limit,$start)
                ->get('pharmacy_bill_basic');
        return $query->result_array();
    }

    public function getBillBasicPat($patient_id) {

        $this->db->select('pharmacy_bill_basic.*');
        $this->db->where('patient_id', $patient_id);
        $query = $this->db->get('pharmacy_bill_basic');

        return $query->result_array();
    }

    public function get_medicine_name($medicine_category_id) {
        $this->db->select('pharmacy.*');
        $this->db->where('pharmacy.medicine_category_id', $medicine_category_id);
        $query = $this->db->get('pharmacy');
        return $query->result_array();
    }

    public function get_medicine_dosage($medicine_category_id) {
        $this->db->select('medicine_dosage.dosage,medicine_dosage.id');
        $this->db->where('medicine_dosage.medicine_category_id', $medicine_category_id);
        $query = $this->db->get('medicine_dosage');

        return $query->result_array();
    }

    public function get_supplier_name($supplier_category_id) {
        $query = $this->db->where("id", $supplier_category_id)->get("supplier_category");
        return $query->result_array();
    }

    public function getBillDetails($id) {
        $this->db->select('pharmacy_bill_basic.*,staff.name,staff.surname,patients.patient_name,patients.id as patientid,patients.patient_unique_id');
        $this->db->join('patients', 'pharmacy_bill_basic.patient_id = patients.id');
        $this->db->join('staff', 'pharmacy_bill_basic.generated_by = staff.id');
        $this->db->where('pharmacy_bill_basic.id', $id);
        $query = $this->db->get('pharmacy_bill_basic');
        return $query->row_array();
    }

    public function getAllBillDetails($id) {
        $query = $this->db->select('pharmacy_bill_detail.*,pharmacy.medicine_name,pharmacy.unit,pharmacy.id as medicine_id')
                ->join('pharmacy', 'pharmacy_bill_detail.medicine_name = pharmacy.id')
                ->where('pharmacy_bill_basic_id', $id)
                ->get('pharmacy_bill_detail');
        return $query->result_array();
    }

    public function getSupplierDetails($id) {
        $this->db->select('supplier_bill_basic.*,supplier_category.supplier_category,supplier_category.supplier_person,supplier_category.contact,supplier_category.address');
        $this->db->join('supplier_category', 'supplier_category.id=supplier_bill_basic.supplier_id');
        $this->db->where('supplier_bill_basic.id', $id);
        $query = $this->db->get('supplier_bill_basic');
        return $query->row_array();
    }

    public function getAllSupplierDetails($id) {
        $query = $this->db->select('medicine_batch_details.*,pharmacy.medicine_name,pharmacy.unit,pharmacy.id as medicine_id,medicine_category.medicine_category')
                ->join('pharmacy', 'medicine_batch_details.pharmacy_id = pharmacy.id')
                ->join('medicine_category', 'medicine_batch_details.medicine_category_id = medicine_category.id')
                ->where('medicine_batch_details.supplier_bill_basic_id', $id)
                ->get('medicine_batch_details');
        return $query->result_array();
    }

    public function getBillDetailsPharma($id) {
        $this->db->select('pharmacy_bill_basic.*');
        $this->db->where('pharmacy_bill_basic.id', $id);
        $query = $this->db->get('pharmacy_bill_basic');
        return $query->row_array();
    }

    public function getAllBillDetailsPharma($id) {
        $query = $this->db->select('pharmacy_bill_detail.*,pharmacy.medicine_name,pharmacy.unit,pharmacy.id as medicine_id')
                ->join('pharmacy', 'pharmacy_bill_detail.medicine_name = pharmacy.id')
                ->where('pharmacy_bill_basic_id', $id)
                ->get('pharmacy_bill_detail');
        return $query->result_array();
    }

    public function getQuantity($batch_no,$med_id) {
        $query = $this->db->select('medicine_batch_details.id,medicine_batch_details.available_quantity,medicine_batch_details.quantity,medicine_batch_details.purchase_price,medicine_batch_details.sale_rate')
                ->where('batch_no', $batch_no)
                ->where('pharmacy_id', $med_id)
                ->get('medicine_batch_details');
        return $query->row_array();
    }
     public function getQuantityedit($batch_no) {
        $query = $this->db->select('medicine_batch_details.id,medicine_batch_details.available_quantity,medicine_batch_details.quantity,medicine_batch_details.purchase_price,medicine_batch_details.sale_rate')
                ->where('batch_no', $batch_no)
                //->where('pharmacy_id', $med_id)
                ->get('medicine_batch_details');
        return $query->row_array();
    }

    public function checkvalid_medicine_exists($str) {
        $medicine_name = $this->input->post('medicine_name');

        if ($this->check_medicie_exists($medicine_name)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_medicie_exists($name, $id) {
        if ($id != 0) {
            $data = array('id != ' => $id, 'medicine_name' => $name);
            $query = $this->db->where($data)->get('pharmacy');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('medicine_name', $name);
            $query = $this->db->get('pharmacy');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function availableQty($update_quantity) {
        $query = $this->db->where('id', $update_quantity['id'])
                ->update('medicine_batch_details', $update_quantity);
    }

    public function totalQuantity($pharmacy_id) {
        $query = $this->db->select('sum(available_quantity) as total_qty')
                ->where('pharmacy_id', $pharmacy_id)
                ->get('medicine_batch_details');
        return $query->row_array();
    }

    public function searchBillReport($date_from, $date_to) {
        $this->db->select('pharmacy_bill_basic.*');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get("pharmacy_bill_basic");
        return $query->result_array();
    }

    public function delete_medicine_batch($id) {
        $this->db->where("id", $id)->delete("medicine_batch_details");
    }

    public function delete_bill_detail($delete_arr) {
        foreach ($delete_arr as $key => $value) {
            $id = $value["id"];
            $this->db->where("id", $id)->delete("prescription");
        }
    }

    public function getBillNo() {
        $query = $this->db->select("max(id) as id")->get('pharmacy_bill_basic');

        return $query->row_array();
    }

    public function getExpiryDate($batch_no,$med_id) {
        $query = $this->db->where("batch_no", $batch_no)
                ->where("pharmacy_id",$med_id)
                ->get('medicine_batch_details');
        return $query->row_array();
    }
    public function getExpireDate($batch_no) {
        $query = $this->db->where("batch_no", $batch_no)
                //->where("pharmacy_id",$med_id)
                ->get('medicine_batch_details');
        return $query->row_array();
    }

    public function getBatchNoList($medicine) {
        $query = $this->db->where('pharmacy_id', $medicine)
                ->where('available_quantity >', 0)
                ->get('medicine_batch_details');
        return $query->result_array();
    }

    public function addBadStock($data) {
        $this->db->insert("medicine_bad_stock", $data);
    }

    public function updateMedicineBatch($data) {
        $this->db->where("id", $data["id"])->update("medicine_batch_details", $data);
    }

    public function getMedicineBadStock($id) {
        $query = $this->db->where("pharmacy_id", $id)->get("medicine_bad_stock");
        return $query->result();
    }

    public function deleteBadStock($id) {
        $this->db->where("id", $id)->delete("medicine_bad_stock");
    }

    public function searchNameLike($category, $value) {
        $query = $this->db->where("medicine_category_id", $category)->like("medicine_name", $value)->get("pharmacy");
        return $query->result_array();
    }

}

?>