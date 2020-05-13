<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#424242" />
        <?php
        $titleresult = $this->customlib->getTitleName();
        if (!empty($titleresult["name"])) {
            $title_name = $titleresult["name"];
        } else {
            $title_name = "Hospital Name Title";
        }
        ?>
        <title><?php echo $title_name; ?></title>
        <!--favican-->
        <link href="<?php echo base_url(); ?>backend/images/s-favican.png" rel="shortcut icon" type="image/x-icon">
        <!-- CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/style.css">
        <style type="text/css">

            .inner-bg {padding: 10px 0 170px 0;}
            body{background: #424242;}        
            .discover{margin-top: -90px;position: relative;z-index: -1;}
            .form-bottom {box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.35); padding-bottom: 10px !important}
            .gradient{margin-top: 40px;text-align: right;padding: 10px;background: rgb(72,72,72);
                      background: -moz-linear-gradient(left, rgba(72,72,72,1) 1%, rgba(73,73,73,1) 44%, rgba(73,73,73,1) 100%);
                      background-image: linear-gradient(to right, rgba(72, 72, 72, 0.23) 1%, rgba(37, 37, 37, 0.64) 44%, rgba(73, 73, 73, 0) 100%);
                      background-position-x: initial;
                      background-position-y: initial;
                      background-size: initial;
                      background-repeat-x: initial;
                      background-repeat-y: initial;
                      background-attachment: initial;
                      background-origin: initial;
                      background-clip: initial;
                      background-color: initial;
                      background: -webkit-linear-gradient(left, rgba(72,72,72,1) 1%,rgb(73, 73, 73) 44%,rgba(73,73,73,1) 100%);
                      background: linear-gradient(to right, rgba(72, 72, 72, 0.23) 1%,rgba(37, 37, 37, 0.64) 44%,rgba(73, 73, 73, 0) 100%);
                      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#484848', endColorstr='#494949',GradientType=1 );}        
            @media (min-width: 320px) and (max-width: 991px){
                .width100{width: 100% !important;display: block !important;
                          float: left !important; margin-bottom: 5px !important;
                          border-radius: 2px !important;}
                .width50{width: 50% !important;
                         margin-bottom: 5px !important;
                         display: block !important;
                         border-radius:2px 0px 0px 2px !important;
                         float: left !important;
                         margin-left: 0px !important; }
                .widthright50{width: 50% !important;
                              display: block !important;
                              margin-bottom: 5px !important;
                              border-radius: 0px 2px 2px 0px !important;
                              float: left !important;margin-left: 0px !important;} }
            input[type="text"], input[type="password"], textarea, textarea.form-control {
                height: 40px;border: 1px solid #999;}

            input[type="text"]:focus, input[type="password"]:focus, textarea:focus, textarea.form-control:focus {border: 1px solid #424242;}

            button.btn {height: 40px;line-height: 40px;}
            .logowidth{padding-right: 120px;/* height: 50px;*/}        
            @media(max-width:767px){
                .discover{margin-top: 10px}
                .gradient {text-align: center;}
                .logowidth{padding-right:0px;}     
            }  
            @media(min-width:768px) and (max-width:992px){
                .discover{margin-top: 10px}
                .logowidth{padding-right:0px;} 
                .gradient {text-align: center;}  
            }

            .bgwhite{ background: #e4e5e7;
                      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.5);overflow: auto;border-radius: 6px;}


            label.radio-inline{font-size: 14px;}
            .radio-inline input[type=radio]{position: absolute; margin-top: 8px; outline: none;}
            .backstretch{position: relative;}
            .backstretch:after {
                position: absolute;
                z-index: 2;
                width: 100%;
                height: 100%;
                display: block;
                left: 0;
                top: 0;
                content: "";
                background-color: rgba(16, 16, 16, 0.70);
            }
        </style>
    </head>
    <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text">
                            <div class="gradient">

                                <?php
                                $logoresult = $this->customlib->getLogoImage();
                                if (!empty($logoresult["image"])) {
                                    $logo_image = base_url() . "uploads/hospital_content/logo/" . $logoresult["image"];
                                } else {
                                    $logo_image = base_url() . "uploads/hospital_content/logo/s_logo.png";
                                }
                                if (!empty($logoresult["mini_logo"])) {
                                    $mini_logo = base_url() . "uploads/hospital_content/logo/" . $logoresult["mini_logo"];
                                } else {
                                    $mini_logo = base_url() . "uploads/hospital_content/logo/smalllogo.png";
                                }
                                ?>
                                <div class="">
                                    <img src="<?php echo $logo_image; ?>" class="logowidth">
                                </div>
                                    <!--<img src="<?php echo base_url(); ?>backend/images/s_logo.png" class="logowidth">-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3 class="font-white"><?php echo $this->lang->line('reset_password'); ?></h3>

                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>
                                <form action="<?php echo site_url('user/resetpassword/' . $role . '/' . $verification_code) ?>" method="post">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <div class="form-group">
                                        <label class="sr-only"><?php echo $this->lang->line('password'); ?></label>
                                        <input type="password" name="password" placeholder="<?php echo $this->lang->line('password'); ?>" class="form-password form-control" id="form-password">
                                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only"><?php echo $this->lang->line('confirm_password'); ?></label>
                                        <input type="password" name="confirm_password" placeholder="<?php echo $this->lang->line('confirm_password'); ?>" class="form-control" id="form-confirm_password">
                                        <span class="text-danger"><?php echo form_error('confirm_password'); ?></span>
                                    </div>
                                    <button type="submit" class="btn"><?php echo $this->lang->line('submit'); ?></button>
                                </form>
                                <a href="<?php echo site_url('site/userlogin') ?>" class="forgot"><i class="fa fa-key"></i> <?php echo $this->lang->line('user_login'); ?></a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 discover">
                            <img src="<?php echo base_url(); ?>backend/usertemplate/assets/img/backgrounds/discover.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.backstretch.min.js"></script>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url(); ?>';
        $.backstretch([
            base_url + "backend/usertemplate/assets/img/backgrounds/user15.jpg"
        ], {duration: 3000, fade: 750});
        $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function () {
            $(this).removeClass('input-error');
        });
        $('.login-form').on('submit', function (e) {
            $(this).find('input[type="text"], input[type="password"], textarea').each(function () {
                if ($(this).val() == "") {
                    e.preventDefault();
                    $(this).addClass('input-error');
                } else {
                    $(this).removeClass('input-error');
                }
            });
        });
    });
</script>