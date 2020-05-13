<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Chat extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function unauthorized() {
        $data = array();
        $this->load->view('layout/header', $data);
        $this->load->view('unauthorized', $data);
        $this->load->view('layout/footer', $data);
    }

    public function index() {
        $data = array();
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'audit/index');

        $this->load->view('layout/header');
        $this->load->view('admin/chat/chat', $data);
        $this->load->view('layout/footer');
    }

    //   public function index()
    // {
    //     $this->session->set_userdata('top_menu', 'Reports');
    //     $this->session->set_userdata('sub_menu', 'audit/index');
    //     $userdata                     = $this->customlib->getUserData();
    //     $data['receiver_id']          = 0;
    //     $data['sender_id']            = $userdata['id'];
    //     $data['title']                = 'Audit Trail Report';
    //     $data['title_list']           = 'Audit Trail List';
    //     $data['conversation']         = $this->Chat_model->conversation($userdata['id']);
    //     $data['conversation_staff']   = $this->Chat_model->conversation_staff($userdata['id']);
    //     $data['conversation_parent']  = $this->Chat_model->conversation_parent($userdata['id']);
    //     $data['conversation_student'] = $this->Chat_model->conversation_student($userdata['id']);
    //     if (!empty($data['conversation'])) {
    //         $data['onload_conversation'] = $data['conversation'][0]['receiver_id'];
    //         $data['type']                = $data['conversation'][0]['receiver_type'];
    //         $data['start']               = "1";
    //     } else {
    //         $data['start'] = "0";
    //     }
    //     $data['load'] = "1";
    //     $this->load->view('layout/header');
    //     $this->load->view('admin/chat/chat', $data);
    //     $this->load->view('layout/footer');
    // }

    public function dashbord() {

        $data['start'] = "0";
        $this->load->view('layout/header');
        $this->load->view('admin/chat/dashbord', $data);
        $this->load->view('layout/footer');
    }

    public function load_page() {

        $sender_id = $_REQUEST['sender_id'];
        $receiver_id = $_REQUEST['receiver_id'];
        $type = $_REQUEST['type'];
        $data['sender_id'] = $sender_id;
        $data['conversation'] = $type;
        $data['conversation_staff'] = $this->Chat_model->conversation_staff($sender_id);
        $data['conversation_parent'] = $this->Chat_model->conversation_parent($sender_id);
        $data['conversation_student'] = $this->Chat_model->conversation_student($sender_id);
        $data['onload_conversation'] = $receiver_id;

        $listaudit = $this->audit_model->get();
        $data['resultlist'] = $listaudit;
        $result = $this->Chat_model->get_chat($_POST['sender_id'], $_POST['receiver_id']);
        //echo $this->db->last_query();die;
        $data['result'] = $result;
        $data['receiver_id'] = $_POST['receiver_id'];
        $data['type'] = $type;

        $data['recever_name'] = $this->Chat_model->receiver_name($_POST['receiver_id'], $type);

        $this->load->view('admin/chat/chats', $data);
    }

    public function chatdemo() {

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'audit/index');
        $data['title'] = 'Audit Trail Report';
        $data['title_list'] = 'Audit Trail List';
        $listaudit = $this->audit_model->get();
        $data['resultlist'] = $listaudit;
        $this->load->view('layout/header');
        $this->load->view('admin/chat/chatdemo', $data);
        $this->load->view('layout/footer');
    }

    public function reply() {

        $data['sender_id'] = $_POST['sender_id'];
        $data['receiver_id'] = $_POST['receiver_id'];
        $data['sender_type'] = 1;
        $data['receiver_type'] = $_POST['type'];
        $data['message'] = $_POST['message'];
        $inserted_id = $this->Chat_model->add($data);
        $result = $this->Chat_model->get_chat($_POST['sender_id'], $_POST['receiver_id']);

        $data['result'] = $result;
        $data['recever_name'] = $this->Chat_model->receiver_name($_POST['receiver_id'], $_POST['type']);
        $data['conversation'] = $this->Chat_model->conversation($_POST['sender_id']);
        $status = count($data['conversation']);

        if ($status == 1) {

            echo "0";
        } else {

            echo "1";
        }
        // die;
    }

    public function load_message() {

        $result = $this->Chat_model->get_chat($_POST['sender_id'], $_POST['receiver_id']);

        $data['sender_id'] = $_POST['sender_id'];
        $data['result'] = $result;
        $data['receiver_id'] = $_POST['receiver_id'];
        $data['type'] = 'staff';
        $data['recever_name'] = $this->Chat_model->receiver_name($_POST['receiver_id'], '1');
    }

    public function user_list() {

        $name = "";
        if (isset($_REQUEST['user_name']) && $_REQUEST['user_name'] != '') {

            $name .= $_REQUEST['user_name'];
        }

        $staff = $this->Chat_model->get_staff($name);
        $student = $this->Chat_model->get_student($name);
        $parent = $this->Chat_model->get_parent($name);
        $userdata = $this->customlib->getUserData();

        $data['sender_id'] = $userdata['id'];
        $data['staff'] = $staff;
        $data['student'] = $student;
        $data['parent'] = $parent;
        if (isset($_REQUEST['start']) && $_REQUEST['start'] != '') {

            $data['start_status'] = $_REQUEST['start'];
        }

        $data['start_status'] = '1';

        $this->load->view('admin/chat/_usertlist', $data);
    }

    public function delete_message($id, $sender_id) {

        $this->db->where('id', $id)->delete('chat');
        $data['conversation'] = $this->Chat_model->conversation($sender_id);

        if (empty($data['conversation'])) {

            echo "0";
        } else {

            echo "1";
        }
    }

    public function chat_seen() {

        $sender_id = $_REQUEST['sender_id'];
        $receiver_id = $_REQUEST['receiver_id'];
        $receiver_type = $_REQUEST['type'];
        $sender_type = 1;
        $data['seen'] = '1';
        $this->Chat_model->seen($sender_id, $receiver_id, $sender_type, $receiver_type, $data);
    }

