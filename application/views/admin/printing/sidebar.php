<div class="box border0">
    <ul class="tablists">
        <?php if ($this->rbac->hasPrivilege('opd_prescription_print_header_footer', 'can_view')) { ?>
            <li><a href="<?php echo site_url('admin/printing') ?>" class="<?php echo set_sidebar_Submenu('admin/printing'); ?>"><?php echo $this->lang->line('opd') . " " . $this->lang->line('prescription'); ?></a></li>
        <?php } if ($this->rbac->hasPrivilege('opd_bill_print_header_footer', 'can_view')) { ?>
            <li><a href="<?php echo site_url('admin/printing/opdprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/opdprinting'); ?>"><?php echo $this->lang->line('opd') . " " . $this->lang->line('bill'); ?></a></li>
        <?php } if ($this->rbac->hasPrivilege('ipd_prescription_print_header_footer', 'can_view')) { ?>
            <li><a href="<?php echo site_url('admin/printing/ipdpresprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/ipdpresprinting'); ?>"><?php echo $this->lang->line('ipd') . " " . $this->lang->line('prescription'); ?></a></li>
        <?php } if ($this->rbac->hasPrivilege('ipd_bill_print_header_footer', 'can_view')) { ?>
            <li><a href="<?php echo site_url('admin/printing/ipdprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/ipdprinting'); ?>"><?php echo $this->lang->line('ipd') . " " . $this->lang->line('bill'); ?></a></li>
        <?php }  if ($this->rbac->hasPrivilege('pharmacy_bill_print_header_footer', 'can_view')) { ?>
            <li><a href="<?php echo site_url('admin/printing/pharmacyprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/pharmacyprinting'); ?>"><?php echo $this->lang->line('pharmacy') . " " . $this->lang->line('bill'); ?></a></li>
        <?php } if ($this->rbac->hasPrivilege('print_payslip_header_footer', 'can_view')) { ?>
            <li><a href="<?php echo site_url('admin/printing/payslipprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/payslipprinting'); ?>"><?php echo $this->lang->line('payslip'); ?></a></li>
        <?php } if ($this->rbac->hasPrivilege('birth_print_header_footer', 'can_view')) { ?>

           <li> <a href="<?php echo site_url('admin/printing/birthprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/birthprinting'); ?>"><?php echo $this->lang->line('birth_record'); ?></a></li>
        <?php } if ($this->rbac->hasPrivilege('death_print_header_footer', 'can_view')) {  ?>
            <li><a href="<?php echo site_url('admin/printing/deathprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/deathprinting'); ?>"><?php echo $this->lang->line('death_record'); ?></a></li>
        <?php } if ($this->rbac->hasPrivilege('pathology_print_header_footer', 'can_view')) { ?>

            <li><a href="<?php echo site_url('admin/printing/pathologyprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/pathologyprinting'); ?>"><?php echo $this->lang->line('pathology'); ?></a></li>
   
        <?php } if ($this->rbac->hasPrivilege('radiology_print_header_footer', 'can_view')) { ?>
              <li>  <a href="<?php echo site_url('admin/printing/radiologyprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/radiologyprinting'); ?>"><?php echo $this->lang->line('radiology'); ?></a>
        <?php } if ($this->rbac->hasPrivilege('ot_print_header_footer', 'can_view')) {?>
               <li> <a href="<?php echo site_url('admin/printing/otprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/otprinting'); ?>"><?php echo $this->lang->line('operation_theatre'); ?></a></li>
      
        <?php } if ($this->rbac->hasPrivilege('bloodbank_print_header_footer', 'can_view')) { ?>
                <li><a href="<?php echo site_url('admin/printing/bloodbankprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/bloodbankprinting'); ?>"><?php echo $this->lang->line('blood_bank'); ?></a></li>
               
        <?php } if ($this->rbac->hasPrivilege('ambulance_print_header_footer', 'can_view')) { ?>

               <li> <a href="<?php echo site_url('admin/printing/ambulanceprinting') ?>" class="<?php echo set_sidebar_Submenu('admin/printing/ambulanceprinting'); ?>"><?php echo $this->lang->line('ambulance'); ?></a></li>

        <?php } ?>
       
    </ul>
</div>
