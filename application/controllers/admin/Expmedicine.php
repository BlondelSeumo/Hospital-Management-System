<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expmedicine extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->search_type = $this->config->item('search_type');
    }

    public function search() {
        if (!$this->rbac->hasPrivilege('ambulance', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Transport');
        $this->session->set_userdata('sub_menu', 'vehicle/index');
        $data['title'] = 'Add Vehicle';
        $listVehicle = $this->vehicle_model->get();
        $data['listVehicle'] = $listVehicle;
        $this->load->view('layout/header');
        $this->load->view('admin/vehicle/search', $data);
        $this->load->view('layout/footer');
    }

    public function add() {
        if (!$this->rbac->hasPrivilege('ambulance', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('vehicle_no', $this->lang->line('vehicle_no'), 'required');
        $this->form_validation->set_rules('vehicle_model', $this->lang->line('vehicle_model'), 'required');
        $this->form_validation->set_rules('vehicle_type', $this->lang->line('vehicle') . " " . $this->lang->line('type'), 'required');

        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'vehicle_no' => form_error('vehicle_no'),
                'vehicle_model' => form_error('vehicle_model'),
                'vehicle_type' => form_error('vehicle_type'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $manufacture_year = $this->input->post('manufacture_year');
            $data = array(
                'vehicle_no' => $this->input->post('vehicle_no'),
                'vehicle_model' => $this->input->post('vehicle_model'),
                'driver_name' => $this->input->post('driver_name'),
                'driver_licence' => $this->input->post('driver_licence'),
                'driver_contact' => $this->input->post('driver_contact'),
                'vehicle_type' => $this->input->post('vehicle_type'),
                'note' => $this->input->post('note'),
            );
            ($manufacture_year != "") ? $data['manufacture_year'] = $manufacture_year : '';
            $this->vehicle_model->add($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function edit() {
        if (!$this->rbac->hasPrivilege('ambulance', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $listVehicle = $this->vehicle_model->getDetails($id);
        echo json_encode($listVehicle);
    }

    public function update() {
        if (!$this->rbac->hasPrivilege('ambulance', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required');
        $this->form_validation->set_rules('vehicle_model', $this->lang->line('vehicle_model'), 'required');
        $this->form_validation->set_rules('vehicle_type', $this->lang->line('vehicle') . " " . $this->lang->line('type'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'vehicle_no' => form_error('vehicle_no'),
                'vehicle_model' => form_error('vehicle_model'),
                'vehicle_type' => form_error('vehicle_type'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('id');
            $manufacture_year = $this->input->post('manufacture_year');
            $data = array(
                'id' => $id,
                'vehicle_no' => $this->input->post('vehicle_no'),
                'vehicle_model' => $this->input->post('vehicle_model'),
                'driver_name' => $this->input->post('driver_name'),
                'driver_licence' => $this->input->post('driver_licence'),
                'driver_contact' => $this->input->post('driver_contact'),
                'vehicle_type' => $this->input->post('vehicle_type'),
                'note' => $this->input->post('note'),
            );
            ($manufacture_year != "") ? $data['manufacture_year'] = $manufacture_year : '';
            $this->vehicle_model->add($data);
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully.');
        }
        echo json_encode($array);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('ambulance', 'can_delete')) {
            access_denied();
        }
        $this->vehicle_model->remove($id);
        redirect('admin/Vehicle/search');
    }

    public function addCallAmbulance() {
        if (!$this->rbac->hasPrivilege('ambulance_call', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('patient_name', $this->lang->line('patient') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('vehicle_no', $this->lang->line('vehicle_model'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'vehicle_no' => form_error('vehicle_no'),
                'date' => form_error('date'),
                'amount' => form_error('amount'),
                'patient_name' => form_error('patient_name'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $date = $this->input->post("date");
            $data = array(
                'patient_name' => $this->input->post('patient_name'),
                'contact_no' => $this->input->post('contact_no'),
                'address' => $this->input->post('address'),
                'vehicle_no' => $this->input->post('vehicle_no'),
                'driver' => $this->input->post('driver'),
                'amount' => $this->input->post('amount'),
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($date))
            );
            $this->vehicle_model->addCallAmbulance($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getCallAmbulance() {
        if (!$this->rbac->hasPrivilege('ambulance_call', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Transport');
        $this->session->set_userdata('sub_menu', 'vehicle/getcallambulance');
        $data['title'] = 'Add Vehicle';
        $listCall = $this->vehicle_model->getCallAmbulance();
        $vehiclelist = $this->vehicle_model->get();
        $data['listCall'] = $listCall;
        $data['vehiclelist'] = $vehiclelist;
        $this->load->view('layout/header');
        $this->load->view('admin/vehicle/ambulance_call', $data);
        $this->load->view('layout/footer');
    }

    public function editCall() {
        if (!$this->rbac->hasPrivilege('ambulance_call', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("id");
        $listCall = $this->vehicle_model->getCallDetails($id);
        $date = date($this->customlib->getSchoolDateFormat(true, true), strtotime($listCall['date']));
        $listCall["date"] = $date;
        echo json_encode($listCall);
    }

    public function updateCallAmbulance() {
        if (!$this->rbac->hasPrivilege('ambulance_call', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('patient_name', $this->lang->line('patient') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('vehicle_no', $this->lang->line('vehicle_no'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'patient_name' => form_error('patient_name'),
                'vehicle_no' => form_error('vehicle_no'),
                'date' => form_error('date'),
                'amount' => form_error('amount'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('id');
            $date = $this->input->post('date');

            $data = array(
                'id' => $id,
                'patient_name' => $this->input->post('patient_name'),
                'contact_no' => $this->input->post('contact_no'),
                'address' => $this->input->post('address'),
                'vehicle_no' => $this->input->post('vehicle_no'),
                'driver' => $this->input->post('driver_name'),
                'amount' => $this->input->post('amount'),
                'date' => date('Y-m-d H:i:s', $this->customlib->datetostrtotime($date))
            );
            $this->vehicle_model->addCallAmbulance($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    function deleteCallAmbulance($id) {
        if (!$this->rbac->hasPrivilege('ambulance_call', 'can_delete')) {
            access_denied();
        }
        $this->vehicle_model->delete($id);
        redirect('admin/Vehicle/getcallambulance');
    }

    public function getVehicleDetail() {
        $id = $this->input->post('id');
        $result = $this->vehicle_model->getDetails($id);
        echo json_encode($result);
    }

    public function expmedicinereport() {

        if (!$this->rbac->hasPrivilege('expiry_medicine_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/expmedicine/expmedicinereport');
        $this->session->set_userdata('top_menu', 'Reports');
        $select = 'medicine_batch_details.*,pharmacy.medicine_name,pharmacy.medicine_company,pharmacy.supplier,pharmacy.medicine_group,medicine_category.medicine_category';
        $join = array(
            'JOIN pharmacy ON medicine_batch_details.pharmacy_id = pharmacy.id', 'JOIN medicine_category ON pharmacy.medicine_category_id = medicine_category.id'
        );
        $table_name = "medicine_batch_details";

        $where = array(
            "medicine_batch_details.expiry_date_format <= '" . date('Y-m-d') . "' ",
        );

        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }

        if (empty($search_type)) {

            $search_type = "";
            $resultlist = $this->report_model->getReport($select, $join, $table_name, $where);
        } else {

            $search_table = "medicine_batch_details";
            $search_column = "expiry_date_format";
            $resultlist = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column, $where);
        }

        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data["listCall"] = $resultlist;

        $this->load->view('layout/header');
        $this->load->view('admin/expmedicine/expmedicinereport.php', $data);
        $this->load->view('layout/footer');
    }

}

?>