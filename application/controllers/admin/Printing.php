<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Printing extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {

        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'opdpre');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/opdpresprinting', $data);
        $this->load->view('layout/footer');
    }

    function ipdprinting() {
        if (!$this->rbac->hasPrivilege('ipd_bill_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/ipdprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'ipd');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/ipdprinting', $data);
        $this->load->view('layout/footer');
    }

        function opdprinting() {
        if (!$this->rbac->hasPrivilege('opd_bill_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/opdprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'opd');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/opdprinting', $data);
        $this->load->view('layout/footer');
    }

    function ipdpresprinting() {
        if (!$this->rbac->hasPrivilege('ipd_prescription_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/ipdpresprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'ipdpres');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/ipdpresprinting', $data);
        $this->load->view('layout/footer');
    }

    function birthprinting() {
        if (!$this->rbac->hasPrivilege('birth_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/birthprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'birth');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/birthprinting', $data);
        $this->load->view('layout/footer');
    }

    function deathprinting() {
        if (!$this->rbac->hasPrivilege('death_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/deathprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'death');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/deathprinting', $data);
        $this->load->view('layout/footer');
    }

    function pathologyprinting() {
        if (!$this->rbac->hasPrivilege('pathology_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/pathologyprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'pathology');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/pathologyprinting', $data);
        $this->load->view('layout/footer');
    }

    function radiologyprinting() {
        if (!$this->rbac->hasPrivilege('radiology_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/radiologyprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'radiology');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/radiologyprinting', $data);
        $this->load->view('layout/footer');
    }

    function otprinting() {
        if (!$this->rbac->hasPrivilege('ot_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/otprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'ot');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/otprinting', $data);
        $this->load->view('layout/footer');
    }

    function pharmacyprinting() {
        if (!$this->rbac->hasPrivilege('pharmacy_bill_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/pharmacyprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'pharmacy');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/pharmacyprinting', $data);
        $this->load->view('layout/footer');
    }

    function bloodbankprinting() {
        if (!$this->rbac->hasPrivilege('bloodbank_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/bloodbankprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'bloodbank');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/bloodbankprinting', $data);
        $this->load->view('layout/footer');
    }

    function ambulanceprinting() {
        if (!$this->rbac->hasPrivilege('ambulance_print_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/ambulanceprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'ambulance');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/ambulanceprinting', $data);
        $this->load->view('layout/footer');
    }

    function payslipprinting() {
        if (!$this->rbac->hasPrivilege('print_payslip_header_footer', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/printing/payslipprinting');
        $this->session->set_userdata('sub_menu', 'admin/printing');
        $data["printing_list"] = $this->printing_model->get('', 'payslip');
        $this->load->view('layout/header');
        $this->load->view('admin/printing/payslipprinting', $data);
        $this->load->view('layout/footer');
    }

    function getRecord($id) {

        $result = $this->printing_model->get($id, '');
        echo json_encode($result);
    }

    function add() {

        $this->form_validation->set_rules('print_header', 'Print Header', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'print_header' => form_error('print_header'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $insertData = array(
                'print_footer' => $this->input->post('print_footer'),
                'setting_for' => $this->input->post('setting_for'),
                'is_active' => 'yes'
            );
            $insert_id = $this->printing_model->add($insertData);
            if (isset($_FILES["print_header"]) && !empty($_FILES['print_header']['name'])) {
                $fileInfo = pathinfo($_FILES["print_header"]["name"]);
                $img_name = $insert_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["print_header"]["tmp_name"], "./uploads/printing/" . $img_name);
                $img_data = array('id' => $insert_id, 'print_header' => 'uploads/printing/' . $img_name);
                $this->printing_model->add($img_data);
            }
            $msg = "Record Added Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function update() {
        $this->form_validation->set_rules('print_header', 'Print Header', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'print_header' => form_error('print_header'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id = $this->input->post('printid');
            $insertData = array(
                'id' => $this->input->post('printid'),
                'print_footer' => $this->input->post('print_footer'),
                'is_active' => 'yes'
            );
            $this->printing_model->add($insertData);
            if (isset($_FILES["print_header"]) && !empty($_FILES['print_header']['name'])) {
                $fileInfo = pathinfo($_FILES["print_header"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["print_header"]["tmp_name"], "./uploads/printing/" . $img_name);
                $img_data = array('id' => $id, 'print_header' => 'uploads/printing/' . $img_name);
                $this->printing_model->add($img_data);
            }
            $msg = "Record Updated Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    public function delete($id) {
        if (!empty($id)) {
            $this->printing_model->delete($id);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('delete_message'));
        } else {
            $array = array('status' => 'success', 'error' => '', 'message' => '');
        }
        echo json_encode($array);
    }

    function handle_upload() {
        if (isset($_FILES["print_header"]) && !empty($_FILES['print_header']['name'])) {
            $allowedExts = array('jpg', 'jpeg', 'png', "pdf", "doc", "docx", "rar", "zip");
            $temp = explode(".", $_FILES["print_header"]["name"]);
            $extension = end($temp);
            if ($_FILES["print_header"]["error"] > 0) {
                $error .= $this->lang->line('error_opening_the_file') . "<br />";
            }
            if (($_FILES["print_header"]["type"] != "application/pdf") && ($_FILES["print_header"]["type"] != "image/gif") && ($_FILES["print_header"]["type"] != "image/jpeg") && ($_FILES["print_header"]["type"] != "image/jpg") && ($_FILES["print_header"]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($_FILES["print_header"]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($_FILES["print_header"]["type"] != "image/pjpeg") && ($_FILES["print_header"]["type"] != "image/x-png") && ($_FILES["print_header"]["type"] != "application/x-rar-compressed") && ($_FILES["print_header"]["type"] != "application/octet-stream") && ($_FILES["print_header"]["type"] != "application/zip") && ($_FILES["print_header"]["type"] != "application/octet-stream") && ($_FILES["print_header"]["type"] != "image/png")) {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            if (!in_array(strtolower($extension), $allowedExts)) {
                $this->form_validation->set_message('handle_upload', $this->lang->line('extension_not_allowed'));
                return false;
            }
            return true;
        } else {
            $this->form_validation->set_message('handle_upload', $this->lang->line('the_file_field_is_required'));
            return false;
        }
    }

}

?>