<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customlib {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('session');
        $this->CI->load->library('user_agent');
        $this->CI->load->model('Notification_model', '', TRUE);
        $this->CI->load->model('Setting_model', '', TRUE);
        $this->CI->load->model('Notificationsetting_model', '', TRUE);
    }

    function getPatienttype() {
        $paitent_type = array();
        $paitent_type['inpatient'] = 'Inpatient';
        $paitent_type['outpatient'] = 'Outpatient';
        return $paitent_type;
    }

    function timeFormat() {
        $time_format = array();
        $time_format['24-hour'] = '24 Hour';
        $time_format['12-hour'] = '12 Hour';
        return $time_format;
    }

    function getCSRF() {
        $csrf_input = "<input type='hidden' ";
        $csrf_input .= "name='" . $this->CI->security->get_csrf_token_name() . "'";
        $csrf_input .= " value='" . $this->CI->security->get_csrf_hash() . "'/>";

        return $csrf_input;
    }

    function contentAvailabelFor() {
        $content_for = array();
        $role_array = $this->getStaffRole();
        $role = json_decode($role_array);

        $content_for[$role->name] = "All " . $role->name;
        $content_for['student'] = 'Student';

        return $content_for;
    }

    function getCalltype() {
        $call_type = array();

        $call_type['Incoming'] = $this->CI->lang->line('incoming');
        $call_type['Outgoing'] = $this->CI->lang->line('outgoing');
        return $call_type;
    }

    function getGender() {
        $gender = array();
        $gender['Male'] = $this->CI->lang->line('male');
        $gender['Female'] = $this->CI->lang->line('female');
        return $gender;
    }

    function getStatus() {
        $status = array();
        $status[""] = $this->CI->lang->line('select');
        $status['enabled'] = $this->CI->lang->line('enabled');
        $status['disabled'] = $this->CI->lang->line('disabled');
        return $status;
    }

    function getDateFormat() {
        $dateFormat = array();
        $dateFormat['d-m-Y'] = 'dd-mm-yyyy';
        $dateFormat['d-M-Y'] = 'dd-mmm-yyyy';
        $dateFormat['d/m/Y'] = 'dd/mm/yyyy';
        $dateFormat['d.m.Y'] = 'dd.mm.yyyy';
        $dateFormat['m-d-Y'] = 'mm-dd-yyyy';
        $dateFormat['m/d/Y'] = 'mm/dd/yyyy';
        $dateFormat['m.d.Y'] = 'mm.dd.yyyy';
        return $dateFormat;
    }

    function getCurrency() {
        $currency = array();
        $currency['AED'] = 'AED';
        $currency['AFN'] = 'AFN';
        $currency['ALL'] = 'ALL';
        $currency['AMD'] = 'AMD';
        $currency['ANG'] = 'ANG';
        $currency['AOA'] = 'AOA';
        $currency['ARS'] = 'ARS';
        $currency['AUD'] = 'AUD';
        $currency['AWG'] = 'AWG';
        $currency['AZN'] = 'AZN';
        $currency['BAM'] = 'BAM';
        $currency['BBD'] = 'BAM';
        $currency['BDT'] = 'BDT';
        $currency['BGN'] = 'BGN';
        $currency['BHD'] = 'BHD';
        $currency['BIF'] = 'BIF';
        $currency['BMD'] = 'BMD';
        $currency['BND'] = 'BND';
        $currency['BOB'] = 'BOB';
        $currency['BOV'] = 'BOV';
        $currency['BRL'] = 'BRL';
        $currency['BSD'] = 'BSD';
        $currency['BTN'] = 'BTN';
        $currency['BWP'] = 'BWP';
        $currency['BYN'] = 'BYN';
        $currency['BYR'] = 'BYR';
        $currency['BZD'] = 'BZD';
        $currency['CAD'] = 'CAD';
        $currency['CDF'] = 'CDF';
        $currency['CHE'] = 'CHE';
        $currency['CHF'] = 'CHF';
        $currency['CHW'] = 'CHW';
        $currency['CLF'] = 'CLF';
        $currency['CLP'] = 'CLP';
        $currency['CNY'] = 'CNY';
        $currency['COP'] = 'COP';
        $currency['COU'] = 'COU';
        $currency['CRC'] = 'CRC';
        $currency['CUC'] = 'CUC';
        $currency['CUP'] = 'CUP';
        $currency['CVE'] = 'CVE';
        $currency['CZK'] = 'CZK';
        $currency['DJF'] = 'DJF';
        $currency['DKK'] = 'DKK';
        $currency['DOP'] = 'DOP';
        $currency['DZD'] = 'DZD';
        $currency['EGP'] = 'EGP';
        $currency['ERN'] = 'ERN';
        $currency['ETB'] = 'ETB';
        $currency['EUR'] = 'EUR';
        $currency['FJD'] = 'FJD';
        $currency['FKP'] = 'FKP';
        $currency['GBP'] = 'GBP';
        $currency['GEL'] = 'GEL';
        $currency['GHS'] = 'GHS';
        $currency['GIP'] = 'GIP';
        $currency['GMD'] = 'GMD';
        $currency['GNF'] = 'GNF';
        $currency['GTQ'] = 'GTQ';
        $currency['GYD'] = 'GYD';
        $currency['HKD'] = 'HKD';
        $currency['HNL'] = 'HNL';
        $currency['HRK'] = 'HRK';
        $currency['HTG'] = 'HTG';
        $currency['HUF'] = 'HUF';
        $currency['IDR'] = 'IDR';
        $currency['ILS'] = 'ILS';
        $currency['INR'] = 'INR';
        $currency['IQD'] = 'IQD';
        $currency['IRR'] = 'IRR';
        $currency['ISK'] = 'ISK';
        $currency['JMD'] = 'JMD';
        $currency['JOD'] = 'JOD';
        $currency['JPY'] = 'JPY';
        $currency['KES'] = 'KES';
        $currency['KGS'] = 'KGS';
        $currency['KHR'] = 'KHR';
        $currency['KMF'] = 'KMF';
        $currency['KPW'] = 'KPW';
        $currency['KRW'] = 'KRW';
        $currency['KWD'] = 'KWD';
        $currency['KYD'] = 'KYD';
        $currency['KZT'] = 'KZT';
        $currency['LAK'] = 'LAK';
        $currency['LBP'] = 'LBP';
        $currency['LKR'] = 'LKR';
        $currency['LRD'] = 'LRD';
        $currency['LSL'] = 'LSL';
        $currency['LYD'] = 'LYD';
        $currency['MAD'] = 'MAD';
        $currency['MDL'] = 'MDL';
        $currency['MGA'] = 'MGA';
        $currency['MKD'] = 'MKD';
        $currency['MMK'] = 'MMK';
        $currency['MNT'] = 'MNT';
        $currency['MOP'] = 'MOP';
        $currency['MRO'] = 'MRO';
        $currency['MUR'] = 'MUR';
        $currency['MVR'] = 'MVR';
        $currency['MWK'] = 'MWK';
        $currency['MXN'] = 'MXN';
        $currency['MXV'] = 'MXV';
        $currency['MYR'] = 'MYR';
        $currency['MZN'] = 'MZN';
        $currency['NAD'] = 'NAD';
        $currency['NGN'] = 'NGN';
        $currency['NIO'] = 'NIO';
        $currency['NOK'] = 'NOK';
        $currency['NPR'] = 'NPR';
        $currency['NZD'] = 'NZD';
        $currency['OMR'] = 'OMR';
        $currency['PAB'] = 'PAB';
        $currency['PEN'] = 'PEN';
        $currency['PGK'] = 'PGK';
        $currency['PHP'] = 'PHP';
        $currency['PKR'] = 'PKR';
        $currency['PLN'] = 'PLN';
        $currency['PYG'] = 'PYG';
        $currency['QAR'] = 'QAR';
        $currency['RON'] = 'RON';
        $currency['RSD'] = 'RSD';
        $currency['RUB'] = 'RUB';
        $currency['RWF'] = 'RWF';
        $currency['SAR'] = 'SAR';
        $currency['SBD'] = 'SBD';
        $currency['SCR'] = 'SCR';
        $currency['SDG'] = 'SDG';
        $currency['SEK'] = 'SEK';
        $currency['SGD'] = 'SGD';
        $currency['SHP'] = 'SHP';
        $currency['SLL'] = 'SLL';
        $currency['SOS'] = 'SOS';
        $currency['SRD'] = 'SRD';
        $currency['SSP'] = 'SSP';
        $currency['STD'] = 'STD';
        $currency['SVC'] = 'SVC';
        $currency['SYP'] = 'SYP';
        $currency['SZL'] = 'SZL';
        $currency['THB'] = 'THB';
        $currency['TJS'] = 'TJS';
        $currency['TMT'] = 'TMT';
        $currency['TND'] = 'TND';
        $currency['TOP'] = 'TOP';
        $currency['TRY'] = 'TRY';
        $currency['TTD'] = 'TTD';
        $currency['TWD'] = 'TWD';
        $currency['TZS'] = 'TZS';
        $currency['UAH'] = 'UAH';
        $currency['UGX'] = 'UGX';
        $currency['USD'] = 'USD';
        $currency['USN'] = 'USN';
        $currency['UYI'] = 'UYI';
        $currency['UYU'] = 'UYU';
        $currency['UZS'] = 'UZS';
        $currency['VEF'] = 'VEF';
        $currency['VND'] = 'VND';
        $currency['VUV'] = 'VUV';
        $currency['WST'] = 'WST';
        $currency['XAF'] = 'XAF';
        $currency['XAG'] = 'XAG';
        $currency['XAU'] = 'XAU';
        $currency['XBA'] = 'XBA';
        $currency['XBB'] = 'XBB';
        $currency['XBC'] = 'XBC';
        $currency['XBD'] = 'XBD';
        $currency['XCD'] = 'XCD';
        $currency['XDR'] = 'XDR';
        $currency['XOF'] = 'XOF';
        $currency['XPD'] = 'XPD';
        $currency['XPF'] = 'XPF';
        $currency['XPT'] = 'XPT';
        $currency['XSU'] = 'XSU';
        $currency['XTS'] = 'XTS';
        $currency['XUA'] = 'XUA';
        $currency['XXX'] = 'XXX';
        $currency['YER'] = 'YER';
        $currency['ZAR'] = 'ZAR';
        $currency['ZMW'] = 'ZMW';
        $currency['ZWL'] = 'ZWL';
        return $currency;
    }

    function getRteStatus() {
        $status = array();
        $status['Yes'] = $this->CI->lang->line('yes');
        $status['No'] = $this->CI->lang->line('no');
        return $status;
    }

    function getDaysname() {
        $status = array();
        $status['Monday'] = 'Monday';
        $status['Tuesday'] = 'Tuesday';
        $status['Wednesday'] = 'Wednesday';
        $status['Thursday'] = 'Thursday';
        $status['Friday'] = 'Friday';
        $status['Saturday'] = 'Saturday';
        $status['Sunday'] = 'Sunday';
        return $status;
    }

    function getcontenttype() {
        $status = array();
        $status['Assignments'] = 'Assignments';
        $status['Study_material'] = 'Study Material';
        $status['Syllabus'] = 'Syllabus';
        $status['Other_download'] = 'Other Download';
        return $status;
    }

    function getPageContentCategory() {
        $category = array();
        $category['standard'] = 'Standard';
        $category['events'] = 'Events';
        $category['notice'] = 'Notice';
        $category['gallery'] = 'Gallery';
        return $category;
    }

    function getDatepickerFormat($date_only = true, $time = false) {

        $setting_result = $this->CI->setting_model->get();
        $time_format = $setting_result[0]['time_format'];

        $hi_format = ' h:i A';
        $Hi_format = ' H:i';

        $admin = $this->CI->session->userdata('hospitaladmin');
        if ($admin) {
            if ($date_only && !$time) {

                return $admin['date_format'];
            } elseif ($time_format == "24-hour") {

                return $admin['date_format'] . $Hi_format;
            } elseif ($time_format == "12-hour") {

                return $admin['date_format'] . $hi_format;
            }
        } else if ($this->CI->session->userdata('patient')) {

            $student = $this->CI->session->userdata('patient');
            if ($date_only && !$time) {

                return $student['date_format'];
            } elseif ($time_format == "24-hour") {

                return $student['date_format'] . $Hi_format;
            } elseif ($time_format == "12-hour") {

                return $student['date_format'] . $hi_format;
            }
        }
    }

    function getSchoolDateFormat($date_only = true, $time = false) {
        // to be used by session or sch_setting table

        $setting_result = $this->CI->setting_model->get();
        $time_format = $setting_result[0]['time_format'];

        $hi_format = ' h:i A';
        $Hi_format = ' H:i';

        $admin = $this->CI->session->userdata('hospitaladmin');
        if ($admin) {
            if ($date_only && !$time) {

                return $admin['date_format'];
            } elseif ($time_format == "24-hour") {

                return $admin['date_format'] . $Hi_format;
            } elseif ($time_format == "12-hour") {

                return $admin['date_format'] . $hi_format;
            }
        } else if ($this->CI->session->userdata('patient')) {

            $student = $this->CI->session->userdata('patient');
            if ($date_only && !$time) {

                return $student['date_format'];
            } elseif ($time_format == "24-hour") {

                return $student['date_format'] . $Hi_format;
            } elseif ($time_format == "12-hour") {

                return $student['date_format'] . $hi_format;
            }
        }
    }

    function getTimeZone() {
        $admin = $this->CI->session->userdata('hospitaladmin');
        if ($admin) {
            return $admin['timezone'];
        } else if ($this->CI->session->userdata('patient')) {
            $student = $this->CI->session->userdata('patient');
            return $student['timezone'];
        }
    }

    function getSchoolCurrencyFormat() {
        $admin = $this->CI->session->userdata('hospitaladmin');
        if ($admin) {
            return $admin['currency_symbol'];
        } else if ($this->CI->session->userdata('student')) {
            $student = $this->CI->session->userdata('student');
            return $student['currency_symbol'];
        } else if ($this->CI->session->userdata('patient')) {
            $patient = $this->CI->session->userdata('patient');
            return $patient['currency_symbol'];
        }
    }

    function getLoggedInUserData() {
        $admin = $this->CI->session->userdata('hospitaladmin');
        if ($admin) {
            return $admin;
        } else if ($this->CI->session->userdata('patient')) {
            $student = $this->CI->session->userdata('patient');
            return $student;
        }
    }

    function getCurrentTheme() {

        $theme = "default";
        $admin = $this->CI->session->userdata('hospitaladmin');

        if ($admin) {
            if (isset($admin['theme']) && $admin['theme'] != "") {
                $ext = pathinfo($admin['theme'], PATHINFO_EXTENSION);
                $theme = basename($admin['theme'], "." . $ext);
            }
        } else if ($this->CI->session->userdata('patient')) {
            $student = $this->CI->session->userdata('patient');


            if (isset($student['theme']) && $student['theme'] != "") {
                $ext = pathinfo($student['theme'], PATHINFO_EXTENSION);
                $theme = basename($student['theme'], "." . $ext);
            }
        }
        return $theme;
    }

    function getRTL() {
        $rtl = "";
        $admin = $this->CI->session->userdata('hospitaladmin');
        if ($admin) {
            if ($admin['is_rtl'] == "disabled") {
                $rtl = "";
            } else {
                $rtl = "dir='rtl' lang='ar'";
            }
        } else if ($this->CI->session->userdata('patient')) {
            $student = $this->CI->session->userdata('patient');

            if ($student['is_rtl'] == "disabled") {
                $rtl = "";
            } else {
                $rtl = "dir='rtl' lang='ar'";
            }
        }
        return $rtl;
    }

    function getStudentSessionUserID() {
        $student_session = $this->CI->session->all_userdata();
        $session_Array = $this->CI->session->userdata('patient');
        $studentID = $session_Array['patient'];
        return $studentID;
    }

    function getPatientSessionUserID() {
        $student_session = $this->CI->session->all_userdata();
        $session_Array = $this->CI->session->userdata('patient');
        $studentID = $session_Array['patient_id'];
        return $studentID;
    }

    function getUsersID() { // users table id of users
        $session_Array = $this->CI->session->userdata('student');
        $user_id = $session_Array['id'];
        return $user_id;
    }

    function getStaffID() { // users table id of users
        $session_Array = $this->CI->session->userdata('hospitaladmin');
        $staff_id = $session_Array['id'];
        return $staff_id;
    }

    function getSessionLanguage() {
        $student_session = $this->CI->session->userdata('hospitaladmin');
        $language = $student_session['language'];
        $lang_id = $language['lang_id'];
        return $lang_id;
    }

    function checkPaypalDisplay() {
        $payment_setting = $this->CI->paymentsetting_model->get();
        return $payment_setting;
    }

    function getStudentSessionUserName() {
        $student_session = $this->CI->session->all_userdata();
        $session_Array = $this->CI->session->userdata('patient');
        $studentUsername = $session_Array['name'];
        return $studentUsername;
    }

    function getAdminSessionUserName() {
        $student_session = $this->CI->session->userdata('hospitaladmin');
        $username = $student_session['username'];

        return $username;
    }

    function getUserRole() {

        $user = $this->CI->session->userdata('student');
        return $user['role'];
    }

    function getMonthDropdown() {
        $array = array();
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $array[$month] = $month;
        }
        return $array;
    }

    function getMonthList() {
        $months = array(1 => $this->CI->lang->line('january'), 2 => $this->CI->lang->line('february'), 3 => $this->CI->lang->line('march'), 4 => $this->CI->lang->line('april'), 5 => $this->CI->lang->line('may'), 6 => $this->CI->lang->line('june'), 7 => $this->CI->lang->line('july'), 8 => $this->CI->lang->line('august'), 9 => $this->CI->lang->line('september'), 10 => $this->CI->lang->line('october'), 11 => $this->CI->lang->line('november'), 12 => $this->CI->lang->line('december'));
        return $months;
    }

    function geLangMonthList() {
        $months = array('january' => $this->CI->lang->line('january'), 'february' => $this->CI->lang->line('february'), 'march' => $this->CI->lang->line('march'), 'april' => $this->CI->lang->line('april'), 'may' => $this->CI->lang->line('may'), 'june' => $this->CI->lang->line('june'), 'july' => $this->CI->lang->line('july'), 'august' => $this->CI->lang->line('august'), 'september' => $this->CI->lang->line('september'), 'october' => $this->CI->lang->line('october'), 'november' => $this->CI->lang->line('november'), 'december' => $this->CI->lang->line('december'));
        return $months;
    }

    function getAppName() {
        $admin = $this->CI->session->userdata('hospitaladmin');
        if ($admin) {
            return $admin['sch_name'];
        } else if ($this->CI->session->userdata('patient')) {
            $student = $this->CI->session->userdata('patient');
            return $student['sch_name'];
        }
    }

    function getStaffRole() {
        $admin = $this->CI->session->userdata('hospitaladmin');
        $roles = $admin['roles'];
        if ($admin) {
            $role_key = key($roles);
            return json_encode(array('id' => $roles[$role_key], 'name' => $role_key));
        }
    }

    function getSchoolName() {
        $admin = $this->CI->Setting_model->getSetting();
        return $admin->name;
    }

    function getAppVersion() {
		//Build: 200120
        $appVersion = "2.1";
        return $appVersion;
    }

    function datetostrtotime($date) {
        $format = $this->getSchoolDateFormat();
        if (!empty($date)) {
            if ($format == 'd-m-Y')
                list($day, $month, $year) = explode('-', $date);
            if ($format == 'd/m/Y')
                list($day, $month, $year) = explode('/', $date);
            if ($format == 'd-M-Y')
                list($day, $month, $year) = explode('-', $date);
            if ($format == 'd.m.Y')
                list($day, $month, $year) = explode('.', $date);
            if ($format == 'm-d-Y')
                list($month, $day, $year) = explode('-', $date);
            if ($format == 'm/d/Y')
                list($month, $day, $year) = explode('/', $date);
            if ($format == 'm.d.Y')
                list($month, $day, $year) = explode('.', $date);

            $dater = $day . "-" . $month . "-" . $year;
            return strtotime($dater);
        }
    }

    function dateyyyymmddTodateformat($date) {

        $format = $this->getSchoolDateFormat();


        if ($format == 'd-m-Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'd/m/Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'd-M-Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'd.m.Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'm-d-Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'm/d/Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'm.d.Y')
            list($month, $day, $year) = explode('-', $date);
        $date = $year . "-" . $day . "-" . $month;


        return strtotime($date);
    }

    function dateFront() {
        $admin = $this->CI->Setting_model->getSetting();
        return $admin->date_format;
    }

    function chatDateTimeformat($date) {

        $date_formated = date_parse_from_format('d M Y, H:i:s', $date);
        $year = $date_formated['year'];
        $month = str_pad($date_formated['month'], 2, "0", STR_PAD_LEFT);
        $day = str_pad($date_formated['day'], 2, "0", STR_PAD_LEFT);
        $hour = str_pad($date_formated['hour'], 2, "0", STR_PAD_LEFT);
        $minute = str_pad($date_formated['minute'], 2, "0", STR_PAD_LEFT);
        $second = str_pad($date_formated['second'], 2, "0", STR_PAD_LEFT);

        $format_date = $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":" . $second;
        return $format_date;
    }

    function dateyyyymmddTodateformatFront($date) {
        $format = $this->dateFront();

        if ($format == 'd-m-Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'd/m/Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'd-M-Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'd.m.Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'm-d-Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'm/d/Y')
            list($month, $day, $year) = explode('-', $date);
        if ($format == 'm.d.Y')
            list($month, $day, $year) = explode('-', $date);
        $date = $year . "-" . $day . "-" . $month;


        return strtotime($date);
    }

    function timezone_list() {
        static $timezones = null;

        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new DateTime('now', new DateTimeZone('UTC'));

            foreach (DateTimeZone::listIdentifiers() as $timezone) {

                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[$timezone] = '(' . $this->format_GMT_offset($offset) . ') ' . $this->format_timezone_name($timezone);
            }

            array_multisort($offsets, $timezones);
        }
        return $timezones;
    }

    function format_GMT_offset($offset) {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    public function format_timezone_name($name) {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }

    function getMailMethod() {
        $mail_method = array();
        $mail_method['sendmail'] = 'SendMail';
        $mail_method['smtp'] = 'SMTP';
        return $mail_method;
    }

    function getNotificationModes() {
        $notification = array();
        if ($this->CI->module_lib->hasActive('OPD')) {
            $notification['opd_patient_registration'] = $this->CI->lang->line('opd_patient_registration');
        }
        if ($this->CI->module_lib->hasActive('IPD')) {
            $notification['ipd_patient_registration'] = $this->CI->lang->line('ipd_patient_registration');
        }
        if ($this->CI->module_lib->hasActive('IPD')) {
            $notification['patient_discharged'] = $this->CI->lang->line('ipd') . " " . $this->CI->lang->line('patient') . " " . $this->CI->lang->line('discharged');
        }
        if ($this->CI->module_lib->hasActive('OPD')) {
            $notification['patient_revisit'] = $this->CI->lang->line('opd') . " " . $this->CI->lang->line('patient') . " " . $this->CI->lang->line('revisit');
        }
        $notification['login_credential'] = $this->CI->lang->line('login_credential');
        if ($this->CI->module_lib->hasActive('front_office')) {
            $notification['appointment'] = $this->CI->lang->line('appointment') . " " . $this->CI->lang->line('approved');
        }
        return $notification;
    }

    function sendMailSMS($find) {

        $notifications = $this->CI->notificationsetting_model->get();


        if (!empty($notifications)) {
            foreach ($notifications as $note_key => $note_value) {
                if ($note_value->type == $find) {
                    return array('mail' => $note_value->is_mail, 'sms' => $note_value->is_sms);
                }
            }
        }
        return false;
    }

    public function setUserLog($username, $role) {
        if ($this->CI->agent->is_browser()) {
            $agent = $this->CI->agent->browser() . ' ' . $this->CI->agent->version();
        } elseif ($this->CI->agent->is_robot()) {
            $agent = $this->CI->agent->robot();
        } elseif ($this->CI->agent->is_mobile()) {
            $agent = $this->CI->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $data = array(
            'user' => $username,
            'role' => $role,
            'ipaddress' => $this->CI->input->ip_address(),
            'user_agent' => $agent . ", " . $this->CI->agent->platform(),
        );
        $this->CI->userlog_model->add($data);
    }

    function mediaType() {
        $media_type = array();
        $media_type['image/jpeg'] = "Image";
        $media_type['video'] = "Video";
        $media_type['text/plain'] = "Text";
        $media_type['application/zip'] = "Zip";
        $media_type['application/x-rar'] = "Rar";
        $media_type['application/pdf'] = "Pdf";
        $media_type['application/msword'] = "Word";
        $media_type['application/vnd.ms-excel'] = "Excel";
        $media_type['other'] = "Other";
        return $media_type;
    }

    function getFormString($str, $start, $end) {

        $string = false;
        $pattern = sprintf(
                '/%s(.+?)%s/ims', preg_quote($start, '/'), preg_quote($end, '/')
        );

        if (preg_match($pattern, $str, $matches)) {
            list(, $match) = $matches;
            $string = trim($match);
        }
        return $string;
    }

    function uniqueFileName($prefix = "", $name = "") {
        if (!empty($_FILES)) {
            $newFileName = uniqid($prefix, true) . '.' . strtolower(pathinfo($name, PATHINFO_EXTENSION));
            return $newFileName;
        }
        return false;
    }

    function getUserData() {
        $result = $this->getLoggedInUserData();
        $id = $result["id"];
        $data = $this->CI->staff_model->get($id);
        return $data;
    }

    function countincompleteTask($id) {

        $result = $this->CI->calendar_model->countincompleteTask($id);
        return $result;
    }

    function getincompleteTask($id) {

        $result = $this->CI->calendar_model->getincompleteTask($id);
        return $result;
    }

    public function getLogoImage() {
        $result = $this->CI->setting_model->getLogoImage();
        return $result;
    }

    public function getTitleName() {
        $result = $this->CI->setting_model->getTitleName();
        return $result;
    }

    public function getLanguage() {
        $result = $this->CI->setting_model->getLanguage();
        return $result;
    }

//========================
//========================
}
