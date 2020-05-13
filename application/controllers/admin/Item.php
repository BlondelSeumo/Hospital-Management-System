<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->config->load("payroll");
        $this->search_type = $this->config->item('search_type');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('item', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Inventory');
        $this->session->set_userdata('sub_menu', 'Item/index');
        $data['title'] = 'Add Item';
        $data['title_list'] = 'Recent Items';


        $item_result = $this->item_model->get();

        $data['itemlist'] = $item_result;


        $itemcategory = $this->itemcategory_model->get();
        $data['itemcatlist'] = $itemcategory;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/item/itemList', $data);
        $this->load->view('layout/footer', $data);
    }

    function add() {


        if (!$this->rbac->hasPrivilege('item', 'can_view')) {
            access_denied();
        }

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('unit', $this->lang->line('unit'), 'trim|required|xss_clean');


        $this->form_validation->set_rules(
                'item_category_id', $this->lang->line('item') . " " . $this->lang->line('category'), array(
            'required',
            array('check_exists', array($this->item_model, 'valid_check_exists'))
                )
        );

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('name'),
                'unit' => form_error('unit'),
                'item_category_id' => form_error('item_category_id'),
            );

            $array = array('status' => 'fail', 'error' => $msg);
        } else {

            $data = array(
                'item_category_id' => $this->input->post('item_category_id'),
                'name' => $this->input->post('name'),
                'unit' => $this->input->post('unit'),
                'description' => $this->input->post('description'),
            );

            $insert_id = $this->item_model->add($data);


            $array = array('status' => 'success', 'error' => '', 'message' => 'New Item Successfully Inserted');
        }

        echo json_encode($array);
    }

    public function download($file) {
        $this->load->helper('download');
        $filepath = "./uploads/inventory_items/" . $this->uri->segment(6);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment();
        force_download($name, $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('item', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->item_model->remove($id);
        redirect('admin/item/index');
    }

    function getAvailQuantity() {
        $item_id = $this->input->get('item_id');
        $data = $this->item_model->getItemAvailable($item_id);
        $available = ($data['added_stock'] - $data['issued']);

        echo json_encode(array('available' => $available));
    }

    function handle_upload() {
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
            $allowedExts = array('jpg', 'jpeg', 'png');
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            if ($_FILES["file"]["error"] > 0) {
                $error .= "Error opening the file<br />";
            }
            if ($_FILES["file"]["type"] != 'image/gif' &&
                    $_FILES["file"]["type"] != 'image/jpeg' &&
                    $_FILES["file"]["type"] != 'image/png') {

                $this->form_validation->set_message('handle_upload', 'File type not allowed');
                return false;
            }
            if (!in_array(strtolower($extension), $allowedExts)) {

                $this->form_validation->set_message('handle_upload', 'Extension not allowed');
                return false;
            }

            if ($_FILES["file"]["size"] > 10240000) {

                $this->form_validation->set_message('handle_upload', 'File size shoud be less than 100 kB');
                return false;
            }
            if ($error == "") {
                return true;
            }
        } else {
            return true;
        }
    }

    function get_data($id) {
        $item = $this->item_model->get($id);

        $data = array(
            'id' => $item['id'],
            'item_category_id' => $item['item_category_id'],
            'name' => $item['name'],
            'unit' => $item['unit'],
            'description' => $item['description'],
        );

        echo json_encode($data);
    }

    function edit() {

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('unit', $this->lang->line('unit'), 'trim|required|xss_clean');


        $this->form_validation->set_rules(
                'item_category_id', $this->lang->line('item') . " " . $this->lang->line('category'), array(
            'required',
            array('check_exists', array($this->item_model, 'valid_check_exists'))
                )
        );

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'name' => form_error('name'),
                'unit' => form_error('unit'),
                'item_category_id' => form_error('item_category_id'),
            );

            $array = array('status' => 'fail', 'error' => $msg);
        } else {

            $data = array(
                'id' => $this->input->post('id'),
                'name'=>$this->input->post('name'),
                'item_category_id' => $this->input->post('item_category_id'),
                'unit' => $this->input->post('unit'),
                'description' => $this->input->post('description'),
            );

            $insert_id = $this->item_model->add($data);


            $array = array('status' => 'success', 'error' => '', 'message' => 'New Item Successfully Inserted');
        }

        echo json_encode($array);
    }

    public function itemreport() {

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/itemreport');
        $search_type = $this->input->post("search_type");

        if (isset($search_type)) {

            $search_type = $this->input->post("search_type");
        } else {

            $search_type = "this_month";
        }

        $data["searchlist"] = $this->search_type;
        $data["search_type"] = $search_type;
        $data['stockresult'] = $this->itemstock_model->get_currentstock();

        $this->load->view('layout/header');
        $this->load->view('admin/item/itemreport', $data);
        $this->load->view('layout/footer');
    }

    public function additemreport() {
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/additemreport');
        $search_type = $this->input->post("search_type");

        if (isset($search_type)) {

            $search_type = $this->input->post("search_type");
        } else {

            $search_type = "this_month";
        }

        $data["searchlist"] = $this->search_type;

        $data["search_type"] = $search_type;

        $data['itemresult'] = $this->itemstock_model->get_ItemByBetweenDate($search_type);


        $this->load->view('layout/header');
        $this->load->view('admin/item/additemreport', $data);
        $this->load->view('layout/footer');
    }

}

?>