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
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/jquery.mCustomScrollbar.min.css">
        <style type="text/css">
            .col-md-offset-3 { margin-left: 29%;}
            .loginbg {
                background: #39f;
                max-height: 480px;
                box-shadow:0 10px 18px 0 rgba(62, 57, 107, 0.2);
                border-radius: 4px;
            }

            a.forgot {padding-top:0px;}
            a.forgot {padding-top:0px; color: #b0de37;}
            a:hover.forgot {padding-top:0px; color: #fff; text-decoration: underline;}

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
            @media (max-width: 767px){.col-md-offset-3 {margin-left: 0;}}
        </style>

    </head>
    <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <?php
                        $empty_notice = 0;
                        $offset = "";
                        if (empty($notice)) {
                            $empty_notice = 1;
                            $offset = "col-md-offset-3";
                        }
                        ?>
                        <div class="col-lg-5 col-sm-5 form-box <?php echo $offset; ?>">
                            <div class="loginbg">  
                                <div class="form-top">
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
                                    <div class="form-top-left">
                                        <img src="<?php echo $logo_image; ?>" style="height: 30px;">    
                                    </div>
                                    <div class="form-top-right">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </div>

                                <div class="form-bottom">
                                    <h3 class="font-white bolds"><?php echo $this->lang->line('admin_login'); ?></h3>
                                    <?php
                                    if (isset($error_message)) {
                                        echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                    }
                                    ?>
                                    <?php
                                    if ($this->session->flashdata('message')) {
                                        echo "<div class='alert alert-success'>" . $this->session->flashdata('message') . "</div>";
                                    };
                                    ?>

                                    <form action="<?php echo site_url('site/login') ?>" method="post">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="form-group">                                            
                                            <input type="text" name="username" placeholder="<?php echo $this->lang->line('username'); ?>" value="" class="form-username form-control" id="email">
                                            <span class="text-danger"><?php echo form_error('username'); ?></span>
                                        </div>
                                        <div class="form-group">                                           
                                            <input type="password" value="" name="password" placeholder="<?php echo $this->lang->line('password'); ?>" class="form-password form-control" id="password">
                                            <span class="text-danger"><?php echo form_error('password'); ?></span>
                                        </div>
                                        <button type="submit" class="btn"><?php echo $this->lang->line('sign_in'); ?></button>
                                    </form>
                                    <br>
                                    <p><a href="<?php echo site_url('site/forgotpassword') ?>" class="forgot"><i class="fa fa-key"></i> <?php echo $this->lang->line('forgot_password'); ?>?</a> </p> 

                                </div>
                            </div>
                        </div>
                        <?php
                        if (!$empty_notice) {
                            ?>
                            <div class="col-lg-1 col-sm-1"><div class="separatline"></div></div> 
                            <div class="col-lg-6 col-sm-6 col-sm-6">
                                <div class="loginright form-box  mCustomScrollbar">
                                    <div class="messages"> 

                                        <h3><?php echo $this->lang->line('what_is_new_in'); ?> <?php echo $school['name']; ?></h3>
                                        <?php
                                        foreach ($notice as $notice_key => $notice_value) {
                                            ?>
                                            <h4><?php echo $notice_value['title']; ?></h4>

                                            <?php
                                            $string = ($notice_value['description']);
                                            $string = strip_tags($string);
                                            if (strlen($string) > 100) {

                                                // truncate string
                                                $stringCut = substr($string, 0, 100);
                                                $endPoint = strrpos($stringCut, ' ');

                                                //if the string doesn't contain any space then it will cut without word basis.
                                                $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                $string .= '... <a class=more href="' . site_url('read/' . $notice_value['slug']) . '">Read More</a>';
                                            }
                                            echo '<p>' . $string . '</p>';
                                            ?>

                                            <div class="logdivider"></div>
                                            <?php
                                        }
                                        ?>





                                    </div>  
                                </div>
                                    <!-- <img src="<?php echo base_url(); ?>backend/usertemplate/assets/img/backgrounds/bg3.jpg" class="img-responsive" style="border-radius:4px;" /> -->
                            </div><!--./col-lg-6-->
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.mCustomScrollbar.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.mousewheel.min.js"></script>

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
