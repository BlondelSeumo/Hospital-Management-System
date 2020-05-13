<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Msgnineone {

    private $_CI;
    public $route = "4";
    public $authKey = "";
    public $senderId = "";
    public $url = "https://control.msg91.com/api/sendhttp.php";

    function __construct($array) {
        $this->_CI = & get_instance();

        $this->authKey = $array['authkey'];
        $this->senderId = $array['senderid'];
    }

    function sendSMS($to, $message) {
        $postData = array(
            'authkey' => $this->authKey,
            'mobiles' => $to,
            'message' => $message,
            'sender' => $this->senderId,
            'route' => $this->route
        );

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
        ));
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            //echo 'error:' . curl_error($ch);
        }
        curl_close($ch);

        return true;
    }

}

?>