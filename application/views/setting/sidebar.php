<div class="col-md-2">
    <div class="box border0">
        <ul class="tablists">
            <?php if ($this->rbac->hasPrivilege('general_settings', 'can_view')) { ?>
                <li class="<?php echo set_Innermenu('schsettings/index'); ?>"><a class="<?php echo set_Innermenu('schsettings/index'); ?>" href="<?php echo base_url(); ?>schsettings"><?php echo $this->lang->line('general_settings'); ?></a></li>
            <?php } ?>
            <?php if ($this->rbac->hasPrivilege('notification_setting', 'can_view')) { ?>
                <li><a class="<?php echo set_Innermenu('notification/setting'); ?>" href="<?php echo base_url(); ?>admin/notification/setting"><?php echo $this->lang->line('notification_setting'); ?></a></li>
            <?php } if ($this->rbac->hasPrivilege('sms_setting', 'can_view')) { ?>
                <li>

                    <a class="<?php echo set_Innermenu('smsconfig/index'); ?>" href="<?php echo base_url(); ?>smsconfig"><?php echo $this->lang->line('sms_setting'); ?></a></li> 
            <?php } if ($this->rbac->hasPrivilege('email_setting', 'can_view')) { ?>
                <li><a class="<?php echo set_Innermenu('emailconfig/index'); ?>" href="<?php echo base_url(); ?>emailconfig"><?php echo $this->lang->line('email_setting'); ?></a></li>
            <?php } ?>  
            <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_view')) { ?>  
                <li><a class="<?php echo set_Innermenu('admin/paymentsettings'); ?>" href="<?php echo base_url(); ?>admin/paymentsettings"><?php echo $this->lang->line('payment_methods'); ?></a></li> 
            <?php } if ($this->rbac->hasPrivilege('front_cms_setting', 'can_view')) { ?>
                <li><a class="<?php echo set_Innermenu('admin/frontcms/index'); ?>" href="<?php echo base_url(); ?>admin/frontcms"><?php echo $this->lang->line('front_cms_setting'); ?></a></li>        <?php } ?>  <?php if ($this->rbac->hasPrivilege('superadmin')) { ?>                                                     
                <li><a class="<?php echo set_Innermenu('admin/roles'); ?>" href="<?php echo base_url(); ?>admin/roles"><?php echo $this->lang->line('roles_permissions'); ?></a></li> 
            <?php } ?>
            <li><a class="<?php echo set_Innermenu('admin/backup'); ?>" href="<?php echo base_url(); ?>admin/admin/backup"><?php echo $this->lang->line('backup / restore'); ?></a></li> 
            <?php if ($this->rbac->hasPrivilege('languages', 'can_add')) { ?>
                <li><a class="<?php echo set_Innermenu('language/index'); ?>" href="<?php echo base_url(); ?>admin/language"><?php echo $this->lang->line('languages'); ?></a></li>
            <?php } ?>
            <!--     <?php if ($this->rbac->hasPrivilege('superadmin')) { ?>
                            <li><a class="<?php echo set_Innermenu('users/index'); ?>" href="<?php echo base_url(); ?>admin/adminuser"><?php echo $this->lang->line('admin_users'); ?></a></li>  
                <?php
            }
            ?> -->
            <?php if ($this->rbac->hasPrivilege('user_status')) { ?>
                <li ><a class="<?php echo set_Innermenu('users/index'); ?>" href="<?php echo base_url(); ?>admin/users"><?php echo $this->lang->line('users'); ?></a></li>
            <?php } if ($this->rbac->hasPrivilege('superadmin')) { ?>
                <li class="<?php echo set_Innermenu('admin/module'); ?>"><a class="<?php echo set_Innermenu('admin/module'); ?>" href="<?php echo base_url(); ?>admin/module"><?php echo $this->lang->line('modules'); ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>