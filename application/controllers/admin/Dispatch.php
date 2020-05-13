<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dispatch extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('postal_dispatch', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'front_office');
        $this->session->set_userdata('sub_menu', 'admin/dispatch');
        $this->form_validation->set_rules('to_title', 'To Title', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['DispatchList'] = $this->dispatch_model->dispatch_list();
            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/dispatchview', $data);
            $this->load->view('layout/footer');
        } else {

            $dispatch = array(
                'reference_no' => $this->input->post('ref_no'),
                'to_title' => $this->input->post('to_title'),
                'address' => $this->input->post('address'),
                'note' => $this->input->post('note'),
                'from_title' => $this->input->post('from'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'type' => 'dispatch'
            );

            $dispatch_id = $this->dispatch_model->insert('dispatch_receive', $dispatch);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = 'id' . $dispatch_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/front_office/dispatch_receive/" . $img_name);
                $this->dispatch_model->image_add('dispatch', $dispatch_id, $img_name);
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success"> Dispatch added successfully</div>');
            redirect('admin/dispatch');
        }
    }

    public function add() {

        $this->form_validation->set_rules('to_title', $this->lang->line('to_title'), 'required');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('to_title'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $dispatch = array(
                'reference_no' => $this->input->post('ref_no'),
                'to_title' => $this->input->post('to_title'),
                'address' => $this->input->post('address'),
                'note' => $this->input->post('note'),
                'from_title' => $this->input->post('from_title'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'type' => 'dispatch'
            );

            $dispatch_id = $this->dispatch_model->insert('dispatch_receive', $dispatch);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = 'id' . $dispatch_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/front_office/dispatch_receive/" . $img_name);
                $this->dispatch_model->image_add('dispatch', $dispatch_id, $img_name);
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function editdispatch() {
        if (!$this->rbac->hasPrivilege('postal_dispatch', 'can_edit')) {
            access_denied();
        }


        $id = $this->input->post('id');
        $this->form_validation->set_rules('to_title', $this->lang->line('to_title'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('to_title'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {


            $dispatch = array(
                'reference_no' => $this->input->post('ref_no'),
                'to_title' => $this->input->post('to_title'),
                'address' => $this->input->post('address'),
                'note' => $this->input->post('note'),
                'from_title' => $this->input->post('from_title'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'type' => 'dispatch'
            );


            $this->dispatch_model->update_dispatch('dispatch_receive', $id, 'dispatch', $dispatch);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = 'id' . $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/front_office/dispatch_receive/" . $img_name);
                $this->dispatch_model->image_update('dispatch', $id, $img_name);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    public function download($documents) {
        $this->load->helper('download');
        $filepath = "./uploads/front_office/dispatch_receive/" . $documents;
        $data = file_get_contents($filepath);
        $name = $documents;
        force_download($name, $data);
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('postal_dispatch', 'can_delete')) {
            access_denied();
        }

        $this->dispatch_model->delete($id);
    }

    public function imagedelete($id, $image) {
        $this->dispatch_model->image_delete($id, $image);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"> Dispatch deleted successfully</div>');
        redirect('admin/dispatch');
    }

    public function details($id, $type) {
        if (!$this->rbac->hasPrivilege('postal_dispatch', 'can_view')) {
            access_denied();
        }
        $data['data'] = $this->dispatch_model->dis_rec_data($id, $type);
        $this->load->view('admin/frontoffice/dispacthreceviemodel', $data);
    }

    public function get_dispatch($id) {

        $data = $this->dispatch_model->recevie_data($id);
        $a = array(
            'datedd' => date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($data['date'])),
        );

        $result = array_merge($a, $data);

        echo json_encode($result);
    }

}
