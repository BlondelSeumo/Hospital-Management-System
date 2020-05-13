<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Floor extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/setup/floor');
        $this->session->set_userdata('sub_menu', 'bed');
        $data['floor'] = $this->floor_model->floor_list();
        $this->load->view('layout/header');
        $this->load->view('setup/floor', $data);
        $this->load->view('layout/footer');
    }

    function add() {
        $this->form_validation->set_rules(
                'name', $this->lang->line('name'), array('required',
            array('check_exists', array($this->floor_model, 'valid_floor'))
                )
        );
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('name'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $floor = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            );
            $this->floor_model->savefloor($floor);
            $msg = "Floor Added Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function getDataByid($id) {
        $data['floor_data'] = $this->floor_model->floor_list($id);
        $this->load->view('setup/editFloorModal', $data);
    }

    function edit($id) {

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = array(
                'name' => form_error('name'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $floor = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            );

            $this->floor_model->savefloor($floor);
            $msg = "Floor Updated Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

    function delete($id) {

        if (!empty($id)) {

            $this->floor_model->delete($id);
        }
    }

}
