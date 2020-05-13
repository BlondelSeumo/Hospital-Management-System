<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itemissue_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {

        $sql = "SELECT item_issue.*,item.name as `item_name`,item.item_category_id,item_category.item_category ,staff.employee_id,staff.name as docname,staff.surname as docsurname,roles.name FROM `item_issue` left JOIN item on item.id=item_issue.item_id left JOIN item_category on item_category.id=item.item_category_id left JOIN staff on staff.id=item_issue.issue_to left JOIN staff_roles on staff_roles.staff_id =staff.id left JOIN roles on roles.id= staff_roles.role_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('item_issue');
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
            $this->db->update('item_issue', $data);
        } else {
            $this->db->insert('item_issue', $data);
            return $this->db->insert_id();
        }
    }

    public function get_IssueInventoryReport($search_type) {

        $return = 1;
        $condition = '';
        if ($search_type == 'period') {
            $this->form_validation->set_rules('date_from', $this->lang->line('date_from'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_to', $this->lang->line('date_to'), 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                echo form_error();
                $return = 0;
            } else {
                $from_date = $this->input->post('date_from');
                $to_date = $this->input->post('date_to');

                $date_from = date("Y-m-d", $this->customlib->datetostrtotime($from_date));
                $date_to = date("Y-m-d", $this->customlib->datetostrtotime($to_date));
                $start_date = $date_from;
                $end_date = $date_to;
            }
        } else if ($search_type == 'today') {

            $today = strtotime('today');

            $first_date = date('Y-m-d', $today);


            $start_date = $first_date;
            $end_date = $first_date;
        } else if ($search_type == 'this_week') {

            $this_week_start = strtotime('-1 week monday');
            $this_week_end = strtotime('sunday');

            $first_date = date('Y-m-d', $this_week_start);
            $last_date = date('Y-m-d', $this_week_end);

            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == 'last_week') {

            $last_week_start = strtotime('-2 week monday');
            $last_week_end = strtotime('-1 week sunday');

            $first_date = date('Y-m-d', $last_week_start);
            $last_date = date('Y-m-d', $last_week_end);

            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == 'this_month') {
            $first_date = date('Y-m-01');
            $last_date = date('Y-m-t');

            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == 'last_month') {
            $month = date("m", strtotime("-1 month"));
            $first_date = date('Y-' . $month . '-01');
            $last_date = date('Y-' . $month . '-' . date('t', strtotime($first_date)));
            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == 'last_3_month') {
            $month = date("m", strtotime("-2 month"));
            $first_date = date('Y-' . $month . '-01');
            $firstday = date('Y-' . 'm' . '-01');
            $last_date = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)));
            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == 'last_6_month') {
            $month = date("m", strtotime("-5 month"));
            $first_date = date('Y-' . $month . '-01');
            $firstday = date('Y-' . 'm' . '-01');
            $last_date = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)));
            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == 'last_12_month') {
            $first_date = date('Y-m' . '-01', strtotime("-11 month"));
            $firstday = date('Y-' . 'm' . '-01');
            $last_date = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)));
            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == 'last_year') {

            $search_year = date('Y', strtotime("-1 year"));
            $first_date = '01-01-' . $search_year;
            $last_date = '31-12-' . $search_year;
            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == 'this_year') {

            $search_year = date('Y');

            $first_date = '01-01-' . $search_year;
            $last_date = '31-12-' . $search_year;
            $start_date = $first_date;
            $end_date = $last_date;
        } else if ($search_type == '') {
            $return = 0;
        }
        if ($return == 1) {
            $condition = " and date_format(item_issue.issue_date,'%Y-%m-%d') between '" . $start_date . "' and '" . $end_date . "'";
        }

        $sql = "SELECT item_issue.*,item.name as `item_name`,item.item_category_id,item_category.item_category ,staff.employee_id,staff.name ,staff.surname,roles.name FROM `item_issue` INNER JOIN item on item.id=item_issue.item_id INNER JOIN item_category on item_category.id=item.item_category_id INNER JOIN staff on staff.id=item_issue.issue_to INNER JOIN staff_roles on staff_roles.staff_id =staff.id INNER JOIN roles on roles.id= staff_roles.role_id where 1 " . $condition;

        $query = $this->db->query($sql);
        return $query->result_array();
    }

}

?>