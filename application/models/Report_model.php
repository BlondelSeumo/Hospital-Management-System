<?php

class Report_model extends CI_Model {

    public function getReport($select = '', $join = array(), $table_name, $additional_where = array()) {
        if (empty($additional_where)) {
            $additional_where = array(" 1 = 1");
        }

        if (!empty($join)) {
            $query = "select " . $select . " from " . $table_name . " " . implode(" ", $join) . " where " . implode("and ", $additional_where);
        } else {
            $query = "select " . $select . " from " . $table_name . " where" . implode("and ", $additional_where);
        }

        $res = $this->db->query($query);
        return $res->result_array();
    }

    public function searchReport($select, $join = array(), $table_name, $search_type, $search_table, $search_column, $additional_where = array()) {

        if ($search_type == 'period') {
            $this->form_validation->set_rules('date_from', $this->lang->line('date_from'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_to', $this->lang->line('date_to'), 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                echo form_error();
            } else {
                $from_date = $this->input->post('date_from');
                $to_date = $this->input->post('date_to');

                $date_from = date("Y-m-d", $this->customlib->datetostrtotime($from_date));
                $date_to = date("Y-m-d 23:59:59.993", $this->customlib->datetostrtotime($to_date));
                $where = array($search_table . "." . $search_column . " >=  '" . $date_from . "' ", $search_table . "." . $search_column . " <=  '" . $date_to . "'");
            }
        } else if ($search_type == 'today') {

            $today = strtotime('today 00:00:00');

            $first_date = date('Y-m-d H:i:s', $today);


            $where = array($search_table . "." . $search_column . " = '" . $first_date . "'");
        } else if ($search_type == 'this_week') {

            $this_week_start = strtotime('-1 week monday 00:00:00');
            $this_week_end = strtotime('sunday 23:59:59');

            $first_date = date('Y-m-d H:i:s', $this_week_start);
            $last_date = date('Y-m-d H:i:s', $this_week_end);

            $where = array($search_table . "." . $search_column . " >= '" . $first_date . "'", $search_table . "." . $search_column . "<= '" . $last_date . "'");
        } else if ($search_type == 'last_week') {

            $last_week_start = strtotime('-2 week monday 00:00:00');
            $last_week_end = strtotime('-1 week sunday 23:59:59');

            $first_date = date('Y-m-d H:i:s', $last_week_start);
            $last_date = date('Y-m-d H:i:s', $last_week_end);

            $where = array($search_table . "." . $search_column . " >= '" . $first_date . "'", $search_table . "." . $search_column . "<= '" . $last_date . "'");
        } else if ($search_type == 'this_month') {
            $first_date = date('Y-m-01');
            $last_date = date('Y-m-t 23:59:59.993');
            $where = array($search_table . "." . $search_column . " >= '" . $first_date . "'", $search_table . "." . $search_column . "<= '" . $last_date . "'");
        } else if ($search_type == 'last_month') {
            $month = date("m", strtotime("-1 month"));
            $first_date = date('Y-' . $month . '-01');
            $last_date = date('Y-' . $month . '-' . date('t', strtotime($first_date)) . ' 23:59:59.993');
            $where = array($search_table . "." . $search_column . ">= '" . $first_date . "'", $search_table . "." . $search_column . "<= '" . $last_date . "'");
        } else if ($search_type == 'last_3_month') {
            $month = date("m", strtotime("-2 month"));
            $first_date = date('Y-' . $month . '-01');
            $firstday = date('Y-' . 'm' . '-01');
            $last_date = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)) . ' 23:59:59.993');
            $where = array($search_table . "." . $search_column . ">= '" . $first_date . "'", $search_table . "." . $search_column . "<= '" . $last_date . "'");
        } else if ($search_type == 'last_6_month') {
            $month = date("m", strtotime("-5 month"));
            $first_date = date('Y-' . $month . '-01');
            $firstday = date('Y-' . 'm' . '-01');
            $last_date = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)) . ' 23:59:59.993');
            $where = array($search_table . "." . $search_column . ">= '" . $first_date . "'", $search_table . "." . $search_column . "<= '" . $last_date . "'");
        } else if ($search_type == 'last_12_month') {
            $first_date = date('Y-m' . '-01', strtotime("-11 month"));
            $firstday = date('Y-' . 'm' . '-01');
            $last_date = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)) . ' 23:59:59.993');
            $where = array($search_table . "." . $search_column . ">= '" . $first_date . "'", $search_table . "." . $search_column . "<= '" . $last_date . "'");
        } else if ($search_type == 'last_year') {
            $search_year = date('Y', strtotime("-1 year"));
            $where = array("year(" . $search_table . "." . $search_column . ") = '" . $search_year . "'");
        } else if ($search_type == 'this_year') {

            $search_year = date('Y');
            $where = array("year(" . $search_table . "." . $search_column . ") = '" . $search_year . "'");
        } else if ($search_type == 'all time') {
            $where = array();
        }

        if (empty($additional_where)) {
            $additional_where = array('1 = 1');
        }

        if (!empty($where)) {
            $query = "select " . $select . " from " . $table_name . " " . implode(" ", $join) . " where " . implode(" and ", $where) . " and " . implode(" and ", $additional_where) . " order by " . $search_table.".".$search_column;
        } else {
            $query = "select " . $select . " from " . $table_name . " " . implode(" ", $join) . " where " . implode("  and ", $additional_where) . " order by " . $search_table.".".$search_column;
        }

        $res = $this->db->query($query);

        return $res->result_array();
    }


    public function searchReportexpiry($select, $join = array(), $table_name, $search_type, $search_table, $search_column, $additional_where = array()) {

        $this_mnt = $first_date = date('M/Y');
        // $this_mnt1 = $first_date = date('M/Y',strtotime('-11 month'));
        // print_r($this_mnt1);
        // exit();

        for($i=1;$i<=11;$i++){

            $last_year[] = $search_table . "." . $search_column ."='".date('M/Y',strtotime("-".$i."  month"))."'";
            $this_year[] = $search_table . "." . $search_column ."='". date('M/Y',strtotime("+".$i."  month"))."'";
        }
        // print_r($this_year);
        // exit();
        // if ($search_type == 'period') {

        //     $this->form_validation->set_rules('date_from', $this->lang->line('date_from'), 'trim|required|xss_clean');
        //     $this->form_validation->set_rules('date_to', $this->lang->line('date_to'), 'trim|required|xss_clean');
        //     if ($this->form_validation->run() == FALSE) {
        //         echo form_error();
        //     } else {
        //         $from_date = $this->input->post('date_from');
        //         $to_date = $this->input->post('date_to'); 

        //     $date_f = date('M-Y',strtotime('01-'.$from_date));
        //     $date_t = date('M-Y',strtotime('01-'.$to_date));
        //     $date1=date_create("01-".$date_f);
        //     $date2=date_create("01-".$date_t);
        //     $diff=date_diff($date1,$date2);
        //     $monthdiff = $diff->format("%R%M");
           
        //     $rest1 = substr($monthdiff, -3,1);
        //     $rest2 = substr($monthdiff, -2);
       
        //     for($i=0;$i<=$rest2;$i++){

        //         $time_period[] = $search_table . "." . $search_column ."='".date('M/Y',strtotime($rest1.$i."  month"))."'";
                    
        //     }
        //     $where = $time_period;
        //     }

        // } 
        if ($search_type == 'this_month') {
            $where = array($search_table . "." . $search_column . " = '" . $this_mnt . "'", $search_table . "." . $search_column . " = '" . $this_mnt . "'");
        } else if ($search_type == 'last_month') {
           
            $where = array($last_year[0]);
        } else if ($search_type == 'last_3_month') {
          
          $where = array($last_year[0],$last_year[1],$last_year[2]);
        } else if ($search_type == 'last_6_month') {
           
            $where = array($last_year[0],$last_year[1],$last_year[3],$last_year[4],$last_year[5],$last_year[6]);
        } else if ($search_type == 'last_year') {
           
            $where = $last_year;
        } else if ($search_type == 'this_year') {
            
            $where = $this_year;
        } else if ($search_type == 'all time') {
            $where = array();
        }
        if (empty($additional_where)) {
            $additional_where = array('1 = 1');
        }

        if (!empty($where)) {
            // $query = "select " . $select . " from " . $table_name . " " . implode(" ", $join) . " where " . implode(" and ", $where) . " and " . implode(" and ", $additional_where) . " order by " . $search_table.".".$search_column;
             $query = "select " . $select . " from " . $table_name . " " . implode(" ", $join) . " where " . implode(" or ", $where)  . " order by " . $search_table.".".$search_column;
         
        } else {
            $query = "select " . $select . " from " . $table_name . " " . implode(" ", $join) . " where " . implode("  and ", $additional_where) . " order by " . $search_table.".".$search_column;
        }

        $res = $this->db->query($query);

        return $res->result_array();
    }

    public function transactionReport($select = '', $join = array(), $table_name, $additional_where = array()) {
        if (empty($additional_where)) {
            $additional_where = array(" 1 = 1");
        }

        if (!empty($join)) {
            $query = "select " . $select . " from " . $table_name . " " . implode(" ", $join) . " where " . implode("and ", $additional_where);
        } else {
            $query = "select " . $select . " from " . $table_name . " where" . implode("and ", $additional_where);
        }

        $res = $this->db->query($query);
        return $res->result_array();
    }

}

?>