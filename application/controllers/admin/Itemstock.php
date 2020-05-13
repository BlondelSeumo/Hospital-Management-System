<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itemstock extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->config->load('image_valid');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('item_stock', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Inventory');
        $this->session->set_userdata('sub_menu', 'Itemstock/index');
        $data['title'] = 'Add Item';
        $data['title_list'] = 'Recent Items';

        $this->form_validation->set_rules('item_id', $this->input->post('item'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantity', $this->input->post('quantity'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_category_id', $this->input->post('item') . " " . $this->input->post('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_photo', $this->lang->line('photo'), 'callback_handle_upload');

        if ($this->form_validation->run() == FALSE) {
            
        } else {

            $store_id = ($this->input->post('store_id')) ? $this->input->post('store_id') : NULL;
            $data = array(
                'item_id' => $this->input->post('item_id'),
                'symbol' => $this->input->post('symbol'),
                'supplier_id' => $this->input->post('supplier_id'),
                'store_id' => $store_id,
                'quantity' => $this->input->post('symbol') . $this->input->post('quantity'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
            );

            $insert_id = $this->itemstock_model->add($data);

            if (isset($_FILES["item_photo"]) && !empty($_FILES['item_photo']['name'])) {

                $fileInfo = pathinfo($_FILES["item_photo"]["name"]);

                $img_name = $insert_id . '.' . $fileInfo['extension'];

                move_uploaded_file($_FILES["item_photo"]["tmp_name"], "./uploads/inventory_items/" . $img_name);

                $data_img = array('id' => $insert_id, 'attachment' => 'uploads/inventory_items/' . $img_name);

                $this->itemstock_model->add($data_img);
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item added successfully</div>');
            redirect('admin/itemstock/index');
        }
        $item_result = $this->itemstock_model->get();
        $data['itemlist'] = $item_result;
        $itemcategory = $this->itemcategory_model->get();
        $data['itemcatlist'] = $itemcategory;
        $itemsupplier = $this->itemsupplier_model->get();
        $data['itemsupplier'] = $itemsupplier;
        $itemstore = $this->itemstore_model->get();
        $data['itemstore'] = $itemstore;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/itemstock/itemList', $data);
        $this->load->view('layout/footer', $data);
    }

    public function add() {


        $this->form_validation->set_rules('item_id', $this->lang->line('item'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('purchase_price', $this->lang->line('purchase') . " " . $this->lang->line('price'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantity', $this->lang->line('quantity'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_category_id', $this->lang->line('item') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_photo', $this->lang->line('item_photo'), 'callback_handle_upload');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'e1' => form_error('item_id'),
                'e2' => form_error('quantity'),
                'e3' => form_error('item_category_id'),
                'item_photo' => form_error('item_photo'),
                'purchase_price' => form_error('purchase_price')
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $store_id = ($this->input->post('store_id')) ? $this->input->post('store_id') : NULL;

            $data = array(
                'item_id' => $this->input->post('item_id'),
                'symbol' => $this->input->post('symbol'),
                'supplier_id' => $this->input->post('supplier_id'),
                'purchase_price' => $this->input->post('purchase_price'),
                'store_id' => $store_id,
                'quantity' => $this->input->post('symbol') . $this->input->post('quantity'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
            );

            $insert_id = $this->itemstock_model->add($data);



            if (isset($_FILES["item_photo"]) && !empty($_FILES['item_photo']['name'])) {

                $fileInfo = pathinfo($_FILES["item_photo"]["name"]);

                $img_name = $insert_id . '.' . $fileInfo['extension'];

                move_uploaded_file($_FILES["item_photo"]["tmp_name"], "./uploads/inventory_items/" . $img_name);

                $data_img = array('id' => $insert_id, 'attachment' => 'uploads/inventory_items/' . $img_name);

                $this->itemstock_model->add($data_img);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    public function update() {


        $this->form_validation->set_rules('item_id', $this->lang->line('item'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantity', $this->lang->line('quantity'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_category_id', $this->lang->line('item') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('purchase_price', $this->lang->line('purchase') . " " . $this->lang->line('price'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_photo', $this->lang->line('item_photo'), 'callback_handle_upload');

        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'e1' => form_error('item_id'),
                'e2' => form_error('quantity'),
                'e3' => form_error('item_category_id'),
                'purchase_price' => form_error('purchase_price'),
                'item_photo' => form_error('item_photo')
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $store_id = ($this->input->post('store_id')) ? $this->input->post('store_id') : NULL;
            $updateid = $this->input->post("itemstockid");
            $data = array(
                'id' => $updateid,
                'item_id' => $this->input->post('item_id'),
                'symbol' => $this->input->post('symbol'),
                'supplier_id' => $this->input->post('supplier_id'),
                'store_id' => $store_id,
                'quantity' => $this->input->post('symbol') . $this->input->post('quantity'),
                'purchase_price' => $this->input->post('purchase_price'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
            );

            $insert_id = $this->itemstock_model->add($data);



            if (isset($_FILES["item_photo"]) && !empty($_FILES['item_photo']['name'])) {

                $fileInfo = pathinfo($_FILES["item_photo"]["name"]);

                $img_name = $updateid . '.' . $fileInfo['extension'];

                move_uploaded_file($_FILES["item_photo"]["tmp_name"], "./uploads/inventory_items/" . $img_name);

                $data_img = array('id' => $updateid, 'attachment' => 'uploads/inventory_items/' . $img_name);

                $this->itemstock_model->add($data_img);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    public function download($file) {
        $this->load->helper('download');
        $filepath = "./uploads/inventory_items/" . $this->uri->segment(6);
        $data = file_get_contents($filepath);
        $name = $this->uri->segment(6);
        force_download($name, $data);
    }

    function getItemByCategory() {

        $item_category_id = $this->input->get('item_category_id');
        $data = $this->item_model->getItemByCategory($item_category_id);
        echo json_encode($data);
    }

    function getItemunit() {
        $id = $this->input->get('id');
        $data = $this->item_model->getItemunit($id);
        echo json_encode($data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('item_stock', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->itemstock_model->remove($id);
        redirect('admin/itemstock/index');
    }

    public function handle_upload() {

        $image_validate = $this->config->item('file_validate');

        if (isset($_FILES["item_photo"]) && !empty($_FILES['item_photo']['name'])) {

            $file_type = $_FILES["item_photo"]['type'];
            $file_size = $_FILES["item_photo"]["size"];
            $file_name = $_FILES["item_photo"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @filesize($_FILES['item_photo']['tmp_name'])) {

                if (!in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array(strtolower($ext), $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'File Extension Not Allowed');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', "Error File Uploading");
                return false;
            }

            return true;
        }
        return true;
    }

    function edit($id) {

        $data['id'] = $id;
        $item = $this->itemstock_model->get($id);
        $data['item'] = $item;

        $data['title_list'] = 'Fees Master List';

        $itemcategory = $this->itemcategory_model->get();

        $data['itemcatlist'] = $itemcategory;

        $itemsupplier = $this->itemsupplier_model->get();

        $data['itemsupplier'] = $itemsupplier;

        $itemstore = $this->itemstore_model->get();

        $data['itemstore'] = $itemstore;
        echo json_encode($item);
    }

    function save_edit($id) {


        $this->form_validation->set_rules('quantity', $this->lang->line('quantity'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_id', $this->lang->line('item'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_category_id', $this->lang->line('item') . " " . $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {


            $msg = array(
                'e1' => form_error('item_id'),
                'e2' => form_error('item_category_id'),
                'e3' => form_error('quantity'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $store_id = ($this->input->post('store_id')) ? $this->input->post('store_id') : NULL;
            $data = array(
                'id' => $id,
                'item_id' => $this->input->post('item_id'),
                'symbol' => $this->input->post('symbol'),
                'supplier_id' => $this->input->post('supplier_id'),
                'store_id' => $store_id,
                'quantity' => $this->input->post('symbol') . $this->input->post('quantity'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
            );

            $this->itemstock_model->add($data);


            if (isset($_FILES["item_photo"]) && !empty($_FILES['item_photo']['name'])) {
                $fileInfo = pathinfo($_FILES["item_photo"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["item_photo"]["tmp_name"], "./uploads/inventory_items/" . $img_name);
                $data_img = array('id' => $id, 'attachment' => 'uploads/inventory_items/' . $img_name);

                $this->itemstock_model->add($data_img);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }

        echo json_encode($array);
    }

    function edit_new($id) {
        if (!$this->rbac->hasPrivilege('item_stock', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Fees Master';
        $data['id'] = $id;
        $item = $this->itemstock_model->get($id);
        $data['item'] = $item;
        $data['title_list'] = 'Fees Master List';
        $item_result = $this->itemstock_model->get();
        $data['itemlist'] = $item_result;
        $itemcategory = $this->itemcategory_model->get();
        $data['itemcatlist'] = $itemcategory;
        $itemsupplier = $this->itemsupplier_model->get();
        $data['itemsupplier'] = $itemsupplier;
        $itemstore = $this->itemstore_model->get();
        $data['itemstore'] = $itemstore;


        $this->form_validation->set_rules('item_id', $this->lang->line('item'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('item_category_id', $this->lang->line('item') . " " . $this->lang->line('category'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/itemstock/itemEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $store_id = ($this->input->post('store_id')) ? $this->input->post('store_id') : NULL;
            $data = array(
                'id' => $id,
                'item_id' => $this->input->post('item_id'),
                'symbol' => $this->input->post('symbol'),
                'supplier_id' => $this->input->post('supplier_id'),
                'store_id' => $store_id,
                'quantity' => $this->input->post('symbol') . $this->input->post('quantity'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'description' => $this->input->post('description'),
            );

            $this->itemstock_model->add($data);


            if (isset($_FILES["item_photo"]) && !empty($_FILES['item_photo']['name'])) {
                $fileInfo = pathinfo($_FILES["item_photo"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["item_photo"]["tmp_name"], "./uploads/inventory_items/" . $img_name);
                $data_img = array('id' => $id, 'attachment' => 'uploads/inventory_items/' . $img_name);

                $this->itemstock_model->add($data_img);
            }


            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Item stock updated successfully</div>');
            redirect('admin/itemstock/index');
        }
    }

}

?>