<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendar extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->library('customlib');
        $this->load->library('pagination');
    }

    public function events() {


        if (!$this->rbac->hasPrivilege('calendar_to_do_list', 'can_view')) {
            access_denied();
        }

        $event_colors = array("#03a9f4", "#c53da9", "#757575", "#8e24aa", "#d81b60", "#7cb342", "#fb8c00", "#fb3b3b");
        $data["event_colors"] = $event_colors;
        $config['base_url'] = base_url() . 'admin/calendar/events';
        $config['total_rows'] = $this->calendar_model->countrows();
        $config['per_page'] = 10;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_link"] = "&laquo;";
        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";
        $config["last_link"] = "&raquo;";
        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '<li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '<li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $userdata = $this->customlib->getUserData();
        $data["role"] = $userdata["user_type"];

        $tasklist = $this->calendar_model->getTask(10, $this->uri->segment(4), $userdata["id"], $userdata["role_id"]);

        $data["tasklist"] = $tasklist;
        $data["title"] = "Event Calendar";
        $this->load->view("layout/header.php");
        $this->load->view("setting/eventcalendar.php", $data);
        $this->load->view("layout/footer.php");
    }

    public function addtodo() {
        if (!$this->rbac->hasPrivilege('calendar_to_do_list', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('task_title', $this->lang->line('title'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('task_date', $this->lang->line('date'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'task_title' => form_error('task_title'),
                'task_date' => form_error('task_date'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $userdata = $this->customlib->getUserData();
            $event_title = $this->input->post("task_title");
            $event_description = '';
            $event_type = 'task';
            $event_color = '#000';
            $date = $this->input->post('task_date');
            $start_date = date("Y-m-d H:i:s", strtotime($date));
            $eventid = $this->input->post("eventid");
            if (!empty($eventid)) {

                $eventdata = array('event_title' => $event_title,
                    'event_description' => $event_description,
                    'start_date' => $start_date,
                    'end_date' => $start_date,
                    'event_type' => $event_type,
                    'event_color' => $event_color,
                    'event_for' => $userdata["id"],
                    'id' => $eventid,
                );
                $msg = $this->lang->line('update_message');
            } else {
                $eventdata = array('event_title' => $event_title,
                    'event_description' => $event_description,
                    'start_date' => $start_date,
                    'end_date' => $start_date,
                    'event_type' => $event_type,
                    'event_color' => $event_color,
                    'is_active' => "no",
                    'event_for' => $userdata["id"],
                    'role_id' => $userdata["role_id"],
                );
                $msg = $this->lang->line('success_message');
            }
            $this->calendar_model->saveEvent($eventdata);
            $array = array('status' => 'success', 'error' => '', 'message' => $msg);
        }

        echo json_encode($array);
    }

    public function saveevent() {


        $this->form_validation->set_rules('title', $this->lang->line('event') . " " . $this->lang->line('title'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'title' => form_error('title'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $event_title = $this->input->post("title");
            $event_description = $this->input->post("description");
            $event_type = $this->input->post("event_type");
            $event_color = $this->input->post("eventcolor");
            if (empty($event_color)) {
                $event_color = '#337ab7';
            }

            $a = $this->input->post("event_dates");
            $b = explode('-', trim($a));

            $start_date = date("Y-m-d H:i:s", strtotime($b[0]));
            $end_date = date("Y-m-d H:i:s", strtotime($b[1]));
            $event_for = "";


            $userdata = $this->customlib->getUserData();
            if ($event_type == 'private') {

                $event_for = $userdata["id"];
            } else if ($event_type == 'sameforall') {

                $event_for = $userdata["role_id"];
            } else if ($event_type == 'public') {

                $event_for = "0";
            } else if ($event_type == 'protected') {

                $event_for = $userdata["role_id"];
            }
            $eventdata = array('event_title' => $event_title,
                'event_description' => $event_description,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'event_type' => $event_type,
                'event_color' => $event_color,
                'event_for' => $event_for
            );

            $this->calendar_model->saveEvent($eventdata);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function updateevent() {
        if (!$this->rbac->hasPrivilege('calendar_to_do_list', 'can_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'title' => form_error('title'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $event_title = $this->input->post("title");
            $event_description = $this->input->post("description");
            $event_type = $this->input->post("eventtype");
            $event_color = $this->input->post("eventcolor");
            $id = $this->input->post("eventid");

            $event_for = "";
            $userdata = $this->customlib->getUserData();
            if ($event_type == 'private') {

                $event_for = $userdata["id"];
            } else if ($event_type == 'sameforall') {

                $event_for = $userdata["role_id"];
            } else if ($event_type == 'public') {

                $event_for = "0";
            } else if ($event_type == 'protected') {

                $event_for = $userdata["role_id"];
            }
            $a = $this->input->post("eventdates");
            $b = explode('-', trim($a));

            $start_date = date("Y-m-d H:i:s", strtotime($b[0]));
            $end_date = date("Y-m-d H:i:s", strtotime($b[1]));

            $eventdata = array('id' => $id,
                'event_title' => $event_title,
                'event_description' => $event_description,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'event_type' => $event_type,
                'event_color' => $event_color,
                'event_for' => $event_for
            );

            $this->calendar_model->saveEvent($eventdata);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getevents() {


        $userdata = $this->customlib->getUserData();
        $result = $this->calendar_model->getEvents();

        if (!empty($result)) {

            foreach ($result as $key => $value) {

                $event_type = $value["event_type"];

                if ($event_type == 'private') {

                    $event_for = $userdata["id"];
                }if ($event_type == 'protected') {

                    $event_for = $userdata["id"];
                } else if ($event_type == 'sameforall') {

                    $event_for = $userdata["role_id"];
                } else if ($event_type == 'public') {

                    $event_for = "0";
                } else if ($event_type == 'task') {

                    $event_for = $userdata["id"];
                }

                if ($event_type == 'task') {

                    if (($event_for == $value["event_for"]) && ($value["role_id"] == $userdata["role_id"])) {
                        $eventdata[] = array('title' => $value["event_title"],
                            'start' => $value["start_date"],
                            'end' => $value["end_date"],
                            'description' => $value["event_description"],
                            'id' => $value["id"],
                            'backgroundColor' => $value["event_color"],
                            'borderColor' => $value["event_color"],
                            'event_type' => $value["event_type"],
                        );
                    }
                } else {
                    if ($event_for == $value["event_for"]) {
                        $eventdata[] = array('title' => $value["event_title"],
                            'start' => $value["start_date"],
                            'end' => $value["end_date"],
                            'description' => $value["event_description"],
                            'id' => $value["id"],
                            'backgroundColor' => $value["event_color"],
                            'borderColor' => $value["event_color"],
                            'event_type' => $value["event_type"],
                        );
                    }
                }
            }

            echo json_encode($eventdata);
        }
    }

    public function view_event($id) {
        if (!$this->rbac->hasPrivilege('calendar_to_do_list', 'can_view')) {
            access_denied();
        }
        $result = $this->calendar_model->getEvents($id);
        $start_date = date("m/d/Y H:i:s", strtotime($result["start_date"]));
        $end_date = date("m/d/Y H:i:s", strtotime($result["end_date"]));
        $colorid = trim($result["event_color"], "#");
        $result["colorid"] = $colorid;
        $result["startdate"] = $start_date;
        $result["enddate"] = $end_date;


        echo json_encode($result);
    }

    public function delete_event($id) {
        if (!$this->rbac->hasPrivilege('calendar_to_do_list', 'can_delete')) {
            access_denied();
        }
        if (!empty($id)) {

            $result = $this->calendar_model->deleteEvent($id);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('delte_massage'));
        } else {

            $array = array('status' => 'fail', 'error' => '', 'message' => $this->lang->line('cannot_delete_this_event'));
        }
        echo json_encode($array);
    }

    public function gettaskbyid($id) {
        if (!$this->rbac->hasPrivilege('calendar_to_do_list', 'can_edit')) {
            access_denied();
        }


        $result = $this->calendar_model->getEvents($id);

        echo json_encode($result);
    }

    public function markcomplete($id) {

        $status = $this->input->post("active");

        $eventdata = array('is_active' => $status, 'id' => $id);
        if (!empty($id)) {

            $this->calendar_model->saveEvent($eventdata);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        } else {

            $array = array('status' => 'fail', 'error' => '', 'message' => $this->lang->line('cannot_mark_complete_this_event'));
        }
        echo json_encode($array);
    }

}

?>