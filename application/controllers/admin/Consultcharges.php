<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Consultcharges extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->load->library('form_validation');
    }

    public function index() {
        
        if (!$this->rbac->hasPrivilege('doctor_opd_charges', 'can_view')) {
            access_denied();
        }

        $doctors = $this->staff_model->getStaffbyrole(3);
        $data["doctors"] = $doctors;
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'charges/index');
        $data['resultlist'] = $this->charge_model->get_chargedoctorfee();
        $data['schedule'] = $this->organisation_model->get();
        $this->load->view("layout/header");
        $this->load->view("admin/consultcharges/charge", $data);
        $this->load->view("layout/footer");
    }

    function rolekey_exists($key) {
        $this->charge_model->check_doctor_exists($key);
    }

    public function addconsultcharges() {
        if (!$this->rbac->hasPrivilege('doctor_opd_charges', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('doctor', $this->lang->line('doctor'), 'required|callback_rolekey_exists');
        $this->form_validation->set_rules('standard_charge', $this->lang->line('standard') . " " . $this->lang->line('charge'), 'required');
        $this->form_validation->set_rules(
                'doctor', $this->lang->line('doctor') . " " . $this->lang->line('id'), array('required',
            array('check_exists', array($this->charge_model, 'valid_doctor_id'))
                )
        );

        if ($this->form_validation->run() == false) {
            $msg = array(
                'doctor' => form_error('doctor'),
                'standard_charge' => form_error('standard_charge'),
            );
            $json_array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $data = array(
                'doctor' => $this->input->post('doctor'),
                'standard_charge' => $this->input->post('standard_charge'),
            );
            $insert_id = $this->charge_model->addconsultcharges($data);

            $schedule_charge = $this->input->post('schedule_charge');

            $i = 0;
            if (!empty($schedule_charge)) {
                foreach ($schedule_charge as $key => $value) {
                    $schedule_charge_id = $this->input->post("schedule_charge_id");
                    $schedule_data = array(
                        // 'charge_type' => $this->input->post('charge_type'),
                        'charge_id' => $insert_id,
                        'org_id' => $schedule_charge_id[$i],
                        'org_charge' => $value,
                    );
                    $i++;
                    $insert_data[] = $schedule_data;
                }

                $this->tpa_model->addcharge($insert_data);
            }

            $json_array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($json_array);
    }

    public function get_charge_category() {
        if (!$this->rbac->hasPrivilege('doctor_opd_charges', 'can_view')) {
            access_denied();
        }
        $charge_type = $this->input->post("charge_type");
        $data = $this->charge_model->getChargeCategory($charge_type);
        echo json_encode($data);
    }

    public function getDetails() {
        if (!$this->rbac->hasPrivilege('doctor_opd_charges', 'can_view')) {
            access_denied();
        }
        $id = $this->input->post("charges_id");
        $organisation = $this->input->post("organisation");
        $result = $this->charge_model->getDetailsTpadoctor($id, $organisation);
        echo json_encode($result);
    }

    public function getScheduleChargeBatch() {
        $id = $this->input->post("charges_id");
        $result = $this->charge_model->getScheduleChargeBatchTpadoctor($id);
        $data["result"] = $result;
        $allCharge = $this->charge_model->getOrganisationChargesTpadoctor($id);
        $data["allCharge"] = $allCharge;
        $this->load->view('admin/consultcharges/schedulechargeDetail', $data);
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('doctor_opd_charges', 'can_delete')) {
            access_denied();
        }
        $result = $this->charge_model->deletedoctorcharge($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('delete_message') . '</div>');
        redirect('admin/consultcharges');
    }

    public function scheduleChargeBatchGet() {
        $id = $this->input->post("charges_id");
        $result = $this->charge_model->getScheduleChargeBatchTpadoctor($id);
        $data["result"] = $result;
        $allCharge = $this->charge_model->getOrganisationChargesTpadoctor($id);
        $data["allCharge"] = $allCharge;

        $this->load->view('admin/consultcharges/schedulechargeEdit', $data);
    }

    public function update_charges() {
        if (!$this->rbac->hasPrivilege('doctor_opd_charges', 'can_edit')) {
            access_denied();
        }


        $this->form_validation->set_rules('standard_charge', $this->lang->line('standard') . " " . $this->lang->line('charge'), 'required');
        $this->form_validation->set_rules('doctor', $this->lang->line('doctor'), 'required');

        if ($this->form_validation->run() == false) {
            $msg = array(
                'charge' => form_error('standard_charge'),
                'doctor' => form_error('doctor'),
            );
            $json_array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('id');
            $data = array(
                'id' => $id,
                'doctor' => $this->input->post('doctor'),
                'standard_charge' => $this->input->post('standard_charge'),
            );

            $update_data = $this->charge_model->update_consultcharges($data);
            $schedule_charge = $this->input->post('schedule_charge');
            $i = 0;
            if (!empty($schedule_charge)) {
                foreach ($schedule_charge as $key => $value) {
                    $schedule_charge_id = $this->input->post("schedule_charge_id");
                    $ids = $this->input->post('sid');
                    if ($ids[$i] == 0) {
                        $insert_data = array(
                            'charge_id' => $id,
                            'org_id' => $schedule_charge_id[$i],
                            'org_charge' => $value,
                        );
                        $ins_data[] = $insert_data;
                    } else {
                        $schedule_data = array(
                            'id' => $ids[$i],
                            'org_charge' => $value,
                        );
                        $this->tpa_model->edit_orgtpa($ids[$i], $schedule_data);
                    }
                    $i++;
                }
            }
            if (isset($ins_data)) {
                $this->tpa_model->addcharge($ins_data);
            }
            $json_array = array('status' => 'success', 'error' => '', 'message' => 'Record Added Successfully');
        }

        echo json_encode($json_array);
    }

    public function add_ipdconsultcharges() {
        $this->form_validation->set_rules('charge_type', $this->lang->line('charge') . " " . $this->lang->line('type'), 'required');
        $this->form_validation->set_rules('charge_category', $this->lang->line('charge') . " " . $this->lang->line('category'), 'required');
        $this->form_validation->set_rules('apply_charge', $this->lang->line('applied') . " " . $this->lang->line('charge'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        if ($this->form_validation->run() == false) {
            $msg = array(
                'date' => form_error('date'),
                'charge_type' => form_error('charge_type'),
                'charge_category' => form_error('charge_category'),
                'apply_charge' => form_error('apply_charge'),
            );
            $json_array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $data = array('patient_id' => $this->input->post('patient_id'),
                'date' => date("Y-m-d", $this->customlib->datetostrtotime($this->input->post('date'))),
                'charge_id' => $this->input->post('charge_id'),
                'org_charge_id' => $this->input->post('org_id'),
                'apply_charge' => $this->input->post('apply_charge'),
                'created_at' => date('Y-m-d'),
            );
            $this->charge_model->add_ipdconsultcharges($data);
            $json_array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
        }
        echo json_encode($json_array);
    }

    public function getchargeDetails() {

        $charge_category = $this->input->post("charge_category");
        $result = $this->charge_model->getchargeDetails($charge_category);
        echo json_encode($result);
    }

}

?>