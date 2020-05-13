<!DOCTYPE html>
<html dir="<?php echo ($front_setting->is_active_rtl) ? "rtl" : "ltr"; ?>" lang="<?php echo ($front_setting->is_active_rtl) ? "ar" : "en"; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $page['title']; ?></title>
        <meta name="title" content="<?php echo $page['meta_title']; ?>">
        <meta name="keywords" content="<?php echo $page['meta_keyword']; ?>">
        <meta name="description" content="<?php echo $page['meta_description']; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo base_url($front_setting->fav_icon); ?>" type="image/x-icon">
        <link href="<?php echo $base_assets_url; ?>css/all.css" rel="stylesheet">
        <link href="<?php echo $base_assets_url; ?>css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo $base_assets_url; ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $base_assets_url; ?>css/style.css" rel="stylesheet">
        <script src="<?php echo $base_assets_url; ?>js/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo $base_assets_url; ?>front/bootstrap-datetimepicker.min.css" />
        <script src="<?php echo $base_assets_url; ?>front/moment.min.js"></script>
        <script src="<?php echo $base_assets_url; ?>front/jquery.min.js"></script>
        <script src="<?php echo $base_assets_url; ?>front/bootstrap-datetimepicker.min.js"></script>
        <?php
        $this->load->view('layout/theme');

        if ($front_setting->is_active_rtl) {
            ?>
            <link href="<?php echo $base_assets_url; ?>rtl/bootstrap-rtl.min.css" rel="stylesheet">
            <link href="<?php echo $base_assets_url; ?>rtl/style-rtl.css" rel="stylesheet">
            <?php
        }
        ?>


        <?php echo $front_setting->google_analytics; ?> 
    </head>
    <body>


        <?php echo $header; ?>

        <?php echo $slider; ?>

        <?php if (isset($featured_image) && $featured_image != "") {
            ?>

            <!--  <div class="background-opacity about-title">
                 <div class="container">
                     <div class="page-title-wrapper"><h2 class="captions">Event</h2>
                         <ol class="breadcrumb">
                             <li><a href="#">Home</a></li>
                             <li class="active"><a href="#">Event</a></li>
                         </ol>
                     </div>
                 </div>
             </div> -->
            <?php
        }
        ?> 

        <div class="container spacet50 spaceb50">
            <div class="row"> 
                <?php
                $page_colomn = "col-md-12";

                if ($page_side_bar) {

                    $page_colomn = "col-md-12 col-sm-12";
                }
                ?>
                <div class="<?php echo $page_colomn; ?>">
                    <?php echo $content; ?> 
                </div>  
                <?php
                if ($page_side_bar) {
                    ?>


                    <?php
                }
                ?>


            </div><!--./row-->
        </div><!--./container-->  

        <?php echo $footer; ?>

        <script src="<?php echo $base_assets_url; ?>js/bootstrap.min.js"></script>
        <script src="<?php echo $base_assets_url; ?>js/ss-lightbox.js"></script>
        <script src="<?php echo $base_assets_url; ?>js/custom.js"></script>
    </body>
</html>