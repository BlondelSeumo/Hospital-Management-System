<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('active_link')) {

    function activate_menu($controller, $action) {
        $CI = get_instance();
        $method = $CI->router->fetch_method();
        $class = $CI->router->fetch_class();
        return ($method == $action && $controller == $class) ? 'active' : '';
    }

    function set_Topmenu($top_menu_name) {
        $CI = get_instance();
        $session_top_menu = $CI->session->userdata('top_menu');
        if ($session_top_menu == $top_menu_name) {
            return 'active';
        }
        return "";
    }

    function set_Submenu($sub_menu_name) {
        $CI = get_instance();
        $session_sub_menu = $CI->session->userdata('sub_menu');
        if ($session_sub_menu == $sub_menu_name) {
            return 'active';
        }
        return "";
    }

    function set_Innermenu($inner_menu_name) {
        $CI = get_instance();
        $session_sub_menu = $CI->session->userdata('inner_menu');
        if ($session_sub_menu == $inner_menu_name) {
            return 'active';
        }
        return "";
    }

    function set_sidebar_Submenu($sub_sidebar_menu_name) {
        $CI = get_instance();
        $session_sub_menu = $CI->session->userdata('sub_sidebar_menu');
        if ($session_sub_menu == $sub_sidebar_menu_name) {
            return 'active';
        }
        return "";
    }

}

function access_denied() {
    redirect('admin/unauthorized');
}

function update_config_installed() {
    $CI = & get_instance();
    $config_path = APPPATH . 'config/config.php';
    $CI->load->helper('file');
    @chmod($config_path, FILE_WRITE_MODE);
    $config_file = read_file($config_path);
    $config_file = trim($config_file);
    $config_file = str_replace("\$config['installed'] = false;", "\$config['installed'] = true;", $config_file);
    $config_file = str_replace("\$config['base_url'] = '';", "\$config['base_url'] = '" . site_url() . "';", $config_file);
    if (!$fp = fopen($config_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
        return FALSE;
    }
    flock($fp, LOCK_EX);
    fwrite($fp, $config_file, strlen($config_file));
    flock($fp, LOCK_UN);
    fclose($fp);
    @chmod($config_path, FILE_READ_MODE);
    return TRUE;
}

function update_autoload_installed() {
    $CI = & get_instance();
    $autoload_path = APPPATH . 'config/autoload.php';
    $CI->load->helper('file');
    @chmod($autoload_path, FILE_WRITE_MODE);
    $autoload_file = read_file($autoload_path);
    $autoload_file = trim($autoload_file);
    $autoload_file = str_replace("\$autoload['model'] = array()", "\$autoload['model'] = array('staff_model', 'setting_model', 'language_model', 'admin_model', 'smsconfig_model', 'langpharses_model', 'expense_model', 'expensehead_model', 'content_model', 'user_model', 'notification_model', 'paymentsetting_model', 'payroll_model', 'department_model', 'designation_model', 'emailconfig_model', 'income_model', 'incomehead_model', 'itemcategory_model', 'item_model', 'messages_model', 'itemstore_model', 'itemsupplier_model', 'notificationsetting_model', 'itemstock_model', 'itemissue_model', 'userlog_model', 'cms_program_model', 'cms_menu_model', 'cms_media_model', 'cms_page_model', 'cms_menuitems_model', 'cms_page_content_model', 'role_model', 'calendar_model', 'userpermission_model', 'staffroles_model', 'staffattendancemodel', 'rolepermission_model', 'timeline_model', 'module_model', 'patient_model', 'floor_Model', 'bedtype_model',  'prescription_model', 'operationtheatre_model', 'pharmacy_model', 'medicine_category_model', 'lab_model', 'pathology_category_model', 'pathology_model', 'blooddonor_model', 'blood_donorcycle_model', 'bloodissue_model', 'bloodbankstatus_model', 'charge_category_model', 'charge_model', 'organisation_model', 'tpa_model', 'vehicle_model', 'appointment_model', 'radio_model', 'floor_model', 'bed_model', 'bedgroup_model','chat_model','chatuser_model','visitors_purpose_model','visitors_model','systemnotification_model','supplier_category_model','source_model','report_model','printing_model','payment_model','modulepermission_model','medicine_dosage_model','leavetypes_model','leaverequest_model','general_call_model','frontcms_setting_model','expmedicine_model','dispatch_model','customfield_model','content_model','consultcharge_model','complaintType_model','complaint_model','birthordeath_model')", $autoload_file);
    $autoload_file = str_replace("\$autoload['libraries'] = array('database', 'session', 'form_validation')", "\$autoload['libraries'] = array('database', 'email', 'session', 'form_validation', 'upload', 'pagination', 'Customlib', 'Role', 'Smsgateway', 'QDMailer', 'Adler32', 'Aes')", $autoload_file);
    if (!$fp = fopen($autoload_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
        return FALSE;
    }
    flock($fp, LOCK_EX);
    fwrite($fp, $autoload_file, strlen($autoload_file));
    flock($fp, LOCK_UN);
    fclose($fp);
    @chmod($config_path, FILE_READ_MODE);
    return TRUE;
}

function delete_dir($dirPath) {
    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            delete_dir($file);
        } else {
            unlink($file);
        }
    }
    if (rmdir($dirPath)) {
        return true;
    }
    return false;
}

function admin_url($url = '') {
    if ($url == '') {
        return site_url() . 'site/login';
    } else {
        return site_url() . 'site/login';
    }
}

?>