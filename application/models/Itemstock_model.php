<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Itemstock_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {
        $this->db->select('`item_stock`.*, `item`.`name`,`item`.`id` as itemid, `item`.`item_category_id`, `item`.`description` as des, `item_category`.`item_category`, `item_supplier`.`item_supplier`, `item_store`.`item_store`')->from('item_stock');
        $this->db->join('item ', 'item.id = item_stock.item_id');
        $this->db->join('item_category', 'item.item_category_id = item_category.id');
        $this->db->join('item_supplier', 'item_stock.supplier_id = item_supplier.id');
        $this->db->join('item_store', 'item_store.id = item_stock.store_id', 'left outer');
        if ($id != null) {
            $this->db->where('item_stock.id', $id);
        } else {
            $this->db->order_by('item_stock.id', 'DESC');
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
        $this->db->delete('item_stock');
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
            $this->db->update('item_stock', $data);
        } else {
            $this->db->insert('item_stock', $data);
            return $this->db->insert_id();
        }
    }

    public function get_currentstock() {
        $query = "SELECT sum(`item_stock`.`quantity`) as available_stock, `item`.`name`, `item`.`item_category_id`, `item`.`description` as `des`, `item_category`.`item_category`, `item_supplier`.`item_supplier`, `item_store`.`item_store`,(SELECT sum(quantity) from item_issue where item.id=item_issue.item_id) as total_issued FROM `item_stock` JOIN `item` ON `item`.`id` = `item_stock`.`item_id` JOIN `item_category` ON `item`.`item_category_id` = `item_category`.`id` JOIN `item_supplier` ON `item_stock`.`supplier_id` = `item_supplier`.`id` LEFT OUTER JOIN `item_store` ON `item_store`.`id` = `item_stock`.`store_id`  group by `item`.`id`";
        $querydata = $this->db->query($query);
        return $querydata->result_array();
    }

    public function get_ItemByBetweenDate($search_type) {
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
            $condition = " and date_format(item_stock.date,'%Y-%m-%d') between '" . $start_date . "' and '" . $end_date . "'";
        }


        $sql = "SELECT `item_stock`.*, `item`.`name`, `item`.`item_category_id`, `item`.`description` as `des`, `item_category`.`item_category`, `item_supplier`.`item_supplier`, `item_store`.`item_store` FROM `item_stock` JOIN `item` ON `item`.`id` = `item_stock`.`item_id` JOIN `item_category` ON `item`.`item_category_id` = `item_category`.`id` JOIN `item_supplier` ON `item_stock`.`supplier_id` = `item_supplier`.`id` LEFT OUTER JOIN `item_store` ON `item_store`.`id` = `item_stock`.`store_id` where 1 " . $condition . " ORDER BY `item_stock`.`id` DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

}

?>