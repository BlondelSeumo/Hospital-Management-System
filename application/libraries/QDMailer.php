<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class QDMailer {

    public function __construct() {
        require_once('PHPMailer/PHPMailerAutoload.php');
    }

}
