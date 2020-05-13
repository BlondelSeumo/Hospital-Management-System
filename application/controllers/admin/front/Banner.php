<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banner extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->config('ci-blog');
        $this->banner_content = $this->config->item('ci_front_banner_content');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('banner_images', 'can_view')) {
            access_denied();
        }
        $data = array();
        $this->session->set_userdata('top_menu', 'Front CMS');
        $this->session->set_userdata('sub_menu', 'admin/front/banner');
        $result = $this->cms_program_model->getByCategory($this->banner_content);
        if (!empty($result)) {
            $data['banner_images'] = $this->cms_program_model->front_cms_program_photos($result[0]['id']);
        }
        $this->load->view('layout/header');
        $this->load->view('admin/front/banner/index', $data);
        $this->load->view('layout/footer');
    }

    function add() {
        if (!$this->rbac->hasPrivilege('banner_images', 'can_add')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Front CMS');
        $this->session->set_userdata('sub_menu', 'admin/front/banner');
        $banner_content = $this->config->item('ci_front_banner_content');
        $this->form_validation->set_rules('content_id', $this->lang->line('fees') . " " . $this->lang->line('payment') . " " . $this->lang->line('id'), 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'content_id' => form_error('content_id'),
            );
            $array = array('status' => '0', 'error' => 'Something wrong');
            echo json_encode($array);
        } else {

            $data = array(
                'program_id' => 0,
                'media_gallery_id' => $this->input->post('content_id'),
            );

            $response = $this->cms_program_model->banner($banner_content, $data);
            if ($response) {
                $array = array('status' => '1', 'error' => '', 'msg' => $this->lang->line('success_message'));
            } else {
                $array = array('status' => '0', 'error' => 'Something wrong', 'msg' => $this->lang->line('worning_message'));
            }
            echo json_encode($array);
        }
    }

    function remove() {
        if (!$this->rbac->hasPrivilege('banner_images', 'can_delete')) {
            access_denied();
        }
        $banner_content = $this->config->item('ci_front_banner_content');
        $this->form_validation->set_rules('content_id', 'Fees Payment Id', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'content_id' => form_error('content_id'),
            );
            $array = array('status' => '0', 'error' => $this->lang->line('worning_message'));
            echo json_encode($array);
        } else {
            $media_gallery_id = $this->input->post('content_id');
            $response = $this->cms_program_model->bannerDelete($banner_content, $media_gallery_id);
            if ($response) {
                $array = array('status' => '1', 'error' => '', 'msg' => $this->lang->line('delete_message'));
            } else {
                $array = array('status' => '0', 'error' => 'Something wrong', 'msg' => $this->lang->line('worning_message'));
            }
            echo json_encode($array);
        }
    }

}

?>