<?php

define('THEMES_DIR', 'themes');
define('BASE_URI', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

class MY_Controller extends CI_Controller {

    protected $langs = array();

    function __construct() {
        parent::__construct();
        $lang_array = array();
        $this->load->helper('language');
        $this->load->config('license');
        $this->load->library('auth');
        $this->load->library('module_lib');
        $this->load->helper('directory');
        $this->load->model('setting_model');
        if ($this->session->has_userdata('admin')) {
            $admin = $this->session->userdata('admin');
            $language = ($admin['language']['language']);
        } else if ($this->session->has_userdata('patient')) {
            $student = $this->session->userdata('patient');
            $language = ($student['language']['language']);
        } else {
            $sss = $this->setting_model->get();
            $language = $sss[0]['language'];
        }

        $this->config->set_item('language', $language);
        $map = directory_map(APPPATH . "./language/" . $language . "/app_files");
        foreach ($map as $lang_key => $lang_value) {
            $lang_array[] = 'app_files/' . str_replace(".php", "", $lang_value);
        }
        $this->load->language($lang_array, $language);
    }

}

class Admin_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('rbac');
        $this->auth->is_logged_in();
    }

}

class Patient_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->auth->is_logged_in_user('patient');
    }

}

class Public_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

}

class Parent_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->auth->is_logged_in_user('parent');
    }

}

class Front_Controller extends CI_Controller {

    protected $data = array();
    protected $school_details = array();
    protected $parent_menu = '';
    protected $page_title = '';
    protected $theme_path = '';
    protected $front_setting = '';

    function __construct() {

        parent::__construct();
        $this->load->helper('language');
        $this->check_installation();
        if ($this->config->item('installed') == true) {
            $this->db->reconnect();
        }

        $this->school_details = $this->setting_model->getSchoolDetail();


        $this->load->model('frontcms_setting_model');
        $this->front_setting = $this->frontcms_setting_model->get();
        if (!$this->front_setting->is_active_front_cms) {
            redirect('site/userlogin');
        }
        $this->theme_path = $this->front_setting->theme;
//================
        $language = ($this->school_details->language);
        $this->load->helper('directory');
        $lang_array = array('form_validation_lang');
        $map = directory_map(APPPATH . "./language/" . $language . "/app_files");
        foreach ($map as $lang_key => $lang_value) {
            $lang_array[] = 'app_files/' . str_replace(".php", "", $lang_value);
        }

        $this->load->language($lang_array, $language);
//===============

        $this->load->config('ci-blog');
    }

    protected function load_theme($content = null, $layout = true) {

        $this->data['main_menus'] = '';
        $this->data['school_setting'] = $this->school_details;
        $this->data['front_setting'] = $this->front_setting;
        $menu_list = $this->cms_menu_model->getBySlug('main-menu');
        $footer_menu_list = $this->cms_menu_model->getBySlug('bottom-menu');
        if (count($menu_list)  > 0) {
            $this->data['main_menus'] = $this->cms_menuitems_model->getMenus($menu_list['id']);
        }

        if (count($footer_menu_list)  > 0) {
            $this->data['footer_menus'] = $this->cms_menuitems_model->getMenus($footer_menu_list['id']);
        }
        $this->data['header'] = $this->load->view('themes/' . $this->theme_path . '/header', $this->data, TRUE);

        $this->data['slider'] = $this->load->view('themes/' . $this->theme_path . '/home_slider', $this->data, TRUE);

        $this->data['footer'] = $this->load->view('themes/' . $this->theme_path . '/footer', $this->data, TRUE);

        $this->base_assets_url = 'backend/' . THEMES_DIR . '/' . $this->theme_path . '/';

        $this->data['base_assets_url'] = BASE_URI . $this->base_assets_url;


        $this->data['content'] = (is_null($content)) ? '' : $this->load->view(THEMES_DIR . '/' . $this->theme_path . '/' . $content, $this->data, TRUE);
        $this->load->view(THEMES_DIR . '/' . $this->theme_path . '/layout', $this->data);
    }

    protected function load_theme_form($content = null, $layout = true) {

        $this->data['main_menus'] = '';
        $this->data['school_setting'] = $this->school_details;
        $this->data['front_setting'] = $this->front_setting;
        $menu_list = $this->cms_menu_model->getBySlug('main-menu');
        $footer_menu_list = $this->cms_menu_model->getBySlug('bottom-menu');
        if (count($menu_list > 0)) {
            $this->data['main_menus'] = $this->cms_menuitems_model->getMenus($menu_list['id']);
        }

        if (count($footer_menu_list > 0)) {
            $this->data['footer_menus'] = $this->cms_menuitems_model->getMenus($footer_menu_list['id']);
        }
        $this->data['header'] = $this->load->view('themes/' . $this->theme_path . '/header', $this->data, TRUE);

        $this->data['slider'] = $this->load->view('themes/' . $this->theme_path . '/home_slider', $this->data, TRUE);

        $this->data['footer'] = $this->load->view('themes/' . $this->theme_path . '/footer', $this->data, TRUE);

        $this->base_assets_url = 'backend/' . THEMES_DIR . '/' . $this->theme_path . '/';

        $this->data['base_assets_url'] = BASE_URI . $this->base_assets_url;


        $this->data['content'] = (is_null($content)) ? '' : $this->load->view(THEMES_DIR . '/' . $this->theme_path . '/' . $content, $this->data, TRUE);

        $this->load->view(THEMES_DIR . '/' . $this->theme_path . '/layout', $this->data);
    }

    private function check_installation() {
        if ($this->uri->segment(1) !== 'install') {
            $this->load->config('migration');
            if ($this->config->item('installed') == false && $this->config->item('migration_enabled') == false) {
                redirect(base_url() . 'install/start');
            } else {
                if (is_dir(APPPATH . 'controllers/install')) {
                    echo '<h3>Delete the install folder from application/controllers/install</h3>';
                    die;
                }
            }
        }
    }

}

?>