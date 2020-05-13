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
        <link href="<?php echo base_url(); ?>backend/images/s-favican.png" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/jquery.mCustomScrollbar.min.css">
        <style type="text/css">
            .width100, .width50{font-size: 12px !important;}  
            .discover{margin-top: -90px;position: relative;z-index: -1;}
            /*.form-bottom {box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.35);}*/
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
                      background: linear-gradient(to right, rgba(72, 72, 72, 0.02) 1%,rgba(37, 37, 37, 0.67) 30%,rgba(73, 73, 73, 0) 100%);
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
                background-color: rgba(0, 0, 0, 0.80);
            }
            .col-md-offset-3 { margin-left: 29%;}

            .loginbg {
                background: rgba(0, 0, 0, 0.81);
                max-height: 440px;
                box-shadow: 0px 7px 12px rgba(0, 0, 0, 0.29);
                border-radius: 4px;
            }
            .loginright {
                text-align: left;
                color: #fff;
                max-height: 385px;
                /* padding-right: 20px; */
                overflow: auto;
                position: relative;
                width: 100%;
                max-width: 100%;
                height: 385px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            .logdivider {
                background: rgba(255, 253, 253, 0.7);
                clear: both;
                width: 100%;
                height: 1px;
                margin: 15px 0 15px;
            }

            .separatline {
                margin-left: 30px;
                width: 1px;
                height: 450px;
                background: rgba(255, 253, 253, 0.7);
            }
            .loginright h3 {
                font-size: 22px;
                color: #eae8e8;
                margin-top: 10px;
                line-height: normal;
                font-weight: 500;
                padding-bottom: 10px;
            }
            .col-md-offset-3 { margin-left: 29%;}
            a.forgot {padding-top:0px;}
            @media (max-width: 767px) {
                .separatline {
                    margin-left: 0;
                    width: 100%;
                    height: 2px;
                    margin: 35px auto 0px auto;
                }
                .col-md-offset-3 {margin-left: 0;}
            }
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
                        <div class="col-lg-5 col-sm-5 <?php echo $offset; ?> form-box">
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
                                        <img src="<?php echo $logo_image; ?>" class="logowidth">

                                    </div>
                                    <div class="form-top-right"> <i class="fa fa-key"></i>
                                    </div>
                                </div>
                                <div class="form-bottom">
                                    <h3 class="font-white"><?php echo $this->lang->line('user_login'); ?></h3>
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
                                    <form action="<?php echo site_url('site/userlogin') ?>" method="post">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="form-group">
                                            <label class="sr-only" for="form-username">
                                                <?php echo $this->lang->line('username'); ?></label>
                                            <input type="text" name="username" placeholder="<?php echo $this->lang->line('username'); ?>" class="form-username form-control" id="email"> <span class="text-danger"><?php echo form_error('username'); ?></span>
                                        </div>
                                        <div class="form-group">                                        
                                            <input type="password" name="password" placeholder="<?php echo $this->lang->line('password'); ?>" class="form-password form-control" id="password"> <span class="text-danger"><?php echo form_error('password'); ?></span>
                                        </div>
                                        <button type="submit" class="btn">
                                            <?php echo $this->lang->line('sign_in'); ?></button>
                                    </form>
                                    <br>
                                    <p><a href="<?php echo site_url('site/ufpassword') ?>"  class="forgot"> <i class="fa fa-key"></i> <?php echo $this->lang->line('forgot_password'); ?></a> </p> 
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
                            </div><!--./col-lg-6-->
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.mCustomScrollbar.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.mousewheel.min.js"></script>
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
