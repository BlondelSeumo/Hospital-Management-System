 <div class="col-md-2">
                <div class="box border0">
                    <ul class="tablists">
                        <?php if ($this->rbac->hasPrivilege('medicine_category', 'can_view')) { ?>
                        <li><a href="<?php echo base_url(); ?>admin/medicinecategory/medicine" class="<?php echo set_sidebar_Submenu('admin/medicinecategory/medicine'); ?>"> <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?></th></a></li>
						<?php } ?>
                         <?php  if ($this->rbac->hasPrivilege('medicine_supplier', 'can_view')) { ?>
						 <li><a class="<?php echo set_sidebar_Submenu('admin/medicinecategory/supplier'); ?>" href="<?php echo base_url(); ?>admin/medicinecategory/supplier" > <th><?php echo $this->lang->line('supplier'); ?></th></a></li>
 <?php }  if ($this->rbac->hasPrivilege('medicine_dosage', 'can_view')) { ?>
                         <li><a class="<?php echo set_sidebar_Submenu('admin/medicinedosage'); ?>" href="<?php echo base_url(); ?>admin/medicinedosage" href="<?php echo base_url(); ?>admin/medicinedosage" > <th><?php echo $this->lang->line('medicine')." ".$this->lang->line('dosage'); ?></th></a></li>
                     <?php } ?>
                    </ul>
                </div>
            </div>