<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Complaint extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('complain', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'front_office');
        $this->session->set_userdata('sub_menu', 'admin/complaint');
        $this->form_validation->set_rules('name', 'Complaint By', 'required');


        if ($this->form_validation->run() == FALSE) {
            $data['complaint_list'] = $this->complaint_model->complaint_list();
            $data['complaint_type'] = $this->complaint_model->getComplaintType();
            $data['complaintsource'] = $this->complaint_model->getComplaintSource();
            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/complaintview', $data);
            $this->load->view('layout/footer');
        } else {

            $complaint = array(
                'complaint_type' => $this->input->post('complaint'),
                'source' => $this->input->post('source'),
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
                'action_taken' => $this->input->post('action_taken'),
                'assigned' => $this->input->post('assigned'),
                'note' => $this->input->post('note')
            );


            $complaint_id = $this->complaint_model->add($complaint);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = 'id' . $complaint_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/front_office/complaints/" . $img_name);
                $this->complaint_model->image_add($complaint_id, $img_name);
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Complaint added successfully</div>');
            redirect('admin/complaint');
        }
    }

    function add() {


        $this->form_validation->set_rules('name', $this->lang->line('complain_by'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $complaint = array(
                'complaint_type' => $this->input->post('complaint'),
                'source' => $this->input->post('source'),
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
                'action_taken' => $this->input->post('action_taken'),
                'assigned' => $this->input->post('assigned'),
                'note' => $this->input->post('note')
            );


            $complaint_id = $this->complaint_model->add($complaint);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = 'id' . $complaint_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/front_office/complaints/" . $img_name);
                $this->complaint_model->image_add($complaint_id, $img_name);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    function edit() {
        $id = $this->input->post('id');
        if (!$this->rbac->hasPrivilege('complain', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('name', $this->lang->line('complain_by'), 'required');


        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $complaint = array(
                'complaint_type' => $this->input->post('complaint'),
                'source' => $this->input->post('source'),
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
                'action_taken' => $this->input->post('action_taken'),
                'assigned' => $this->input->post('assigned'),
                'note' => $this->input->post('note')
            );

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = 'id' . $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/front_office/complaints/" . $img_name);
                $this->complaint_model->image_add($id, $img_name);
            }
            $this->complaint_model->compalaint_update($id, $complaint);

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    function details($id) {
        if (!$this->rbac->hasPrivilege('complain', 'can_view')) {
            access_denied();
        }

        $data['complaint_data'] = $this->complaint_model->complaint_list($id);
        $this->load->view('admin/frontoffice/Complaintmodalview', $data);
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('complain', 'can_delete')) {
            access_denied();
        }

        $this->complaint_model->delete($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> Complaint deleted successfully</div>');

        redirect('admin/complaint');
    }

    function download($image) {
        $this->load->helper('download');
        $filepath = "./uploads/front_office/complaints/" . $image;
        $data = file_get_contents($filepath);
        $name = $image;
        force_download($name, $data);
    }

    function imagedelete($id, $image) {
        if (!$this->rbac->hasPrivilege('complain', 'can_delete')) {
            access_denied();
        }
        $this->complaint_model->image_delete($id, $image);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> Complaint deleted successfully</div>');
        redirect('admin/complaint');
    }

    public function check_default($post_string) {
        return $post_string == "" ? FALSE : TRUE;
    }

    public function get_complaint($id) {

        $data = $this->complaint_model->complaint_list($id);

        $a = array(
            'datedd' => date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($data['date'])),
        );

        $result = array_merge($a, $data);

        echo json_encode($result);
    }

}