//=====================rahul====================
    public function searchuser() {
        $keyword = $this->input->post('keyword');
        $staff_id = $this->customlib->getStaffID();

        $chat_user = $this->chatuser_model->getMyID($staff_id, 'staff');


        $chat_user_id = 0;
        if (!empty($chat_user)) {
            $chat_user_id = $chat_user->id;
        }
        $data['chat_user'] = $this->chatuser_model->searchForUser($keyword, $chat_user_id, 'staff', $staff_id);



        $userlist = $this->load->view('admin/chat/_partialSearchUser', $data, true);
        $array = array('status' => '1', 'error' => '', 'page' => $userlist);

        echo json_encode($array);
    }

    public function myuser() {
        $data = array();
        $staff_id = $this->customlib->getStaffID();
        $chat_user = $this->chatuser_model->getMyID($staff_id, 'staff');

        $data['chat_user'] = array();
        $data['userList'] = array();

        if (!empty($chat_user)) {
            $data['chat_user'] = $chat_user;
            $data['userList'] = $this->chatuser_model->myUser($staff_id, $chat_user->id);
        }




        $userlist = $this->load->view('admin/chat/_partialmyuser', $data, true);
        $array = array('status' => '1', 'error' => '', 'page' => $userlist);
        echo json_encode($array);
    }

    public function getChatRecord() {
        $chat_user = $this->chatuser_model->getMyID($this->customlib->getStaffID(), 'staff');
        $data['chat_user'] = $chat_user;
        $chat_connection_id = $this->input->post('chat_connection_id');
        $chat_to_user = 0;
        $user_last_chat = $this->chatuser_model->getLastMessages($chat_connection_id);

        $chat_connection = $this->chatuser_model->getChatConnectionByID($chat_connection_id);
        if (!empty($chat_connection)) {
            $chat_to_user = $chat_connection->chat_user_one;
            $chat_connection_id = $chat_connection->id;
            if ($chat_connection->chat_user_one == $chat_user->id) {
                $chat_to_user = $chat_connection->chat_user_two;
            }
        }

        $data['chatList'] = $this->chatuser_model->myChatAndUpdate($chat_connection_id, $chat_user->id);
        $userlist = $this->load->view('admin/chat/_partialChatRecord', $data, true);
        $array = array('status' => '1', 'error' => '', 'page' => $userlist, 'chat_to_user' => $chat_to_user, 'chat_connection_id' => $chat_connection_id, 'user_last_chat' => $user_last_chat);
        echo json_encode($array);
    }

    public function newMessage() {

        $chat_connection_id = $this->input->post('chat_connection_id');
        $chat_to_user = $this->input->post('chat_to_user');
        $message = $this->input->post('message');
        $time = $this->input->post('time');
        $insert_record = array(
            'chat_user_id' => $chat_to_user,
            'message' => trim($message),
            'chat_connection_id' => $chat_connection_id,
            'created_at' => $this->customlib->chatDateTimeformat($time),
        );

        $last_insert_id = $this->chatuser_model->addMessage($insert_record);

        $array = array('status' => '1', 'last_insert_id' => $last_insert_id, 'error' => '', 'message' => 'inserted --r');
        echo json_encode($array);
    }

    public function chatUpdate() {
        $chat_connection_id = $this->input->post('chat_connection_id');
        $chat_user_id = $this->input->post('chat_to_user');
        $last_chat_id = $this->input->post('last_chat_id');
        $user_last_chat = $this->chatuser_model->getLastMessages($chat_connection_id);
        $data['chat_user_id'] = $chat_user_id;
        $chat_user = $this->chatuser_model->getMyID($this->customlib->getStaffID(), 'staff');

        $data['updated_chat'] = $this->chatuser_model->getUpdatedchat($chat_connection_id, $last_chat_id, $chat_user->id);

        $userlist = $this->load->view('admin/chat/_chatupdate', $data, true);
        $array = array('status' => '1', 'error' => '', 'page' => $userlist, 'user_last_chat' => $user_last_chat);
        echo json_encode($array);
    }

    public function adduser() {

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('user_id', 'Contact Person --r', 'required|trim|xss_clean');
        $this->form_validation->set_rules('user_type', 'User Type', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $errors = array(
                'user_id' => form_error('user_id'),
            );
            $array = array('status' => 0, 'error' => $errors, 'msg' => 'Something went wrong');
            echo json_encode($array);
        } else {
            $user_type = $this->input->post('user_type');
            $user_id = $this->input->post('user_id');
            $staff_id = $this->customlib->getStaffID();
            $first_entry = array(
                'user_type' => "staff",
                'staff_id' => $staff_id
            );
            $insert_data = array('user_type' => strtolower($user_type), 'create_staff_id' => NULL);

            if ($user_type == "Student") {
                $insert_data['student_id'] = $user_id;
            } elseif ($user_type == "Staff") {
                $insert_data['staff_id'] = $user_id;
            }
            $insert_message = array(
                'message' => 'you are now connected on chat',
                'chat_user_id' => 0,
                'is_first' => 1,
                'chat_connection_id' => 0
            );

            //===================
            $new_user_record = $this->chatuser_model->addNewUser($first_entry, $insert_data, 'staff', $staff_id, $insert_message);
            $json_record = json_decode($new_user_record);

            //==================

            $new_user = $this->chatuser_model->getChatUserDetail($json_record->new_user_id);

            $chat_user = $this->chatuser_model->getMyID($this->customlib->getStaffID(), 'staff');
            $data['chat_user'] = $chat_user;
            $chat_connection_id = $json_record->new_user_chat_connection_id;
            $chat_to_user = 0;
            $user_last_chat = $this->chatuser_model->getLastMessages($chat_connection_id);

            $chat_connection = $this->chatuser_model->getChatConnectionByID($chat_connection_id);
            if (!empty($chat_connection)) {
                $chat_to_user = $chat_connection->chat_user_one;
                $chat_connection_id = $chat_connection->id;
                if ($chat_connection->chat_user_one == $chat_user->id) {
                    $chat_to_user = $chat_connection->chat_user_two;
                }
            }

            $data['chatList'] = $this->chatuser_model->myChatAndUpdate($chat_connection_id, $chat_user->id);
            $chat_records = $this->load->view('admin/chat/_partialChatRecord', $data, true);
            $array = array('status' => '1', 'error' => '', 'message' => $this->lang->line('success_message'), 'new_user' => $new_user, 'chat_connection_id' => $json_record->new_user_chat_connection_id, 'chat_records' => $chat_records, 'user_last_chat' => $user_last_chat);
            echo json_encode($array);
        }
    }

    function mychatnotification() {
        $chat_user = $this->chatuser_model->getMyID($this->customlib->getStaffID(), 'staff');
        $notifications = array();
        if (!empty($chat_user)) {
            $notifications = $this->chatuser_model->getChatNotification($chat_user->id);
        }
        $array = array('status' => '1', 'message' => $this->lang->line('success_message'), 'notifications' => $notifications);
        echo json_encode($array);
    }

    function mynewuser() {
        $users_list = $this->input->post('users');
        $chat_user = $this->chatuser_model->getMyID($this->customlib->getStaffID(), 'staff');
        $data['chat_user'] = $chat_user;
        $data['new_user_list'] = array();
        if (!empty($chat_user)) {
            $data['new_user_list'] = $this->chatuser_model->mynewuser($chat_user->id, $users_list);
        }

        $chat_records = $this->load->view('admin/chat/_partialmynewuser', $data, true);
        $array = array('status' => '1', 'error' => '', 'message' => $this->lang->line('success_message'), 'new_user_list' => $chat_records);
        echo json_encode($array);
    }

}
