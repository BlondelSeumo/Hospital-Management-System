<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ImageResize {

    private $generate_image_file;
    private $generate_thumbnails;
    private $image_max_size;
    private $thumbnail_size;
    private $thumbnail_prefix;
    private $destination_dir;
    private $thumbnail_destination_dir;
    private $save_dir;
    private $quality;
    private $random_file_name;
    private $config;
    private $file_count;
    private $image_width;
    private $image_height;
    private $image_type;
    private $image_size_info;
    private $image_res;
    private $image_scale;
    private $new_width;
    private $new_height;
    private $new_canvas;
    private $new_file_name;
    private $curr_tmp_name;
    private $file_name;
    private $x_offset;
    private $y_offset;
    private $resized_response;
    private $thumb_response;
    private $unique_rnd_name;
    public $response;
    public $media = false;

    function __construct() {
        //set local vars
        $this->CI = & get_instance();
        $this->CI->config->load("thumbnail");
        $this->generate_image_file = $this->CI->config->item("generate_image_file");
        $this->generate_thumbnails = $this->CI->config->item("generate_thumbnails");
        $this->image_max_size = $this->CI->config->item("image_max_size");
        $this->thumbnail_size = $this->CI->config->item("thumbnail_size");
        $this->thumbnail_prefix = $this->CI->config->item("thumbnail_prefix");
        $this->random_file_name = $this->CI->config->item("random_file_name");
        $this->quality = $this->CI->config->item("quality");
        // $this->file_data = $this->config->item("file_data");
        // $this->file_count = count($this->file_data['name']);
        // $this->destination_dir = $config["destination_folder"];
        // $this->thumbnail_destination_dir = $config["thumbnail_destination_folder"];
    }

    //resize function
    public function resize($file_data, $destination_folder, $thumbnail_folder, $media = false) {
        $this->media = $media;
        $this->file_data = $file_data;
        $this->file_count = count($this->file_data['name']);
        $this->destination_dir = $destination_folder;
        $this->thumbnail_destination_dir = $thumbnail_folder;
        if ($this->generate_image_file) {
            $this->response["images"] = $this->resize_it();
        }
        if ($this->generate_thumbnails) {
            $this->response["thumbs"] = $this->thumbnail_it();
        }
        return $this->response;
    }

    private function resize_it() {
        if ($this->file_count > 0) {
            if (!is_array($this->file_data['name'])) {
                throw new Exception('HTML file input field must be in array format!');
            }
            for ($x = 0; $x < $this->file_count; $x++) {
                //========
                //folder path setup
                //file name setup
                $this->curr_tmp_name = $this->file_data['tmp_name'][$x];
                $this->new_file_name = $this->file_data['name'][$x];
                $tot_rows = $this->CI->cms_media_model->getSlug($this->new_file_name);

                if ($tot_rows > 0) {
                    $pos = strrpos($this->new_file_name, '.');
                    $name = substr($this->new_file_name, 0, $pos);
                    $ext = substr($this->new_file_name, $pos);
                    $this->new_file_name = $name . "-" . strtotime(date('Y-m-d')) . $ext;
                }

                $filename_err = explode(".", $this->new_file_name);
                $file_ext = mime_content_type($this->file_data['tmp_name'][$x]);
                $fileName = $this->new_file_name;
                //upload image path
                $upload_image = $this->destination_dir . basename($fileName);
                //upload image
                if (move_uploaded_file($this->curr_tmp_name, $upload_image)) {
                    //thumbnail creation
                    $this->image_size_info = filesize($this->curr_tmp_name);


                    $img_array = array(
                        'store_name' => $this->new_file_name,
                        'file_type' => $file_ext,
                        'file_size' => $this->image_size_info,
                        'thumb_name' => $this->new_file_name,
                        'thumb_path' => $this->thumbnail_destination_dir,
                        'dir_path' => $this->destination_dir,
                        'height' => 0,
                        'width' => 0,
                    );

                    if ($this->generate_thumbnails) {
                        if ($file_ext == 'image/jpeg' || $file_ext == 'image/png' || $file_ext == 'image/gif') {
                            $thumbnail = $this->thumbnail_destination_dir . $fileName;
                            list($width, $height) = getimagesize($upload_image);
                            $img_array['height'] = $height;
                            $img_array['width'] = $width;
                            $thumb_width = $this->thumbnail_size;
                            $thumb_height = $this->thumbnail_size;
                            $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);

                            switch ($file_ext) {
                                case 'image/jpeg':
                                    $source = imagecreatefromjpeg($upload_image);
                                    break;
                                case 'image/png':
                                    $source = imagecreatefrompng($upload_image);
                                    break;
                                case 'image/gif':
                                    $source = imagecreatefromgif($upload_image);
                                    break;
                                default:
                                // $source = imagecreatefromjpeg($upload_image);
                            }

                            imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
                            switch ($file_ext) {
                                case 'image/jpeg':
                                    imagejpeg($thumb_create, $thumbnail, 100);
                                    break;
                                case 'image/png':
                                    imagepng($thumb_create, $thumbnail, 9);
                                    break;

                                case 'image/gif':
                                    imagegif($thumb_create, $thumbnail, 100);
                                    break;
                                default:
                                // imagejpeg($thumb_create, $thumbnail, 100);
                            }
                        }
                    }
                    $this->resized_response[] = $img_array;
                }

                //=========
            }
        }
        return $this->resized_response;
    }

    //generate cropped and resized thumbnails
    private function thumbnail_it() {
        if ($this->file_count > 0) {
            if (!is_array($this->file_data['name'])) {
                throw new Exception('HTML file input field must be in array format!');
            }
            for ($x = 0; $x < $this->file_count; $x++) {

                if ($this->file_data['error'][$x] > 0) {
                    $this->upload_error_no = $this->file_data['error'][$x];
                    throw new Exception($this->get_upload_error());
                }

                if (is_uploaded_file($this->curr_tmp_name)) {
                    $this->curr_tmp_name = $this->file_data['tmp_name'][$x];
                    $this->get_image_info();

                    if ($this->random_file_name && !empty($this->unique_rnd_name)) {
                        $this->new_file_name = $this->thumbnail_prefix . $this->unique_rnd_name[$x];
                    } else if ($this->random_file_name) {
                        $this->new_file_name = $this->thumbnail_prefix . uniqid() . $this->get_extension();
                    } else {
                        $this->new_file_name = $this->thumbnail_prefix . $this->file_data['name'][$x];
                    }

                    $this->image_res = $this->get_image_resource();

                    $this->new_width = $this->thumbnail_size;
                    $this->new_height = $this->thumbnail_size;
                    $this->save_dir = $this->thumbnail_destination_dir;


                    $this->y_offset = 0;
                    $this->x_offset = 0;
                    if ($this->image_width > $this->image_height) {
                        $this->x_offset = ($this->image_width - $this->image_height) / 2;
                        $this->image_width = $this->image_height = $this->image_width - ($this->x_offset * 2);
                    } else {
                        $this->y_offset = ($this->image_height - $this->image_width) / 2;
                        $this->image_width = $this->image_height = $this->image_height - ($this->y_offset * 2);
                    }

                    if ($this->image_resampling()) {
                        $this->thumb_response[] = $this->save_image();
                    }
                    imagedestroy($this->image_res);
                }
            }
        }
        return $this->thumb_response;
    }

    //save image to destination
    private function save_image() {
        if (!file_exists($this->save_dir)) { //try and create folder if none exist
            if (!mkdir($this->save_dir, 0755, true)) {
                throw new Exception($this->save_dir . ' - directory doesn\'t exist!');
            }
        }

        switch ($this->image_type) {//determine mime type
            case 'image/png':
                imagepng($this->new_canvas, $this->save_dir . $this->new_file_name);
                imagedestroy($this->new_canvas);
                return array('file_name' => $this->file_name, 'file_type' => $this->image_type, 'store_name' => $this->new_file_name, 'dir_path' => $this->destination_dir, 'thumb_path' => $this->thumbnail_destination_dir);
                break;
            case 'image/gif':
                imagegif($this->new_canvas, $this->save_dir . $this->new_file_name);
                imagedestroy($this->new_canvas);
                return array('file_name' => $this->file_name, 'file_type' => $this->image_type, 'store_name' => $this->new_file_name, 'dir_path' => $this->destination_dir, 'thumb_path' => $this->thumbnail_destination_dir);
                break;
            case 'image/jpeg': case 'image/pjpeg':
                imagejpeg($this->new_canvas, $this->save_dir . $this->new_file_name, $this->quality);
                imagedestroy($this->new_canvas);
                return array('file_name' => $this->file_name, 'file_type' => $this->image_type, 'store_name' => $this->new_file_name, 'dir_path' => $this->destination_dir, 'thumb_path' => $this->thumbnail_destination_dir);
                break;
            default:
                imagedestroy($this->new_canvas);
                return false;
        }
    }

    //get image info
    private function get_image_info() {
        $this->image_size_info = getimagesize($this->curr_tmp_name);

        if ($this->image_size_info) {
            $this->image_width = $this->image_size_info[0]; //image width
            $this->image_height = $this->image_size_info[1]; //image height
            $this->image_type = $this->image_size_info['mime']; //image type
        } else {
            throw new Exception("Make sure Image file is valid image!");
        }
    }

    //image resample
    private function image_resampling() {
        $this->new_canvas = imagecreatetruecolor($this->new_width, $this->new_height);
        if (imagecopyresampled($this->new_canvas, $this->image_res, 0, 0, $this->x_offset, $this->y_offset, $this->new_width, $this->new_height, $this->image_width, $this->image_height)) {
            return true;
        }
    }

    //create image resource
    private function get_image_resource() {
        switch ($this->image_type) {
            case 'image/png':
                return imagecreatefrompng($this->curr_tmp_name);
                break;
            case 'image/gif':
                return imagecreatefromgif($this->curr_tmp_name);
                break;
            case 'image/jpeg': case 'image/pjpeg':
                return imagecreatefromjpeg($this->curr_tmp_name);
                break;
            default:
                return false;
        }
    }

    private function get_extension() {
        if (empty($this->image_type))
            return false;
        switch ($this->image_type) {
            case 'image/gif': return '.gif';
            case 'image/jpeg': return '.jpg';
            case 'image/png': return '.png';
            default: return false;
        }
    }

    private function get_upload_error() {
        switch ($this->upload_error_no) {
            case 1 : return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            case 2 : return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            case 3 : return 'The uploaded file was only partially uploaded.';
            case 4 : return 'No file was uploaded.';
            case 5 : return 'Missing a temporary folder. Introduced in PHP 5.0.3';
            case 6 : return 'Failed to write file to disk. Introduced in PHP 5.1.0';
        }
    }

    public function resizeVideoImg($image_array) {
        $img_data = json_decode($image_array);
        $image = $img_data->thumbnail_url;
        $title = $img_data->title;
        $path_info = pathinfo($image);
        $file_extenstion = '.' . $path_info['extension']; // "bill
        $destination_path = "uploads/gallery/youtube_video/";
        $thumb_path = "uploads/gallery/youtube_video/thumb/";
        $contextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $filename = uniqid() . $file_extenstion;

        if (copy($image, $destination_path . '/' . $filename, stream_context_create($contextOptions))) {
            $this->videoThumbnail($destination_path . '/' . $filename, $thumb_path . '/' . $filename);
            return json_encode(array('vid_title' => $title, 'store_name' => $filename, 'file_type' => 'video', 'file_size' => 0, 'thumb_name' => $filename, 'thumb_path' => $thumb_path, 'dir_path' => $destination_path));
        }
        return false;
    }

    function videoThumbnail($src, $dest) {
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $desired_width = $this->thumbnail_size;
        $desired_height = $this->thumbnail_size;
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        imagejpeg($virtual_image, $dest);
    }

}
