<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pharmacy extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->load->library('mailsmsconf');
        $this->load->library('encoding_lib');
        $this->load->library('CSVReader');
        $this->load->model('pharmacy_model');
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->search_type = $this->config->item('search_type');
        $this->blood_group = $this->config->item('bloodgroup');
        $this->charge_type = $this->config->item('charge_type');
        $data["charge_type"] = $this->charge_type;
        $this->patient_login_prefix = "pat";
        $this->config->load("image_valid");
    }

    public function unauthorized() {
        $data = array();
        $this->load->view('layout/header', $data);
        $this->load->view('unauthorized', $data);
        $this->load->view('layout/footer', $data);
    }

    public function add() {
        if (!$this->rbac->hasPrivilege('medicine', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules(
                'medicine_name', $this->lang->line('medicine') . " " . $this->lang->line('category'), array('required',
            array('check_exists', array($this->medicine_category_model, 'valid_medicine_name'))
                )
        );
        $this->form_validation->set_rules('medicine_category_id', $this->lang->line('medicine') . " " . $this->lang->line('category'), 'required');
        $this->form_validation->set_rules('medicine_company', $this->lang->line('medicine') . " " . $this->lang->line('company'), 'required');
        $this->form_validation->set_rules('medicine_composition', $this->lang->line('medicine') . " " . $this->lang->line('composition'), 'required');
        $this->form_validation->set_rules('medicine_group', $this->lang->line('medicine') . " " . $this->lang->line('group'), 'required');
        $this->form_validation->set_rules('unit', $this->lang->line('unit'), 'required');
        $this->form_validation->set_rules('unit_packing', $this->lang->line('unit') . "/" . $this->lang->line('packing'), 'required');
        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_upload', 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'medicine_name' => form_error('medicine_name'),
                'medicine_category_id' => form_error('medicine_category_id'),
                'medicine_company' => form_error('medicine_company'),
                'medicine_composition' => form_error('medicine_composition'),
                'medicine_group' => form_error('medicine_group'),
                'unit' => form_error('unit'),
                'unit_packing' => form_error('unit_packing'),
                'file' => form_error('file')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $pharmacy = array('medicine_name' => $this->input->post('medicine_name'),
                'medicine_category_id' => $this->input->post('medicine_category_id'),
                'medicine_company' => $this->input->post('medicine_company'),
                'medicine_composition' => $this->input->post('medicine_composition'),
                'medicine_group' => $this->input->post('medicine_group'),
                'unit' => $this->input->post('unit'),
                'min_level' => $this->input->post('min_level'),
                'reorder_level' => $this->input->post('reorder_level'),
                'vat' => $this->input->post('vat'),
                'unit_packing' => $this->input->post('unit_packing'),
                'supplier' => $this->input->post('supplier'),
                'note' => $this->input->post('note'),
                'vat_ac' => $this->input->post('vat_ac')
            );
            $insert_id = $this->pharmacy_model->add($pharmacy);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/medicine_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'medicine_image' => 'uploads/medicine_images/' . $img_name);
                $this->pharmacy_model->update($data_img);
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function search() {
        if (!$this->rbac->hasPrivilege('medicine', 'can_view')) {
            access_denied();
        }
        $medicineCategory = $this->medicine_category_model->getMedicineCategory();
        $data["medicineCategory"] = $medicineCategory;
        $resultlist = $this->pharmacy_model->searchFullText();
        $i = 0;
        foreach ($resultlist as $value) {
            $pharmacy_id = $value['id'];
            $available_qty = $this->pharmacy_model->totalQuantity($pharmacy_id);
            $totalAvailableQty = $available_qty['total_qty'];
            $resultlist[$i]["total_qty"] = $totalAvailableQty;
            $i++;
        }
        $result = $this->pharmacy_model->getPharmacy();
        $data['resultlist'] = $resultlist;
        $data['result'] = $result;
        $this->load->view('layout/header');
        $this->load->view('admin/pharmacy/search', $data);
        $this->load->view('layout/footer');
    }

public function dt_search(){

        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $where_condition=array();
        if( !empty($_POST['search']['value']) ) {
            $where_condition=array('search'=>$_POST['search']['value']);
        }
        $resultlist = $this->pharmacy_model->search_datatable($where_condition);
        $total_result = $this->pharmacy_model->search_datatable_count($where_condition);
       

        $data = array();
        foreach ($resultlist as $result_key => $result_value) {
            $status = "";
            if ($result_value->total_qty <= 0) {
          
                $status = " <span class='text text-danger'> (" . $this->lang->line('out_of_stock') . ")</span>";
            } elseif ($result_value->total_qty <= $result_value->min_level) {
             
                $status = " <span class='text text-warning'> (" . $this->lang->line('low_stock') . ")</span>";
            } else if ($result_value->total_qty <= $result_value->reorder_level) {
             
                $status = "";
                 $status = " <span class='text text-info'> (" . $this->lang->line('reorder') . ")</span>";
            }

        $nestedData=array();    
        $action="<div class='rowoptionview'>";  
        $action.="<a href='#' onclick='viewDetail(".$result_value->id.")' class='btn btn-default btn-xs' data-toggle='tooltip' title='".$this->lang->line('show')."' ><i class='fa fa-reorder'></i></a>"; 
        $action.="<a href='#' class='btn btn-default btn-xs' onclick='addbadstock(".$result_value->id.")' data-toggle='tooltip' title='".$this->lang->line('add') . ' ' . $this->lang->line('bad') . ' ' . $this->lang->line('stock')."' > <i class='fas fa-minus-square'></i> </a>";
                $action.="<div'>";  

        $nestedData[]=$result_value->medicine_name.$action;
        $nestedData[]=$result_value->medicine_company;
        $nestedData[]=$result_value->medicine_composition;
        $nestedData[]=$result_value->medicine_category;
        $nestedData[]=$result_value->medicine_group;
        $nestedData[]=$result_value->unit;
        $nestedData[]=$result_value->total_qty.$status;    
        $data[] = $nestedData;
}


        $json_data = array(
            "draw"            => intval($draw),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval($total_result),  // total number of records
            "recordsFiltered" => intval($total_result), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

}


//======================================================================================
    public function handle_upload() {
        $image_validate = $this->config->item('image_validate');
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @getimagesize($_FILES['file']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array(strtolower($ext), $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }

    public function check_upload() {
        $image_validate = $this->config->item('image_validate');
        if (isset($_FILES["medicine_image"]) && !empty($_FILES['medicine_image']['name'])) {

            $file_type = $_FILES["medicine_image"]['type'];
            $file_size = $_FILES["medicine_image"]["size"];
            $file_name = $_FILES["medicine_image"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @getimagesize($_FILES['medicine_image']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('check_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('check_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('check_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('check_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }

    public function getindate() {
        $purchase_id = $this->input->post("purchase_id");
        $result = $this->pharmacy_model->getindate($purchase_id);
        echo json_encode($result);

    }

    public function getdate() {
        $id = $this->input->post("id");
        $result = $this->pharmacy_model->getdate($id);
        echo json_encode($result);

    }
    public function purchase() {
        if (!$this->rbac->hasPrivilege('medicine_purchase', 'can_view')) {
            access_denied();
        }
        $medicineCategory = $this->medicine_category_model->getMedicineCategory();
        $data["medicineCategory"] = $medicineCategory;
        $supplierCategory = $this->medicine_category_model->getSupplierCategory();
        $data["supplierCategory"] = $supplierCategory;

        $resultlist = $this->pharmacy_model->getSupplier();
        $i = 0;
        foreach ($resultlist as $value) {
            $pharmacy_id = $value['id'];
            $available_qty = $this->pharmacy_model->totalQuantity($pharmacy_id);
            $totalAvailableQty = $available_qty['total_qty'];
            $resultlist[$i]["total_qty"] = $totalAvailableQty;
            $i++;
        }
        $result = $this->pharmacy_model->getPharmacy();
        $data['resultlist'] = $resultlist;
        $data['result'] = $result;
        $this->load->view('layout/header');
        $this->load->view('admin/pharmacy/purchase.php', $data);
        $this->load->view('layout/footer');
    }

    public function exportformat() {
        $this->load->helper('download');
        $filepath = "./backend/import/import_medicine_sample_file.csv";
        $data = file_get_contents($filepath);
        $name = 'import_medicine_sample_file.csv';

        force_download($name, $data);
    }

    public function import() {
        if (!$this->rbac->hasPrivilege('import_medicine', 'can_view')) {
            access_denied();
        }
        $this->form_validation->set_rules('medicine_category_id', $this->lang->line('medicine') . " " . $this->lang->line('category'), 'required|trim|xss_clean');

        $this->form_validation->set_rules('file', $this->lang->line('file'), 'callback_handle_csv_upload');
        $medicineCategory = $this->medicine_category_model->getMedicineCategory();
        $data["medicineCategory"] = $medicineCategory;
        $fields = array('medicine_name', 'medicine_company', 'medicine_composition', 'medicine_group', 'unit', 'min_level', 'reorder_level', 'vat', 'unit_packing', 'note');
        $data["fields"] = $fields;

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'medicine_category_id' => form_error('medicine_category_id'),
                'file' => form_error('file'),
                
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');

            $this->load->view('layout/header');
            $this->load->view('admin/pharmacy/import', $data);
            $this->load->view('layout/footer');
        } else {
            $medicine_category_id = $this->input->post('medicine_category_id');
           // print_r($medicine_category_id);
          //  exit();
            $session = $this->setting_model->getCurrentSession();
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                
                if ($ext == 'csv') {
                    $file = $_FILES['file']['tmp_name'];

                    $result = $this->csvreader->parse_file($file);
                    if (!empty($result)) {
                        $count = 0;
                        for ($i = 1; $i <= count($result); $i++) {

                            $medicine_data[$i] = array();
                            $n = 0;
                            foreach ($result[$i] as $key => $value) {

                                $medicine_data[$i][$fields[$n]] = $this->encoding_lib->toUTF8($result[$i][$key]);
                                $medicine_data[$i]['is_active'] = 'yes';
                                $medicine_data[$i]['medicine_category_id'] = $medicine_category_id;

                                $n++;
                            }

                            $medicine_name = $medicine_data[$i]["medicine_name"];
                            if (!empty($medicine_name)) {
                                if ($this->pharmacy_model->check_medicine_exists($medicine_name, $medicine_category_id)) {
                                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">' . $this->lang->line('record_already_exists') . '</div>');

                                    $insert_id = "";
                                } else {
                                    $insert_id = $this->pharmacy_model->addImport($medicine_data[$i]);
                                }
                            }

                            if (!empty($insert_id)) {
                                $data['csvData'] = $result;
                                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">' . $this->lang->line('students_imported_successfully') . '</div>');
                                $count++;
                                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Total ' . count($result) . " records found in CSV file. Total " . $count . ' records imported successfully.</div>');
                            } else {

                                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">' . $this->lang->line('record_already_exists') . '</div>');
                            }
                        }
                    }
                }
                redirect('admin/pharmacy/import');
            }
        }
    }


     public function handle_csv_upload() {

        $image_validate = $this->config->item('filecsv_validate');

        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = filesize($_FILES['file']['tmp_name'])) {

                if (!in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_csv_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_csv_upload', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_csv_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_csv_upload', "File Type / Extension Not Allowed");
                return false;
            }

            return true;
        }else{
          $this->form_validation->set_message('handle_csv_upload', "File field is required");
                return false;  
        }
        return true;
    }

    public function getDetails() {
        if (!$this->rbac->hasPrivilege('medicine', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("pharmacy_id");
        $result = $this->pharmacy_model->getDetails($id);
        echo json_encode($result);
    }

    public function update() {
        if (!$this->rbac->hasPrivilege('medicine', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('medicine_name', $this->lang->line('medicine') . " " . $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('medicine_category_id', $this->lang->line('medicine') . " " . $this->lang->line('category') . " " . $this->lang->line('id'), 'required');
        $this->form_validation->set_rules('medicine_company', $this->lang->line('medicine') . " " . $this->lang->line('company'), 'required');
        $this->form_validation->set_rules('medicine_composition', $this->lang->line('medicine') . " " . $this->lang->line('composition'), 'required');
        $this->form_validation->set_rules('medicine_group', $this->lang->line('medicine') . " " . $this->lang->line('group'), 'required');
        $this->form_validation->set_rules('unit', $this->lang->line('unit'), 'required');
        $this->form_validation->set_rules('unit_packing', $this->lang->line('unit') . "/" . $this->lang->line('packing'), 'required');
        $this->form_validation->set_rules('medicine_image', $this->lang->line('image'), 'callback_check_upload');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'medicine_name' => form_error('medicine_name'),
                'medicine_category_id' => form_error('medicine_category_id'),
                //'supplier_category_id' => form_error('supplier_category_id'),
                'medicine_company' => form_error('medicine_company'),
                'medicine_composition' => form_error('medicine_composition'),
                'medicine_group' => form_error('medicine_group'),
                'unit' => form_error('unit'),
                'unit_packing' => form_error('unit_packing'),
                'medicine_image' => form_error('medicine_image')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('id');
            $pharmacy = array(
                'id' => $id,
                'medicine_name' => $this->input->post('medicine_name'),
                'medicine_category_id' => $this->input->post('medicine_category_id'),
                'medicine_company' => $this->input->post('medicine_company'),
                'medicine_composition' => $this->input->post('medicine_composition'),
                'medicine_group' => $this->input->post('medicine_group'),
                'unit' => $this->input->post('unit'),
                'min_level' => $this->input->post('min_level'),
                'reorder_level' => $this->input->post('reorder_level'),
                'vat' => $this->input->post('vat'),
                'unit_packing' => $this->input->post('unit_packing'),
                'note' => $this->input->post('edit_note'),
                'vat_ac' => $this->input->post('vat_ac')
            );
            $this->pharmacy_model->update($pharmacy);
            if (isset($_FILES["medicine_image"]) && !empty($_FILES['medicine_image']['name'])) {
                $fileInfo = pathinfo($_FILES["medicine_image"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["medicine_image"]["tmp_name"], "./uploads/medicine_images/" . $img_name);
                $data_img = array('id' => $id, 'medicine_image' => 'uploads/medicine_images/' . $img_name);
                $this->pharmacy_model->update($data_img);
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('medicine', 'can_delete')) {
            access_denied();
        }
        if (!empty($id)) {
            $this->pharmacy_model->delete($id);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function getPharmacy() {
        if (!$this->rbac->hasPrivilege('medicine', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post('pharmacy_id');
        $result = $this->pharmacy_model->getPharmacy($id);
        echo json_encode($result);
    }

    function convertMonthToNumber($monthName) {
        return date('m', strtotime($monthName));
    }

    public function medicineBatch() {
        if (!$this->rbac->hasPrivilege('medicine batch details', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('pharmacy_id', $this->lang->line('pharmacy') . " " . $this->lang->line('id'), 'required');
        $this->form_validation->set_rules('expiry_date', $this->lang->line('expiry') . " " . $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('batch_no', $this->lang->line('batch') . " " . $this->lang->line('no'), 'required');
        $this->form_validation->set_rules('packing_qty', $this->lang->line('packing') . " " . $this->lang->line('qty'), 'required|numeric');
        $this->form_validation->set_rules('quantity', $this->lang->line('quantity'), 'required|numeric');
        $this->form_validation->set_rules('mrp', $this->lang->line('mrp'), 'required|numeric');
        $this->form_validation->set_rules('sale_rate', $this->lang->line('sale') . " " . $this->lang->line('rate'), 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'pharmacy_id' => form_error('pharmacy_id'),
                'expiry_date' => form_error('expiry_date'),
                'expiry_date_format' => form_error('expiry_date_format'),
                'batch_no' => form_error('batch_no'),
                'packing_qty' => form_error('packing_qty'),
                'quantity' => form_error('quantity'),
                'mrp' => form_error('mrp'),
                'sale_rate' => form_error('sale_rate'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('pharmacy_id');
            $inward_date = $this->input->post('inward_date');
            $expdate = $this->input->post('expiry_date');

            $explore = explode("/", $expdate);

            $monthary = $explore[0];
            $yearary = $explore[1];
            $month = $monthary;

            $month_number = $this->convertMonthToNumber($month);
            $insert_date = $yearary . "-" . $month_number . "-01";

            $medicine_batch = array(
                'pharmacy_id' => $id,
                'expiry_date' => $this->input->post('expiry_date'),
                'expiry_date_format' => $insert_date,
                'inward_date' => date('Y-m-d', $this->customlib->datetostrtotime($inward_date)),
                'batch_no' => $this->input->post('batch_no'),
                'packing_qty' => $this->input->post('packing_qty'),
                'purchase_rate_packing' => $this->input->post('purchase_rate_packing'),
                'quantity' => $this->input->post('quantity'),
                'mrp' => $this->input->post('mrp'),
                'sale_rate' => $this->input->post('sale_rate'),
                'amount' => $this->input->post('amount'),
                'available_quantity' => $this->input->post('quantity')
            );
            $this->pharmacy_model->medicineDetail($medicine_batch);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getMedicineBatch() {
        if (!$this->rbac->hasPrivilege('add_medicine_stock', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("pharmacy_id");
        $result = $this->pharmacy_model->getMedicineBatch($id);
        $data["result"] = $result;
        $badstockresult = $this->pharmacy_model->getMedicineBadStock($id);
        $data["badstockresult"] = $badstockresult;
        $this->load->view('admin/pharmacy/medicineDetail', $data);
    }

    public function addpatient() {
        if (!$this->rbac->hasPrivilege('patient', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $check_patient_id = $this->patient_model->getMaxId();

            if (empty($check_patient_id)) {
                $check_patient_id = 1000;
            }

            $patient_id = $check_patient_id + 1;


            $patient_data = array(
                'patient_name' => $this->input->post('name'),
                'mobileno' => $this->input->post('contact'),
                'marital_status' => $this->input->post('marital_status'),
                'email' => $this->input->post('email'),
                'gender' => $this->input->post('gender'),
                'guardian_name' => $this->input->post('guardian_name'),
                'blood_group' => $this->input->post('blood_group'),
                'address' => $this->input->post('address'),
                'known_allergies' => $this->input->post('known_allergies'),
                'patient_unique_id' => $patient_id,
                'note' => $this->input->post('note'),
                'age' => $this->input->post('age'),
                'month' => $this->input->post('month'),
                'is_active' => 'yes',
            );
            $insert_id = $this->patient_model->add_patient($patient_data);

            $user_password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
            $data_patient_login = array(
                'username' => $this->patient_login_prefix . $insert_id,
                'password' => $user_password,
                'user_id' => $insert_id,
                'role' => 'patient'
            );
            $this->user_model->add($data_patient_login);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/patient_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'image' => 'uploads/patient_images/' . $img_name);
                $this->patient_model->add($data_img);
            }
        }
        echo json_encode($array);
    }

    public function patientDetails() {

        if (!$this->rbac->hasPrivilege('patient', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $data = $this->patient_model->patientDetails($id);
        echo json_encode($data);
    }

    public function supplierDetails() {

        if (!$this->rbac->hasPrivilege('medicine_supplier', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $data = $this->patient_model->supplierDetails($id);
        echo json_encode($data);
    }

    public function bill() {
        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'pharmacy');
        $data['resultlist'] = $this->pharmacy_model->getBillBasic();
        $doctors = $this->staff_model->getStaffbyrole(3);
        $data["doctors"] = $doctors;
        $data['medicineCategory'] = $this->medicine_category_model->getMedicineCategory();
        $data['medicineName'] = $this->pharmacy_model->getMedicineName();
        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;
        $data["marital_status"] = $this->marital_status;
        //$data["blood_group"] = $this->blood_group	;
        $data["bloodgroup"] = $this->blood_group;
        $this->load->view('layout/header');
        $this->load->view('admin/pharmacy/pharmacyBill.php', $data);
        $this->load->view('layout/footer');
    }

    public function get_medicine_name() {
        if (!$this->rbac->hasPrivilege('medicine', 'can_view')) {
            access_denied();
        }
        $medicine_category_id = $this->input->post("medicine_category_id");
        $data = $this->pharmacy_model->get_medicine_name($medicine_category_id);
        echo json_encode($data);
    }

    public function get_medicine_dosage() {

        $medicine_category_id = $this->input->post("medicine_category_id");
        $data = $this->pharmacy_model->get_medicine_dosage($medicine_category_id);
        echo json_encode($data);
    }

    public function get_supplier_name() {
        if (!$this->rbac->hasPrivilege('supplier_category', 'can_view')) {
            access_denied();
        }
        $supplier_category_id = $this->input->post("supplier_category_id");
        $data = $this->pharmacy_model->get_supplier_name($supplier_category_id);
        echo json_encode($data);
    }

    public function addBill() {
        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('medicine_category_id[]', $this->lang->line('medicine') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('medicine_name[]', $this->lang->line('medicine') . " " . $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('batch_no[]', $this->lang->line('batch') . " " . $this->lang->line('no'), 'required');


        $this->form_validation->set_rules('quantity[]', $this->lang->line('quantity'), 'required|numeric');
        $this->form_validation->set_rules('sale_price[]', $this->lang->line('sale_price'), 'required|numeric');
        $this->form_validation->set_rules('amount[]', $this->lang->line('amount'), 'required|numeric');
        $this->form_validation->set_rules('total', $this->lang->line('total'), 'required|numeric');
        $this->form_validation->set_rules('patient_id', $this->lang->line('patient'), 'trim|required|xss_clean');
        //$this->form_validation->set_rules('bill_no', $this->lang->line('bill_no'), 'required|numeric');
        //$this->form_validation->set_rules('expire_date[]', $this->lang->line('expire')." ".$this->lang->line('date'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'medicine_category_id' => form_error('medicine_category_id[]'),
                'medicine_name' => form_error('medicine_name[]'),
                'batch_no' => form_error('batch_no[]'),
                //'expire_date' => form_error('expire_date[]'),
                'quantity' => form_error('quantity[]'),
                'sale_price' => form_error('sale_price[]'),
                'amount' => form_error('amount[]'),
                'total' => form_error('total'),
                'patient_id' => form_error('patient_id'),
                    //'bill_no' => form_error('bill_no')
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $patient_id = $this->input->post('patient_id');

            $bill_date = $this->input->post("date");
            $bill_no = $this->input->post('bill_no');

            $data = array(
                'bill_no' => $bill_no,
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($bill_date)),
                'patient_id' => $patient_id,
                'customer_name' => $this->input->post('customer_name'),
                'doctor_name' => $this->input->post('doctor_name'),
                'total' => $this->input->post('total'),
                'discount' => $this->input->post('discount'),
                'tax' => $this->input->post('tax'),
                'net_amount' => $this->input->post('net_amount'),
                'note' => $this->input->post('note'),
                'generated_by' => $this->session->userdata('hospitaladmin')['id'],
            );

            $bill_id = $this->pharmacy_model->addBill($data);

            if ($bill_id) {
                $pharmacy_bill_basic_id = $bill_id;
                $medicine_category_id = $this->input->post('medicine_category_id');
                $medicine_name = $this->input->post('medicine_name');
                $expire_date = $this->input->post('expire_date');
                $batch_no = $this->input->post('batch_no');
                $quantity = $this->input->post('quantity');
                $total_quantity = $this->input->post('available_quantity');
                $medicine_batch_details_id = $this->input->post('id');
                $sale_price = $this->input->post('sale_price');
                $amount = $this->input->post('amount');
                $data = array();
                $i = 0;
                foreach ($medicine_category_id as $key => $value) {
                    $detail = array(
                        'pharmacy_bill_basic_id' => $bill_id,
                        'medicine_category_id' => $medicine_category_id[$i],
                        'medicine_name' => $medicine_name[$i],
                        'expire_date' => $expire_date[$i],
                        'batch_no' => $batch_no[$i],
                        'quantity' => $quantity[$i],
                        'sale_price' => $sale_price[$i],
                        'amount' => $amount[$i],
                    );
                    $available_quantity[$i] = $total_quantity[$i] - $quantity[$i];
                    $update_quantity = array(
                        'id' => $medicine_batch_details_id[$i],
                        'available_quantity' => $available_quantity[$i],
                    );
                    $data[] = $detail;
                    $this->pharmacy_model->availableQty($update_quantity);
                    $i++;
                }

                $this->pharmacy_model->addBillBatch($data);
            } else {
                
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'), 'insert_id' => $bill_id);
        }
        echo json_encode($array);
    }

    public function getBillDetails($id) {
        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_view')) {
            access_denied();
        }
        $print_details = $this->printing_model->get('', 'pharmacy');
        $data["print_details"] = $print_details;
        $data['id'] = $id;
        if (isset($_POST['print'])) {
            $data["print"] = 'yes';
        } else {
            $data["print"] = 'no';
        }

        $result = $this->pharmacy_model->getBillDetails($id);
        $data['result'] = $result;
        $detail = $this->pharmacy_model->getAllBillDetails($id);
        $data['detail'] = $detail;
        $this->load->view('admin/pharmacy/printBill', $data);
    }

    public function getSupplierDetails($id) {
        if (!$this->rbac->hasPrivilege('medicine_purchase', 'can_view')) {
            access_denied();
        }
        $data['id'] = $id;
        if (isset($_POST['print'])) {
            $data["print"] = 'yes';
        } else {
            $data["print"] = 'no';
        }

        $result = $this->pharmacy_model->getSupplierDetails($id);
        $data['result'] = $result;
        $detail = $this->pharmacy_model->getAllSupplierDetails($id);
        $data['detail'] = $detail;
        $this->load->view('admin/pharmacy/printPurchase', $data);
    }

    public function download($file) {

        $this->load->helper('download');

        $filepath = "./uploads/medicine_images/" . $this->uri->segment(6);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(6);
        force_download($name, $data);
    }

    public function getQuantity() {
        if (!$this->rbac->hasPrivilege('medicine', 'can_view')) {
            access_denied();
        }
        $batch_no = $this->input->get('batch_no');
        $med_id = $this->input->get('med_id');
        $data = $this->pharmacy_model->getQuantity($batch_no,$med_id);
        echo json_encode($data);
       
    }

    public function getQuantityedit() {
        if (!$this->rbac->hasPrivilege('medicine', 'can_view')) {
            access_denied();
        }
        $batch_no = $this->input->get('batch_no');
        //$med_id = $this->input->get('med_id');
        $data = $this->pharmacy_model->getQuantityedit($batch_no);
        echo json_encode($data);
       
    }

    public function billReport() {
        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/pharmacy/billreport');
        $select = 'pharmacy_bill_basic.*';
        $table_name = "pharmacy_bill_basic";
        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }
        if (empty($search_type)) {

            $search_type = "";
            $resultlist = $this->report_model->getReport($select, $join = array(), $table_name, $where = array());
        } else {

            $search_table = "pharmacy_bill_basic";
            $search_column = "date";
            $resultlist = $this->report_model->searchReport($select, $join = array(), $table_name, $search_type, $search_table, $search_column, $where = array());
        }
        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data["resultlist"] = $resultlist;
        $this->load->view('layout/header');
        $this->load->view('admin/pharmacy/billReport.php', $data);
        $this->load->view('layout/footer');
    }

    public function editPharmacyBill($id) {
        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_view')) {
            access_denied();
        }
        $medicineCategory = $this->medicine_category_model->getMedicineCategory();
        $data["medicineCategory"] = $medicineCategory;
        $medicine_category_id = $this->input->post("medicine_category_id");
        $data['medicine_category_id'] = $this->pharmacy_model->get_medicine_name($medicine_category_id);
        $data['medicine_category_id'] = $medicine_category_id;
        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;
        $doctors = $this->staff_model->getStaffbyrole(3);
        $data["doctors"] = $doctors;
        $result = $this->pharmacy_model->getBillDetails($id);
        $data['result'] = $result;
        $detail = $this->pharmacy_model->getAllBillDetails($id);
        $data['detail'] = $detail;
        $this->load->view("admin/pharmacy/editPharmacyBill", $data);
    }

    public function editPharmaBill($id) {
        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_view')) {
            access_denied();
        }

        $id = $this->input->post("id");

        $patients = $this->patient_model->getPatientListall();
        $data["patients"] = $patients;

        $result = $this->pharmacy_model->getBillDetails($id);
        $data['result'] = $result;

        echo json_encode($result);
    }

    public function editSupplierBill($id) {
        if (!$this->rbac->hasPrivilege('medicine_purchase', 'can_view')) {
            access_denied();
        }
        $medicineCategory = $this->medicine_category_model->getMedicineCategory();
        $data["medicineCategory"] = $medicineCategory;
        $medicine_category_id = $this->input->post("medicine_category_id");
        $data['medicine_category_id'] = $this->pharmacy_model->get_medicine_name($medicine_category_id);
        $data['medicine_category_id'] = $medicine_category_id;

        $supplierCategory = $this->medicine_category_model->getSupplierCategory();
        $data["supplierCategory"] = $supplierCategory;
        $supplier_category_id = $this->input->post("supplier_category_id");
        $data['supplier_category_id'] = $this->pharmacy_model->get_supplier_name($supplier_category_id);
        $data['supplier_category_id'] = $supplier_category_id;

        $result = $this->pharmacy_model->getSupplierDetails($id);
        $data['result'] = $result;
        $detail = $this->pharmacy_model->getAllSupplierDetails($id);
        $data['detail'] = $detail;
        $this->load->view("admin/pharmacy/editSupplierBill", $data);
    }

    public function updateBill() {

        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_edit')) {
            access_denied();
        }

        $this->form_validation->set_rules('bill_no', $this->lang->line('bill') . " " . $this->lang->line('no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('patient_id', $this->lang->line('patient'), 'trim|required');
        $this->form_validation->set_rules('medicine_category_id[]', $this->lang->line('medicine') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('medicine_name[]', $this->lang->line('medicine') . " " . $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('expire_date[]', $this->lang->line('expire') . " " . $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('batch_no[]', $this->lang->line('batch') . " " . $this->lang->line('no'), 'required');
        $this->form_validation->set_rules('quantity[]', $this->lang->line('quantity'), 'required|numeric');
        $this->form_validation->set_rules('sale_price[]', $this->lang->line('sale_price'), 'required|numeric');
        $this->form_validation->set_rules('amount[]', $this->lang->line('amount'), 'required|numeric');
        $this->form_validation->set_rules('total', $this->lang->line('total'), 'required|numeric');
        if ($this->form_validation->run() == FALSE) {


            $msg = array(
                'bill_no' => form_error('bill_no'),
                'date' => form_error('date'),
                'customer_name' => form_error('customer_name'),
                'patient_id' => form_error('patient_id'),
                'medicine_category_id' => form_error('medicine_category_id[]'),
                'medicine_name' => form_error('medicine_name[]'),
                'expire_date' => form_error('expire_date[]'),
                'batch_no' => form_error('batch_no[]'),
                'quantity' => form_error('quantity[]'),
                'sale_price' => form_error('sale_price[]'),
                'total' => form_error('total'),
                'amount' => form_error('amount[]')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $id = $this->input->post('bill_basic_id');
            $bill_id = $this->input->post("bill_detail_id[]");
            $previous_bill_id = $this->input->post("previous_bill_id[]");
            $bill_date = $this->input->post("date");
            $data_array = array();
            $delete_arr = array();
            foreach ($previous_bill_id as $pkey => $pvalue) {
                if (in_array($pvalue, $bill_id)) {
                    
                } else {
                    $delete_arr[] = array('id' => $pvalue,);
                }
            }

            $data = array(
                'id' => $id,
                'bill_no' => $this->input->post('bill_no'),
                'patient_id' => $this->input->post('patient_id'),
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($bill_date)),
                'customer_name' => $this->input->post('customer_name'),
                'customer_type' => $this->input->post('customer_type'),
                'doctor_name' => $this->input->post('doctor_name'),
                'opd_ipd_no' => $this->input->post('opd_ipd_no'),
                'total' => $this->input->post('total'),
                'discount' => $this->input->post('discount'),
                'tax' => $this->input->post('tax'),
                'net_amount' => $this->input->post('net_amount'),
            );

            $this->pharmacy_model->addBill($data);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/pres_images/" . $img_name);
                $data_img = array('id' => $id, 'file' => 'uploads/pres_images/' . $img_name);
                $this->pharmacy_model->addBill($data_img);
            }

            if (!empty($id)) {
                $pharmacy_bill_basic_id = $id;
                $bill_detail_id = $this->input->post('bill_detail_id');
                $medicine_batch_id = $this->input->post('medicine_batch_id');
                $medicine_category_id = $this->input->post('medicine_category_id');
                $medicine_name = $this->input->post('medicine_name');
                $expiry_date = $this->input->post('expire_date');
                $batch_no = $this->input->post('batch_no');
                $quantity = $this->input->post('quantity');
                $total_quantity = $this->input->post('available_quantity');
                $amount = $this->input->post('amount');
                $sale_price = $this->input->post('sale_price');
                $data = array();
                $i = 0;
                foreach ($medicine_category_id as $key => $value) {
                    if ($bill_id[$i] == 0) {
                        $add_data = array(
                            'pharmacy_bill_basic_id' => $id,
                            'medicine_category_id' => $medicine_category_id[$i],
                            'medicine_name' => $medicine_name[$i],
                            'expire_date' => $expiry_date[$i],
                            'batch_no' => $batch_no[$i],
                            'quantity' => $quantity[$i],
                            'sale_price' => $sale_price[$i],
                            'amount' => $amount[$i],
                        );
                        $data_array[] = $add_data;
                        $available_quantity[$i] = $total_quantity[$i] - $quantity[$i];
                        $add_quantity = array(
                            'id' => $medicine_batch_id[$i],
                            'available_quantity' => $available_quantity[$i],
                        );
                        $this->pharmacy_model->availableQty($add_quantity);
                    } else {
                        $detail = array(
                            'id' => $bill_detail_id[$i],
                            'pharmacy_bill_basic_id' => $id,
                            'medicine_category_id' => $medicine_category_id[$i],
                            'medicine_name' => $medicine_name[$i],
                            'expire_date' => $expiry_date[$i],
                            'batch_no' => $batch_no[$i],
                            'quantity' => $quantity[$i],
                            'sale_price' => $sale_price[$i],
                            'amount' => $amount[$i],
                        );
                        $this->pharmacy_model->updateBillDetail($detail);
                        $available_quantity[$i] = $total_quantity[$i] - $quantity[$i];
                        $update_quantity = array(
                            'id' => $medicine_batch_id[$i],
                            'available_quantity' => $available_quantity[$i],
                        );
                        $this->pharmacy_model->availableQty($update_quantity);
                    }
                    $i++;
                }
            } else {
                
            }
            if (!empty($data_array)) {
                $this->pharmacy_model->addBillBatch($data_array);
            }
            if (!empty($delete_arr)) {
                $this->pharmacy_model->delete_bill_detail($delete_arr);
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function addBillSupplier() {

        if (!$this->rbac->hasPrivilege('medicine_supplier', 'can_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('supplier_id', $this->lang->line('supplier'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('medicine_category_id[]', $this->lang->line('medicine') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('medicine_name[]', $this->lang->line('medicine') . " " . $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('expiry_date[]', $this->lang->line('expiry') . " " . $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('batch_no[]', $this->lang->line('batch') . " " . $this->lang->line('no'), 'required');
        $this->form_validation->set_rules('mrp[]', $this->lang->line('mrp'), 'required');
        $this->form_validation->set_rules('sale_rate[]', $this->lang->line('sale_price'), 'required');
        // $this->form_validation->set_rules('packing_qty[]', $this->lang->line('packing') . " " . $this->lang->line('qty'), 'required');
        $this->form_validation->set_rules('quantity[]', $this->lang->line('quantity'), 'required|numeric');
        $this->form_validation->set_rules('purchase_price[]', $this->lang->line('purchase') . " " . $this->lang->line('price'), 'required|numeric');
        $this->form_validation->set_rules('amount[]', $this->lang->line('amount'), 'required|numeric');
        $this->form_validation->set_rules('total', $this->lang->line('total'), 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'date' => form_error('date'),
                'supplier_id' => form_error('supplier_id'),
                'medicine_category_id' => form_error('medicine_category_id[]'),
                'medicine_name' => form_error('medicine_name[]'),
                'batch_no' => form_error('batch_no[]'),
                'mrp' => form_error('mrp[]'),
                'sale_rate' => form_error('sale_rate[]'),
                'expiry_date' => form_error('expiry_date[]'),
                'quantity' => form_error('quantity[]'),
                'purchase_price' => form_error('purchase_price[]'),
                'total' => form_error('total'),
                'amount' => form_error('amount[]')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $supplier_id = $this->input->post('supplier_id');
            $supplier_name = $this->input->post('supplier_name');
            $bill_date = $this->input->post("date");
            $purchase_no = $this->pharmacy_model->getMaxId();
            if (empty($purchase_no)) {
                $purchase_no = 0;
            }
            $purchase = $purchase_no + 1;

            $data = array(
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($bill_date)),
                'supplier_id' => $supplier_id,
                'supplier_name' => $supplier_name,
                'purchase_no' => $purchase,
                'total' => $this->input->post('total'),
                'discount' => $this->input->post('discount'),
                'tax' => $this->input->post('tax'),
                'net_amount' => $this->input->post('net_amount'),
                'note' => $this->input->post('note')
            );


            $insert_id = $this->pharmacy_model->addBillSupplier($data);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/medicine_images/" . $img_name);
                $data_img = array('id' => $insert_id, 'file' => 'uploads/medicine_images/' . $img_name);
                $this->pharmacy_model->addBillSupplier($data_img);
            }

            if ($insert_id) {

                $medicine_category_id = $this->input->post('medicine_category_id');
                $medicine_name = $this->input->post('medicine_name');
                $expiry_date = $this->input->post('expiry_date');
                $batch_no = $this->input->post('batch_no');
                $batch_amount = $this->input->post('batch_amount');
                $mrp = $this->input->post('mrp');
                $sale_rate = $this->input->post('sale_rate');
                $packing_qty = $this->input->post('packing_qty');
                $quantity = $this->input->post('quantity');

                $purchase_price = $this->input->post('purchase_price');
                $amount = $this->input->post('amount');

                $data1 = array();
                $j = 0;
                foreach ($medicine_name as $key => $mvalue) {
                    $details = array(
                        'inward_date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($bill_date)),
                        'pharmacy_id' => $medicine_name[$j],
                        'supplier_bill_basic_id' => $insert_id,
                        'medicine_category_id' => $medicine_category_id[$j],
                        'expiry_date' => $expiry_date[$j],
                        'batch_no' => $batch_no[$j],
                        'batch_amount' => $batch_amount[$j],
                        'mrp' => $mrp[$j],
                        'sale_rate' => $sale_rate[$j],
                        'packing_qty' => $packing_qty[$j],
                        'quantity' => $quantity[$j],
                        'purchase_price' => $purchase_price[$j],
                        'available_quantity' => $quantity[$j],
                        'amount' => $amount[$j],
                    );
                    $data1[] = $details;

                    $j++;
                }

                $this->pharmacy_model->addBillMedicineBatchSupplier($data1);
            } else {
                
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'), 'insert_id' => $insert_id);
        }
        echo json_encode($array);
    }

    public function updateSupplierBill() {
        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_edit')) {
            access_denied();
        }

        $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('supplier_id', $this->lang->line('supplier'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('medicine_category_id[]', $this->lang->line('medicine') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('medicine_name[]', $this->lang->line('medicine') . " " . $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('expiry_date[]', $this->lang->line('expiry') . " " . $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('batch_no[]', $this->lang->line('batch') . " " . $this->lang->line('no'), 'required');
        $this->form_validation->set_rules('mrp[]', $this->lang->line('mrp'), 'required');
        $this->form_validation->set_rules('sale_rate[]', $this->lang->line('sale_price'), 'required');
        // $this->form_validation->set_rules('packing_qty[]', $this->lang->line('packing') . " " . $this->lang->line('qty'), 'required');
        $this->form_validation->set_rules('quantity[]', $this->lang->line('quantity'), 'required|numeric');
        $this->form_validation->set_rules('purchase_price[]', $this->lang->line('purchase_price'), 'required|numeric');
        $this->form_validation->set_rules('total', $this->lang->line('total'), 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'date' => form_error('date'),
                'supplier_id' => form_error('supplier_id'),
                'medicine_category_id' => form_error('medicine_category_id[]'),
                'medicine_name' => form_error('medicine_name[]'),
                'expiry_date' => form_error('expiry_date[]'),
                'batch_no' => form_error('batch_no[]'),
                'mrp' => form_error('mrp[]'),
                'sale_rate' => form_error('sale_rate[]'),
                'quantity' => form_error('quantity[]'),
                'purchase_price' => form_error('purchase_price[]'),
                'total' => form_error('total')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('bill_basic_id');
            $bill_id = $this->input->post("bill_detail_id[]");
            $previous_bill_id = $this->input->post("previous_bill_id[]");
            $supplier_id = $this->input->post('supplier_id');
            $purchase_no = $this->input->post('purchase_no');
            $data_array = array();
            $delete_arr = array();

            $bill_date = $this->input->post("date");
            $data = array(
                'id' => $id,
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($bill_date)),
                'supplier_id' => $supplier_id,
                'purchase_no' => $purchase_no,
                'total' => $this->input->post('total'),
                'discount' => $this->input->post('discount'),
                'tax' => $this->input->post('tax'),
                'note' => $this->input->post('note'),
                'net_amount' => $this->input->post('net_amount'),
            );

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/medicine_images/" . $img_name);
                $data_img = array('id' => $id, 'file' => 'uploads/medicine_images/' . $img_name);
                $this->pharmacy_model->addBillSupplier($data_img);
            }
            $this->pharmacy_model->addBillSupplier($data);

            if (!empty($id)) {

                $bill_detail_id = $this->input->post('bill_detail_id');
                $medicine_batch_id = $this->input->post('medicine_batch_id');
                $medicine_category_id = $this->input->post('medicine_category_id');
                $medicine_name = $this->input->post('medicine_name');
                $expiry_date = $this->input->post('expiry_date');
                $batch_no = $this->input->post('batch_no');
                $batch_amount = $this->input->post('batch_amount');
                $mrp = $this->input->post('mrp');
                $sale_rate = $this->input->post('sale_rate');
                $packing_qty = $this->input->post('packing_qty');
                $quantity = $this->input->post('quantity');
                $total_quantity = $this->input->post('available_quantity');
                $amount = $this->input->post('amount');
                $purchase_price = $this->input->post('purchase_price');
                $data_array1 = array();
                $bill_date1 = $this->input->post("date");
                $j = 0;
                foreach ($medicine_category_id as $key => $value) {

                    if ($bill_id[$j] == 0) {
                        $add_data = array(
                            'supplier_bill_basic_id' => $id,
                            'medicine_category_id' => $medicine_category_id[$j],
                            'pharmacy_id' => $medicine_name[$j],
                            'inward_date' =>date('Y-m-d H:i:s', $this->customlib->datetostrtotime($bill_date1)),
                            'expiry_date' => $expiry_date[$j],
                            'batch_no' => $batch_no[$j],
                            'batch_amount' => $batch_amount[$j],
                            'mrp' => $mrp[$j],
                            'sale_rate' => $sale_rate[$j],
                            'packing_qty' => $packing_qty[$j],
                            'quantity' => $quantity[$j],
                            'available_quantity' => $quantity[$j],
                            'purchase_price' => $purchase_price[$j],
                            'amount' => $amount[$j],
                        );
                        $data_array[] = $add_data;
                    } else {

                        $detail = array(
                            'id' => $bill_detail_id[$j],
                            'supplier_bill_basic_id' => $id,
                            'medicine_category_id' => $medicine_category_id[$j],
                            'pharmacy_id' => $medicine_name[$j],
                            'inward_date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($bill_date1)),
                            'expiry_date' => $expiry_date[$j],
                            'batch_no' => $batch_no[$j],
                            'batch_amount' => $batch_amount[$j],
                            'mrp' => $mrp[$j],
                            'sale_rate' => $sale_rate[$j],
                            'packing_qty' => $packing_qty[$j],
                            'quantity' => $quantity[$j],
                            'available_quantity' => $quantity[$j],
                            'purchase_price' => $purchase_price[$j],
                            'amount' => $amount[$j],
                        );

                        $this->pharmacy_model->updateMedicineBatchDetail($detail);
                    }

                    $j++;
                }
                //print_r($detail);
               // exit();
            } else {
                
            }
            if (!empty($data_array)) {
                $this->pharmacy_model->addBillMedicineBatchSupplier($data_array);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function deletePharmacyBill($id) {
        if (!$this->rbac->hasPrivilege('pharmacy bill', 'can_delete')) {
            access_denied();
        }
        if (!empty($id)) {
            $this->pharmacy_model->deletePharmacyBill($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Deleted Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function deleteSupplierBill($id) {
        if (!$this->rbac->hasPrivilege('medicine_purchase', 'can_delete')) {
            access_denied();
        }
        if (!empty($id)) {
            $this->pharmacy_model->deleteSupplierBill($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Deleted Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function delete_medicine_batch($id) {
        if (!$this->rbac->hasPrivilege('medicine batch details', 'can_view')) {
            access_denied();
        }
        if (!empty($id)) {
            $this->pharmacy_model->delete_medicine_batch($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Deleted Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    public function getBillNo() {
        $result = $this->pharmacy_model->getBillNo();

        $id = $result["id"];
        if (!empty($result["id"])) {
            $bill_no = $id + 1;
        } else {
            $bill_no = 1;
        }
        echo json_encode($bill_no);
    }

    public function getExpiryDate() {
        $batch_no = $this->input->get_post('batch_no');
        $med_id = $this->input->get_post('med_id');
        $result = $this->pharmacy_model->getExpiryDate($batch_no,$med_id);
        echo json_encode($result);
    }

     public function getExpireDate() {
        $batch_no = $this->input->get_post('batch_no');
        //$med_id = $this->input->get_post('med_id');
        $result = $this->pharmacy_model->getExpireDate($batch_no);
        echo json_encode($result);
    }

    public function getBatchNoList() {
        $medicine = $this->input->get_post('medicine');
        $result = $this->pharmacy_model->getBatchNoList($medicine);
        echo json_encode($result);
    }

    public function addBadStock() {
        if (!$this->rbac->hasPrivilege('medicine batch details', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('pharmacy_id', $this->lang->line('pharmacy') . " " . $this->lang->line('id'), 'required');
        $this->form_validation->set_rules('expiry_date', $this->lang->line('expire') . " " . $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('batch_no', $this->lang->line('batch') . " " . $this->lang->line('no'), 'required');
        $this->form_validation->set_rules('packing_qty', $this->lang->line('qty'), 'required|numeric');
        $this->form_validation->set_rules('inward_date', $this->lang->line('out') . " " . $this->lang->line('ward') . " " . $this->lang->line('date'), 'required');


        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'pharmacy_id' => form_error('pharmacy_id'),
                'expiry_date' => form_error('expiry_date'),
                'batch_no' => form_error('batch_no'),
                'packing_qty' => form_error('packing_qty'),
                'inward_date' => form_error('inward_date'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('pharmacy_id');
            $inward_date = $this->input->post('inward_date');

            $medicine_batch = array(
                'pharmacy_id' => $id,
                'expiry_date' => $this->input->post('expiry_date'),
                'outward_date' => date('Y-m-d', $this->customlib->datetostrtotime($inward_date)),
                'batch_no' => $this->input->post('batch_no'),
                'quantity' => $this->input->post('packing_qty'),
                'note' => $this->input->post('note'),
            );
            $batch_qty = $this->input->post('available_quantity');
            $packing_qty = $this->input->post('packing_qty');
            $available_quantity = $batch_qty - $packing_qty;
            $update_data = array('id' => $this->input->post('medicine_batch_id'), 'available_quantity' => $available_quantity);

            $this->pharmacy_model->addBadStock($medicine_batch);
            $this->pharmacy_model->updateMedicineBatch($update_data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function deleteBadStock($id) {
        if (!$this->rbac->hasPrivilege('medicine', 'can_view')) {
            access_denied();
        }
        if (!empty($id)) {
            $this->pharmacy_model->deleteBadStock($id);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Deleted Successfully.');
        } else {
            $array = array('status' => 'fail', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

}

?>