<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense_model extends CI_Model {

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
            $this->db->select('expenses.id,expenses.date,expenses.invoice_no,expenses.name,expenses.amount,expenses.documents,expenses.note,expense_head.exp_category,expenses.exp_head_id')->from('expenses');
            $this->db->join('expense_head', 'expenses.exp_head_id = expense_head.id');

            $this->db->like('expenses.name', $text);
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select('expenses.id,expenses.date,expenses.name,expenses.invoice_no,expenses.amount,expenses.documents,expenses.note,expense_head.exp_category,expenses.exp_head_id')->from('expenses');
            $this->db->join('expense_head', 'expenses.exp_head_id = expense_head.id');
            $this->db->where('expenses.date >=', $start_date);
            $this->db->where('expenses.date <=', $end_date);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function get($id = null) {
        $this->db->select('expenses.id,expenses.date,expenses.name,expenses.invoice_no,expenses.amount,expenses.documents,expenses.note,expense_head.exp_category,expenses.exp_head_id')->from('expenses');
        $this->db->join('expense_head', 'expenses.exp_head_id = expense_head.id');
        if ($id != null) {
            $this->db->where('expenses.id', $id);
        } else {
            $this->db->order_by('expenses.id', 'DESC');
        }
        $this->db->limit('20');
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('expenses');
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
            $this->db->update('expenses', $data);
        } else {
            $this->db->insert('expenses', $data);
            return $this->db->insert_id();
        }
    }

    public function check_Exits_group($data) {
        $this->db->select('*');
        $this->db->from('expenses');
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
        $this->db->select('expenses.id,expenses.session_id,expenses.invoice_no,expenses.amount,expenses.documents,expenses.note,expense_head.class,feetype.type')->from('expenses');
        $this->db->join('expense_head', 'expenses.class_id = expense_head.id');
        $this->db->join('feetype', 'expenses.feetype_id = feetype.id');
        $this->db->where('expenses.class_id', $class_id);
        $this->db->where('expenses.feetype_id', $type);
        $this->db->where('expenses.session_id', $this->current_session);
        $this->db->order_by('expenses.id');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getTotalExpenseBydate($date) {
        $query = 'SELECT sum(amount) as `amount` FROM `expenses` where date=' . $this->db->escape($date);
        $query = $this->db->query($query);
        return $query->row();
    }

    public function getTotalExpenseBwdate($date_from, $date_to) {
        $object = new stdClass();
        $query = 'SELECT sum(amount) as `amount` FROM `expenses` where date between ' . $this->db->escape($date_from) . ' and ' . $this->db->escape($date_to);

        $query = $this->db->query($query);
        $result = $query->row();
        $amount1 = $result->amount;

        $query2 = 'SELECT sum(net_salary) as `amount` FROM `staff_payslip` where payment_date between ' . $this->db->escape($date_from) . ' and ' . $this->db->escape($date_to);

        $query2 = $this->db->query($query2);
        $result2 = $query2->row();
        $amount2 = $result2->amount;

         $amount = $amount1 + $amount2;

        $object->amount = $amount;
        //$object->amount ;
        //exit;
        return $object;
    }

    public function searchexpensegroup($search_type, $head_id = null) {

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

        $this->db->select('GROUP_CONCAT(expenses.id,"@",expenses.date,"@",expenses.name,"@",expenses.invoice_no,"@",expenses.amount) as expense, expense_head.exp_category,expenses.exp_head_id,sum(expenses.amount) as total_amount')->from('expenses');
        $this->db->join('expense_head', 'expenses.exp_head_id = expense_head.id');
        if ($return == 1) {
            $this->db->where('expenses.date >=', $start_date);
            $this->db->where('expenses.date <=', $end_date);
        }
        if ($head_id != null) {
            $this->db->where('expenses.exp_head_id', $head_id);
        }
        $this->db->group_by('expenses.exp_head_id');
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>