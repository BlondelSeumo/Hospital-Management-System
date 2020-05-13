<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Income_model extends CI_Model {

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
    public function search($text = null, $start_date = null, $end_date = null) {
        if (!empty($text)) {
            $this->db->select('income.id,income.date,income.name,income.invoice_no,income.amount,income.documents,income.note,income_head.income_category,income.inc_head_id')->from('income');
            $this->db->join('income_head', 'income.inc_head_id = income_head.id');

            $this->db->like('income.name', $text);
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select('income.id,income.date,income.name,income.invoice_no,income.amount,income.documents,income.note,income_head.income_category,income.inc_head_id')->from('income');
            $this->db->join('income_head', 'income.inc_head_id = income_head.id');
            $this->db->where('income.date >=', $start_date);
            $this->db->where('income.date <=', $end_date);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function get($id = null) {
        $this->db->select('income.id,income.date,income.name,income.invoice_no,income.amount,income.documents,income.note,income_head.income_category,income.inc_head_id')->from('income');
        $this->db->join('income_head', 'income.inc_head_id = income_head.id');
        if ($id != null) {
            $this->db->where('income.id', $id);
        } else {
            $this->db->order_by('income.id', 'DESC');
        }
        $this->db->limit('20');
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getTotal($search = '') {
        if (!empty($search)) {

            $this->db->where($search);
        }

        $this->db->select('sum(income.amount) as amount')->from('income');
        $this->db->join('income_head', 'income.inc_head_id = income_head.id');
        $query = $this->db->get();

        $result = $query->row_array();

        return $result["amount"];
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('income');
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
            $this->db->update('income', $data);
        } else {
            $this->db->insert('income', $data);
            return $this->db->insert_id();
        }
    }

    public function check_Exits_group($data) {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('session_id', $this->current_session);
        $this->db->where('feetype_id', $data['feetype_id']);
        $this->db->where('class_id', $data['class_id']);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return false;
        } else {
            return true;
        }
    }

    public function getTypeByFeecategory($type, $class_id) {
        $this->db->select('income.id,income.session_id,income.amount,income.invoice_no,income.documents,income.note,income_head.class,feetype.type')->from('income');
        $this->db->join('income_head', 'income.class_id = income_head.id');
        $this->db->join('feetype', 'income.feetype_id = feetype.id');
        $this->db->where('income.class_id', $class_id);
        $this->db->where('income.feetype_id', $type);
        $this->db->where('income.session_id', $this->current_session);
        $this->db->order_by('income.id');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getTotalExpenseBydate($date) {
        $query = 'SELECT sum(amount) as `amount` FROM `income` where date=' . $this->db->escape($date);
        $query = $this->db->query($query);
        return $query->row();
    }

    public function getTotalExpenseBwdate($date_from, $date_to) {
        $query = 'SELECT sum(amount) as `amount` FROM `income` where date between ' . $this->db->escape($date_from) . ' and ' . $this->db->escape($date_to);

        $query = $this->db->query($query);
        return $query->row();
    }

    public function searchincomegroup($search_type, $head_id = null) {
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
            $start_date = date('Y-m-d', strtotime($first_date));
            $end_date = date('Y-m-d', strtotime($last_date));
        } else if ($search_type == 'this_year') {

            $search_year = date('Y');
            $first_date = '01-01-' . $search_year;
            $last_date = '31-12-' . $search_year;
            $start_date = date('Y-m-d', strtotime($first_date));
            $end_date = date('Y-m-d', strtotime($last_date));
        } else if ($search_type == '') {
            $return = 0;
        }

        $this->db->select('GROUP_CONCAT(income.id,"@",income.name,"@",income.invoice_no,"@",income.date,"@",income.amount) as income, income_head.income_category,sum(income.amount) as total_amount')->from('income');
        $this->db->join('income_head', 'income.inc_head_id = income_head.id');
        if ($return == 1) {
            $this->db->where('income.date >=', $start_date);
            $this->db->where('income.date <=', $end_date);
        }
        if ($head_id != null) {
            $this->db->where('income.inc_head_id', $head_id);
        }
        $this->db->group_by('income.inc_head_id');
        $query = $this->db->get();
        return $query->result_array();
    }

}
