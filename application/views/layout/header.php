<!DOCTYPE html>
<html <?php //echo $this->customlib->getRTL();     ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->customlib->getAppName(); ?></title>       
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="theme-color" content="#5190fd" />
        <link href="<?php echo base_url(); ?>backend/images/s-favican.png" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css">    
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/style-main.css"> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/jquery.mCustomScrollbar.min.css"> 
        <?php
        $this->load->view('layout/theme');
        ?>
        <?php
        if ($this->customlib->getRTL() != "") {
            ?>
            <!-- Bootstrap 3.3.5 RTL -->
            <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/bootstrap-rtl/css/bootstrap-rtl.min.css"/> <!-- Theme RTL style -->
            <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/AdminLTE-rtl.min.css" />
            <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/ss-rtlmain.css">
            <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/skins/_all-skins-rtl.min.css" />
            <?php
        }
        ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/all.css">   
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/font-awesome.min.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/ionicons.min.css">       
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/iCheck/flat/blue.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/morris/morris.css">       
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">        
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/datepicker/datepicker3.css"> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/colorpicker/bootstrap-colorpicker.css"> 

        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/daterangepicker/daterangepicker-bs3.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/custom_style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/datepicker/css/bootstrap-datetimepicker.css">
        <!--file dropify-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/dropify.min.css">
        <!--file nprogress-->
        <link href="<?php echo base_url(); ?>backend/dist/css/nprogress.css" rel="stylesheet">

        <!--print table-->
        <link href="<?php echo base_url(); ?>backend/dist/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend/dist/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend/dist/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <!--print table mobile support-->
        <link href="<?php echo base_url(); ?>backend/dist/datatables/css/responsive.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend/dist/datatables/css/rowReorder.dataTables.min.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>backend/custom/jquery.min.js"></script>

        <script src="<?php echo base_url(); ?>backend/plugins/colorpicker/bootstrap-colorpicker.js"></script>
        <script src="<?php echo base_url(); ?>backend/datepicker/date.js"></script>       
        <script src="<?php echo base_url(); ?>backend/dist/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/js/school-custom.js"></script>
        <!-- fullCalendar -->
        <link rel="stylesheet" href="<?php echo base_url() ?>backend/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>backend/fullcalendar/dist/fullcalendar.print.min.css" media="print">

        <link rel="stylesheet" href="<?php echo base_url() ?>backend/plugins/select2/select2.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and me/-->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

    </head>
    <script type="text/javascript">


        var baseurl = "<?php echo base_url(); ?>";
        var chk_validate = "<?php echo $this->config->item('SHLK') ?>";
    </script>

    <body class="hold-transition skin-blue fixed sidebar-mini" >
        <?php
        if ($this->config->item('SHLK') == "") {
            ?>
            <div class="topaleart">
                <div class="slidealert">
                    <div class="alert alert-dismissible topaleart-inside">
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button> -->
                        <p class="palert">Alert! You are using unregistered version of Smart Hospital. Please <a  href="#" class="purchasemodal">click here</a> to register your purchase code for Smart Hospital.</p>
                    </div></div>
            </div>
            <?php
        }
        ?>
        <script type="text/javascript">

            function delete_recordById(url, Msg) {
                if (confirm(<?php echo "'" . $this->lang->line('delete_conform') . "'"; ?>)) {
                    $.ajax({
                        url: url,
                        success: function (res) {
                            successMsg(Msg);
                            window.location.reload(true);
                        }
                    })
                }
            }
            function collapseSidebar() {

                if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
                    sessionStorage.setItem('sidebar-toggle-collapsed', '');
                } else {
                    sessionStorage.setItem('sidebar-toggle-collapsed', '1');
                }

            }

            function checksidebar() {
                if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
                    var body = document.getElementsByTagName('body')[0];
                    body.className = body.className + ' sidebar-collapse';
                }
            }
            checksidebar();
        </script>
        <!--         <body class="hold-transition skin-blue fixed sidebar-mini sidebar-collapse"> -->
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
        <div class="wrapper">
            <header class="main-header" id="alert">            
                <a href="<?php echo base_url(); ?>admin/admin/dashboard" class="logo">                 
                    <span class="logo-mini"><img width="31" height="19" src="<?php echo $mini_logo; ?>" alt="<?php echo $this->customlib->getAppName() ?>" /></span>                 
                    <span class="logo-lg"><img src="<?php echo $logo_image; ?>" alt="<?php echo $this->customlib->getAppName() ?>" /></span>
                </a>             
                <nav class="navbar navbar-static-top" role="navigation">                  
                    <a href="#"  onclick="collapseSidebar()"  class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="col-md-5 col-sm-3 col-xs-5"> 
                        <span href="#" class="sidebar-session">
                            <?php echo $this->setting_model->getCurrentSchoolName(); ?>
                        </span>
                    </div>
                    <div class="col-md-7 col-sm-9 col-xs-7">
                        <div class="pull-right">    
                            <?php if (($this->rbac->hasPrivilege('patient', 'can_view'))) { ?>
                                <form class="navbar-form navbar-left search-form" role="search"  action="<?php echo site_url('admin/admin/search'); ?>" method="POST">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <div class="input-group" style="padding-top:3px;">
                                        <input type="text" name="search_text" class="form-control search-form search-form3" placeholder="<?php echo $this->lang->line('search_by_name'); ?>">
                                        <span class="input-group-btn">
                                            <button type="submit" name="search" id="search-btn" style="padding: 3px 12px !important;border-radius: 0px 30px 30px 0px; background: #fff;" class="btn btn-flat"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>
                            <?php } ?>
                            <div class="navbar-custom-menu">
                                <ul class="nav navbar-nav headertopmenu"> 
                                    <?php if ($this->rbac->hasPrivilege('notification_center', 'can_view')) {
                                         $systemnotifications = $this->notification_model->getUnreadNotification();
                                         if(sizeof($systemnotifications) > 0){
                                     ?>
                                        <li class="cal15"><a href="<?php echo base_url() . "admin/systemnotification" ?>"><i class="fa fa-bell-o"></i>
                                                <?php ?>
                                                <span class="label label-warning"><?php echo sizeof($systemnotifications) ?></span></a></li>
                                    <?php } } ?>
                                    <li class="">
                                        <?php if ($this->rbac->hasPrivilege('bed_status', 'can_view')) { ?><a  data-target="modal" href="#" id='beddata' data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('loading') ?>" onclick="getbedstatus()"><i class="fas fa-bed cal15"></i> <span class="spanDM"><?php echo $this->lang->line('bed') . " " . $this->lang->line('status'); ?></span></a>

                                        </li>
                                        <?php
                                    }
                                    if ($this->module_lib->hasActive('calendar_to_do_list')) {
                                        if ($this->rbac->hasPrivilege('calendar_to_do_list', 'can_view')) {
                                            ?>
                                            <li class="cal15"><a href="<?php echo base_url() ?>admin/calendar/events" title="<?php echo $this->lang->line('calendar') ?>"><i class="fa fa fa-calendar"></i></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    if ($this->module_lib->hasActive('calendar_to_do_list')) {
                                        if ($this->rbac->hasPrivilege('calendar_to_do_list', 'can_view')) {
                                            ?>
                                            <li class="dropdown">
                                                <a href="#" title="<?php echo $this->lang->line('task') ?>" class="dropdown-toggle todoicon" data-toggle="dropdown">
                                                    <i class="fa fa-check-square-o"></i>
                                                    <?php
                                                    $userdata = $this->customlib->getUserData();

                                                    $count = $this->customlib->countincompleteTask($userdata["id"]);
                                                    if ($count > 0) {
                                                        ?>

                                                        <span class="todo-indicator"><?php echo $count ?></span>
                                                    <?php } ?>
                                                </a>
                                                <ul class="dropdown-menu menuboxshadow widthMo250">

                                                    <li class="todoview plr10 ssnoti"><?php echo $this->lang->line('today_you_have'); ?> <?php echo $count; ?> <?php echo $this->lang->line('pending_task'); ?><a href="<?php echo base_url() ?>admin/calendar/events" class="pull-right pt0"><?php echo $this->lang->line('view'); ?> <?php echo $this->lang->line('all'); ?></a></li>
                                                    <li>
                                                        <ul class="todolist">
                                                            <?php
                                                            $tasklist = $this->customlib->getincompleteTask($userdata["id"]);
                                                            foreach ($tasklist as $key => $value) {
                                                                ?>
                                                                <li><div class="checkbox">
                                                                        <label><input type="checkbox" id="newcheck<?php echo $value["id"] ?>" onclick="markc('<?php echo $value["id"] ?>')" name="eventcheck"  value="<?php echo $value["id"]; ?>"><?php echo $value["event_title"] ?></label>
                                                                    </div></li>
                                                            <?php } ?>

                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <?php
                                    $file = "";
                                    $result = $this->customlib->getUserData();

                                    $image = $result["image"];
                                    $role = $result["user_type"];
                                    $id = $result["id"];
                                    if (!empty($image)) {

                                        $file = "uploads/staff_images/" . $image;
                                    } else {

                                        $file = "uploads/staff_images/no_image.png";
                                    }
                                    ?>
                                    <li class="dropdown user-menu">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                            <img src="<?php echo base_url() . $file; ?>" class="topuser-image" alt="User Image">
                                        </a>
                                        <ul class="dropdown-menu dropdown-user menuboxshadow">
                                            <li> 
                                                <div class="sstopuser">
                                                    <div class="ssuserleft">   
                                                        <a href="<?php echo base_url() . "admin/staff/profile/" . $id ?>"><img src="<?php echo base_url() . $file; ?>" alt="User Image"></a>
                                                    </div>

                                                    <div class="sstopuser-test">
                                                        <h4 style="text-transform: capitalize;"><?php echo $this->customlib->getAdminSessionUserName(); ?></h4>
                                                        <h5><?php echo $role; ?></h5>
                                                       <!-- <div class="sspass pt15"><a class="pull-right" href="<?php //echo base_url()."admin/staff/profile/".$id             ?>"><i class="fa fa-user"></i> My Profile</a></div>   --> 
                                                    </div>

                                                    <div class="divider"></div>
                                                    <div class="sspass">
                                                        <a href="<?php echo base_url() . "admin/staff/profile/" . $id ?>" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('my_profile'); ?>"><i class="fa fa-user"></i><?php echo $this->lang->line('profile'); ?></a> 
                                                        <a class="pl25" href="<?php echo base_url(); ?>admin/admin/changepass" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('change_password') ?>"><i class="fa fa-key"></i><?php echo $this->lang->line('password'); ?></a> <a class="pull-right" href="<?php echo base_url(); ?>site/logout"><i class="fa fa-sign-out fa-fw"></i><?php echo $this->lang->line('logout'); ?></a>
                                                    </div>  
                                                </div><!--./sstopuser--></li>
                                        </ul>                             
                                    </li>   
                                </ul>
                            </div>
                        </div>
                    </div>   
                </nav>
            </header>

            <?php $this->load->view('layout/sidebar'); ?>

