<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menus extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('imageResize');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('menus', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Add Book';
        $data['title_list'] = 'Book Details';
        $this->session->set_userdata('top_menu', 'Front CMS');
        $this->session->set_userdata('sub_menu', 'admin/front/menus');

        $listMenus = $this->cms_menu_model->get();

        $data['listMenus'] = $listMenus;

        $this->form_validation->set_rules(
                'menu', 'Menu', array(
            'required',
            array('check_exists', array($this->cms_menu_model, 'valid_check_exists'))
                )
        );

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header');
            $this->load->view('admin/front/menus/index', $data);
            $this->load->view('layout/footer');
        } else {
            $config = array(
                'field' => 'slug',
                'title' => 'menu',
                'table' => 'front_cms_menus',
                'id' => 'id',
            );
            $this->load->library('slug', $config);
            $publish = $this->input->post('publish');
            $data = array(
                'menu' => $this->input->post('menu'),
                'description' => $this->input->post('description')
            );
            $data['slug'] = $this->slug->create_uri($data);
            $this->cms_menu_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/front/menus');
        }
    }

    function add() {

        $this->form_validation->set_rules(
                'menu', $this->lang->line('menu'), array(
            'required',
            array('check_exists', array($this->cms_menu_model, 'valid_check_exists'))
                )
        );

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'e1' => form_error('menu'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $config = array(
                'field' => 'slug',
                'title' => 'menu',
                'table' => 'front_cms_menus',
                'id' => 'id',
            );
            $this->load->library('slug', $config);
            $publish = $this->input->post('publish');
            $data = array(
                'menu' => $this->input->post('menu'),
                'description' => $this->input->post('description')
            );
            $data['slug'] = $this->slug->create_uri($data);
            $this->cms_menu_model->add($data);


            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function additem($slug) {

        $data['title'] = 'Add Book';
        $data['title_list'] = 'Book Details';
        $this->session->set_userdata('top_menu', 'Front CMS');
        $this->session->set_userdata('sub_menu', 'admin/front/menus');
        $result = $this->cms_menu_model->getBySlug($slug);
        $data['result'] = $result;
        $data['top_menu'] = $slug;
        $listMenus = $this->cms_menuitems_model->getMenus($result['id']);
        $data['listdropdown_Menus'] = $listMenus;
        $this->form_validation->set_rules('menu', $this->lang->line('menu'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('ext_url_link', 'External URL', 'trim|xss_clean|callback_check_exists');
        $listPages = $this->cms_page_model->get();
        $data['listPages'] = $listPages;
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header');
            $this->load->view('admin/front/menus/additem', $data);
            $this->load->view('layout/footer');
        } else {
            $config = array(
                'field' => 'slug',
                'title' => 'menu',
                'table' => 'front_cms_menu_items',
                'id' => 'id',
            );
            $this->load->library('slug', $config);
            $data = array(
                'menu_id' => $this->input->post('menu_id'),
                'page_id' => $this->input->post('page_id'),
                'menu' => $this->input->post('menu'),
                'ext_url' => $this->input->post('ext_url'),
                'open_new_tab' => $this->input->post('open_new_tab'),
            );
            if ($this->input->post('ext_url')) {

                $data['ext_url_link'] = $this->input->post('ext_url_link');
            }

            $data['slug'] = $this->slug->create_uri($data);
            $this->cms_menuitems_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/front/menus/additem/' . $result['slug']);
        }
    }

    public function check_exists($ext_url_link) {
        if ($this->input->post('ext_url')) {
            if ($ext_url_link == "") {
                $this->form_validation->set_message('check_exists', 'The  field can not be blank.');
                return FALSE;
            }
        }
        return TRUE;
    }

    function edititem($slug, $top_menu) {

        if (!$this->rbac->hasPrivilege('menus', 'can_add')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Front CMS');
        $this->session->set_userdata('sub_menu', 'admin/front/menus');
        $menu = $this->cms_menuitems_model->getBySlug($slug);

        $data['result'] = $menu;
        $data['top_menu'] = $top_menu;

        $listMenus = $this->cms_menuitems_model->getMenus($menu['menu_id']);
        $data['listdropdown_Menus'] = $listMenus;
        $this->form_validation->set_rules('menu', $this->lang->line('menu'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('ext_url_link', $this->lang->line('external_url'), 'trim|xss_clean|callback_check_exists');
        $listPages = $this->cms_page_model->get();
        $data['listPages'] = $listPages;
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header');
            $this->load->view('admin/front/menus/edititem', $data);
            $this->load->view('layout/footer');
        } else {

            $config = array(
                'field' => 'slug',
                'title' => 'menu',
                'table' => 'front_cms_menu_items',
                'id' => 'id',
            );

            $this->load->library('slug', $config);
            $top_menu = $this->input->post('top_menu');
            $data = array(
                'id' => $this->input->post('id'),
                'page_id' => $this->input->post('page_id'),
                'menu' => $this->input->post('menu'),
                'ext_url' => $this->input->post('ext_url'),
                'open_new_tab' => $this->input->post('open_new_tab'),
            );
            if ($this->input->post('ext_url')) {

                $data['ext_url_link'] = $this->input->post('ext_url_link');
            }

            $data['slug'] = $this->slug->create_uri($data, $this->input->post('id'));
            $this->cms_menuitems_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/front/menus/additem/' . $top_menu);
        }
    }

    function updateMenu() {
        if (!$this->rbac->hasPrivilege('menus', 'can_edit')) {
            access_denied();
        }
        $order = ($this->input->post('order'));
        $weight = 1;
        $array = array();
        foreach ($order as $o_key => $o_value) {

            $array[] = array('id' => $o_value['id'], 'parent_id' => 0, 'weight' => $weight);
            if (isset($o_value['children'])) {
                $weight++;
                foreach ($o_value['children'] as $key => $value) {

                    $array[] = array('id' => $value['id'], 'parent_id' => $o_value['id'], 'weight' => $weight);
                    $weight++;
                }
            }
            $weight++;
        }

        $this->db->update_batch('front_cms_menu_items', $array, 'id');
    }

    function delete_image() {
        $delte_image = $this->input->post('id');
        if ($delte_image == "" && !isset($delte_image)) {
            
        } else {
            echo json_encode(array('status' => 0, 'msg' => 'image deleted successfully'));
            exit;
        }
        echo json_encode(array('status' => 1, 'msg' => 'something wrong'));
    }

    function deleteMenuItem() {

        $data['title'] = 'Fees Master List';
        $id = $this->input->post('id');
        if (!$this->cms_menuitems_model->remove($id)) {
            echo json_encode(array('status' => 0, 'message' => 'Something wrong'));
        } else {
            echo json_encode(array('status' => 1, 'message' => $this->lang->line('success_message')));
        }
    }

    function delete($slug) {
        if (!$this->rbac->hasPrivilege('menus', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->cms_menu_model->removeBySlug($slug);
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Menu deleted successfully</div>');
        redirect('admin/front/menus');
    }

}

?>