<?php

class Cron extends CI_Controller {

    public function __construct($key = "") {
        parent::__construct();
        $setting_result = $this->setting_model->getSetting();
        $this->cron_key = $setting_result->cron_secret_key;
        $this->cron_key;
    }

    public function index($key = "") {
        if ($key != "" && $this->cron_key == $key) {

            $this->autobackup($key);
            $this->expMedicineNotification($key);
            $this->outofStockMedicineNotification($key);
            $this->lowStockMedicineNotification($key);
        } else {
            echo "Invalid Key or Direct access is not allowed";
            return;
        }
    }

    public function autobackup($key = '') {

        if ($this->cron_key == $key) {

            $this->load->dbutil();
            $filename = "db-" . date("Y-m-d_H-i-s") . ".sql";
            $prefs = array(
                'ignore' => array(),
                'format' => 'txt',
                'filename' => 'mybackup.sql',
                'add_drop' => TRUE,
                'add_insert' => TRUE,
                'newline' => "\n"
            );
            $backup = $this->dbutil->backup($prefs);
            $this->load->helper('file');
            write_file('./backup/database_backup/' . $filename, $backup);
            echo "success";
        } else {

            echo "Please pass Cron Secret Key or passed Cron Secret Key is not valid";
        }
    }

    public function expMedicineNotification($key = '') {

        if (($key == "") || ($this->cron_key != $key)) {
            echo "Invalid Key or Direct access is not allowed";
            return;
        }

        $staff_roles = array();
        $result = $this->expmedicine_model->getList();
        $data['list'] = $result;
        $medicine_data = array();

        if (sizeof($result) > 0) {
            $i = 0;
            foreach ($result as $value) {
                $pharmacy_id = $value['id'];
                $medicine_name = $value['medicine_name'];
                $medicine_data[] = $medicine_name;
                $i++;
            }

            $roleresult = $this->staff_model->getStaffbyrole($id = 7);
            if (!empty($roleresult)) {
                $staff_roles[] = array('role_id' => 7, 'send_notification_id' => '');
                foreach ($roleresult as $key => $value) {
                    for ($i = 0; $i < sizeof($medicine_data); $i++) {
                        $notification_data = array('notification_title' => 'Medicine Expire Alert',
                            'notification_desc' => 'Medicine ' . $medicine_data[$i] . ' Expire Alert',
                            'notification_for' => 'Super Admin',
                            'receiver_id' => $value["id"],
                            'date' => date("Y-m-d H:i:s"),
                            'is_active' => 'yes',
                        );

                        $send_data = array(
                            'message' => 'Medicine Expire Alert',
                            'title' => 'Medicine ' . $medicine_data[$i] . ' Expire Alert',
                            'date' => date('Y-m-d'),
                            'created_by' => 'admin',
                            'created_id' => 0,
                            'visible_student' => 'No',
                            'visible_staff' => 'Yes',
                            'visible_parent' => 'No',
                            'publish_date' => date('Y-m-d'),
                        );


                        $this->notification_model->insertBatch($send_data, $staff_roles);
                    }
                }
            }
        } else {
            
        }
    }

    public function outofStockMedicineNotification($key = "") {


        if (($key == "") || ($this->cron_key != $key)) {
            echo "Invalid Key or Direct access is not allowed";
            return;
        }

        $staff_roles = array();
        $medicine_data = array();
        $resultlist = $this->pharmacy_model->searchFullText();
        $i = 0;
        if (!empty($resultlist)) {
            foreach ($resultlist as $value) {
                $pharmacy_id = $value['id'];
                $medicine_name = $value['medicine_name'];
                $available_qty = $this->pharmacy_model->totalQuantity($pharmacy_id);
                $totalAvailableQty = $available_qty['total_qty'];
                $resultlist[$i]["total_qty"] = $totalAvailableQty;

                if ($totalAvailableQty <= 0) {
                    $medicine_data[] = $medicine_name;
                } elseif ($totalAvailableQty <= $min_level) {
                    
                } else if ($totalAvailableQty <= $reorder_level) {
                    
                }

                $i++;
            }

            $roleresult = $this->staff_model->getStaffbyrole($id = 7);

            if (!empty($roleresult)) {
                $staff_roles[] = array('role_id' => 7, 'send_notification_id' => '');

                foreach ($roleresult as $key => $value) {
                    for ($i = 0; $i < sizeof($medicine_data); $i++) {

                        $notification_data = array('notification_title' => 'Medicine Out of Stock Alert',
                            'notification_desc' => 'Medicine ' . $medicine_data[$i] . ' Out of Stock Alert',
                            'notification_for' => 'Super Admin',
                            'receiver_id' => $value["id"],
                            'date' => date("Y-m-d H:i:s"),
                            'is_active' => 'yes',
                        );

                        $send_data = array(
                            'message' => 'Medicine Out of Stock Alert',
                            'title' => 'Medicine ' . $medicine_data[$i] . ' Out of Stock Alert',
                            'date' => date('Y-m-d'),
                            'created_by' => 'admin',
                            'created_id' => 0,
                            'visible_student' => 'No',
                            'visible_staff' => 'Yes',
                            'visible_parent' => 'No',
                            'publish_date' => date('Y-m-d'),
                        );


                        $this->notification_model->insertBatch($send_data, $staff_roles);
                    }
                }
            }
        }
    }

    public function lowStockMedicineNotification($key = "") {


        if (($key == "") || ($this->cron_key != $key)) {
            echo "Invalid Key or Direct access is not allowed";
            return;
        }

        $staff_roles = array();
        $medicine_data = array();
        $resultlist = $this->pharmacy_model->searchFullText();
        $i = 0;
        if (!empty($resultlist)) {
            foreach ($resultlist as $value) {
                $pharmacy_id = $value['id'];
                $medicine_name = $value['medicine_name'];
                $min_level = $value['min_level'];
                $reorder_level = $value['reorder_level'];
                $available_qty = $this->pharmacy_model->totalQuantity($pharmacy_id);
                $totalAvailableQty = $available_qty['total_qty'];
                $resultlist[$i]["total_qty"] = $totalAvailableQty;


                if ($totalAvailableQty <= 0) {
                    
                } elseif ($totalAvailableQty <= $min_level) {

                    $medicine_data[] = $medicine_name;
                } else if ($totalAvailableQty <= $reorder_level) {
                    
                }

                $i++;
            }

            $roleresult = $this->staff_model->getStaffbyrole($id = 7);


            if (!empty($roleresult)) {

                $staff_roles[] = array('role_id' => 7, 'send_notification_id' => '');

                foreach ($roleresult as $key => $value) {

                    for ($i = 0; $i < sizeof($medicine_data); $i++) {

                        $notification_data = array('notification_title' => 'Low Medicine Stock Alert',
                            'notification_desc' => 'Medicine ' . $medicine_data[$i] . ' low stock Alert',
                            'notification_for' => 'Super Admin',
                            'receiver_id' => $value["id"],
                            'date' => date("Y-m-d H:i:s"),
                            'is_active' => 'yes',
                        );



                        $send_data = array(
                            'message' => 'Low Medicine Stock Alert',
                            'title' => 'Medicine ' . $medicine_data[$i] . ' low stock Alert',
                            'date' => date('Y-m-d'),
                            'created_by' => 'admin',
                            'created_id' => 0,
                            'visible_student' => 'No',
                            'visible_staff' => 'Yes',
                            'visible_parent' => 'No',
                            'publish_date' => date('Y-m-d'),
                        );


                        $this->notification_model->insertBatch($send_data, $staff_roles);
                    }
                }
            }
        }
    }

}

?>