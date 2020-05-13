<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends Front_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->config('form-builder');
        $this->load->library(array('mailer', 'form_builder'));
        $this->config->load("mailsms");
        //$this->complaint_model = $this->config->item('complaint_model');
        $this->notification = $this->config->item('notification');
        $this->notificationurl = $this->config->item('notification_url');
        $this->patient_notificationurl = $this->config->item('patient_notification_url');
        $this->load->library('Ajax_pagination');
        $this->banner_content = $this->config->item('ci_front_banner_content');
        $this->perPage = 12;
        $ban_notice_type = $this->config->item('ci_front_notice_content');
        $this->data['banner_notices'] = $this->cms_program_model->getByCategory($ban_notice_type, array('start' => 0, 'limit' => 5));
    }

    public function show_404()
    {
        $this->load->view('errors/error_message');
    }

    public function index()
    {

        $setting                     = $this->frontcms_setting_model->get();
        $this->data['active_menu']   = 'home';
        $this->data['page_side_bar'] = $setting->is_active_sidebar;
        $home_page                   = $this->config->item('ci_front_home_page_slug');
        $result                      = $this->cms_program_model->getByCategory($this->banner_content);
        $this->data['page']          = $this->cms_page_model->getBySlug($home_page);
        if (!empty($result)) {
            $this->data['banner_images'] = $this->cms_program_model->front_cms_program_photos($result[0]['id']);
        }

        $this->load_theme('home');
    }

    public function appointment()
    {
        $setting                     = $this->frontcms_setting_model->get();
        $this->data['active_menu']   = 'Appointment';
        $this->data['page_side_bar'] = $setting->is_active_sidebar;
        $this->data['gender']        = $this->customlib->getGender();
        $this->data['page']          = array('title' => '', 'meta_title' => '', 'meta_keyword' => '', 'meta_description' => '');
        $doctors                     = $this->staff_model->getEmployeeByRoleID(3);
        $this->data["doctors"]       = $doctors;

        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('patient_type', 'Type', 'required');
        $this->form_validation->set_rules('patient_name', 'Name', 'required');
        $this->form_validation->set_rules('doctor', 'Doctor', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        if ($this->input->post('patient_type') == "old patient") {

            $this->form_validation->set_rules('patient_id', 'Patient ID', 'required');
        }

        if ($this->form_validation->run() == false) {

            $this->load_theme_form('form/appointment');
        } else {
            $patient_id   = $this->input->post('patient_id');
            $patient_name = $this->input->post('patient_name');
            // $patientid = $this->input->post('pid');

            $appointment = array(
                'date'               => date("Y-m-d H:i:s", strtotime($this->input->post('date'))),

                'patient_name'       => $patient_name,
                'gender'             => $this->input->post('gender'),
                'email'              => $this->input->post('email'),
                'mobileno'           => $this->input->post('phone'),
                'doctor'             => $this->input->post('doctor'),
                'message'            => $this->input->post('message'),
                'source'             => 'Online',
                'appointment_status' => 'pending',
            );

            if ($this->input->post('patient_type') == "old patient") {
                $appointment['patient_id'] = $this->input->post('customer_id');
            }
            $insert_id = $this->appointment_model->add($appointment);

            $this->notificationurl = $this->config->item('notification_url');
            $notificationurl       = $this->notificationurl;
            $url_link              = $notificationurl["appointment"];
            $url                   = base_url() . $url_link . '/' . $insert_id;

            if ($insert_id) {
                $this->appointmentCreateNotification($this->input->post('customer_id'), $patient_name, $url);
            }
            $this->session->set_flashdata('msg', array('message' => 'We will contact you soon', 'class' => 'alert alert-success'));
            redirect('welcome/appointment');
        }
    }

    public function appointmentCreateNotification($patient_id = '', $patient_name = '', $url)
    {

        $notification      = $this->notification;
        $notification_desc = $notification["appointment_created"];
        $patient_url       = $this->patient_notificationurl['appointment'];
        $patient_desc      = str_replace(array('<patient>', '<url>'), array($patient_name, base_url() . $patient_url), $notification_desc);
        $desc              = str_replace(array('<patient>', '<url>'), array($patient_name, $url), $notification_desc);

        if (!empty($patient_id)) {
            $notification_data = array('notification_title' => 'Appointment Created',
                'notification_desc'                             => $patient_desc,
                'notification_for'                              => 'Patient',
                'notification_type'                             => 'appointment',
                'receiver_id'                                   => $patient_id,
                'date'                                          => date("Y-m-d H:i:s"),
                'is_active'                                     => 'yes',
            );
            $admin_notification_data = array('notification_title' => 'Appointment Created',
                'notification_desc'                                   => $desc,
                'notification_for'                                    => 'Super Admin',
                'notification_type'                                   => 'appointment',
                'receiver_id'                                         => '',
                'date'                                                => date("Y-m-d H:i:s"),
                'is_active'                                           => 'yes',
            );
        } else if (!empty($patient_name)) {
            $notification_data = array('notification_title' => 'Appointment Created',
                'notification_desc'                             => $patient_desc,
                'notification_for'                              => 'Patient',
                'notification_type'                             => 'appointment',
                'receiver_id'                                   => $patient_name,
                'date'                                          => date("Y-m-d H:i:s"),
                'is_active'                                     => 'yes',
            );
            $admin_notification_data = array('notification_title' => 'Appointment Created',
                'notification_desc'                                   => $desc,
                'notification_for'                                    => 'Super Admin',
                'notification_type'                                   => 'appointment',
                'receiver_id'                                         => '',
                'date'                                                => date("Y-m-d H:i:s"),
                'is_active'                                           => 'yes',
            );
        }
        $this->notification_model->addSystemNotification($notification_data);
        $this->notification_model->addSystemNotification($admin_notification_data);
    }

    public function page($slug)
    {
        $page = $this->cms_page_model->getBySlug($slug);
        if (!$page) {
            $this->data['page'] = $this->cms_page_model->getBySlug('404-page');
        } else {

            $this->data['page'] = $this->cms_page_model->getBySlug($slug);
        }

        if ($page['is_homepage']) {
            redirect('frontend');
        }
        $this->data['active_menu']       = $slug;
        $this->data['page_side_bar']     = $this->data['page']['sidebar'];
        $this->data['page_content_type'] = "";
        if (!empty($this->data['page']['category_content'])) {
            $content_array = $this->data['page']['category_content'];
            reset($content_array);
            $first_key            = key($content_array);
            $totalRec             = count($this->cms_program_model->getByCategory($content_array[$first_key]));
            $config['target']     = '#postList';
            $config['base_url']   = base_url() . 'welcome/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page']   = $this->perPage;
            $config['link_func']  = 'searchFilter';
            $this->ajax_pagination->initialize($config);
            //get the posts data
            $this->data['page']['category_content'][$first_key] = $this->cms_program_model->getByCategory($content_array[$first_key], array('limit' => $this->perPage));

            //   print_r($this->data['page']['category_content'][$first_key]);
            // exit;
            $this->data['page_content_type'] = $content_array[$first_key];

            //load the view
        }
        $this->data['page_form'] = false;

        if (strpos($page['description'], '[form-builder:') !== false) {
            $this->data['page_form'] = true;
            $start                   = '[form-builder:';
            $end                     = ']';

            $form_name = $this->customlib->getFormString($page['description'], $start, $end);

            $form = $this->config->item($form_name);

            $this->data['form_name'] = $form_name;
            $this->data['form']      = $form;

            if (!empty($form)) {
                foreach ($form as $form_key => $form_value) {
                    if (isset($form_value['validation'])) {
                        $display_string = ucfirst(preg_replace('/[^A-Za-z0-9\-]/', ' ', $form_value['id']));
                        $this->form_validation->set_rules($form_value['id'], $display_string, $form_value['validation']);
                    }
                }
                if ($this->form_validation->run() == false) {

                } else {
                    $setting = $this->frontcms_setting_model->get();

                    $response_message = $form['email_title']['mail_response'];
                    $record           = $this->input->post();

                    if ($record['form_name'] == 'contact_us') {
                        $cont_data = array(
                            'name'    => $this->input->post('name'),
                            'source'  => 'Online',
                            'email'   => $this->input->post('email'),
                            'purpose' => $this->input->post('subject'),
                            'date'    => date('Y-m-d'),
                            'note'    => $this->input->post('description'),
                        );
                        $visitor_id = $this->visitors_model->add($cont_data);
                    }

                    if ($record['form_name'] == 'complain') {
                        $complaint_data = array(
                            'complaint_type' => 'General',
                            'source'         => 'Online',
                            'name'           => $this->input->post('name'),
                            'email'          => $this->input->post('email'),
                            'contact'        => $this->input->post('contact_no'),
                            'date'           => date('Y-m-d'),
                            'description'    => $this->input->post('description'),
                        );
                       
                        $complaint_id = $this->complaint_model->add($complaint_data);
                    }

                    $email_subject = $record['email_title'];
                    $mail_body     = "";
                    unset($record['email_title']);
                    unset($record['submit']);
                    foreach ($record as $fetch_k_record => $fetch_v_record) {
                        $mail_body .= ucwords($fetch_k_record) . ": " . $fetch_v_record;
                        $mail_body .= "<br/>";
                    }
                    if (!empty($setting) && $setting->contact_us_email != "") {

                        $this->mailer->send_mail($setting->contact_us_email, $email_subject, $mail_body);
                    }

                    $this->session->set_flashdata('msg', $response_message);
                    redirect('page/' . $slug, 'refresh');
                }
            }
        }

        $this->load_theme('pages/page');
    }

    public function ajaxPaginationData()
    {
        $page              = $this->input->post('page');
        $page_content_type = $this->input->post('page_content_type');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $data['page_content_type'] = $page_content_type;
        //total rows count
        $totalRec = count($this->cms_program_model->getByCategory($page_content_type));
        //pagination configuration
        $config['target']     = '#postList';
        $config['base_url']   = base_url() . 'welcome/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $config['link_func']  = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //get the posts data
        $data['category_content'] = $this->cms_program_model->getByCategory($page_content_type, array('start' => $offset, 'limit' => $this->perPage));
        //load the view
        $this->load->view('themes/default/pages/ajax-pagination-data', $data, false);
    }

    public function read($slug)
    {
        $this->data['active_menu']    = 'home';
        $page                         = $this->cms_program_model->getBySlug($slug);
        $this->data['page_side_bar']  = $page['sidebar'];
        $this->data['featured_image'] = $page['feature_image'];
        $this->data['page']           = $page;
        $this->load_theme('pages/read');
    }

}
