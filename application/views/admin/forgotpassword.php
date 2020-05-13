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
            .bgwhite{ background: #e4e5e7;
                      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.5);overflow: auto;border-radius: 6px;}
            .llpb20{padding-bottom: 20px;}
            .around40{padding: 40px;}
            .formbottom2{text-align: left;border: 1px solid #e4e4e4;}
            button.btn:hover {opacity: 100 !important; color: #fff;background: #424242;}
            .form-top2 {text-align: left;}
            .img2{width: 100%}
            .spacingmb30{margin-bottom: 30px;}
            .borderR{border-right: 1px solid rgba(66, 66, 66, 0.16);padding: 0px 40px;}
            input[type="text"], input[type="password"], textarea, textarea.form-control {
                height: 40px;border: 1px solid #999;}
            input[type="text"]:focus, input[type="password"]:focus, textarea:focus, textarea.form-control:focus {
                border: 1px solid #424242;}
            button.btn {height: 40px;line-height: 40px;}
            .ispace{ padding-right:5px;}
            .form-top {background:#39f;
                       box-shadow: 0px 7px 12px rgba(0, 0, 0, 0.29);
                       border-bottom: 1px solid rgba(255, 255, 255, 0.19);}
            .form-bottom{background: #39f;box-shadow: 0px 7px 12px rgba(0, 0, 0, 0.29);}
            .font-white{color: #fff;}
            .form-bottom {padding: 25px 25px 15px 25px;}
            button.btn {
                margin: 0;
                padding: 0 20px;
                vertical-align: middle;
                background: #ff9800;
                border: 0;
                font-family: 'Roboto', sans-serif;
                font-size: 16px;
                font-weight: 400;
                color: #fff;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                border-radius: 4px;
                text-shadow: none;
                -moz-box-shadow: none;
                -webkit-box-shadow: none;
                box-shadow: none;
                -o-transition: all .3s;
                -moz-transition: all .3s;
                -webkit-transition: all .3s;
                -ms-transition: all .3s;
                transition: all .3s;
            }
            button.btn:hover {opacity: 100 !important; color: #fff;background: #fbc02d;}
            a.forgot {padding-top:15px; color: #b0de37;}
            a:hover.forgot {color: #fff; text-decoration: underline;}
        </style>
    </head>
    <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
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
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3 class="font-white"><?php echo $this->lang->line('forgot_password'); ?></h3>

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
                                <form action="<?php echo site_url('site/forgotpassword') ?>" method="post">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username"><?php echo $this->lang->line('email'); ?></label>
                                        <input type="text" name="email" placeholder="<?php echo $this->lang->line('email'); ?>" class="form-username form-control" id="form-username">
                                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                                    </div>
                                    <button type="submit" class="btn"><?php echo $this->lang->line('submit'); ?></button>
                                </form>
                                <a href="<?php echo site_url('site/login') ?>" class="forgot"><i class="fa fa-key"></i> <?php echo $this->lang->line('admin_login'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.backstretch.min.js"></script>
        <!-- <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/scripts.js"></script> -->
        <!--[if lt IE 10]>
            <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/placeholder.js"></script>
        <![endif]-->
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url(); ?>';
        $.backstretch([
            base_url + "backend/usertemplate/assets/img/backgrounds/11.jpg"
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