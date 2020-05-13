<?php

/**
 * 
 */
class Systemnotifications extends Patient_Controller {

    public $school_name;
    public $school_setting;
    public $setting;
    public $payment_method;
    public $patient_data;

    public function __construct() {
        parent::__construct();
        $this->payment_method = $this->paymentsetting_model->getActiveMethod();
        $this->patient_data = $this->session->userdata('patient');
        $this->config->load("payroll");
        $this->load->library('Enc_lib');
        $this->config->load("mailsms");
        $this->appointment_status = $this->config->item('appointment_status');
        $this->marital_status = $this->config->item('marital_status');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->search_type = $this->config->item('search_type');
        $this->blood_group = $this->config->item('bloodgroup');
        $this->notificationicon = $this->config->item('notification_icon');
        $this->charge_type = $this->config->item('charge_type');
        $data["charge_type"] = $this->charge_type;
    }

    public function index() {

        $notifications = $this->notification_model->getPatientSystemNotification();
        $config['base_url'] = base_url() . "patient/systemnotifications/index";
        $config['total_rows'] = sizeof($notifications);
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
        $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
        $config['next_tag_open'] = '<li class="pg-next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="pg-prev">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $this->load->library('pagination', $config);
        $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) ) : 0;
        $notificationlist = $this->notification_model->getPatientSystemNotification($config['per_page'], $page);
        $data["notifications"] = $notificationlist;
        $data['notificationicon'] = $this->notificationicon;
        $this->pagination->initialize($config);


        $this->load->view('layout/patient/header');
        $this->load->view('patient/systemnotification', $data);
        $this->load->view('layout/patient/footer', $data);
    }

    public function updateStatus() {
        $notification_id = $this->input->post("id");

        $patient_data = $this->session->userdata('patient');
        $userid = $patient_data["patient_id"];
        $data = array('notification_id' => $notification_id,
            'receiver_id' => $userid,
            'is_active' => 'no',
            'date' => date("Y-m-d H:i:s")
        );
        $this->notification_model->updateReadNotification($data);
    }

    public function unreadNotification() {
        $result = $this->notification_model->getUnreadNotification();
        print_r($result);
    }

}

?>