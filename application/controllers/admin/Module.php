<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Module extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {

        if (!$this->rbac->hasPrivilege('superadmin', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'schsettings/index');
        $this->session->set_userdata('inner_menu', 'admin/module');
        $permissionlist = $this->module_model->getPermission();
        $data["permissionList"] = $permissionlist;
        $this->load->view("layout/header");
        $this->load->view("setting/permission", $data);
        $this->load->view("layout/footer");
    }

    public function changeStatus() {

        $id = $this->input->post("id");
        $status = $this->input->post("status");

        if (!empty($id)) {

            $data = array('id' => $id, 'is_active' => $status);
            $result = $this->module_model->changeStatus($data);


            $response = array('status' => 1, 'msg' => $this->lang->line('status_change_message'));
            echo json_encode($response);
        }
    }

}

?>