<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('imageResize');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('media_manager', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Add Book';
        $data['title_list'] = 'Book Details';
        $this->session->set_userdata('top_menu', 'Front CMS');
        $this->session->set_userdata('sub_menu', 'admin/front/media');
        $data['mediaTypes'] = $this->customlib->mediaType();
        $this->load->view('layout/header');
        $this->load->view('admin/front/media/index', $data);
        $this->load->view('layout/footer');
    }

    function getMedia() {
        $data = array();
        $data['mediaTypes'] = $this->customlib->mediaType();
        $this->load->view('admin/front/media/getMedia', $data);
    }

    function getPage() {

        $keyword = $this->input->get('keyword');
        $file_type = $this->input->get('file_type');
        $is_gallery = $this->input->get('is_gallery');
        if (!isset($is_gallery)) {
            $is_gallery = 1;
        }

        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->cms_media_model->count_all($keyword, $file_type);
        $config["per_page"] = 60;
        $config["uri_segment"] = 5;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(5);
        $start = ($page - 1) * $config["per_page"];
        $result = $this->cms_media_model->fetch_details($config["per_page"], $start, $keyword, $file_type);
        $img_data = array();
        $check_empty = 0;
        if (!empty($result)) {
            $check_empty = 1;
            foreach ($result as $res_key => $res_value) {

                $div = $this->genrateDiv($res_value, $is_gallery);

                $img_data[] = $div;
            }
        }

        $output = array(
            'pagination_link' => $this->pagination->create_links(),
            'result_status' => $check_empty,
            'result' => $img_data,
        );
        echo json_encode($output);
    }

    function deleteItem() {
        if (!$this->rbac->hasPrivilege('media_manager', 'can_delete')) {
            access_denied();
        }
        $record_id = $this->input->post('record_id');
        $record = $this->cms_media_model->get($record_id);
        if ($record) {

            $destination_path = "uploads/gallery/media/" . $record['img_name'];
            $thumb_path = "uploads/gallery/media/thumb/" . $record['img_name'];
            $del_record = $this->cms_media_model->remove($record_id);
            if ($del_record) {
                if (is_readable($destination_path) && unlink($destination_path) && is_readable($thumb_path) && unlink($thumb_path)) {
                    
                }
                echo json_encode(array('status' => 1, 'msg' => $this->lang->line('delete_message')));
            } else {
                echo json_encode(array('status' => 0, 'msg' => $this->lang->line('delete_message')));
            }
        } else {
            echo json_encode(array('status' => 0, 'msg' => $this->lang->line('delete_message')));
        }
    }

    function addImage() {
        if (!$this->rbac->hasPrivilege('media_manager', 'can_add')) {
            access_denied();
        }

        if (isset($_FILES['files']) && !empty($_FILES['files'])) {
            $destination_path = "uploads/gallery/media/";
            $thumb_path = "uploads/gallery/media/thumb/";
            $responses = $this->imageresize->resize($_FILES["files"], $destination_path, $thumb_path, "media");
            if ($responses) {
                $img_array = array();
                foreach ($responses['images'] as $key => $value) {
                    $data = array(
                        'img_name' => $value['store_name'],
                        'file_type' => $value['file_type'],
                        'file_size' => $value['file_size'],
                        'thumb_name' => $value['store_name'],
                        'thumb_path' => $value['thumb_path'],
                        'dir_path' => $value['dir_path'],
                    );
                    $insert_id = $this->cms_media_model->add($data);
                    $data['record_id'] = $insert_id;
                    $img_array[] = $data;
                }
                if (!empty($img_array)) {
                    $data['img_array'] = $img_array;
                    $this->load->view('admin/partial/_media_content', $data);
                }
            } else {
                echo json_encode(array('status' => 0, 'msg' => 'Please try again', 'response' => ''));
            }
        }
    }

    function genrateDiv($result, $is_gallery) {

        $is_image = "0";
        $is_video = "0";
        if ($result->file_type == 'image/png' || $result->file_type == 'image/jpeg' || $result->file_type == 'image/jpeg' || $result->file_type == 'image/jpeg' || $result->file_type == 'image/gif') {
            $file = base_url() . $result->dir_path . $result->img_name;
            $file_src = base_url() . $result->dir_path . $result->img_name;
            $is_image = 1;
        } elseif ($result->file_type == 'video') {
            $file = base_url() . $result->thumb_path . $result->img_name;
            $file_src = $result->vid_url;

            $is_video = 1;
        } elseif ($result->file_type == 'text/plain') {
            $file = base_url('backend/images/txticon.png');
            $file_src = base_url() . $result->dir_path . $result->img_name;
        } elseif ($result->file_type == 'application/zip' || $result->file_type == 'application/x-rar') {
            $file = base_url('backend/images/zipicon.png');
            $file_src = base_url() . $result->dir_path . $result->img_name;
        } elseif ($result->file_type == 'application/pdf') {
            $file = base_url('backend/images/pdficon.png');
            $file_src = base_url() . $result->dir_path . $result->img_name;
        } elseif ($result->file_type == 'application/msword') {
            $file = base_url('backend/images/wordicon.png');
            $file_src = base_url() . $result->dir_path . $result->img_name;
        } elseif ($result->file_type == 'application/vnd.ms-excel') {
            $file = base_url('backend/images/excelicon.png');
            $file_src = base_url() . $result->dir_path . $result->img_name;
        } else {
            $file = base_url('backend/images/docicon.png');
            $file_src = base_url() . $result->dir_path . $result->img_name;
        }
//==============
        $output = '';
        $output .= "<div class='col-sm-3 col-md-2 col-xs-6 img_div_modal image_div div_record_" . $result->id . "'>";
        $output .= "<div class='fadeoverlay'>";
        $output .= "<div class='fadeheight'>";
        $output .= "<img class='' data-fid='" . $result->id . "' data-content_type='" . $result->file_type . "' data-content_name='" . $result->img_name . "' data-is_image='" . $is_image . "' data-vid_url='" . $result->vid_url . "' data-img='" . base_url() . $result->dir_path . $result->img_name . "' src='" . $file . "'>";
        $output .= "</div>";
        if ($is_video == 1) {
            $output .= "<i class='fa fa-youtube-play videoicon'></i>";
        }
        if ($is_image == 1) {
            $output .= "<i class='fa fa-picture-o videoicon'></i>";
        }
        if (!$is_gallery) {
            $output .= "<div class='overlay3'>";
            $output .= "<a href='#' class='uploadcheckbtn' data-record_id='" . $result->id . "' data-toggle='modal' data-target='#detail' data-image='" . $file . "' data-source='" . $file_src . "' data-media_name='" . $result->img_name . "' data-media_size='" . $result->file_size . "' data-media_type='" . $result->file_type . "'><i class='fa fa-navicon'></i></a>";
            $output .= "<a href='#' class='uploadclosebtn' data-record_id='" . $result->id . "' data-toggle='modal' data-target='#confirm-delete'><i class=' fa fa-trash-o'></i></a>";
            $output .= "<p class='processing'>Processing...</p>";
            $output .= "</div>";
        }
        if ($is_video == 1) {
            $output .= "<p class=''>" . $result->vid_title . "</p>";
        } else {
            $output .= "<p class=''>" . $result->img_name . "</p>";
        }
        $output .= "</div>";
        $output .= "</div>";
        return $output;
//================
    }

    function addVideo() {
        if (!$this->rbac->hasPrivilege('media_manager', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('video_url', $this->lang->line('url'), 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'video_url' => form_error('video_url'),
            );
            $array = array('status' => 0, 'error' => $data);
            echo json_encode($array);
        } else {
            $url = $this->input->post('video_url');
            $youtube = "https://www.youtube.com/oembed?url=" . $url . "&format=json";
            $curl = curl_init($youtube);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);


            $response = array('status' => 0, 'msg' => 'Something wrong');
            if ($httpcode == 200) {
                $img_array = array();
                $upload_response = $this->imageresize->resizeVideoImg($return);

                if ($upload_response) {
                    $upload_response = json_decode($upload_response);
                    $data = array(
                        'vid_url' => $url,
                        'vid_title' => $upload_response->vid_title,
                        'img_name' => $upload_response->store_name,
                        'file_type' => $upload_response->file_type,
                        'file_size' => $upload_response->file_size,
                        'thumb_name' => $upload_response->store_name,
                        'thumb_path' => $upload_response->thumb_path,
                        'dir_path' => $upload_response->dir_path,
                    );
                    $insert_id = $this->cms_media_model->add($data);
                    echo json_encode(array('status' => 1, 'msg' => 'file upload successfully', 'error' => ''));
                } else {
                    echo json_encode(array('status' => 0, 'msg' => 'Please try again', 'error' => ''));
                }
            } else {
                echo json_encode(array('status' => 0, 'msg' => 'Please try again', 'error' => ''));
            }
        }
    }

}

?>