<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Tpa extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->config->load("payroll");
        $this->charge_type = $this->config->item('charge_type');
    }

    function master($id) {
        if (!$this->rbac->hasPrivilege('charges', 'can_view')) {
            access_denied();
        }
        $data["charge_type"] = $this->charge_type;

        foreach ($data["charge_type"] as $key => $value) {


            $data['org'][$key] = $this->tpa_model->org_charge($id, $key);
        }


        $data['result'] = $this->organisation_model->get($id);
        $data['title'] = "TPA Master";

        $this->load->view('layout/header');
        $this->load->view('admin/tpamanagement/tpamasters', $data);
        $this->load->view('layout/footer');
    }

    function add($id) {
        if (!$this->rbac->hasPrivilege('charges', 'can_add')) {
            access_denied();
        }
        $check_value = 0;

        $Charge_type = $this->input->post('charge_type');

        if (isset($_POST['other_charge'])) {

            foreach ($_POST['other_charge'] as $key => $value) {

                $check_value = 1;

                if (empty($_POST['org_othcharge_' . $value])) {

                    $msg['e' . $value] = "The Organisation Charge Field  " . $value . " Required";
                    $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
                } else {

                    $charge = $value;
                    $org_othcharge = $_POST['org_othcharge_' . $value];
                    $data = array('org_id' => $id, 'charge_type' => $Charge_type, 'charge_id' => $charge, 'org_charge' => $org_othcharge);
                    $data_array[] = $data;
                    $array = array('status' => 'success', 'error' => '', 'message' => 'Successfully Inserted');
                }
            }
        }

        if ($check_value == "0") {

            $msg['eerror'] = "The Charges Field  Required";
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        }

        if ($array['status'] == "success") {

            $this->tpa_model->add($data_array);
        }

        echo json_encode($array);
    }

    function get_org_charge($id) {
        if (!$this->rbac->hasPrivilege('charges', 'can_view')) {
            access_denied();
        }
        $res = $this->tpa_model->get_org_charge($id);

        echo json_encode($res);
    }

    public function edit_org() {
        if (!$this->rbac->hasPrivilege('charges', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('org_charge', $this->lang->line('charge'), 'required');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'charge' => form_error('org_charge'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $id = $this->input->post('org_charge_id');
            $charge['org_charge'] = $this->input->post('org_charge');

            $this->tpa_model->edit_org($id, $charge);

            $array = array('status' => 'success', 'error' => '', 'message' => 'Organisation Charge Successfully Updated');
        }

        echo json_encode($array);
    }

    public function delete($id, $red_id) {
        if (!$this->rbac->hasPrivilege('charges', 'can_delete')) {
            access_denied();
        }
        $this->tpa_model->delete($id);
    }

}

?>