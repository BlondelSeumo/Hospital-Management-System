<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
        <h1>
            <?php echo $this->lang->line('payment'); ?>
        </h1>
    </section>

    <!-- Main content -->
    <section class="invoice">

        <div class="row">
            <div class="alert alert-warning alert-dismissible">

                <h4><i class="icon fa fa-warning"></i><?php echo $this->lang->line('cancelled'); ?></h4>
                <a style='color: #3c8dbc;  display: inline-table;' href="<?php echo site_url('patient/dashboard/ipdprofile') ?>"><?php echo $this->lang->line('cancelled_message') ?></a>
            </div>       
        </div>      
    </section>    
    <div class="clearfix"></div>
</div>