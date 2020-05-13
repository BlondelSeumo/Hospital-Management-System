<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontcms extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->config('ci-blog');
        $this->front_themes = $this->config->item('ci_front_themes');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('front_cms_setting', 'can_edit')) {
            access_denied();
        }
        $data['front_themes'] = $this->front_themes;

        $frontcmslist = $this->frontcms_setting_model->get();



        $data['title'] = 'Add Front CMS Setting';
        $data['title_list'] = 'Front CMS Settings';
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'schsettings/index');
        $this->session->set_userdata('inner_menu', 'admin/frontcms/index');
        $data['front_themes'] = $this->front_themes;
        $this->form_validation->set_rules('logo', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == TRUE) {
            $frontcms = $this->input->post('is_active_front_cms');
            $sidebar_options = $this->input->post('sidebar_options');
            if (isset($sidebar_options)) {
                $sidebar_options = json_encode($sidebar_options);
            } else {
                $sidebar_options = json_encode(array());
            }
            if (isset($frontcms)) {
                $is_active_front_cms = $frontcms;
            } else {
                $is_active_front_cms = 0;
            }
            $data = array(
                'id' => $this->input->post('id'),
                'contact_us_email' => $this->input->post('contact_us_email'),
                'is_active_front_cms' => $this->input->post('is_active_front_cms'),
                'is_active_rtl' => $this->input->post('is_active_rtl'),
                'is_active_sidebar' => $this->input->post('is_active_sidebar'),
                'theme' => $this->input->post('theme'),
                'complain_form_email' => $this->input->post('complain_form_email'),
                'sidebar_options' => $sidebar_options,
                'google_analytics' => $this->input->post('google_analytics'),
                'footer_text' => $this->input->post('footer_text'),
                'fb_url' => $this->input->post('fb_url'),
                'twitter_url' => $this->input->post('twitter_url'),
                'youtube_url' => $this->input->post('youtube_url'),
                'google_plus' => $this->input->post('google_plus'),
                'instagram_url' => $this->input->post('instagram_url'),
                'pinterest_url' => $this->input->post('pinterest_url'),
                'linkedin_url' => $this->input->post('linkedin_url'),
            );
            if (isset($_FILES["logo"]) && !empty($_FILES["logo"]['name'])) {
                $newLogoName = $this->customlib->uniqueFileName('front_logo-', $_FILES["logo"]['name']);
                $logo_dir = "./uploads/hospital_content/logo/" . $newLogoName;
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $logo_dir)) {
                    $data['logo'] = $logo_dir;
                    unlink($frontcmslist->logo);
                }
            }
            if (isset($_FILES["logo"]) && !empty($_FILES["fav_icon"]['name'])) {
                $newFavName = uniqid('front_fav_icon-', true) . '.' . strtolower(pathinfo($_FILES["fav_icon"]['name'], PATHINFO_EXTENSION));
                $fav_dir = "./uploads/hospital_content/logo/" . $newFavName;
                if (move_uploaded_file($_FILES["fav_icon"]["tmp_name"], $fav_dir)) {
                    $data['fav_icon'] = $fav_dir;
                    unlink($frontcmslist->fav_icon);
                }
            }
            $this->frontcms_setting_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/frontcms');
        }


        if (!$frontcmslist) {
            $frontcmslist = new stdClass();
            $frontcmslist->id = 0;
            $frontcmslist->is_active_front_cms = 0;
            $frontcmslist->contact_us_email = '';
            $frontcmslist->is_active_sidebar = '';
            $is_active_front_cms = 0;
            $frontcmslist->google_analytics = '';
            $frontcmslist->logo = '';
            $frontcmslist->fav_icon = '';
            $frontcmslist->sidebar_options = json_encode(array());
            $frontcmslist->is_active_rtl = '';
            $frontcmslist->theme = '';
            $frontcmslist->complain_form_email = '';
            $frontcmslist->footer_text = '';
            $frontcmslist->fb_url = '';
            $frontcmslist->twitter_url = '';
            $frontcmslist->youtube_url = '';
            $frontcmslist->google_plus = '';
            $frontcmslist->instagram_url = '';
            $frontcmslist->pinterest_url = '';
            $frontcmslist->linkedin_url = '';
        }
        $data['frontcmslist'] = $frontcmslist;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/frontcms/index', $data);
        $this->load->view('layout/footer', $data);
    }

    function handle_upload() {
        if (isset($_FILES["logo"]) && !empty($_FILES["logo"]['name'])) {
            $allowedExts = array('jpg', 'jpeg', 'png');
            $temp = explode(".", $_FILES["logo"]["name"]);
            $extension = end($temp);
            if ($_FILES["logo"]["error"] > 0) {
                $error .= "Error opening the file<br />";
            }
            if ($_FILES["logo"]["type"] != 'image/gif' &&
                    $_FILES["logo"]["type"] != 'image/jpeg' &&
                    $_FILES["logo"]["type"] != 'image/png') {
                $this->form_validation->set_message('handle_upload', 'Invalid File type.');
                return false;
            }
            if (!in_array(strtolower($extension), $allowedExts)) {
                $this->form_validation->set_message('handle_upload', 'Extension not allowed');
                return false;
            }
            if ($_FILES["logo"]["size"] > 204800) {
                $this->form_validation->set_message('handle_upload', 'File size shoud be less than 200 kB');
                return false;
            }
            return true;
        } else {
            return true;
        }
    }

}
