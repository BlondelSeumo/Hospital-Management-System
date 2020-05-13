<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <h3 class="fo-title"><?php echo $this->lang->line('follow_us'); ?></h3>
               <!--  <p class="heading-text">Qolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibham
                  liber tempor cum soluta nobis eleifend option congue nihil uarta decima et quinta.
                  Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl
                  ut aliquip ex ea commodo consequat eleifend option nihil. Investigationes demonstraverunt
                  lectores legere me lius quod ii legunt saepius parum claram.
                </p> -->
                <ul class="company-social">
                    <?php $this->view('/themes/default/social_media'); ?> 
                </ul>
            </div><!--./col-md-7-->

            <div class="col-md-4 col-sm-4">
                <h3 class="fo-title"><?php echo $this->lang->line('links'); ?></h3>
                <ul class="f1-list">
                    <?php
                    foreach ($footer_menus as $footer_menu_key => $footer_menu_value) {

                        $cls_menu_dropdown = "";
                        if (!empty($footer_menu_value['submenus'])) {

                            $cls_menu_dropdown = "dropdown";
                        }
                        ?>
                        <li class="<?php echo $cls_menu_dropdown; ?>">
                            <?php
                            $top_new_tab = '';
                            $url = '#';
                            if ($footer_menu_value['open_new_tab']) {
                                $top_new_tab = "target='_blank'";
                            }
                            if ($footer_menu_value['ext_url']) {
                                $url = $footer_menu_value['ext_url_link'];
                            } else {
                                $url = site_url($footer_menu_value['page_url']);
                            }
                            ?>

                            <a href="<?php echo $url; ?>" <?php echo $top_new_tab; ?>><?php echo $footer_menu_value['menu']; ?></a>

                            <?php
                            ?>


                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div><!--./col-md-5-->
            <div class="col-md-4 col-sm-4">
                <h3 class="fo-title"><?php echo $this->lang->line('feedback'); ?></h3>
                <?php
                if (in_array('complain', json_decode($front_setting->sidebar_options))) {
                    ?>
                    <div class="complain">
                        <a href="<?php echo site_url('page/complain') ?>"><i class="fa fa-pencil-square"></i><?php echo $this->lang->line('complain'); ?></a>
                    </div><!--./complain-->

                    <?php
                }
                ?>
            </div><!--./col-md-3-->
        </div>  

        <div class="row">
            <div class="col-md-12">
                <div class="infoborderb"></div>
            </div><!--./col-md-12-->
            <div class="col-md-4">
                <div class="contacts-item">
                    <div class="cleft"><i class="fa fa-phone"></i></div>
                    <div class="cright">
                        <a href="#" class="content-title"><?php echo $this->lang->line('contact'); ?></a>
                        <p href="#" class="content-title"><?php echo $school_setting->phone; ?></p>

                    </div>
                </div>
            </div><!--./col-md-4-->
            <div class="col-md-4">
                <div class="contacts-item">

                    <div class="cleft"><i class="fa fa-envelope"></i></div>
                    <div class="cright">

                        <a href="#" class="content-title"><?php echo $this->lang->line('email_us'); ?></a>
                        <p><a href="mailto:<?php echo $school_setting->email; ?>" class="content-title"><?php echo $school_setting->email; ?></a>
                        </p>  
                    </div>
                </div>
            </div><!--./col-md-4-->
            <div class="col-md-4">
                <div class="contacts-item">
                    <div class="cleft"><i class="fa fa-map-marker"></i></div>
                    <div class="cright">
                        <a href="#" class="content-title"><?php echo $this->lang->line('address'); ?></a>
                        <p class="sub-title"><?php echo $school_setting->address; ?></p>
                    </div>
                </div>
            </div><!--./col-md-4-->
        </div>
    </div><!--./container-->

    <div class="copy-right">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center">
                    <p><?php echo $front_setting->footer_text; ?></p>
                </div>
            </div><!--./row-->
        </div><!--./container-->
    </div><!--./copy-right-->
</footer>
