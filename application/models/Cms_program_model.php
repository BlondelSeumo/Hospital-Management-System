<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_program_model extends CI_Model {

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
    public function get($id = null) {
        $this->db->select()->from('front_cms_programs');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    function getByCategory($category = null, $params = array()) {
        $this->db->select('*');
        $this->db->from('front_cms_programs');
        $this->db->order_by('created_at', 'desc');
        $this->db->where('type', $category);
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        // echo $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function updateFeaturedImage($id, $record_id) {
        $this->db->trans_begin();
        $data = array(
            'featured_img' => 'yes'
        );
        $this->db->where('id', $record_id);
        $this->db->update('front_cms_program_photos', $data);
        $data = array(
            'featured_img' => 'no'
        );
        $this->db->where('id !=', $record_id);
        $this->db->where('program_id =', $id);
        $this->db->update('front_cms_program_photos', $data);
        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function getBySlug($slug = null) {
        $this->db->select()->from('front_cms_programs');
        if ($slug != null) {
            $this->db->where('slug', $slug);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        if ($query->num_rows()) {
            $result['page_contents'] = $this->front_cms_program_photos($query->row()->id);
        }

        return $result;
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function front_cms_program_photos($program_id) {
        $this->db->select('front_cms_media_gallery.*');
        $this->db->from('front_cms_program_photos');
        $this->db->join('front_cms_media_gallery', 'front_cms_program_photos.media_gallery_id = front_cms_media_gallery.id');
        $this->db->where('front_cms_program_photos.program_id', $program_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function remove($slug) {
        $this->db->where('slug', $slug);
        $this->db->delete('front_cms_programs');
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
            $this->db->update('front_cms_programs', $data);
        } else {
            $this->db->insert('front_cms_programs', $data);
            return $this->db->insert_id();
        }
    }

    public function inst_batch($data, $contents) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

        $this->db->insert('front_cms_programs', $data);
        $insert_id = $this->db->insert_id();

        if (isset($contents) && !empty($contents)) {
            $total_rec = count($contents);
            for ($i = 0; $i < $total_rec; $i++) {
                $contents[$i]['program_id'] = $insert_id;
            }
            $this->db->insert_batch('front_cms_program_photos', $contents);
        }
        $this->db->trans_complete(); # Completing transaction

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_batch($data, $contents, $remove_content) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 
        $this->db->where('id', $data['id']);
        $this->db->update('front_cms_programs', $data);

        if (!empty($remove_content)) {
            $this->db->where('program_id', $data['id']);
            $this->db->where_in('media_gallery_id', $remove_content);
            $this->db->delete('front_cms_program_photos');
        }
        if (isset($contents) && !empty($contents)) {
            $total_rec = count($contents);
            for ($i = 0; $i < $total_rec; $i++) {
                $contents[$i]['program_id'] = $data['id'];
            }
            $this->db->insert_batch('front_cms_program_photos', $contents);
        }

        $this->db->trans_complete(); # Completing transaction

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function addImage($data) {

        $this->db->insert('front_cms_program_photos', $data);
        return $this->db->insert_id();
    }

    public function removeImage($id) {
        $this->db->where('id', $id);
        $this->db->delete('front_cms_program_photos');
    }

    public function removeBySlug($slug, $type) {
        $this->db->where('slug', $slug);
        $this->db->where('type', $type);
        $this->db->delete('front_cms_programs');
    }

    public function banner($banner_content, $data) {
        $this->db->trans_begin();

        //===============
        $banner_content_record = $this->getByCategory($banner_content);
        if ($banner_content_record) {
            $data['program_id'] = $banner_content_record[0]['id'];
            $this->db->insert('front_cms_program_photos', $data);
        } else {
            $insert_program = array('type' => $banner_content, 'title' => 'Banner Images');
            $insert_program_id = $this->add($insert_program);
            $data['program_id'] = $insert_program_id;
            $this->db->insert('front_cms_program_photos', $data);
        }

        //=======================

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function bannerDelete($banner_content, $media_gallery_id) {
        $this->db->trans_begin();

        //===============
        $banner_content_record = $this->getByCategory($banner_content);
        if ($banner_content_record) {
            $data = array('program_id' => $banner_content_record[0]['id'], 'media_gallery_id' => $media_gallery_id);
            $this->db->where($data);
            $this->db->delete('front_cms_program_photos');
        } else {
            
        }

        //=======================

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
