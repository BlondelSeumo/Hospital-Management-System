<div class="box border0">
    <ul class="tablists">
        <?php if ($this->rbac->hasPrivilege('bed_status', 'can_view')) { ?>
            <li><a href="<?php echo site_url('admin/setup/bed/status') ?>" class="<?php echo set_sidebar_Submenu('admin/setup/bed/status'); ?>"><?php echo $this->lang->line('bed') . " " . $this->lang->line('status'); ?></a></li>
        <?php } if ($this->rbac->hasPrivilege('bed', 'can_view')) { ?>
            <li><a href="<?php echo site_url('admin/setup/bed') ?>" class="<?php echo set_sidebar_Submenu('admin/setup/bed'); ?>"><?php echo $this->lang->line('bed'); ?></a></li>
            <li><a href="<?php echo site_url('admin/setup/bedtype') ?>" class="<?php echo set_sidebar_Submenu('admin/setup/bedtype'); ?>"><?php echo $this->lang->line('bed') . " " . $this->lang->line('type'); ?></a></li>
            <li><a href="<?php echo site_url('admin/setup/bedgroup') ?>" class="<?php echo set_sidebar_Submenu('admin/setup/bedgroup'); ?>"><?php echo $this->lang->line('bed') . " " . $this->lang->line('group'); ?></a></li>
            <li>
                <a href="<?php echo site_url('admin/setup/floor') ?>" class="<?php echo set_sidebar_Submenu('admin/setup/floor'); ?>"><?php echo $this->lang->line('floor'); ?></a></li>                
        <?php } ?>                                                     
    </ul>
</div>
