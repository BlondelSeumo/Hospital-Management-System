<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Room extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function index() {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_sidebar_menu', 'admin/setup/room');
        $this->session->set_userdata('sub_menu', 'bed');
        $data['roomtype_list'] = $this->Roomtype_Model->roomtypelist();
        $data['floor_list'] = $this->Floor_Model->floor_list();
        $data['dept_list'] = $this->Ward_Model->getdepartment();
        $data['room_list'] = $this->Room_Model->roomlist();
        $this->load->view('layout/header');
        $this->load->view('setup/Room', $data);
        $this->load->view('layout/footer');
    }

    function add() {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('floor_id', 'Floor Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('roomtype_id', 'Room Type Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dep_id', 'Departmet Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('name'),
                'floor_id' => form_error('floor_id'),
                'room_type_id' => form_error('roomtype_id'),
                'dep_id' => form_error('dep_id'),
                'description' => form_error('description'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $room = array(
                'name' => $this->input->post('name'),
                'room_type_id' => $this->input->post('roomtype_id'),
                'floor_id' => $this->input->post('floor_id'),
                'dep_id' => $this->input->post('dep_id'),
                'description' => $this->input->post('description'),
            );

            $this->Room_Model->saveroom($room);

            $msg = "Room Added Successfully";

            $array = array('status' => 'success', 'error' => '', 'message' => $msg);
        }
        echo json_encode($array);
    }

    function getdata($id) {

        $data['roomtype_list'] = $this->Roomtype_Model->roomtypelist();
        $data['room_data'] = $this->Room_Model->roomlist($id);
        $data['floor_list'] = $this->Floor_Model->floor_list();
        $data['dept_list'] = $this->Ward_Model->getdepartment();

        $this->load->view('setup/room/editroom', $data);
    }

    function edit($id) {

        $this->form_validation->set_rules('roomtype_id', 'Room Type Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('floor_id', 'Floor Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('department_id', 'Departmet Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('name'),
                'roomtype_id' => form_error('roomtype_id'),
                'floor_id' => form_error('floor_id'),
                'dep_id' => form_error('department_id'),
                'description' => form_error('description'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $room = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'room_type_id' => $this->input->post('roomtype_id'),
                'floor_id' => $this->input->post('floor_id'),
                'dep_id' => $this->input->post('department_id'),
                'description' => $this->input->post('description'),
            );

            $this->Room_Model->saveroom($room);

            $msg = "Room Updated Successfully";

            $array = array('status' => 'success', 'error' => '', 'message' => $msg);
        }
        echo json_encode($array);
    }

}

?>