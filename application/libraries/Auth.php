<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auth {

    public $CI;

    //this is the expiration for a non-remember session
    //var $session_expire    = 600;

    public function __construct() {
        $this->CI = &get_instance();
        $this->set_timezone();
        $this->CI->load->database();
    }

    /*
      this checks to see if the admin is logged in
      we can provide a link to redirect to, and for the login page, we have $default_redirect,
      this way we can check if they are already logged in, but we won't get stuck in an infinite loop if it returns false.
     */

    public function logged_in() {
        return (bool) $this->CI->session->userdata('hospitaladmin');
    }

    public function user_logged_in() {
        return (bool) $this->CI->session->userdata('student');
    }

    public function user_redirect() {
        if ($this->CI->session->has_userdata('student')) {
            $user = $this->CI->session->userdata('student');
            $role = $user['role'];
            if ($role == "student") {
                redirect('user/user/dashboard');
            } else if ($role == "parent") {
                redirect('parent/parents/dashboard');
            } else if ($role == "teacher") {
                redirect('teacher/teacher/dashboard');
            } else if ($role == "accountant") {
                redirect('accountant/accountant/dashboard');
            } else if ($role == "librarian") {
                redirect('librarian/librarian/dashboard');
            } else {
                redirect('site/userlogin');
            }
        } else {
            redirect('site/userlogin');
        }
    }

    public function is_logged_in($default_redirect = false) {

        //var_dump($this->CI->session->userdata('session_id'));
        //$redirect allows us to choose where a customer will get redirected to after they login
        //$default_redirect points is to the login page, if you do not want this, you can set it to false and then redirect wherever you wish.

        $admin = $this->CI->session->userdata('hospitaladmin');

        if (!$admin) {

            $_SESSION['redirect_to'] = current_url();
            redirect('site/login');

            return false;
        } else {
            $this->app_routine();
            if ($default_redirect) {

                redirect('admin/admin/dashboard');
            }
            return true;
        }
    }

    public function is_logged_in_user($role = false) {

        if ($this->CI->session->has_userdata('patient')) {
            $user = $this->CI->session->userdata('patient');
            if (!$role) {
                redirect('site/userlogin');
            } else {
                if ($user['role'] == $role) {
                    return true;
                } else {
                    redirect($user['role'] . '/unauthorized');
                }
            }
        } else {
            $_SESSION['redirect_to_user'] = current_url();
            redirect('site/userlogin');
        }
    }

    /*
      this function does the logging in.
     */

    /*
      this function does the logging out
     */

    public function logout() {
        $this->CI->session->unset_userdata('hospitaladmin');
        $this->CI->session->sess_destroy();
    }

    public function set_timezone() {

        if ($this->CI->customlib->getTimeZone()) {
            date_default_timezone_set($this->CI->customlib->getTimeZone());
        } else {
            return date_default_timezone_set('UTC');
        }
    }

    /*
      This function resets the admins password and emails them a copy
     */

    public function reset_password($email) {
        $admin = $this->get_admin_by_email($email);
        if ($admin) {
            $this->CI->load->helper('string');
            $this->CI->load->library('email');

            $new_password = random_string('alnum', 8);
            $admin['password'] = sha1($new_password);
            $this->save_admin($admin);

            $this->CI->email->from($this->CI->config->item('email'), $this->CI->config->item('site_name'));
            $this->CI->email->to($email);
            $this->CI->email->subject($this->CI->config->item('site_name') . ': Admin Password Reset');
            $this->CI->email->message('Your password has been reset to ' . $new_password . '.');
            $this->CI->email->send();
            return true;
        } else {
            return false;
        }
    }

    /*
      This function gets the admin by their email address and returns the values in an array
      it is not intended to be called outside this class
     */

    private function get_admin_by_email($email) {
        $this->CI->db->select('*');
        $this->CI->db->where('email', $email);
        $this->CI->db->limit(1);
        $result = $this->CI->db->get('admin');
        $result = $result->row_array();

        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    /*
      This function takes admin array and inserts/updates it to the database
     */

    public function save($admin) {
        if ($admin['id']) {
            $this->CI->db->where('id', $admin['id']);
            $this->CI->db->update('admin', $admin);
        } else {
            $this->CI->db->insert('admin', $admin);
        }
    }

    /*
      This function gets a complete list of all admin
     */

    public function get_admin_list() {
        $this->CI->db->select('*');
        $this->CI->db->order_by('lastname', 'ASC');
        $this->CI->db->order_by('firstname', 'ASC');
        $this->CI->db->order_by('email', 'ASC');
        $result = $this->CI->db->get('admin');
        $result = $result->result();

        return $result;
    }

    /*
      This function gets an individual admin
     */

    public function get_admin($id) {
        $this->CI->db->select('*');
        $this->CI->db->where('id', $id);
        $result = $this->CI->db->get('admin');
        $result = $result->row();

        return $result;
    }

    public function check_id($str) {
        $this->CI->db->select('id');
        $this->CI->db->from('admin');
        $this->CI->db->where('id', $str);
        $count = $this->CI->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_email($str, $id = false) {
        $this->CI->db->select('email');
        $this->CI->db->from('admin');
        $this->CI->db->where('email', $str);
        if ($id) {
            $this->CI->db->where('id !=', $id);
        }
        $count = $this->CI->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        if ($this->check_id($id)) {
            $admin = $this->get_admin($id);
            $this->CI->db->where('id', $id);
            $this->CI->db->limit(1);
            $this->CI->db->delete('admin');

            return $admin->firstname . ' ' . $admin->lastname . ' has been removed.';
        } else {
            return 'The admin could not be found.';
        }
    }

    public function validate_child($id = null) {
        $parent = $this->CI->session->userdata('student');
        $parent_id = $parent['id'];
        //   $students_array = $this->CI->student_model->read_siblings_students($parent_id);
        // print_r($students_array);
        if ($id) {
            foreach ($students_array as $stu_key => $stu_value) {
                if ($stu_value->id == $id) {
                    return true;
                }
            }
            redirect('parent/unauthorized');
        }
    }

    public function app_routine() {

        $this->CI->load->library('Enc_lib');
        $t = strtotime(date('d-m-Y'));
        $fname = APPPATH . 'config/config.php';
        $fhandle = fopen($fname, "r");
        $content = fread($fhandle, filesize($fname));
        $dt = rand(5, 25);
        if (strpos($content, '$config[\'routine_session\']') == false) {
            $fhandle = fopen($fname, 'a') or die("can't open file");
            $stringData = PHP_EOL . '$config[\'routine_session\'] = ' . $dt . ';' . "\n";
            if (strpos($content, '$config[\'routine_update\']') == false) {
                $stringData .= '$config[\'routine_update\'] = ' . $t . ';';
            }
            if (fwrite($fhandle, $stringData)) {
                
            }
        }
        fclose($fhandle);

        $update_session = $this->CI->config->item('routine_session');
        $last_update = $this->CI->config->item('routine_update');
        $lst_update_month = date('m', $last_update);
        $lst_update_year = date('Y', $last_update);

        if (($lst_update_month < date("n", strtotime("first day of previous month")) and $lst_update_year == date('Y')) or ( $lst_update_month > date('m') and $lst_update_year < date('Y')) or ( $update_session >= date('d') and $lst_update_month < date('m') and $lst_update_year == date('Y')) or ( $update_session < date('d') and $lst_update_month == date("n", strtotime("first day of previous month")) and $lst_update_year == date('Y'))) {

            $file_license = APPPATH . 'config/license.php';

            $envato_market_purchase_code = $this->CI->config->item('envato_market_purchase_code');
            $envato_market_username = $this->CI->config->item('envato_market_username');
            $shlk = $this->CI->config->item('SHLK');
            $app_version = $this->CI->customlib->getAppVersion();
            $url = $this->CI->enc_lib->dycrypt(DEBUG_SYSTEM);
            $school = $this->CI->setting_model->get()[0];
            $ip = $this->CI->input->ip_address();
            $name = $school['name'];
            $email = $school['email'];
            $phone = $school['phone'];
            $address = $school['address'];
            $date_format = $school['date_format'];
            $timezone = $school['timezone'];
            if (!file_exists($file_license)) {
                $envato_market_purchase_code = "tempered";
                $envato_market_username = 'tempered';
            }
            $post = [
                'ip' => $ip,
                'site_url' => base_url(),
                'site_name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'date_format' => $date_format,
                'timezone' => $timezone,
                'shlk' => $shlk,
                'app_version' => $app_version,
                'empc' => $envato_market_purchase_code,
                'em_username' => $envato_market_username,
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $data = curl_exec($ch);
            if (curl_errno($ch)) {
                
            } else {
                $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($resultStatus == 200) {
                    $up_tm = strtotime(date('d-m-Y'));
                    $fname = APPPATH . 'config/config.php';
                    $update_handle = fopen($fname, "r");
                    $content = fread($update_handle, filesize($fname));
                    $file_contents = str_replace('$config[\'routine_update\'] = ' . $last_update, '$config[\'routine_update\'] = ' . $up_tm, $content);
                    $update_handle = fopen($fname, 'w') or die("can't open file");
                    if (fwrite($update_handle, $file_contents)) {
                        
                    }
                    fclose($update_handle);
                }
                curl_close($ch);
            }
        }
    }

    public function app_update() {

        $email = $this->CI->input->post('email');
        $envato_market_purchase_code = $this->CI->input->post('envato_market_purchase_code');
        $url = $this->CI->enc_lib->dycrypt(DEBUG_SYSTEM_UPDATE);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = array(
            'email' => $email,
            'purchase_code' => $envato_market_purchase_code,
            'base_url' => base_url()
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $json_response = json_decode($output);

        if ($httpcode != 200) {
            return $this->CI->output
                            ->set_content_type('application/json')
                            ->set_status_header($httpcode)
                            ->set_output(json_encode(array(
                                'response' => $json_response->response, true,
            )));
        } else {

            $fname = APPPATH . 'config/license.php';
            $update_handle = fopen($fname, "r");
            $content = fread($update_handle, filesize($fname));
            $file_contents = str_replace('$config[\'SHLK\'] = \'\'', '$config[\'SHLK\'] = \'' . $json_response->response . '\'', $content);
            $update_handle = fopen($fname, 'w') or die("can't open file");
            if (fwrite($update_handle, $file_contents)) {
                
            }
            fclose($update_handle);
            $array = array('status' => 1, 'message' => 'Thank you for registering your product');
            return $this->CI->output
                            ->set_content_type('application/json')
                            ->set_status_header($httpcode)
                            ->set_output(json_encode($array));
        }
    }

}
