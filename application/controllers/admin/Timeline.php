<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timeline extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('Customlib');
    }

    public function add() {

        $this->form_validation->set_rules('timeline_title', 'Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('timeline_date', 'Date', 'trim|required|xss_clean');
        $title = $this->input->post("timeline_title");

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'timeline_title' => form_error('timeline_title'),
                'timeline_date' => form_error('timeline_date'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $visible_check = $this->input->post('visible_check');
            $timeline_date = $this->input->post('timeline_date');
            if (empty($visible_check)) {
                $visible = '';
            } else {

                $visible = $visible_check;
            }
            $timeline = array(
                'title' => $this->input->post('timeline_title'),
                'description' => $this->input->post('timeline_desc'),
                'timeline_date' => date("Y-m-d", strtotime($timeline_date)),
                'status' => $visible,
                'date' => date('Y-m-d'),
                'student_id' => $this->input->post('student_id'));

            $id = $this->timeline_model->add($timeline);

            if (isset($_FILES["timeline_doc"]) && !empty($_FILES['timeline_doc']['name'])) {
                $uploaddir = './uploads/patient_timeline/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["timeline_doc"]["name"]);
                $document = basename($_FILES['timeline_doc']['name']);

                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["timeline_doc"]["tmp_name"], $uploaddir . $img_name);
            } else {

                $document = "";
                $img_name = "";
            }

            $upload_data = array('id' => $id, 'document' => $img_name);
            $this->timeline_model->add($upload_data);
            $msg = "Timeline Added Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $msg);
        }
        echo json_encode($array);
    }

    public function add_staff_timeline() {

        $this->form_validation->set_rules('timeline_title', $this->lang->line('title'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('timeline_date', $this->lang->line('date'), 'trim|required|xss_clean');
        $title = $this->input->post("timeline_title");

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'timeline_title' => form_error('timeline_title'),
                'timeline_date' => form_error('timeline_date'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $visible_check = $this->input->post('visible_check');
            $timeline_date = $this->input->post('timeline_date');
            if (empty($visible_check)) {
                $visible = '';
            } else {

                $visible = $visible_check;
            }
            $timeline = array(
                'title' => $this->input->post('timeline_title'),
                'timeline_date' => date("Y-m-d", strtotime($timeline_date)),
                'description' => $this->input->post('timeline_desc'),
                'status' => $visible,
                'date' => date('Y-m-d'),
                'staff_id' => $this->input->post('staff_id'));

            $id = $this->timeline_model->add_staff_timeline($timeline);

            if (isset($_FILES["timeline_doc"]) && !empty($_FILES['timeline_doc']['name'])) {
                $uploaddir = './uploads/staff_timeline/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["timeline_doc"]["name"]);
                $document = basename($_FILES['timeline_doc']['name']);

                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["timeline_doc"]["tmp_name"], $uploaddir . $img_name);
            } else {

                $document = "";
                $img_name = "";
            }

            $upload_data = array('id' => $id, 'document' => $img_name);
            $this->timeline_model->add_staff_timeline($upload_data);
            $msg = "Timeline Added Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $msg);
        }
        echo json_encode($array);
    }

    public function edit_staff_timeline() {

        $this->form_validation->set_rules('timeline_title', $this->lang->line('title'), 'trim|required|xss_clean');

        $title = $this->input->post("timeline_title");

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'timeline_title' => form_error('timeline_title'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $visible_check = $this->input->post('visible_check');
            $staffid = $this->input->post('staff_id');
            $timelineid = $this->input->post('timeline_id');
            $timeline_date = $this->input->post('timeline_date');
            $date = date("Y-m-d", $this->customlib->datetostrtotime($timeline_date));
            if (empty($visible_check)) {
                $visible = '';
            } else {

                $visible = $visible_check;
            }
            $timeline = array(
                'id' => $timelineid,
                'title' => $this->input->post('timeline_title'),
                'timeline_date' => date("Y-m-d", strtotime($timeline_date)),
                'description' => $this->input->post('timeline_desc'),
                'status' => $visible,
                'date' => date('Y-m-d'),
                'staff_id' => $staffid);

            $this->timeline_model->add_staff_timeline($timeline);

            if (isset($_FILES["timeline_doc"]) && !empty($_FILES['timeline_doc']['name'])) {
                $uploaddir = './uploads/staff_timeline/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["timeline_doc"]["name"]);
                $document = basename($_FILES['timeline_doc']['name']);

                $img_name = $timelineid . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["timeline_doc"]["tmp_name"], $uploaddir . $img_name);

                $upload_data = array('id' => $timelineid, 'document' => $img_name);
                $this->timeline_model->add_staff_timeline($upload_data);
            }


            $msg = "Timeline Added Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $msg);
        }
        echo json_encode($array);
    }

    public function add_patient_timeline() {

        $this->form_validation->set_rules('timeline_title', $this->lang->line('title'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('timeline_date', $this->lang->line('date'), 'trim|required|xss_clean');
        $title = $this->input->post("timeline_title");

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'timeline_title' => form_error('timeline_title'),
                'timeline_date' => form_error('timeline_date'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $visible_check = $this->input->post('visible_check');
            $timeline_date = $this->input->post('timeline_date');
            if (empty($visible_check)) {
                $visible = '';
            } else {

                $visible = $visible_check;
            }
            $timeline = array(
                'title' => $this->input->post('timeline_title'),
                'timeline_date' => date("Y-m-d", $this->customlib->datetostrtotime($timeline_date)),
                'description' => $this->input->post('timeline_desc'),
                'status' => $visible,
                'date' => date('Y-m-d'),
                'patient_id' => $this->input->post('patient_id'));

            $id = $this->timeline_model->add_patient_timeline($timeline);

            if (isset($_FILES["timeline_doc"]) && !empty($_FILES['timeline_doc']['name'])) {
                $uploaddir = './uploads/patient_timeline/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["timeline_doc"]["name"]);
                $document = basename($_FILES['timeline_doc']['name']);

                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["timeline_doc"]["tmp_name"], $uploaddir . $img_name);
            } else {

                $document = "";
                $img_name = "";
            }

            $upload_data = array('id' => $id, 'document' => $img_name);
            $this->timeline_model->add_patient_timeline($upload_data);
            $msg = "Timeline Added Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $msg);
        }
        echo json_encode($array);
    }

    public function edit_patient_timeline() {

        $this->form_validation->set_rules('timeline_title', $this->lang->line('title'), 'trim|required|xss_clean');

        $title = $this->input->post("timeline_title");

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'timeline_title' => form_error('timeline_title'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $visible_check = $this->input->post('visible_check');
            $patientid = $this->input->post('patient_id');
            $timelineid = $this->input->post('timeline_id');
            $timeline_date = $this->input->post('timeline_date');
            $date = date("Y-m-d", $this->customlib->datetostrtotime($timeline_date));
            if (empty($visible_check)) {
                $visible = '';
            } else {

                $visible = $visible_check;
            }
            $timeline = array(
                'id' => $timelineid,
                'title' => $this->input->post('timeline_title'),
                'timeline_date' => $date,
                'description' => $this->input->post('timeline_desc'),
                'status' => $visible,
                'date' => date('Y-m-d'),
                'patient_id' => $patientid);

            $this->timeline_model->add_patient_timeline($timeline);

            if (isset($_FILES["timeline_doc"]) && !empty($_FILES['timeline_doc']['name'])) {
                $uploaddir = './uploads/patient_timeline/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }
                $fileInfo = pathinfo($_FILES["timeline_doc"]["name"]);
                $document = basename($_FILES['timeline_doc']['name']);

                $img_name = $timelineid . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["timeline_doc"]["tmp_name"], $uploaddir . $img_name);

                $upload_data = array('id' => $timelineid, 'document' => $img_name);
                $this->timeline_model->add_patient_timeline($upload_data);
            }


            $msg = "Timeline Added Successfully";
            $array = array('status' => 'success', 'error' => '', 'message' => $msg);
        }
        echo json_encode($array);
    }

    public function download($timeline_id, $doc) {
        $this->load->helper('download');
        $filepath = "./uploads/patient_timeline/" . $doc;
        $data = file_get_contents($filepath);
        $name = $doc;
        force_download($name, $data);
    }

    public function download_staff_timeline($timeline_id, $doc) {
        $this->load->helper('download');
        $filepath = "./uploads/staff_timeline/" . $doc;
        $data = file_get_contents($filepath);
        $name = $doc;
        force_download($name, $data);
    }

    public function download_patient_timeline($timeline_id, $doc) {
        $this->load->helper('download');
        $filepath = "./uploads/patient_timeline/" . $doc;
        $data = file_get_contents($filepath);
        $name = $doc;
        force_download($name, $data);
    }

    public function delete_timeline($id) {

        if (!empty($id)) {

            $this->timeline_model->delete_timeline($id);
        }
    }

    public function delete_staff_timeline($id) {

        if (!empty($id)) {

            $this->timeline_model->delete_staff_timeline($id);
        }
    }

    public function delete_patient_timeline($id) {

        if (!empty($id)) {

            $this->timeline_model->delete_patient_timeline($id);
        }
    }

    public function student_timeline($id = 77) {

        $result = $this->timeline_model->getStudentTimeline($id);

        $data["result"] = $result;

        $this->load->view("admin/student_timeline", $data);
    }

    public function staff_timeline($id = 77) {

        $userdata = $this->customlib->getUserData();
        $userid = $userdata['id'];
        $status = '';
        if ($userid == $id) {
            $status = 'yes';
        }

        $result = $this->timeline_model->getStaffTimeline($id, $status);

        $data["result"] = $result;

        $this->load->view("admin/staff_timeline", $data);
    }

    public function patient_timeline($id = 77) {

        $userdata = $this->customlib->getUserData();
        $userid = $userdata['id'];
        $status = '';
        if ($userid == $id) {
            $status = 'yes';
        }

        $result = $this->timeline_model->getPatientTimeline($id, $status);

        $data["result"] = $result;

        $this->load->view("admin/patient_timeline", $data);
    }

}

?>