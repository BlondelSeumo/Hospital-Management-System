<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_page_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->load->config('ci-blog');
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {
        $this->db->select('front_cms_pages.*,front_cms_page_contents.content_type')->from('front_cms_pages');
        $this->db->join('front_cms_page_contents', 'front_cms_pages.id = front_cms_page_contents.page_id', 'left');
        if ($id != null) {
            $this->db->where('front_cms_pages.id', $id);
        } else {
            $this->db->order_by('front_cms_pages.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getBySlug($slug = null) {
        $this->db->select()->from('front_cms_pages');
        if ($slug != null) {
            $this->db->where('slug', $slug);
        }
        $query = $this->db->get();

        if ($query->row_array() <= 0) {
            return false;
        }
        $result = $query->row_array();
        $result['category_content'] = $this->getPageCategoryContent($result['id']);
        return $result;
    }

    public function getPageCategoryContent($page_id) {
        $content_result = array();
        $content = $this->cms_page_content_model->getContentByPage($page_id);
        if (!empty($content)) {
            foreach ($content as $content_k => $content_v) {
                $content_result[$content_v['content_type']] = $content_v['content_type'];
            }
        }
        return $content_result;
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('front_cms_pages');
    }

    public function removeBySlug($slug) {
        $this->db->where('slug', $slug);
        $this->db->delete('front_cms_pages');
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('front_cms_pages', $data);
        } else {
            $this->db->insert('front_cms_pages', $data);
            return $this->db->insert_id();
        }
    }

    public function valid_check_exists($str) {
        $url = $this->input->post('url');
        $id = $this->input->post('id');

        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_data_exists($url, $id)) {
            $this->form_validation->set_message('check_exists', 'URL already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_data_exists($url, $id) {
        $this->db->where('url', $url);
        $this->db->where('id !=', $id);
        $query = $this->db->get('front_cms_pages');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
