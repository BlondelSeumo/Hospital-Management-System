<ul class="sessionul fixedmenu" style="display: none;">
    <?php
    // if ($this->rbac->hasPrivilege('quick_session_change', 'can_view')) {
    ?>
    <!-- <li class="removehover">
        <a data-toggle="modal" data-target="#sessionModal"><?php echo $this->lang->line('current_session') . ": " . $this->setting_model->getCurrentSessionName(); ?><i class="fa fa-pencil pull-right"></i></a>


    </li> -->
    <?php //} ?>

    <li class="dropdown">
        <a class="dropdown-toggle drop5" data-toggle="dropdown" href="#" aria-expanded="false">
            <span><?php echo $this->lang->line('quick_links'); ?></span> <i class="glyphicon glyphicon-th pull-right"></i>
        </a>
        <ul class="dropdown-menu verticalmenu" style="min-width:194px;font-size:10pt;left:3px;">
            <?php if ($this->rbac->hasPrivilege('student', 'can_view')) { ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>student/search"><i class="fa fa-user-plus"></i><?php echo $this->lang->line('student_details'); ?></a></li>

            <?php } ?>


            <?php if ($this->rbac->hasPrivilege('income', 'can_add')) { ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/income"> &nbsp;<i class="fa fa-usd"></i> <?php echo $this->lang->line('add_income'); ?></a></li>
            <?php } ?>
            <?php if ($this->rbac->hasPrivilege('expense', 'can_view')) { ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/expense"><i class="fa fa-credit-card"></i><?php echo $this->lang->line('add_expense'); ?></a></li>

            <?php } ?>


            <?php
            if ($this->rbac->hasPrivilege('staff_attendance', 'can_view')) {
                ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/staffattendance"><i class="fa fa-calendar-check-o"></i><?php echo $this->lang->line('staff_attendance'); ?></a></li>

            <?php } if ($this->rbac->hasPrivilege('staff', 'can_view')) { ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/staff"><i class="fa fa-calendar-check-o"></i><?php echo $this->lang->line('staff_directory'); ?></a></li>

                <?php
            }
            ?>



            <?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_view')) { ?>           
                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/enquiry"><i class="fa fa-calendar-check-o"></i><?php echo $this->lang->line('admission_enquiry'); ?></a></li>
                <?php
            }
            if ($this->rbac->hasPrivilege('complaint', 'can_view')) {
                ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/complaint"><i class="fa fa-calendar-check-o"></i><?php echo $this->lang->line('complain'); ?></a></li>

            <?php } if ($this->rbac->hasPrivilege('upload_content', 'can_view')) { ?>
                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/content"><i class="fa fa-download"></i><?php echo $this->lang->line('upload_content'); ?></a></li>

                <?php
            }
            if ($this->rbac->hasPrivilege('item_stock', 'can_add')) {
                ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/itemstock"><i class="fa fa-object-group"></i><?php echo $this->lang->line('add_item_stock'); ?></a></li>

                <?php
            }
            if ($this->rbac->hasPrivilege('notice_board', 'can_view')) {
                ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/notification"><i class="fa fa-bullhorn"></i><?php echo $this->lang->line('notice_board'); ?></a></li>

                <?php
            }
            if ($this->rbac->hasPrivilege('email_sms', 'can_view')) {
                ?>
                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>admin/mailsms/compose"><i class="fa fa-envelope-o"></i><?php echo $this->lang->line('send_email_/_sms'); ?></a></li>
                    <?php } ?>
        </ul>
    </li>
</ul>  
