<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_media_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function bulk_add($data = null) {

        $this->db->insert_batch('front_cms_media_gallery', $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function add($data) {
        $this->db->insert('front_cms_media_gallery', $data);
        return $this->db->insert_id();
    }

    public function get($id = null) {
        $this->db->select()->from('front_cms_media_gallery');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result();
        }
    }

    public function getSlug($slug = null) {
        $sql = "SELECT img_name FROM `front_cms_media_gallery` WHERE img_name = '" . $slug . "' OR img_name LIKE '" . $slug . "-[0-9]*' ORDER BY LENGTH(img_name), img_name DESC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('front_cms_media_gallery');
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    function count_all($st = NULL, $media_type = NULL) {
        $this->db->like('file_type', $media_type);
        $this->db->like('img_name', $st);
        $query = $this->db->get("front_cms_media_gallery");
        return $query->num_rows();
    }

    function fetch_details($limit, $start, $st = 'img', $media_type = NULL) {
        $output = '';
        $this->db->select("*");
        $this->db->like('img_name', $st);
        $this->db->like('file_type', $media_type);
        $this->db->from("front_cms_media_gallery");
        $this->db->order_by("id", "DESC");
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

}
